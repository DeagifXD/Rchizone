<?php 
/**
 * Rchizone
 * 
 * @package Rchizone
 * @author Deagif
 * @version 1.06
 */

$this->need('header.php'); ?>

<?php
    $hero_banner = $this->options->websiteBanner ? $this->options->websiteBanner : '/usr/themes/rchizone/assets/img/avatar.jpg';
    $hero_avatar = $this->options->websiteAvatar ? $this->options->websiteAvatar : '/usr/themes/rchizone/assets/img/avatar.jpg';
?>

<div class="index_hero" style="background-image: url('<?php echo $hero_banner; ?>')">
    <img class="avatar" src="<?php echo $hero_avatar; ?>">

    <h1 class="title"><?php $this->options->title(); ?></h1>
    <div class="divider"></div>
    <p class="desc"><?php $this->options->description(); ?></p>
    
    <div class="nav">
        <div class="nav-inner">
            <?php
                $links = explode("\n", $this->options->nav_links);
                foreach ($links as $link) {
                    $link = trim($link);
                    if (!$link) continue;
                    list($name, $url) = explode('|', $link);
                    echo '<a href="' . $url . '">' . $name . '</a><span class="dot">·</span>';
                }
            ?>

            <div class="nav-dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle">更多</a>

                <div class="dropdown-menu">
                    <?php
                        $links = explode("\n", $this->options->more_links);
                        foreach ($links as $link) {
                            $link = trim($link);
                            if (!$link) continue;
                            list($name, $url) = explode('|', $link);
                            echo '<a href="' . $url . '">' . $name . '</a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="index_container">
    <?php while($this->next()): ?> 
        <div class="index_post_card">
            <!-- 头图 -->
            <?php if ($this->fields->thumb): ?>
                <a href="<?php $this->permalink(); ?>">
                    <div class="thumb">
                        <img src="<?php $this->fields->thumb(); ?>" alt="">
                    </div>
                </a>
            <?php endif; ?>

            <!-- 标题 -->
            <h2 class="title">
                <a href="<?php $this->permalink(); ?>">
                    <?php $this->title(); ?>
                </a>
            </h2>

            <!-- 信息 -->
            <div class="meta">
                <span class="item">
                    <div class="base-icon calendar-icon icon-index"></div>
                    <?php $this->date("Y-m-d"); ?>
                </span>

                <span class="item">
                    <div class="base-icon comment-icon icon-index"></div>
                    <?php $this->commentsNum("%d 条评论"); ?>
                </span>

                <span class="item">
                    <div class="base-icon category-icon icon-index"></div>
                    <?php $this->category(","); ?>
                </span>
            </div>

            <!-- 内容 -->
            <div class="content">
                <a href="<?php $this->permalink(); ?>">
                    <?php $this->excerpt(120); ?>
                </a>
            </div>

            <!-- 标签 -->
            <?php if ($this->tags && count($this->tags) > 0): ?>
                <div class="tag">
                    <div class="base-icon tag-icon icon-index"></div>
                    <?php $this->tags('', true, ''); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

    <div class="index_pagination">
        <?php $this->pageNav('‹', '›', 3, '...'); ?>
    </div>

    <?php if ($this->options->showModule === 'yes'): ?>
        <div class="index_module">
            <div class="container">
                <!-- 最新评论 -->
                <div class="module_card">
                    <h3>最新评论</h3>
                    <div class="list">
                        <?php
                        $recentNum = $this->options->commentsListSize ? $this->options->commentsListSize : 5;
                        
                        \Widget\Comments\Recent::alloc(array(
                            'pageSize' => $recentNum,
                            'ignoreAuthor' => true
                        ))->to($comments);
                        
                        $hasComment = false;
                        
                        if ($comments->have()):
                            while ($comments->next()):
                                $hasComment = true;
                        ?>
                        <a href="<?php $comments->permalink(); ?>" class="item">
                            <span class="author"><?php $comments->author(false); ?>: </span>
                            <span class="comment"><?php $comments->excerpt(20, '...'); ?></span>
                        </a>
                        <?php
                            endwhile;
                        endif;
                        
                        // 若无有效评论，显示提示
                        if (!$hasComment):
                        ?>
                        <p class="empty">暂无评论</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 最近文章 -->
                <div class="module_card">
                    <h3>最近文章</h3>
                    <div class="list">
                        <?php
                            $pageSize = $this->options->postsListSize ? $this->options->postsListSize : 5;

                            \Widget\Contents\Post\Recent::alloc(array(
                                'pageSize' => $pageSize
                            ))->to($posts);
                        
                            $hasPost = false;
                        
                            if ($posts->have()):
                                while ($posts->next()):
                                    $hasPost = true;
                        ?>
                        <a href="<?php $posts->permalink(); ?>" class="item">
                            <span class="title"><?php $posts->title(); ?></span>
                            <span class="date"><?php $posts->date('Y-m-d'); ?></span>
                        </a>
                            <?php
                            endwhile;
                        endif;
                        
                        if (!$hasPost):
                        ?>
                        <p class="empty">暂无文章</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 近期归档 -->
                <div class="module_card">
                    <h3>近期归档</h3>
                    <div class="list">
                        <?php
                        $archives = $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y年m月&limit=6');

                        if ($archives->have()):
                            while ($archives->next()):
                        ?>
                        <a href="<?php $archives->permalink(); ?>" class="item">
                            <span class="title">
                                <?php $archives->date('Y年m月'); ?>
                            </span>
                        </a>
                        <?php
                            endwhile;
                        else:
                        ?>
                        <p class="empty">暂无归档</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="<?php $this->options->themeUrl('assets/js/index.js'); ?>?v=<?php echo THEME_VERSION; ?>"></script>

<?php $this->need('footer.php'); ?>