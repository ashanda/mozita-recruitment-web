<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

/**
 * Register job custom post type
 */
if (!function_exists('jobster_register_job_type')): 
    function jobster_register_job_type() {
        register_post_type('job', array(
            'labels' => array(
                'name'               => __('Jobs', 'jobster'),
                'singular_name'      => __('Job', 'jobster'),
                'add_new'            => __('Add New Job', 'jobster'),
                'add_new_item'       => __('Add Job', 'jobster'),
                'edit'               => __('Edit', 'jobster'),
                'edit_item'          => __('Edit Job', 'jobster'),
                'new_item'           => __('New Job', 'jobster'),
                'view'               => __('View', 'jobster'),
                'view_item'          => __('View Job', 'jobster'),
                'search_items'       => __('Search Jobs', 'jobster'),
                'not_found'          => __('No Jobs found', 'jobster'),
                'not_found_in_trash' => __('No Jobs found in Trash', 'jobster'),
                'parent'             => __('Parent Job', 'jobster'),
            ),
            'public'                => true,
            'exclude_from_search '  => false,
            'has_archive'           => true,
            'rewrite'               => array('slug' => _x('jobs', 'URL SLUG', 'jobster')),
            'supports'              => array('title', 'editor'),
            'show_in_rest'          => true,
            'can_export'            => true,
            'register_meta_box_cb'  => 'jobster_add_job_metaboxes',
            'menu_icon'             => 'dashicons-portfolio',
        ));

        // add job location taxonomy
        register_taxonomy('job_location', 'job', array(
            'labels' => array(
                'name'                       => __('Job Locations', 'jobster'),
                'singular_name'              => __('Job Location', 'jobster'),
                'search_items'               => __('Search Job Locations', 'jobster'),
                'popular_items'              => __('Popular Job Locations', 'jobster'),
                'all_items'                  => __('All Job Locations', 'jobster'),
                'edit_item'                  => __('Edit Job Location', 'jobster'),
                'update_item'                => __('Update Job Location', 'jobster'),
                'add_new_item'               => __('Add New Job Location', 'jobster'),
                'new_item_name'              => __('New Job Location Name', 'jobster'),
                'separate_items_with_commas' => __('Separate job locations with commas', 'jobster'),
                'add_or_remove_items'        => __('Add or remove job locations', 'jobster'),
                'choose_from_most_used'      => __('Choose from the most used job locations', 'jobster'),
                'not_found'                  => __('No job location found.', 'jobster'),
                'menu_name'                  => __('Job Locations', 'jobster'),
            ),
            'hierarchical'      => true,
            'query_var'         => true,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'job-location'),
            'show_in_rest'      => true,
        ));

        // add job category taxonomy
        register_taxonomy('job_category', 'job', array(
            'labels' => array(
                'name'                       => __('Job Categories', 'jobster'),
                'singular_name'              => __('Job Category', 'jobster'),
                'search_items'               => __('Search Job Categories', 'jobster'),
                'popular_items'              => __('Popular Job Categories', 'jobster'),
                'all_items'                  => __('All Job Categories', 'jobster'),
                'edit_item'                  => __('Edit Job Category', 'jobster'),
                'update_item'                => __('Update Job Category', 'jobster'),
                'add_new_item'               => __('Add New Job Category', 'jobster'),
                'new_item_name'              => __('New Job Category Name', 'jobster'),
                'separate_items_with_commas' => __('Separate job categories with commas', 'jobster'),
                'add_or_remove_items'        => __('Add or remove job categories', 'jobster'),
                'choose_from_most_used'      => __('Choose from the most used job categories', 'jobster'),
                'not_found'                  => __('No job category found.', 'jobster'),
                'menu_name'                  => __('Job Categories', 'jobster'),
            ),
            'hierarchical'      => true,
            'query_var'         => true,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'job-category'),
            'show_in_rest'      => true,
        ));

        // add job employment type taxonomy
        register_taxonomy('job_type', 'job', array(
            'labels' => array(
                'name'                       => __('Job Types', 'jobster'),
                'singular_name'              => __('Job Type', 'jobster'),
                'search_items'               => __('Search Job Types', 'jobster'),
                'popular_items'              => __('Popular Job Types', 'jobster'),
                'all_items'                  => __('All Job Types', 'jobster'),
                'edit_item'                  => __('Edit Job Type', 'jobster'),
                'update_item'                => __('Update Job Type', 'jobster'),
                'add_new_item'               => __('Add New Job Type', 'jobster'),
                'new_item_name'              => __('New Job Type Name', 'jobster'),
                'separate_items_with_commas' => __('Separate job types with commas', 'jobster'),
                'add_or_remove_items'        => __('Add or remove job types', 'jobster'),
                'choose_from_most_used'      => __('Choose from the most used job types', 'jobster'),
                'not_found'                  => __('No job type found.', 'jobster'),
                'menu_name'                  => __('Job Types', 'jobster'),
            ),
            'hierarchical'      => false,
            'query_var'         => true,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'job-type'),
            'show_in_rest'      => true,
        ));

        // add job career level taxonomy
        register_taxonomy('job_level', 'job', array(
            'labels' => array(
                'name'                       => __('Job Levels', 'jobster'),
                'singular_name'              => __('Job Level', 'jobster'),
                'search_items'               => __('Search Job Levels', 'jobster'),
                'popular_items'              => __('Popular Job Levels', 'jobster'),
                'all_items'                  => __('All Job Levels', 'jobster'),
                'edit_item'                  => __('Edit Job Level', 'jobster'),
                'update_item'                => __('Update Job Level', 'jobster'),
                'add_new_item'               => __('Add New Job Level', 'jobster'),
                'new_item_name'              => __('New Job Level Name', 'jobster'),
                'separate_items_with_commas' => __('Separate job levels with commas', 'jobster'),
                'add_or_remove_items'        => __('Add or remove job levels', 'jobster'),
                'choose_from_most_used'      => __('Choose from the most used job levels', 'jobster'),
                'not_found'                  => __('No job level found.', 'jobster'),
                'menu_name'                  => __('Job Levels', 'jobster'),
            ),
            'hierarchical'      => false,
            'query_var'         => true,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'job-level'),
            'show_in_rest'      => true,
        ));

        register_meta(
            'job_category', 
            'job_category_icon', 
            'jobster_sanitize_term_meta'
        );
    }
