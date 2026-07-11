<?php
$thumb = $this->fields->thumb;
$hero_banner = $this->options->websiteBanner ? $this->options->websiteBanner : '/usr/themes/rchizone/assets/img/avatar.jpg';
$thumb = $thumb ? $thumb : $hero_banner;
?>

<div class="post_hero" style="background-image: url('<?php echo $thumb; ?>')" data-preview="<?php echo $thumb; ?>">
    <div class="mask"></div>
    <div class="content">
        <h1><?php $this->title() ?></h1>
        <div class="divider"></div>
        <div class="meta">
            <span class="item">
                <div class="base-icon calendar-icon icon-post"></div>
                <?php $this->date('发布于 Y-m-d'); ?>
                <div class="base-icon comment-icon icon-post"></div>
                <?php $this->commentsNum('%d 条评论'); ?>
                <?php if ($this->categories): ?>
                    <div class="base-icon category-icon icon-post"></div>
                    <?php $this->category(','); ?>
                <?php endif ; ?>
            </span>
        </div>
    </div>
</div>