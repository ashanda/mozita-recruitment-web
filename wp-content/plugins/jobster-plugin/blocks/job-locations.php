<?php
/**
 * Job locations block
 */
if (!function_exists('jobster_job_locations_block')): 
    function jobster_job_locations_block() {
        wp_register_script(
            'jobster-job-locations-block',
            plugins_url('js/job-locations.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-components',
                'wp-editor',
                'wp-i18n'
            )
        );

        wp_enqueue_style(
            'jobster-job-locations-block-editor',
            plugins_url('css/job-locations.css', __FILE__),
            array('wp-edit-blocks')
        );

        wp_localize_script('jobster-job-locations-block', 'jl_vars', 
            array(
                'locations' => jobster_get_job_locations()
            )
        );

        register_block_type('jobster-plugin/job-locations', array(
            'editor_script' => 'jobster-job-locations-block',
            'attributes' => array(
                'data_content' => array('type' => 'string')
            ),
            'render_callback' => 'jobster_job_locations_block_render'
        ));
    }
endif;
add_action('init', 'jobster_job_locations_block');

if (!function_exists('jobster_job_locations_block_render')): 
    function jobster_job_locations_block_render($attrs, $content = null) {
        extract(shortcode_atts(array('data_content'), $attrs));

        if (!isset($attrs['data_content'])) {
            return null;
        }

        $data = json_decode(urldecode($attrs['data_content']), true);

        $animation =    isset($data['animation']) && $data['animation'] == 'e'
                        ? 'pxp-animate-in pxp-animate-in-top'
                        : '';

        $align_text = '';
        $align_cards = '';
        if (isset($data['align']) && $data['align'] == 'c') {
            $align_text = 'text-center';
            $align_cards = 'justify-content-center';
        }

        $search_jobs_url = jobster_get_page_link('job-search.php');

    }
endif;
?>