endif;
add_action('init', 'jobster_register_job_type');

if (!function_exists('jobster_change_job_default_title')): 
    function jobster_change_job_default_title($title) {
        $screen = get_current_screen();

        if ('job' == $screen->post_type) {
            $title = __('Add job title', 'jobster');
        }

        return $title;
    }
endif;
add_filter('enter_title_here', 'jobster_change_job_default_title');

if (!function_exists('jobster_add_job_metaboxes')): 
    function jobster_add_job_metaboxes() {
        add_meta_box('job-details-section', __('Job Details', 'jobster'), 'jobster_job_details_render', 'job', 'normal', 'default');
        add_meta_box('job-action-section', __('Job Apply Action', 'jobster'), 'jobster_job_action_render', 'job', 'normal', 'default');
        add_meta_box('job-cover-section', __('Job Cover', 'jobster'), 'jobster_job_cover_render', 'job', 'side', 'default');
        add_meta_box('job-featured-section', __('Featured', 'jobster'), 'jobster_job_featured_render', 'job', 'side', 'default');
        add_meta_box('job-company-section', __('Company', 'jobster'), 'jobster_job_company_render', 'job', 'normal', 'default');
    }
endif;

if (!function_exists('jobster_job_details_render')):
    function jobster_job_details_render($post) {
        wp_nonce_field('jobster_job', 'job_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="30%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="job_experience">' . __('Required Experience', 'jobster') . '</label><br>
                            <input name="job_experience" id="job_experience" type="text" value="' . esc_attr(get_post_meta($post->ID, 'job_experience', true)) . '" placeholder="' . __('E.g. Minimum 1 year', 'jobster') . '">
                        </div>
                    </td>
                    <td width="30%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="job_salary">' . __('Salary', 'jobster') . '</label><br>
                            <input name="job_salary" id="job_salary" type="text" value="' . esc_attr(get_post_meta($post->ID, 'job_salary', true)) . '">
                        </div>
                    </td>
                    <td width="40%" valign="top">&nbsp;</td>
                </tr>
            </table>';
    }
endif;

if (!function_exists('jobster_job_action_render')): 
    function jobster_job_action_render($post) {
        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="job_company">' . __('Apply Job External URL', 'jobster') . '</label><br />
                            <input name="job_action" id="job_action" type="text" value="' . esc_attr(get_post_meta($post->ID, 'job_action', true)) . '">
                        </div>
                    </td>
                    <td width="50%" valign="top">&nbsp;</td>
                </tr>
            </table>';
    }
endif;

if (!function_exists('jobster_job_cover_render')): 
    function jobster_job_cover_render($post) {
        $cover_src = JOBSTER_PLUGIN_PATH . 'post-types/images/cover-placeholder.png';
        $cover_val = get_post_meta($post->ID, 'job_cover', true);
        $cover = wp_get_attachment_image_src($cover_val, 'pxp-gallery');
        $has_image = '';

        if (is_array($cover)) {
            $has_image = 'pxp-has-image';
            $cover_src = $cover[0];
        }

        print '
            <input name="job_cover" id="job_cover" type="hidden" value="' . esc_attr($cover_val) . '">
            <div class="pxp-job-cover-placeholder-container ' . esc_attr($has_image) . '">
                <div class="pxp-job-cover-image-placeholder" style="background-image: url(' . esc_url($cover_src) . ');"></div>
                <div class="pxp-delete-job-cover-image"><span class="fa fa-trash-o"></span></div>
            </div>';
    }
endif;

if (!function_exists('jobster_job_featured_render')): 
    function jobster_job_featured_render($post) {
        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top">
                        <p class="meta-options">
                            <input type="hidden" name="job_featured" value="">
                            <input type="checkbox" name="job_featured" value="1" ';
                            if (esc_html(get_post_meta($post->ID, 'job_featured', true)) == 1) {
                                print ' checked ';
                            }
                            print ' />
                            <label for="job_featured">' . __('Set as Featured', 'jobster') . '</label>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;

if (!function_exists('jobster_job_company_render')): 
    function jobster_job_company_render($post) {
        $company_list = '';
        $selected_company = esc_html(get_post_meta($post->ID, 'job_company', true));

        $args = array(
            'post_type' => 'company',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $company_selection = new WP_Query($args);
        $company_selection_arr  = get_object_vars($company_selection);

        if (is_array($company_selection_arr['posts']) && count($company_selection_arr['posts']) > 0) {
            foreach ($company_selection_arr['posts'] as $company) {
                $company_list .= '<option value="' . esc_attr($company->ID) . '"';
                if ($company->ID == $selected_company) {
                    $company_list .= ' selected';
                }
                $company_list .= '>' . $company->post_title . '</option>';
            }
        }

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="job_company">' . __('Assign a Company', 'jobster') . '</label><br />
                            <select id="job_company" name="job_company">
                                <option value="">' . __('None', 'jobster') . '</option>
                                ' . $company_list . '
                            </select>
                        </div>
                    </td>
                    <td width="50%" valign="top">&nbsp;</td>
                </tr>
            </table>';
    }
endif;

/**
 * Sanitize data
 */
if (!function_exists('jobster_sanitize_term_meta')): 
    function jobster_sanitize_term_meta($value) {
        return sanitize_text_field($value);
    }
endif;

/**
 * Getter for job category icon
 */
if (!function_exists('jobster_get_job_category_icon')): 
    function jobster_get_job_category_icon($term_id) {
        $value = get_term_meta($term_id, 'job_category_icon', true);
        $value = jobster_sanitize_term_meta($value);

        return $value;
    }
endif;

/**
 * Add job category icon custom field
 */
if (!function_exists('jobster_add_job_category_icon')): 
    function jobster_add_job_category_icon() { ?>
        <?php wp_nonce_field(basename(__FILE__), 'term_meta_nonce'); ?>
        <div class="form-field term-meta-text-wrap">
            <label for="job_category_icon">
                <?php esc_html_e('Icon', 'jobster'); ?>
            </label>
            <input 
                type="hidden" 
                name="job_category_icon" 
                id="job_category_icon" 
                value="" 
                class="pxp-icons-field"
            >
            <a class="button button-secondary pxp-open-icons">
                <?php echo esc_html('Browse Icons...', 'jobster'); ?>
            </a>
        </div>
    <?php }
endif;
add_action('job_category_add_form_fields', 'jobster_add_job_category_icon');

/**
 * Edit job category icon custom field
 */
if (!function_exists('jobster_edit_job_category_icon')): 
    function jobster_edit_job_category_icon($term) {
        $value = jobster_get_job_category_icon($term->term_id);

        if (!$value) {
            $value = '';
        } ?>

        <tr class="form-field term-meta-text-wrap">
            <th scope="row">
                <label for="job_category_icon">
                    <?php esc_html_e('Icon', 'jobster'); ?>
                </label>
            </th>
            <td>
                <?php wp_nonce_field(basename(__FILE__), 'term_meta_nonce'); ?>
                <input 
                    type="hidden" 
                    name="job_category_icon" 
                    id="job_category_icon" 
                    value="<?php echo esc_attr($value); ?>" 
                    class="pxp-icons-field"
                >
                <a class="button button-secondary pxp-open-icons">
                    <?php echo esc_html('Browse Icons...', 'jobster'); ?>
                </a>
            </td>
        </tr>
    <?php }
endif;
add_action('job_category_edit_form_fields', 'jobster_edit_job_category_icon');

/**
 * Save job category icon custom field
 */
if (!function_exists('jobster_save_job_category_icon')): 
    function jobster_save_job_category_icon($term_id) {
        if (!isset($_POST['term_meta_nonce']) 
            || !wp_verify_nonce($_POST['term_meta_nonce'], basename(__FILE__))) {
            return;
        }

        $old_value = jobster_get_job_category_icon($term_id);
        $new_value = isset($_POST['job_category_icon'])
                    ? jobster_sanitize_term_meta($_POST['job_category_icon'])
                    : '';

        if ($old_value && '' === $new_value) {
            delete_term_meta($term_id, 'job_category_icon');
        } else if ($old_value !== $new_value) {
            update_term_meta($term_id, 'job_category_icon', $new_value);
        }
    }
endif;
add_action('edit_job_category', 'jobster_save_job_category_icon');
add_action('create_job_category', 'jobster_save_job_category_icon');

if (!function_exists('jobster_job_meta_save')): 
    function jobster_job_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['job_noncename']) && wp_verify_nonce($_POST['job_noncename'], 'jobster_job')) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        if (isset($_POST['job_experience'])) {
            update_post_meta($post_id, 'job_experience', sanitize_text_field($_POST['job_experience']));
        }
        if (isset($_POST['job_salary'])) {
            update_post_meta($post_id, 'job_salary', sanitize_text_field($_POST['job_salary']));
        }
        if (isset($_POST['job_action'])) {
            update_post_meta($post_id, 'job_action', sanitize_text_field($_POST['job_action']));
        }
        if (isset($_POST['job_cover'])) {
            update_post_meta($post_id, 'job_cover', sanitize_text_field($_POST['job_cover']));
        }
        if (isset($_POST['job_featured'])) {
            update_post_meta($post_id, 'job_featured', sanitize_text_field($_POST['job_featured']));
        }
        if (isset($_POST['job_company'])) {
            update_post_meta($post_id, 'job_company', sanitize_text_field($_POST['job_company']));  
        }
    }
