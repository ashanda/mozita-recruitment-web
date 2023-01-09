<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_admin_jobs')):
    function jobster_admin_jobs() {
        add_settings_section(
            'jobster_jobs_section',
            __('Jobs', 'jobster'),
            'jobster_jobs_section_callback',
            'jobster_jobs_settings'
        );
        add_settings_field(
            'jobster_jobs_per_page_field',
            __('Jobs per Page', 'jobster'),
            'jobster_jobs_per_page_field_render',
            'jobster_jobs_settings',
            'jobster_jobs_section'
        );
        add_settings_field(
            'jobster_job_page_layout_field',
            __('Job Page Layout', 'jobster'),
            'jobster_job_page_layout_field_render',
            'jobster_jobs_settings',
            'jobster_jobs_section'
        );
        add_settings_field(
            'jobster_job_page_similar_field',
            __('Show Similar Jobs on Job Page', 'jobster'),
            'jobster_job_page_similar_field_render',
            'jobster_jobs_settings',
            'jobster_jobs_section'
        );
        add_settings_field(
            'jobster_job_page_similar_title_field',
            __('Similar Jobs Title on Job Page', 'jobster'),
            'jobster_job_page_similar_title_field_render',
            'jobster_jobs_settings',
            'jobster_jobs_section'
        );
        add_settings_field(
            'jobster_job_page_similar_subtitle_field',
            __('Similar Jobs Subtitle on Job Page', 'jobster'),
            'jobster_job_page_similar_subtitle_field_render',
            'jobster_jobs_settings',
            'jobster_jobs_section'
        );
        add_settings_field(
            'jobster_job_anonymous_apply_field',
            __('Allow candidates to apply to jobs without being registered', 'jobster'),
            'jobster_job_anonymous_apply_field_render',
            'jobster_jobs_settings',
            'jobster_jobs_section'
        );
    }
endif;

if (!function_exists('jobster_jobs_section_callback')): 
    function jobster_jobs_section_callback() { 
        echo '';
    }
endif;

if (!function_exists('jobster_jobs_per_page_field_render')): 
    function jobster_jobs_per_page_field_render() { 
        $options = get_option('jobster_jobs_settings'); ?>

        <input 
            type="number" 
            step="1" 
            min="1" 
            name="jobster_jobs_settings[jobster_jobs_per_page_field]" 
            id="jobster_jobs_settings[jobster_jobs_per_page_field]" 
            style="width: 65px;" 
            value="<?php if (isset($options['jobster_jobs_per_page_field'])) { 
                    echo esc_attr($options['jobster_jobs_per_page_field']); 
                } ?>" 
        />
    <?php }
endif;

if (!function_exists('jobster_job_page_layout_field_render')): 
    function jobster_job_page_layout_field_render() {
        $options = get_option('jobster_jobs_settings'); ?>

        <select 
            name="jobster_jobs_settings[jobster_job_page_layout_field]" 
            id="jobster_jobs_settings[jobster_job_page_layout_field]"
        >
            <option 
                value="wide" 
                <?php selected(
                    isset($options['jobster_job_page_layout_field'])
                    && $options['jobster_job_page_layout_field'] == 'wide'
                ) ?>
            >
                <?php esc_html_e('Wide', 'jobster'); ?>
            </option>
            <option 
                value="side" 
                <?php selected(
                    isset($options['jobster_job_page_layout_field'])
                    && $options['jobster_job_page_layout_field'] == 'side'
                ) ?>
            >
                <?php esc_html_e('Side', 'jobster'); ?>
            </option>
            <option 
                value="center" 
                <?php selected(
                    isset($options['jobster_job_page_layout_field'])
                    && $options['jobster_job_page_layout_field'] == 'center'
                ) ?>
            >
                <?php esc_html_e('Center', 'jobster'); ?>
            </option>
        </select>
    <?php }
endif;

if (!function_exists('jobster_job_page_similar_field_render')): 
    function jobster_job_page_similar_field_render() { 
        $options = get_option('jobster_jobs_settings'); ?>

        <input 
            type="checkbox" 
            name="jobster_jobs_settings[jobster_job_page_similar_field]" 
            <?php if (isset($options['jobster_job_page_similar_field'])) { 
                checked($options['jobster_job_page_similar_field'], 1); 
            } ?> 
            value="1"
        >
    <?php }
endif;

if (!function_exists('jobster_job_page_similar_title_field_render')): 
    function jobster_job_page_similar_title_field_render() { 
        $options = get_option('jobster_jobs_settings'); ?>

        <input 
            type="text" 
            name="jobster_jobs_settings[jobster_job_page_similar_title_field]" 
            id="jobster_jobs_settings[jobster_job_page_similar_title_field]" 
            style="width: 50%;" 
            value="<?php if (isset($options['jobster_job_page_similar_title_field'])) {
                    echo esc_attr($options['jobster_job_page_similar_title_field']);
                } ?>" 
        />
    <?php }
endif;

if (!function_exists('jobster_job_page_similar_subtitle_field_render')): 
    function jobster_job_page_similar_subtitle_field_render() { 
        $options = get_option('jobster_jobs_settings'); ?>

        <input 
            type="text" 
            name="jobster_jobs_settings[jobster_job_page_similar_subtitle_field]" 
            id="jobster_jobs_settings[jobster_job_page_similar_subtitle_field]" 
            style="width: 50%;" 
            value="<?php if (isset($options['jobster_job_page_similar_subtitle_field'])) {
                    echo esc_attr($options['jobster_job_page_similar_subtitle_field']);
                } ?>" 
        />
    <?php }
endif;

if (!function_exists('jobster_job_anonymous_apply_field_render')): 
    function jobster_job_anonymous_apply_field_render() { 
        $options = get_option('jobster_jobs_settings'); ?>

        <input 
            type="checkbox" 
            name="jobster_jobs_settings[jobster_job_anonymous_apply_field]" 
            <?php if (isset($options['jobster_job_anonymous_apply_field'])) { 
                checked($options['jobster_job_anonymous_apply_field'], 1); 
            } ?> 
            value="1"
        >
    <?php }
endif;
?>