<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

global $post;

$redirect = get_post_meta($post->ID, 'company_redirect', true);
$website = get_post_meta($post->ID, 'company_website', true);
if ($redirect == 1 && !empty($website)) {
    wp_redirect($website);
    exit;
}

get_header();

$companies_settings = get_option('jobster_companies_settings');
$layout =   isset($companies_settings['jobster_company_page_layout_field']) 
            ? $companies_settings['jobster_company_page_layout_field'] 
            : 'wide';

get_template_part('templates/single_company_' . $layout);

get_footer();
?>