endif;
add_action('save_post', 'jobster_job_meta_save');

if (!function_exists('jobster_get_job_locations_categories')): 
    function jobster_get_job_locations_categories() {
        $location_tax = array( 
            'job_location'
        );
        $location_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        ); 
        $location_terms = get_terms($location_tax, $location_args);

        $category_tax = array( 
            'job_category'
        );
        $category_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        ); 
        $category_terms = get_terms($category_tax, $category_args);

        echo json_encode(array(
            'getlc' => true,
            'locations' => $location_terms,
            'categories' => $category_terms
        ));
        exit();

        die();
    }
endif;
add_action(
    'wp_ajax_nopriv_jobster_get_job_locations_categories',
    'jobster_get_job_locations_categories'
);
add_action(
    'wp_ajax_jobster_get_job_locations_categories',
    'jobster_get_job_locations_categories'
);

if (!function_exists('jobster_get_job_locations')): 
    function jobster_get_job_locations() {
        $location_tax = array( 
            'job_location'
        );
        $location_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        ); 
        $location_terms = get_terms($location_tax, $location_args);

        if (is_array($location_terms) && count($location_terms)) {
            $locations = array();

            foreach ($location_terms as $term) {
                $location = new stdClass();
    
                $location->id = $term->term_id;
                $location->name = $term->name;
    
                array_push($locations, $location);
            }

            return urlencode(json_encode($locations, true));
        } else {
            return '';
        }
    }
endif;
?>