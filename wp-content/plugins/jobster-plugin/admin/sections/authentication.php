<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_admin_authentication')): 
    function jobster_admin_authentication() {
        add_settings_section(
            'jobster_authentication_section', 
            __('Authentication', 'jobster'), 
            'jobster_authentication_section_callback', 
            'jobster_authentication_settings'
        );
        add_settings_field(
            'jobster_terms_field', 
            __('Terms and Conditions Page', 'jobster'), 
            'jobster_terms_field_render', 
            'jobster_authentication_settings', 
            'jobster_authentication_section'
        );
        add_settings_field(
            'jobster_signin_redirect_candidate_field', 
            __('Candidate After Sign In Redirect Page', 'jobster'), 
            'jobster_signin_redirect_candidate_field_render', 
            'jobster_authentication_settings', 
            'jobster_authentication_section'
        );
        add_settings_field(
            'jobster_signin_redirect_company_field', 
            __('Company After Sign In Redirect Page', 'jobster'), 
            'jobster_signin_redirect_company_field_render', 
            'jobster_authentication_settings', 
            'jobster_authentication_section'
        );
        add_settings_field(
            'jobster_disable_candidate_field', 
            __('Disable Candidate Registration', 'jobster'), 
            'jobster_disable_candidate_field_render', 
            'jobster_authentication_settings', 
            'jobster_authentication_section'
        );
        add_settings_field(
            'jobster_disable_company_field', 
            __('Disable Company Registration', 'jobster'), 
            'jobster_disable_company_field_render', 
            'jobster_authentication_settings', 
            'jobster_authentication_section'
        );
    }
endif;

if (!function_exists('jobster_authentication_section_callback')): 
    function jobster_authentication_section_callback() { 
        echo '';
    }
endif;

if (!function_exists('jobster_terms_field_render')): 
    function jobster_terms_field_render() {
        $options = get_option('jobster_authentication_settings'); 

        $pages_list = '';
        $selected_page =    isset($options['jobster_terms_field'])
                            ? $options['jobster_terms_field']
                            : '';

        $args = array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $page_selection = new WP_Query($args);
        $page_selection_arr  = get_object_vars($page_selection);

        if (is_array($page_selection_arr['posts']) 
            && count($page_selection_arr['posts']) > 0
        ) {
            foreach ($page_selection_arr['posts'] as $page) {
                $pages_list .= '<option value="' . esc_attr($page->ID) . '"';
                if ($page->ID == $selected_page) {
                    $pages_list .= ' selected';
                }
                $pages_list .= '>' . $page->post_title . '</option>';
            }
        } ?>

        <select name="jobster_authentication_settings[jobster_terms_field]">
            <option value=""><?php esc_html_e('None', 'jobster'); ?></option>

            <?php if (is_array($page_selection_arr['posts']) 
                && count($page_selection_arr['posts']) > 0
            ) {
                foreach ($page_selection_arr['posts'] as $page) { ?>
                    <option 
                        value="<?php echo esc_attr($page->ID); ?>" 
                        <?php selected($page->ID, $selected_page); ?>
                    >
                        <?php echo esc_html($page->post_title); ?>
                    </option>
                <?php }
            } ?>
        </select>
    <?php }
endif;

if (!function_exists('jobster_signin_redirect_candidate_field_render')): 
    function jobster_signin_redirect_candidate_field_render() {
        $options = get_option('jobster_authentication_settings'); 

        $pages_list = '';
        $selected_page =    isset($options['jobster_signin_redirect_candidate_field'])
                            ? $options['jobster_signin_redirect_candidate_field']
                            : '';

        $args = array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $page_selection = new WP_Query($args);
        $page_selection_arr  = get_object_vars($page_selection);

        if (is_array($page_selection_arr['posts']) 
            && count($page_selection_arr['posts']) > 0
        ) {
            foreach ($page_selection_arr['posts'] as $page) {
                $pages_list .= '<option value="' . esc_attr($page->ID) . '"';
                if ($page->ID == $selected_page) {
                    $pages_list .= ' selected';
                }
                $pages_list .= '>' . $page->post_title . '</option>';
            }
        } ?>

        <select name="jobster_authentication_settings[jobster_signin_redirect_candidate_field]">
            <option value="">
                <?php esc_html_e('Default (Current Page)', 'jobster'); ?>
            </option>

            <?php if (is_array($page_selection_arr['posts']) 
                && count($page_selection_arr['posts']) > 0
            ) {
                foreach ($page_selection_arr['posts'] as $page) { ?>
                    <option 
                        value="<?php echo esc_attr($page->ID); ?>" 
                        <?php selected($page->ID, $selected_page); ?>
                    >
                        <?php echo esc_html($page->post_title); ?>
                    </option>
                <?php }
            } ?>
        </select>
    <?php }
endif;

if (!function_exists('jobster_signin_redirect_company_field_render')): 
    function jobster_signin_redirect_company_field_render() {
        $options = get_option('jobster_authentication_settings'); 

        $pages_list = '';
        $selected_page =    isset($options['jobster_signin_redirect_company_field'])
                            ? $options['jobster_signin_redirect_company_field']
                            : '';

        $args = array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $page_selection = new WP_Query($args);
        $page_selection_arr  = get_object_vars($page_selection);

        if (is_array($page_selection_arr['posts']) 
            && count($page_selection_arr['posts']) > 0
        ) {
            foreach ($page_selection_arr['posts'] as $page) {
                $pages_list .= '<option value="' . esc_attr($page->ID) . '"';
                if ($page->ID == $selected_page) {
                    $pages_list .= ' selected';
                }
                $pages_list .= '>' . $page->post_title . '</option>';
            }
        } ?>

        <select name="jobster_authentication_settings[jobster_signin_redirect_company_field]">
            <option value="">
                <?php esc_html_e('Default (Current Page)', 'jobster'); ?>
            </option>

            <?php if (is_array($page_selection_arr['posts']) 
                && count($page_selection_arr['posts']) > 0
            ) {
                foreach ($page_selection_arr['posts'] as $page) { ?>
                    <option 
                        value="<?php echo esc_attr($page->ID); ?>" 
                        <?php selected($page->ID, $selected_page); ?>
                    >
                        <?php echo esc_html($page->post_title); ?>
                    </option>
                <?php }
            } ?>
        </select>
    <?php }
endif;

if (!function_exists('jobster_disable_candidate_field_render')): 
    function jobster_disable_candidate_field_render() { 
        $options = get_option('jobster_authentication_settings'); ?>

        <input 
            type="checkbox" 
            name="jobster_authentication_settings[jobster_disable_candidate_field]" 
            <?php if (isset($options['jobster_disable_candidate_field'])) { 
                checked($options['jobster_disable_candidate_field'], 1);
            } ?> 
            value="1"
        >
    <?php }
endif;

if (!function_exists('jobster_disable_company_field_render')): 
    function jobster_disable_company_field_render() { 
        $options = get_option('jobster_authentication_settings'); ?>

        <input 
            type="checkbox" 
            name="jobster_authentication_settings[jobster_disable_company_field]" 
            <?php if (isset($options['jobster_disable_company_field'])) { 
                checked($options['jobster_disable_company_field'], 1); 
            } ?> 
            value="1"
        >
    <?php }
endif;
?>