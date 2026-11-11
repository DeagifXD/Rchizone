<?php
/**
 * Rchizone
 *
 * 粉色星星背景 + 深棕导航的轻量博客主题
 *
 * @package Rchizone
 * @author RchiZone
 * @version 1.6.4
 * @link https://typecho.org
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<main class="site-main" role="main">
    <?php if (!$this->is('index')): ?>
        <h1 class="archive-title">
            <?php $this->archiveTitle([
                'category' => _t('分类「%s」下的文章'),
                'search'   => _t('包含关键字「%s」的文章'),
                'tag'      => _t('标签「%s」下的文章'),
                'author'   => _t('%s 发布的文章')
            ], '', ''); ?>
        </h1>
    <?php endif; ?>

    <?php if ($this->have()): ?>
        <?php while ($this->next()): ?>
            <?php $this->need('card.php'); ?>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty-state">
            <p><?php _e('这里还没有内容，去后台写一篇吧。'); ?></p>
        </div>
    <?php endif; ?>

    <?php $this->pageNav('&lsaquo;', '&rsaquo;', 3, '&hellip;'); ?>

    <?php if ($this->is('index')): ?>
        <section class="widgets">
            <div class="widget-card">
                <h3><?php _e('最新文章'); ?></h3>
                <ul class="widget-list">
                    <?php \Widget\Contents\Post\Recent::alloc('pageSize=5')
                        ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                </ul>
            </div>

            <div class="widget-card">
                <h3><?php _e('热门标签'); ?></h3>
                <div class="tag-cloud">
                    <?php \Widget\Metas\Tag\Cloud::alloc('sort=count&desc=1&limit=18')->to($tags); ?>
                    <?php while ($tags->next()): ?>
                        <a href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="widget-card">
                <h3><?php _e('近期归档'); ?></h3>
                <ul class="widget-list">
                    <?php \Widget\Contents\Post\Date::alloc('type=month&format=Y年m月')
                        ->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php $this->need('footer.php'); ?>
