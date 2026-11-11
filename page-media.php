<?php
/**
 * 媒体库
 *
 * 展示后台上传的图片、视频等媒体文件
 *
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$this->need('header.php');

$db = \Typecho\Db::get();
$options = \Widget\Options::alloc();

$mediaItems = $db->fetchAll(
    $db->select('cid', 'title', 'text', 'created')
        ->from('table.contents')
        ->where('type = ?', 'attachment')
        ->where('status = ?', 'publish')
        ->order('created', \Typecho\Db::SORT_DESC)
);

$imageTypes = ['jpg', 'jpeg', 'gif', 'png', 'tiff', 'bmp', 'webp', 'avif'];
$videoTypes = ['mp4', 'webm', 'ogv', 'ogg', 'mov', 'm4v'];
?>

<main class="site-main" role="main">
    <article class="article">
        <h1 class="article__title"><?php $this->title(); ?></h1>

        <div class="article__content">
            <?php $this->content(); ?>

            <?php if (!empty($mediaItems)): ?>
                <div class="media-grid">
                    <?php foreach ($mediaItems as $mediaItem): ?>
                        <?php
                        $info = json_decode((string) $mediaItem['text'], true);
                        $info = is_array($info) ? $info : [];

                        $path = (string) ($info['path'] ?? '');
                        $type = strtolower((string) ($info['type'] ?? ''));
                        $name = (string) ($info['name'] ?? basename($path));
                        $url = $path !== '' ? \Typecho\Common::url($path, $options->siteUrl) : '';

                        if ($url === '') {
                            continue;
                        }
                        ?>
                        <?php if (in_array($type, $imageTypes, true)): ?>
                            <a class="media-item" href="<?php echo rchi_esc($url); ?>"
                               target="_blank" rel="noopener">
                                <img src="<?php echo rchi_esc($url); ?>" alt="<?php echo rchi_esc($name); ?>"
                                     loading="lazy">
                            </a>
                        <?php elseif (in_array($type, $videoTypes, true)): ?>
                            <div class="media-item">
                                <video controls preload="metadata" src="<?php echo rchi_esc($url); ?>"></video>
                                <span class="media-item__badge"><?php _e('视频'); ?></span>
                            </div>
                        <?php else: ?>
                            <a class="media-item" href="<?php echo rchi_esc($url); ?>"
                               target="_blank" rel="noopener">
                                <span class="media-file"><?php echo rchi_esc($name); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="page-empty">
                    <?php _e('媒体库还是空的，去后台「管理 → 媒体库」上传图片或视频后就会显示在这里。'); ?>
                </p>
            <?php endif; ?>
        </div>
    </article>
</main>

<?php $this->need('footer.php'); ?>
