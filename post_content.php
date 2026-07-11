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
    </div>
</div>