<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<main class="site-main" role="main">
    <div class="article not-found">
        <p class="not-found__code">404</p>
        <h1 class="article__title"><?php _e('页面走丢了'); ?></h1>
        <p class="not-found__text"><?php _e('你访问的页面可能已被移动或删除，试试搜索看看。'); ?></p>
        <form class="not-found__form" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
            <input type="text" name="s" placeholder="<?php _e('输入关键字...'); ?>" aria-label="<?php _e('搜索'); ?>">
            <button type="submit"><?php _e('搜索'); ?></button>
        </form>
        <p><a class="read-more" href="<?php $this->options->siteUrl(); ?>"><?php _e('返回首页'); ?><span class="arrow">&rarr;</span></a></p>
    </div>
</main>

<?php $this->need('footer.php'); ?>
