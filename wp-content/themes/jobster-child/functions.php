<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

add_action('wp_enqueue_scripts', 'jobster_enqueue_styles');
function jobster_enqueue_styles() {
    $parenthandle = 'jobster-style';
    $theme = wp_get_theme();

    wp_enqueue_style($parenthandle, get_template_directory_uri() . '/style.css', 
        array(
            'font-awesome',
            'pxp-base-font',
            'bootstrap',
            'owl-carousel',
            'owl-theme',
            'animate'
        ), 
        $theme->parent()->get('Version')
    );

    wp_enqueue_style('child-style', get_stylesheet_uri(),
        array($parenthandle),
        $theme->get('Version')
    );
}
?>