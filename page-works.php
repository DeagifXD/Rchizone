<?php
/**
 * 作品集
 *
 * 聚合「作品」「小说」等标签下的文章，以电子书目录的形式呈现
 *
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$this->need('header.php');

$works = rchi_posts_by_tags(['作品', '小说'], 100);
$intro = trim((string) $this->content);
?>

<main class="site-main" role="main">
    <article class="article ebook">
        <header class="ebook__cover">
            <p class="ebook__kicker"><?php _e('Collection'); ?></p>
            <h1 class="ebook__title"><?php $this->title(); ?></h1>
            <p class="ebook__sub">
                <?php printf(_t('共 %d 篇'), count($works)); ?> · <?php echo date('Y'); ?>
            </p>
            <span class="ebook__ornament" aria-hidden="true"></span>
        </header>

        <?php if ($intro !== ''): ?>
            <div class="ebook__intro"><?php echo $intro; ?></div>
        <?php endif; ?>

        <?php if (!empty($works)): ?>
            <div class="ebook__toc" aria-hidden="true">
                <span><?php _e('目录'); ?></span>
                <span class="ebook__toc-line"></span>
                <span class="ebook__toc-en">Contents</span>
            </div>

            <div class="work-list">
                <?php $index = 0; ?>
                <?php foreach ($works as $work): ?>
                    <?php $index++; $no = sprintf('%02d', $index); ?>
                    <a class="work-item" href="<?php echo rchi_esc($work['permalink']); ?>">
                        <span class="work-item__no"><?php echo $no; ?></span>
                        <span class="work-item__thumb">
                            <img src="<?php echo rchi_esc($work['thumb']); ?>"
                                 alt="<?php echo rchi_esc($work['title']); ?>" loading="lazy">
                        </span>
                        <span class="work-item__body">
                            <span class="work-item__head">
                                <span class="work-item__title"><?php echo rchi_esc($work['title']); ?></span>
                                <span class="work-item__leader" aria-hidden="true"></span>
                                <span class="work-item__page">P.<?php echo $no; ?></span>
                            </span>
                            <span class="work-item__meta">
                                <span><?php echo (new \Typecho\Date($work['created']))->format('Y-m-d'); ?></span>
                                <?php if (!empty($work['tags'])): ?>
                                    <span class="work-item__sep">·</span>
                                    <span><?php echo rchi_esc(implode(' / ', $work['tags'])); ?></span>
                                <?php endif; ?>
                                <span class="work-item__sep">·</span>
                                <span><?php echo (int) $work['likes']; ?> <?php _e('赞'); ?></span>
                            </span>
                            <span class="work-item__excerpt"><?php echo rchi_esc($work['excerpt']); ?></span>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="ebook__foot">
                <span class="ebook__foot-label"><?php _e('索引'); ?></span>
                <div class="ebook__links">
                    <?php foreach (['作品', '小说'] as $tagName): ?>
                        <?php $tagUrl = rchi_tag_link($tagName); ?>
                        <?php if ($tagUrl): ?>
                            <a href="<?php echo rchi_esc($tagUrl); ?>">
                                <?php printf(_t('查看全部「%s」'), rchi_esc($tagName)); ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p class="page-empty">
                <?php _e('还没有作品，给文章加上「作品」或「小说」标签后就会显示在这里。'); ?>
            </p>
        <?php endif; ?>
    </article>
</main>

<?php $this->need('footer.php'); ?>
