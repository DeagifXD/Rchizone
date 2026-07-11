<button id="backToTop" class="back-to-top">︿</button>
<script src="<?php $this->options->themeUrl('assets/js/backtotop.js'); ?>?v=<?php echo THEME_VERSION; ?>"></script>

<footer class="footer_container">
    <p class="text title">
        <?php
            $currentYear = date('Y');
            $startYear = $this->options->copyrightStartYear ?: $currentYear;

            $yearText = ($startYear != $currentYear) ? "{$startYear}-{$currentYear}" : $currentYear;
        ?>
        © <?php echo $yearText; ?> <?php $this->options->title(); ?>
    </p>

    <p class="text">
        <a href="https://typecho.org/">Powered by Typecho</a> | <a href="https://github.com/DeagifXD/Rchizone">Theme by Rchizone</a>
    </p>

    <?php
        $icp = $this->options->icpString;
        $filing = $this->options->filingString;

        if ($icp || $filing) {
            echo '<p class="text">';
        
            if ($icp) {
                echo '<a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener noreferrer">' 
                    . $icp . 
                '</a>';
            }
        
            if ($icp && $filing) {
                echo ' | ';
            }
        
            if ($filing) {
                echo '<a href="http://www.beian.gov.cn/portal/registerSystemInfo" target="_blank" rel="noopener noreferrer">' 
                    . $filing . 
                '</a>';
            }
        
            echo '</p>';
        }
    ?>
</footer>

</body>
</html>