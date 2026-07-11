<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form){
    //主页头像地址
    $websiteAvatar = new Typecho_Widget_Helper_Form_Element_Text(
        "websiteAvatar",
        NULL,
        "",
        _t("主页头像地址"),
    );
    $form->addInput($websiteAvatar);

    //主页横幅图片
    $websiteBanner = new Typecho_Widget_Helper_Form_Element_Text(
        "websiteBanner",
        NULL,
        "",
        _t("主页横幅图片地址"),
    );
    $form->addInput($websiteBanner);

    //网页标签栏图标
    $websiteIcon = new Typecho_Widget_Helper_Form_Element_Text(
        "websiteIcon",
        NULL,
        "",
        _t("网页标签栏图标"),
    );
    $form->addInput($websiteIcon);

    //自定义导航栏
    $navLinks = new Typecho_Widget_Helper_Form_Element_Textarea(
        'nav_links',
        NULL,
        '首页|/',
        '导航链接',
        '请按照格式输入，每行一个，格式为：名称|链接，例如：首页|/'
    );
    $form->addInput($navLinks);

    //更多下拉菜单
    $moreLinks = new Typecho_Widget_Helper_Form_Element_Textarea(
        'more_links',
        NULL,
        '关于我|/about.html',
        '下拉菜单',
        '请按照格式输入，每行一个，格式为：名称|链接，例如：关于我|/about.html'
    );
    $form->addInput($moreLinks);

    //显示模块内容
    $showModule = new Typecho_Widget_Helper_Form_Element_Select(
        'showModule',
        [
            'yes' => '显示',
            'no' => '不显示'
        ],
        'yes',
        '显示底部模块内容',
        '显示最近文章、最新评论、最新评论'
    );

    $form->addInput($showModule);

    //版权起始年份
    $copyrightStartYear = new Typecho_Widget_Helper_Form_Element_Text(
        "copyrightStartYear",
        NULL,
        "",
        _t("版权起始年份"),
        _t("设置版权信息的起始年份，留空则显示当前年")
    );

    $form->addInput($copyrightStartYear);

    //ICP备案号
    $icpString = new Typecho_Widget_Helper_Form_Element_Text(
        "icpString",
        NULL,
        "",
        _t("ICP备案号"),
    );

    $form->addInput($icpString);

    //备案号
    $filingString = new Typecho_Widget_Helper_Form_Element_Text(
        "filingString",
        NULL,
        "",
        _t("联网单位备案号"),
    );

    $form->addInput($filingString);
}

function themeFields($layout) {
    $thumb = new Typecho_Widget_Helper_Form_Element_Text(
        'thumb',
        NULL,
        NULL,
        _t('头图地址'),
        _t('填写文章头图 URL，用于缩略图显示')
    );
    $layout->addItem($thumb);

    $friendLinks = new Typecho_Widget_Helper_Form_Element_Text(
        'friendLinks',
        NULL,
        NULL,
        _t('友情链接'),
        _t('json 文件地址')
    );
    $layout->addItem($friendLinks);
}

//限制评论长度
function limitCommentLength($comment)
{
    $content = $comment['text'];

    //关键词限制
    $blacklist = [
        'астролог',   // 俄语：占星
        'казино',
        'viagra',
        'porn',
        '赌博',
        '博彩'
    ];

    foreach ($blacklist as $word) {
        if (mb_stripos($content, $word) !== false) {
            $comment['status'] = 'spam';
            return $comment;
        }
    }

    //俄语屏蔽
    if (preg_match('/[\x{0400}-\x{04FF}]/u', $content)) {
        $comment['status'] = 'spam';
        return $comment;
    }

    //长度限制
    $length = mb_strlen(trim(strip_tags($content)), 'UTF-8');

    if ($length > 300) {
        throw new Typecho_Widget_Exception('评论不能超过300字');
    }

    return $comment;
}

function themeInit($archive)
{
    Typecho_Plugin::factory('Widget_Feedback')->comment = 'limitCommentLength';
}