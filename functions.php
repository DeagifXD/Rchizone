<?php
/**
 * RchiZone 主题
 *
 * 粉色星星背景 + 深棕导航的轻量博客主题
 *
 * @package rchizone
 * @author RchiZone
 * @version 1.4.9
 * @link https://typecho.org
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

if (!defined('RCHI_VERSION')) {
    define('RCHI_VERSION', '1.6.4');
}

/**
 * 主题设置
 *
 * @param \Typecho\Widget\Helper\Form $form
 */
function themeConfig($form)
{
    $avatar = new \Typecho\Widget\Helper\Form\Element\Text(
        'rchiAvatar',
        null,
        null,
        _t('头像地址'),
        _t('留空使用主题自带图片 assets/img/avatar.jpg')
    );
    $form->addInput($avatar);

    $hero = new \Typecho\Widget\Helper\Form\Element\Text(
        'rchiHero',
        null,
        null,
        _t('顶部背景图地址'),
        _t('留空使用头像图片作为顶部背景')
    );
    $form->addInput($hero);

    $subtitle = new \Typecho\Widget\Helper\Form\Element\Text(
        'rchiSubtitle',
        null,
        null,
        _t('副标题'),
        _t('显示在站点标题下方，留空则使用站点描述')
    );
    $form->addInput($subtitle);

    $navLinks = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'rchiNavLinks',
        null,
        null,
        _t('导航链接'),
        _t('每行一个，格式：名称|链接。留空则自动使用「首页 + 独立页面」。仅支持 http(s)、// 或 / 开头的地址')
    );
    $form->addInput($navLinks);

    $copyrightStart = new \Typecho\Widget\Helper\Form\Element\Text(
        'rchiCopyrightStart',
        null,
        null,
        _t('版权起始年份'),
        _t('例如 2024；留空则只显示当前年份')
    );
    $form->addInput($copyrightStart);

    $icp = new \Typecho\Widget\Helper\Form\Element\Text(
        'rchiIcp',
        null,
        null,
        _t('ICP 备案号'),
        _t('例如：黑ICP备2024021558号；留空不显示')
    );
    $form->addInput($icp);

    $filing = new \Typecho\Widget\Helper\Form\Element\Text(
        'rchiFiling',
        null,
        null,
        _t('公安联网备案号'),
        _t('例如：黑公网安备23010802000125号；留空不显示')
    );
    $form->addInput($filing);

    $footer = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'rchiFooter',
        null,
        null,
        _t('页脚附加内容'),
        _t('支持 HTML，例如额外的备案说明；留空不显示')
    );
    $form->addInput($footer);
}

/**
 * 文章自定义字段
 *
 * @param \Typecho\Widget\Helper\Layout $layout
 */
function themeFields($layout)
{
    $thumb = new \Typecho\Widget\Helper\Form\Element\Text(
        'thumb',
        null,
        null,
        _t('缩略图地址'),
        _t('留空则自动截取正文第一张图片')
    );
    $layout->addItem($thumb);
}

/**
 * 获取主题文件 URL（返回字符串，不直接输出）
 *
 * @param string $path
 * @return string
 */
function rchi_theme_url(string $path = '')
{
    $options = \Widget\Options::alloc();

    return $options->themeUrl($path, $options->theme);
}

/**
 * 转义 HTML
 *
 * @param mixed $value
 * @return string
 */
function rchi_esc($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * 只允许安全的链接协议，杜绝 javascript: / data: 注入
 *
 * @param string $url
 * @return string
 */
function rchi_safe_url(string $url)
{
    $url = trim($url);

    if ($url === '' || $url === '#') {
        return '#';
    }

    if (preg_match('#^(https?://|//|/|\#)#i', $url)) {
        return $url;
    }

    return '#';
}

/**
 * 解析「名称|链接」多行文本
 *
 * @param string $raw
 * @return array
 */
function rchi_parse_links(string $raw)
{
    $links = [];

    foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
        $line = trim($line);
        if ($line === '') {
            continue;
        }

        $parts = array_map('trim', explode('|', $line, 2));
        if ($parts[0] === '') {
            continue;
        }

        $links[] = [
            'name' => $parts[0],
            'url'  => rchi_safe_url($parts[1] ?? '')
        ];
    }

    return $links;
}

/**
 * 获取文章点赞数
 *
 * @param \Widget\Base\Contents $archive
 * @return int
 */
function rchi_like_count($archive)
{
    $likes = $archive->fields->likes;

    return $likes === null || $likes === '' ? 0 : max(0, (int) $likes);
}

/**
 * 获取文章缩略图
 *
 * @param \Widget\Base\Contents $archive
 * @return string
 */
function rchi_thumb($archive)
{
    return rchi_resolve_thumb((string) $archive->fields->thumb, (string) $archive->content);
}

/**
 * 根据字段与正文解析缩略图地址
 *
 * @param string $thumb
 * @param string $content
 * @return string
 */
