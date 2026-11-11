<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<main class="site-main site-main--post" role="main">
    <article class="article article--post">
        <div class="article__content" itemprop="articleBody">
            <?php $this->content(); ?>
        </div>

        <?php if (!empty($this->tags)): ?>
            <div class="article__tags">
                <?php $this->tags('', true, ''); ?>
            </div>
        <?php endif; ?>

        <div class="article__like">
            <button class="like-btn" type="button"
                    data-like
                    data-cid="<?php $this->cid(); ?>"
                    data-endpoint="<?php $this->options->themeUrl('like.php'); ?>">
                <img src="<?php $this->options->themeUrl('assets/img/like.png'); ?>" alt="">
                <span class="like-btn__text"><?php _e('点赞'); ?></span>
                <span class="like-btn__count" data-like-count><?php echo rchi_like_count($this); ?></span>
            </button>
        </div>
    </article>

    <nav class="article__near" aria-label="<?php _e('上一篇和下一篇'); ?>">
        <span class="near-item"><?php _e('上一篇'); ?>：<?php $this->thePrev('%s', _t('没有了')); ?></span>
        <span class="near-item"><?php _e('下一篇'); ?>：<?php $this->theNext('%s', _t('没有了')); ?></span>
    </nav>
</main>

<?php $this->need('footer.php'); ?>
