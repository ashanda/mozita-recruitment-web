<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

$colors_settings = get_option('jobster_colors_settings');

$text_color =   isset($colors_settings['jobster_text_color_field'])
                ? $colors_settings['jobster_text_color_field']
                : '';
$main_color =   isset($colors_settings['jobster_main_color_field'])
                ? $colors_settings['jobster_main_color_field']
                : '';
$main_color_t = isset($colors_settings['jobster_main_tranparent_color_field'])
                ? $colors_settings['jobster_main_tranparent_color_field']
                : '';
$main_color_d = isset($colors_settings['jobster_main_color_dark_field'])
                ? $colors_settings['jobster_main_color_dark_field']
                : '';
$main_color_l = isset($colors_settings['jobster_main_color_light_field'])
                ? $colors_settings['jobster_main_color_light_field']
                : '';
$secondary_color =  isset($colors_settings['jobster_secondary_color_field'])
                    ? $colors_settings['jobster_secondary_color_field']
                    : '';
$secondary_color_l =    isset($colors_settings['jobster_secondary_color_light_field'])
                        ? $colors_settings['jobster_secondary_color_light_field']
                        : '';

print '.pxp-root {';

if ($text_color != '') {
    print '--pxpTextColor: ' . esc_html($text_color) . ';';
}
if ($main_color != '') {
    print '--pxpMainColor: ' . esc_html($main_color) . ';';
    print '--pxpMainColorTransparent: ' . esc_html($main_color_t) . ';';
}
if ($main_color_d != '') {
    print '--pxpMainColorDark: ' . esc_html($main_color_d) . ';';
}
if ($main_color_l != '') {
    print '--pxpMainColorLight: ' . esc_html($main_color_l) . ';';
}
if ($secondary_color != '') {
    print '--pxpSecondaryColor: ' . esc_html($secondary_color) . ';';
}
if ($secondary_color_l != '') {
    print '--pxpSecondaryColorLight: ' . esc_html($secondary_color_l) . ';';
}

print '}';
?>