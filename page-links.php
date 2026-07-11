<?php
/**
 * 友情链接页面
 *
 * @package custom
 */
$this->need('header.php');
?>

<?php 
$links = [];
$friendsUrl = $this->fields->friendLinks;

if (!empty($friendsUrl)) {

    // 如果是本地路径，自动补全成 URL
    if (strpos($friendsUrl, '/usr/') === 0) {
        $friendsUrl = $this->options->siteUrl . ltrim($friendsUrl, '/');
    }

    $json = @file_get_contents($friendsUrl);

    if ($json !== false) {
        $decoded = json_decode($json, true);
        if (is_array($decoded)) {
            $links = $decoded;
        }
    }
}
?>

<a href="<?php $this->options->siteUrl(); ?>" class="back-home">&lt; 返回</a>

<?php $this->need('post_hero.php'); ?>

<div class="post_container">
    <div class="card">
        <div class="content">
            <?php $this->content(); ?>

            <h2>小伙伴们</h2>
            <div class="links-container">
                <?php foreach ($links as $link): ?>
                    <div class="card">
                        <div class="avatar">
                            <img src="<?php echo $link['avatar'] ?>">
                        </div>
                        <div class="info">
                            <div class="name"><?php echo $link['name']; ?></div>
                            <div class="desc"><?php echo $link['desc']; ?></div>
                        </div>
                        <?php if(!empty($link['url'])): ?>
                            <a href="<?php echo $link['url'] ?>" class="link-button">
                                <div class="base-icon link-icon icon-link"></div>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($this->tags): ?>
            <div class="tags">
                <div class="base-icon tag-icon icon-index"></div>
                <?php $this->tags('', true, ''); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->need('comments.php'); ?>

<?php $this->need('modal.php'); ?>

<?php $this->need('footer.php'); ?>