<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<main class="site-main" role="main">
    <article class="article">
        <h1 class="article__title"><?php $this->title(); ?></h1>
        <div class="article__content" itemprop="articleBody">
            <?php $this->content(); ?>
        </div>
    </article>
</main>

<?php $this->need('footer.php'); ?>
