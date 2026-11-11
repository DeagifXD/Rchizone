<?php
/**
 * 友情链接
 *
 * 以列表形式展示朋友们的头像与名字
 *
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 友链数据：name 名字、avatar 头像地址、url 站点地址（可留空，留空时不可点击）
 */
$friends = [
    ['name' => 'Baka9Cirno', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=1411299023&spec=100', 'url' => ''],
    ['name' => 'Yukino', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=497345109&spec=100', 'url' => ''],
    ['name' => 'BakaDuang', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=1224933754&spec=100', 'url' => ''],
    ['name' => '艾斯比', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=109002774&spec=100', 'url' => ''],
    ['name' => 'Lapluma', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=2216406477&spec=100', 'url' => ''],
    ['name' => 'Nun', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=1615649632&spec=100', 'url' => ''],
    ['name' => '培根', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=2480865292&spec=100', 'url' => ''],
    ['name' => 'Sakula', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=1002444182&spec=100', 'url' => ''],
    ['name' => '日奈', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=1541619899&spec=100', 'url' => ''],
    ['name' => 'Nya13', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=1436260130&spec=100', 'url' => ''],
    ['name' => 'TICO', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=315449839&spec=100', 'url' => ''],
    ['name' => '二级电锯', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=349275865&spec=100', 'url' => ''],
    ['name' => '磁暴', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=1753562893&spec=100', 'url' => ''],
    ['name' => 'Xiaoxin', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=2867242501&spec=100', 'url' => ''],
    ['name' => '夕立', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=1030139599&spec=100', 'url' => ''],
    ['name' => '寄豆', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=2139399440&spec=100', 'url' => ''],
    ['name' => '转寂西鬼', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=3331543071&spec=100', 'url' => ''],
    ['name' => 'FUFU', 'avatar' => 'https://q2.qlogo.cn/headimg_dl?dst_uin=2919007112&spec=100', 'url' => ''],
];

$this->need('header.php');
?>

<main class="site-main" role="main">
    <article class="article friends">
        <header class="friends__head">
            <p class="friends__kicker"><?php _e('Friends'); ?></p>
            <h1 class="friends__title"><?php $this->title(); ?></h1>
            <p class="friends__count"><?php printf(_t('共 %d 位小伙伴'), count($friends)); ?></p>
        </header>

        <?php if (trim((string) $this->content) !== ''): ?>
            <div class="friends__intro"><?php $this->content(); ?></div>
        <?php endif; ?>

        <div class="friend-list">
            <?php foreach ($friends as $friend): ?>
                <?php
                $name = (string) ($friend['name'] ?? '');
                $avatar = (string) ($friend['avatar'] ?? '');
                $url = (string) ($friend['url'] ?? '');
                $initial = $name === ''
                    ? '?'
                    : (function_exists('mb_substr') ? mb_substr($name, 0, 1, 'UTF-8') : substr($name, 0, 1));
                $tag = $url !== '' ? 'a' : 'div';
                ?>
                <<?php echo $tag; ?> class="friend<?php echo $url !== '' ? ' friend--link' : ''; ?>"
                    <?php if ($url !== ''): ?>href="<?php echo rchi_esc($url); ?>"
                    target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                    <span class="friend__avatar" data-initial="<?php echo rchi_esc($initial); ?>">
                        <?php if ($avatar !== ''): ?>
                            <img src="<?php echo rchi_esc($avatar); ?>"
                                 alt="<?php echo rchi_esc($name); ?>"
                                 loading="lazy" decoding="async" referrerpolicy="no-referrer"
                                 onerror="this.remove()">
                        <?php endif; ?>
                    </span>
                    <span class="friend__name"><?php echo rchi_esc($name); ?></span>
                </<?php echo $tag; ?>>
            <?php endforeach; ?>
        </div>
    </article>
</main>

<?php $this->need('footer.php'); ?>
