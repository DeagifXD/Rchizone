<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
$currentYear = date('Y');
$startYear = (int) ($this->options->rchiCopyrightStart ?: $currentYear);
$yearText = ($startYear > 0 && $startYear < $currentYear)
    ? $startYear . '-' . $currentYear
    : (string) $currentYear;

$icp = trim((string) $this->options->rchiIcp);
$filing = trim((string) $this->options->rchiFiling);
?>

<footer class="site-footer">
    <div class="site-footer__card">
        <p class="site-footer__line site-footer__line--title">
            &copy; <?php echo rchi_esc($yearText); ?>
            <a href="<?php echo rchi_esc($this->options->siteUrl); ?>"><?php $this->options->title(); ?></a>
        </p>

        <p class="site-footer__line">
            <a href="https://typecho.org" target="_blank" rel="noopener noreferrer">Powered by Typecho</a>
            <span class="dot">|</span>
            <a href="https://github.com/DeagifXD/Rchizone" target="_blank" rel="noopener noreferrer">Theme by RchiZone</a>
        </p>

        <?php if ($icp !== '' || $filing !== ''): ?>
            <p class="site-footer__line">
                <?php if ($icp !== ''): ?>
                    <a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener noreferrer"><?php echo rchi_esc($icp); ?></a>
                <?php endif; ?>
                <?php if ($icp !== '' && $filing !== ''): ?>
                    <span class="dot">|</span>
                <?php endif; ?>
                <?php if ($filing !== ''): ?>
                    <a href="http://www.beian.gov.cn/portal/registerSystemInfo" target="_blank"
                       rel="noopener noreferrer"><?php echo rchi_esc($filing); ?></a>
                <?php endif; ?>
            </p>
        <?php endif; ?>

        <?php if ($this->options->rchiFooter): ?>
            <div class="site-footer__extra"><?php echo $this->options->rchiFooter; ?></div>
        <?php endif; ?>
    </div>
</footer>

<button class="theme-toggle" type="button" aria-label="<?php _e('切换夜间模式'); ?>" title="<?php _e('切换夜间模式'); ?>">
    <svg class="icon-sun" viewBox="0 0 24 24" width="20" height="20" fill="none"
         stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 14.5A8.5 8.5 0 0 1 9.5 4a7 7 0 1 0 10.5 10.5z"></path>
    </svg>
    <svg class="icon-moon" viewBox="0 0 24 24" width="20" height="20" fill="none"
         stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
        <circle cx="12" cy="12" r="4"></circle>
        <path d="M12 2v2M12 20v2M2 12h2M20 12h2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M19.1 4.9l-1.4 1.4M6.3 17.7l-1.4 1.4"></path>
    </svg>
</button>

<button class="to-top" type="button" aria-label="<?php _e('返回顶部'); ?>">
    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 19V5"></path>
        <path d="M6 11l6-6 6 6"></path>
    </svg>
</button>

<?php $this->footer(); ?>

<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="<?php _e('图片查看器'); ?>">
    <button class="lightbox__close" type="button" aria-label="<?php _e('关闭'); ?>" title="<?php _e('关闭'); ?>">&times;</button>

    <button class="lightbox__nav lightbox__nav--prev" type="button"
            data-lb-prev aria-label="<?php _e('上一张'); ?>" title="<?php _e('上一张'); ?>">&#8249;</button>

    <figure class="lightbox__figure">
        <img class="lightbox__img" alt="">
        <figcaption class="lightbox__caption"></figcaption>
    </figure>

    <button class="lightbox__nav lightbox__nav--next" type="button"
            data-lb-next aria-label="<?php _e('下一张'); ?>" title="<?php _e('下一张'); ?>">&#8250;</button>

    <div class="lightbox__counter" aria-live="polite"></div>
</div>

<script src="<?php $this->options->themeUrl('assets/js/theme.js'); ?>?v=<?php echo RCHI_VERSION; ?>"></script>
</body>
</html>
