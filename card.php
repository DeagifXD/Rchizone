<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
$likes = rchi_like_count($this);
$thumb = rchi_thumb($this);
$tags = $this->tags;
?>
<article class="post-card">
    <a class="post-card__thumb" href="<?php $this->permalink(); ?>" tabindex="-1" aria-hidden="true">
        <img src="<?php echo rchi_esc($thumb); ?>" alt="<?php $this->title(); ?>" loading="lazy">
    </a>

    <div class="post-card__body">
        <h2 class="post-card__title">
            <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
        </h2>

        <div class="post-card__meta">
            <span class="meta-item">
                <i class="icon icon--calendar" aria-hidden="true"></i>
                <time datetime="<?php $this->date('c'); ?>"><?php $this->date('Y-m-d'); ?></time>
            </span>
            <span class="meta-item">
                <i class="icon icon--like" aria-hidden="true"></i>
                <span data-like-count><?php echo $likes; ?></span>
                <?php _e('赞'); ?>
            </span>
            <span class="meta-item">
                <i class="icon icon--category" aria-hidden="true"></i>
                <?php $this->category(', '); ?>
            </span>
        </div>

        <p class="post-card__excerpt">
            <a href="<?php $this->permalink(); ?>"><?php $this->excerpt(120, '...'); ?></a>
        </p>

        <?php if (!empty($tags)): ?>
            <div class="post-card__tags">
                <i class="icon icon--tag" aria-hidden="true"></i>
                <?php $this->tags('', true, ''); ?>
            </div>
        <?php endif; ?>
    </div>
</article>
