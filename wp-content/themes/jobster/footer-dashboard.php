<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

$footer_settings = get_option('jobster_footer_settings');
$copyright =    isset($footer_settings['jobster_copyright_field'])
                ? $footer_settings['jobster_copyright_field']
                : ''; ?>
    <footer>
        <?php if ($copyright != '') { ?>
            <div class="pxp-footer-copyright pxp-text-light">
                <?php echo esc_html($copyright); ?>
            </div>
        <?php } ?>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>