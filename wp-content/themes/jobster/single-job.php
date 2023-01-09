<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

global $post;
get_header();

$jobs_settings = get_option('jobster_jobs_settings');
$layout =   isset($jobs_settings['jobster_job_page_layout_field']) 
            ? $jobs_settings['jobster_job_page_layout_field'] 
            : 'wide';

get_template_part('templates/single_job_' . $layout);

get_footer();
?>