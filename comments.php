<?php
function threadedComments($comments, $options) {
    ?>
    <li id="li-<?php $comments->theId(); ?>" class="comment-item">
        <div class="comment-box">
            <div class="comment-avatar">
                <?php $comments->gravatar(50); ?>
            </div>

            <div class="comment-content">
                <div class="comment-meta">
                    <span class="comment-author">
                        <?php $comments->author(); ?>
                    </span>
                    <span class="comment-date">
                        <?php $comments->date('Y-m-d H:i'); ?>
                    </span>

                    <a href="javascript:void(0);" 
                        class="comment-reply-btn"
                        data-coid="<?php $comments->coid(); ?>"
                        data-author="<?php $comments->author(); ?>">
                        回复
                    </a>
                </div>

                <?php if ($comments->parent): ?>
                    <div class="comment-reply">
                        回复 @<?php $comments->parentAuthor(); ?>：
                    </div>
                <?php endif; ?>

                <div class="comment-text">
                    <?php $comments->content(); ?>
                </div>
            </div>
        </div>

        <?php if ($comments->children): ?>
            <ul class="comment-children">
                <?php $comments->threadedComments($options); ?>
            </ul>
        <?php endif; ?>
    </li>
    <?php
}
?>

<div class="comment-container">
    <div class="comment-card" id="comments">
        <h3 class="title"><?php $this->commentsNum('%d 条评论'); ?></h3>

        <?php $this->comments()->to($comments); ?>
        <?php if ($comments->have()): ?>
            <ul class="comment-list">
                <?php $comments->listComments([
                    'callback' => 'threadedComments'
                ]); ?>
            </ul>
        <?php endif; ?>

        <?php if ($this->allow("comment")): ?>
            <div id="<?php $this->respondId(); ?>" class="respond">
                <div id="reply-notification" class="reply-notification" style="display: none;">
                    <span>正在回复 <strong id="reply-author-name"></strong></span>
                    <a href="javascript:void(0);" id="cancel-reply-btn" class="cancel-reply-btn">取消回复</a>
                </div>

                <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" class="comment-form">
                    <input type="hidden" name="parent" id="comment-parent" value="0">
                    
                    <div class="input_text">
                        <textarea name="text" id="textarea" required placeholder="请输入评论内容"></textarea>
                    </div>

                    <div class="input_expert">
                        <?php if (!$this->user->hasLogin()): ?>
                            <div class="info">
                                <div class="label"><span>昵称</span></div>
                                <input type="text" name="author" id="comment-author" placeholder="你的昵称" required>
                            </div>
                            <div class="info">
                                <div class="label"><span>邮箱</span></div>
                                <input type="email" name="mail" id="comment-email" placeholder="邮箱"
                                <?php if ($this->options->commentsRequireMail): ?> required <?php endif; ?>>
                            </div>
                            <div class="info">
                                <div class="label"><span>网站</span></div>
                                <input type="url" name="url" id="comment-url" placeholder="https://"
                                <?php if ($this->options->commentsRequireUrl): ?> required <?php endif; ?>>
                            </div>
                        <?php endif; ?>

                        <button type="submit" id="comment-submit-btn">发送</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <p>评论已关闭</p>
        <?php endif; ?>
    </div>
</div>

<script src="<?php $this->options->themeUrl('assets/js/comments.js'); ?>?v=<?php echo THEME_VERSION; ?>"></script>

<script>
    const textarea = document.getElementById('textarea');

    if (textarea) {
        const counter = document.createElement('div');
        counter.style.textAlign = 'right';
        counter.style.fontSize = '12px';
        counter.style.color = '#999';
        counter.innerText = '0 / 300';

        textarea.parentNode.appendChild(counter);

        textarea.addEventListener('input', function () {
            let len = textarea.value.length;

            if (len > 300) {
                textarea.value = textarea.value.substring(0, 300);
                len = 300;
            }

            counter.innerText = len + ' / 300';
        });
    }
</script>