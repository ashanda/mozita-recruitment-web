<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

global $post;
get_header();

$candidates_settings = get_option('jobster_candidates_settings');
$layout =   isset($candidates_settings['jobster_candidate_page_layout_field']) 
            ? $candidates_settings['jobster_candidate_page_layout_field'] 
            : 'wide';

get_template_part('templates/single_candidate_' . $layout);

get_footer();
?>