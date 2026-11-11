<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
$avatar = $this->options->rchiAvatar ?: rchi_theme_url('assets/img/avatar.jpg');
$subtitle = $this->options->rchiSubtitle ?: $this->options->description;
$siteUrl = (string) $this->options->siteUrl;
$isPost = $this->is('post');
$heroImage = $isPost
    ? rchi_thumb($this)
    : ($this->options->rchiHero ?: $avatar);

$navItems = [];
$moreItems = [];
$rawNav = trim((string) $this->options->rchiNavLinks);

if ($rawNav !== '') {
    $navItems = rchi_parse_links($rawNav);
} else {
    $navItems[] = ['name' => _t('首页'), 'url' => $siteUrl, 'current' => $this->is('index')];

    $mainNav = [
        ['日常', 'tag', '日常'],
        ['媒体库', 'page', 'media'],
        ['作品集', 'page', 'works'],
        ['笔记', 'tag', '笔记']
    ];

    foreach ($mainNav as $entry) {
        if ($entry[1] === 'tag') {
            $url = rchi_tag_link($entry[2]);
            $current = $this->is('tag', $entry[2]);
        } else {
            $url = rchi_page_link($entry[2]);
            $current = $this->is('page', $entry[2]);
        }

        if ($url) {
            $navItems[] = ['name' => $entry[0], 'url' => $url, 'current' => $current];
        }
    }
}

foreach ([['友情链接', 'links'], ['关于我', 'about']] as $entry) {
    $url = rchi_page_link($entry[1]);

    if ($url) {
        $moreItems[] = [
            'name'    => $entry[0],
            'url'     => $url,
            'current' => $this->is('page', $entry[1])
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <script>
        (function () {
            try {
                var saved = window.localStorage.getItem('rchi-theme');
                var dark = saved ? saved === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
            } catch (error) {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>
    <meta name="theme-color" content="#6d5452">
    <title><?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('标签 %s 下的文章'),
            'author'   => _t('%s 发布的文章')
        ], '', ' - '); ?><?php $this->options->title(); ?></title>
    <link rel="icon" href="<?php $this->options->themeUrl('assets/img/icon.png'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/style.css'); ?>?v=<?php echo RCHI_VERSION; ?>">
    <?php $this->header(); ?>
</head>
<body class="<?php echo $isPost ? 'is-single is-post' : ($this->is('page') ? 'is-single' : 'is-list'); ?>">

<header class="hero<?php echo $isPost ? ' hero--post' : ''; ?>"
        style="background-image:url('<?php echo rchi_esc($heroImage); ?>')"
        <?php if ($isPost): ?>data-cover="<?php echo rchi_esc($heroImage); ?>"<?php endif; ?>>
    <?php if ($isPost): ?>
        <div class="hero__inner hero__inner--post">
            <div class="hero__bar">
                <a class="hero__back" href="<?php echo rchi_esc($siteUrl); ?>" data-back>
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15 18l-6-6 6-6"></path>
                    </svg>
                    <span><?php _e('返回'); ?></span>
                </a>
                <button class="hero__expand" type="button"
                        data-preview="<?php echo rchi_esc($heroImage); ?>"
                        aria-label="<?php _e('查看封面大图'); ?>" title="<?php _e('查看封面大图'); ?>">
                    <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 4H4v5M15 4h5v5M15 20h5v-5M9 20H4v-5"></path>
                    </svg>
                </button>
            </div>

            <div class="hero__post-body">
                <h1 class="hero__post-title"><?php $this->title(); ?></h1>
                <div class="hero__post-meta">
                    <span class="meta-item">
                        <i class="icon icon--calendar" aria-hidden="true"></i>
                        <time datetime="<?php $this->date('c'); ?>"><?php $this->date('Y-m-d'); ?></time>
                    </span>
                    <span class="meta-item">
                        <i class="icon icon--comment" aria-hidden="true"></i>
                        <?php $this->commentsNum(_t('%d 条评论')); ?>
                    </span>
                    <span class="meta-item">
                        <i class="icon icon--category" aria-hidden="true"></i>
                        <?php $this->category(', '); ?>
                    </span>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="hero__inner">
            <a class="hero__avatar" href="<?php echo rchi_esc($siteUrl); ?>" aria-label="<?php _e('返回首页'); ?>">
                <img src="<?php echo rchi_esc($avatar); ?>" alt="<?php $this->options->title(); ?>">
            </a>
            <h1 class="hero__title">
                <a href="<?php echo rchi_esc($siteUrl); ?>"><?php $this->options->title(); ?></a>
            </h1>
            <div class="hero__divider" aria-hidden="true"></div>
            <?php if (!empty($subtitle)): ?>
                <p class="hero__desc"><?php echo rchi_esc($subtitle); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <nav class="hero__nav" id="siteNav" aria-label="<?php _e('主导航'); ?>">
    <div class="hero__nav-inner">
        <?php foreach ($navItems as $index => $item): ?>
            <?php if ($index > 0): ?><span class="nav-sep" aria-hidden="true">·</span><?php endif; ?>
            <a class="nav-link<?php if (!empty($item['current'])) echo ' is-current'; ?>"
               href="<?php echo rchi_esc($item['url']); ?>"><?php echo rchi_esc($item['name']); ?></a>
        <?php endforeach; ?>

        <?php if (!empty($moreItems)): ?>
            <span class="nav-sep" aria-hidden="true">·</span>
            <div class="nav-more">
                <span class="nav-link nav-more__toggle" role="button" tabindex="0"
                      aria-haspopup="true" aria-expanded="false"><?php _e('更多'); ?></span>
                <div class="nav-more__menu">
                    <?php foreach ($moreItems as $moreItem): ?>
                        <a class="<?php if (!empty($moreItem['current'])) echo 'is-current'; ?>"
                           href="<?php echo rchi_esc($moreItem['url']); ?>"><?php echo rchi_esc($moreItem['name']); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <form class="nav-search" role="search" method="post" action="<?php echo rchi_esc($siteUrl); ?>">
        <input type="text" name="s" placeholder="<?php _e('搜索...'); ?>" aria-label="<?php _e('搜索'); ?>">
        <button class="nav-search__toggle" type="button" aria-label="<?php _e('搜索'); ?>">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                 stroke-width="1.8" stroke-linecap="round">
                <circle cx="11" cy="11" r="7"></circle>
                <path d="M20 20l-3.5-3.5"></path>
            </svg>
        </button>
    </form>
    </nav>
</header>