function rchi_resolve_thumb(string $thumb, string $content = '')
{
    $default = rchi_theme_url('assets/img/avatar.jpg');
    $thumb = trim($thumb);

    if ($thumb === '' && preg_match('/<img[^>]+src=([\'"])(.*?)\1/i', $content, $matches)) {
        $thumb = $matches[2];
    }

    if ($thumb === '') {
        return $default;
    }

    // 站内相对路径：文件不存在时回退到主题默认图
    if ($thumb[0] === '/' && substr($thumb, 0, 2) !== '//') {
        if (!is_file(__TYPECHO_ROOT_DIR__ . $thumb)) {
            return $default;
        }

        return rtrim((string) \Widget\Options::alloc()->siteUrl, '/') . $thumb;
    }

    // 无协议的相对路径
    if (!preg_match('#^(https?:)?//#i', $thumb) && strpos($thumb, 'data:') !== 0) {
        $local = __TYPECHO_ROOT_DIR__ . '/' . ltrim($thumb, '/');

        if (is_file($local)) {
            return rtrim((string) \Widget\Options::alloc()->siteUrl, '/') . '/' . ltrim($thumb, '/');
        }

        return $default;
    }

    return rchi_safe_url($thumb);
}

/**
 * 通过标签名获取标签归档链接
 *
 * @param string $name
 * @return string|null
 */
function rchi_tag_link(string $name)
{
    static $tags = null;

    if ($tags === null) {
        $tags = [];
        \Widget\Metas\Tag\Cloud::alloc()->to($rows);

        while ($rows->next()) {
            $tags[(string) $rows->name] = (string) $rows->permalink;
        }
    }

    return $tags[$name] ?? null;
}

/**
 * 通过 slug 获取独立页面链接
 *
 * @param string $slug
 * @return string|null
 */
function rchi_page_link(string $slug)
{
    static $pages = null;

    if ($pages === null) {
        $pages = [];

        $db = \Typecho\Db::get();
        $options = \Widget\Options::alloc();

        $rows = $db->fetchAll(
            $db->select('cid', 'slug')
                ->from('table.contents')
                ->where('type = ?', 'page')
                ->where('status = ?', 'publish')
        );

        foreach ($rows as $row) {
            $pages[(string) $row['slug']] = \Typecho\Router::url('page', [
                'cid'  => (int) $row['cid'],
                'slug' => (string) $row['slug']
            ], $options->index);
        }
    }

    return $pages[$slug];
}

/**
 * 截取纯文本摘要
 *
 * @param string $text
 * @param int $length
 * @return string
 */
function rchi_excerpt_from_text(string $text, int $length = 120)
{
    $text = str_replace('<!--markdown-->', '', $text);
    $text = trim(preg_replace('/\s+/u', ' ', strip_tags($text)));

    return mb_strimwidth($text, 0, $length, '...', 'UTF-8');
}

/**
 * 按标签筛选文章（用于作品集页面）
 *
 * @param array $tagNames
 * @param int $limit
 * @return array
 */
function rchi_posts_by_tags(array $tagNames, int $limit = 50)
{
    if (empty($tagNames)) {
        return [];
    }

    $db = \Typecho\Db::get();
    $options = \Widget\Options::alloc();

    $rows = $db->fetchAll(
        $db->select(
            'table.contents.cid',
            'table.contents.title',
            'table.contents.slug',
            'table.contents.created',
            'table.contents.text'
        )
            ->from('table.contents')
            ->join('table.relationships', 'table.relationships.cid = table.contents.cid')
            ->join('table.metas', 'table.metas.mid = table.relationships.mid')
            ->where('table.contents.type = ?', 'post')
            ->where('table.contents.status = ?', 'publish')
            ->where('table.metas.type = ?', 'tag')
            ->where('table.metas.name IN ?', array_values($tagNames))
            ->group('table.contents.cid')
            ->order('table.contents.created', \Typecho\Db::SORT_DESC)
            ->limit($limit)
    );

    if (empty($rows)) {
        return [];
    }

    $cids = array_map(function ($row) {
        return (int) $row['cid'];
    }, $rows);

    $fieldRows = $db->fetchAll(
        $db->select('cid', 'name', 'str_value')
            ->from('table.fields')
            ->where('cid IN ?', $cids)
            ->where('name IN ?', ['thumb', 'likes'])
    );

    $fields = [];
    foreach ($fieldRows as $field) {
        $fields[(int) $field['cid']][$field['name']] = $field['str_value'];
    }

    $tagRows = $db->fetchAll(
        $db->select('table.relationships.cid', 'table.metas.name')
            ->from('table.relationships')
            ->join('table.metas', 'table.metas.mid = table.relationships.mid')
            ->where('table.relationships.cid IN (?)', $cids)
            ->where('table.metas.type = ?', 'tag')
    );

    $tagsByCid = [];
    foreach ($tagRows as $tagRow) {
        $tagsByCid[(int) $tagRow['cid']][] = (string) $tagRow['name'];
    }

    $posts = [];
    foreach ($rows as $row) {
        $cid = (int) $row['cid'];

        $posts[] = [
            'cid'       => $cid,
            'title'     => (string) $row['title'],
            'created'   => (int) $row['created'],
            'excerpt'   => rchi_excerpt_from_text((string) $row['text'], 110),
            'thumb'     => rchi_resolve_thumb((string) ($fields[$cid]['thumb'] ?? ''), (string) $row['text']),
            'likes'     => (int) ($fields[$cid]['likes'] ?? 0),
            'tags'      => $tagsByCid[$cid] ?? [],
            'permalink' => \Typecho\Router::url('post', [
                'cid'  => $cid,
                'slug' => (string) $row['slug']
            ], $options->index)
        ];
    }

    return $posts;
}
