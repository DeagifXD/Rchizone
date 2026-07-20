<div class="post_container">
    <div class="card">

        <div class="content">
            <?php $this->content(); ?>
        </div>


        <?php if ($this->tags): ?>
            <div class="tags">
                <div class="base-icon tag-icon icon-index"></div>
                <?php $this->tags('', true, ''); ?>
            </div>
        <?php endif; ?>


        <div class="like-box">

            <button 
            id="like-btn" 
            data-cid="<?php echo $this->cid; ?>" 
            onclick="likePost(this)"
            >

                👍 点赞

                <span id="like-count">
                    <?php echo getLikeCount($this->cid); ?>
                </span>

            </button>

        </div>

    </div>
</div>


<script>

const likeUrl = "<?php $this->options->themeUrl('like.php'); ?>";

</script>


<script src="<?php $this->options->themeUrl('assets/js/like.js'); ?>?v=<?php echo THEME_VERSION; ?>"></script>