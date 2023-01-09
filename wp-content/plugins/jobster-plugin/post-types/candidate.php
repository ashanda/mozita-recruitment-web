<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

/**
 * Register candidate custom post type
 */
if (!function_exists('jobster_register_candidate_type')): 
    function jobster_register_candidate_type() {
        register_post_type('candidate', array(
            'labels' => array(
                'name'               => __('Candidates', 'jobster'),
                'singular_name'      => __('Candidate', 'jobster'),
                'add_new'            => __('Add New Candidate', 'jobster'),
                'add_new_item'       => __('Add Candidate', 'jobster'),
                'edit'               => __('Edit', 'jobster'),
                'edit_item'          => __('Edit Candidate', 'jobster'),
                'new_item'           => __('New Candidate', 'jobster'),
                'view'               => __('View', 'jobster'),
                'view_item'          => __('View Candidate', 'jobster'),
                'search_items'       => __('Search Candidates', 'jobster'),
                'not_found'          => __('No Candidates found', 'jobster'),
                'not_found_in_trash' => __('No Candidates found in Trash', 'jobster'),
                'parent'             => __('Parent Candidate', 'jobster'),
            ),
            'public'                => true,
            'exclude_from_search '  => false,
            'has_archive'           => true,
            'rewrite'               => array('slug' => _x('candidates', 'URL SLUG', 'jobster')),
            'supports'              => array('title', 'editor', 'comments'),
            'show_in_rest'          => true,
            'can_export'            => true,
            'register_meta_box_cb'  => 'jobster_add_candidate_metaboxes',
            'menu_icon'             => 'dashicons-businessman',
        ));

        // add candidate industry taxonomy
        register_taxonomy('candidate_industry', 'candidate', array(
            'labels' => array(
                'name'                       => __('Candidate Industries', 'jobster'),
                'singular_name'              => __('Candidate Industry', 'jobster'),
                'search_items'               => __('Search Candidate Industries', 'jobster'),
                'popular_items'              => __('Popular Candidate Industries', 'jobster'),
                'all_items'                  => __('All Candidate Industries', 'jobster'),
                'edit_item'                  => __('Edit Candidate Industry', 'jobster'),
                'update_item'                => __('Update Candidate Industry', 'jobster'),
                'add_new_item'               => __('Add New Candidate Industry', 'jobster'),
                'new_item_name'              => __('New Candidate Industry Name', 'jobster'),
                'separate_items_with_commas' => __('Separate candidate industries with commas', 'jobster'),
                'add_or_remove_items'        => __('Add or remove candidate industries', 'jobster'),
                'choose_from_most_used'      => __('Choose from the most used candidate industries', 'jobster'),
                'not_found'                  => __('No candidate industry found.', 'jobster'),
                'menu_name'                  => __('Candidate Industries', 'jobster'),
            ),
            'hierarchical'      => true,
            'query_var'         => true,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'candidate-industry'),
            'show_in_rest'      => true,
        ));

        // add candidate location taxonomy
        register_taxonomy('candidate_location', 'candidate', array(
            'labels' => array(
                'name'                       => __('Candidate Locations', 'jobster'),
                'singular_name'              => __('Candidate Location', 'jobster'),
                'search_items'               => __('Search Candidate Locations', 'jobster'),
                'popular_items'              => __('Popular Candidate Locations', 'jobster'),
                'all_items'                  => __('All Candidate Locations', 'jobster'),
                'edit_item'                  => __('Edit Candidate Location', 'jobster'),
                'update_item'                => __('Update Candidate Location', 'jobster'),
                'add_new_item'               => __('Add New Candidate Location', 'jobster'),
                'new_item_name'              => __('New Candidate Location Name', 'jobster'),
                'separate_items_with_commas' => __('Separate candidate locations with commas', 'jobster'),
                'add_or_remove_items'        => __('Add or remove candidate locations', 'jobster'),
                'choose_from_most_used'      => __('Choose from the most used candidate locations', 'jobster'),
                'not_found'                  => __('No candidate location found.', 'jobster'),
                'menu_name'                  => __('Candidate Locations', 'jobster'),
            ),
            'hierarchical'      => true,
            'query_var'         => true,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'candidate-location'),
            'show_in_rest'      => true,
        ));

        // add candidate skills taxonomy
        register_taxonomy('candidate_skill', 'candidate', array(
            'labels' => array(
                'name'                       => __('Candidate Skills', 'jobster'),
                'singular_name'              => __('Candidate Skill', 'jobster'),
                'search_items'               => __('Search Candidate Skills', 'jobster'),
                'popular_items'              => __('Popular Candidate Skills', 'jobster'),
                'all_items'                  => __('All Candidate Skills', 'jobster'),
                'edit_item'                  => __('Edit Candidate Skill', 'jobster'),
                'update_item'                => __('Update Candidate Skill', 'jobster'),
                'add_new_item'               => __('Add New Candidate Skill', 'jobster'),
                'new_item_name'              => __('New Candidate Skill Name', 'jobster'),
                'separate_items_with_commas' => __('Separate candidate skills with commas', 'jobster'),
                'add_or_remove_items'        => __('Add or remove candidate skills', 'jobster'),
                'choose_from_most_used'      => __('Choose from the most used candidate skills', 'jobster'),
                'not_found'                  => __('No candidate skill found.', 'jobster'),
                'menu_name'                  => __('Candidate Skills', 'jobster'),
            ),
            'hierarchical'      => false,
            'query_var'         => true,
            'show_admin_column' => false,
            'rewrite'           => array('slug' => 'candidate-skill'),
            'show_in_rest'      => true,
        ));
        
        // add candidate brand and experts taxonomy
        register_taxonomy('candidate_brand', 'candidate', array(
            'labels' => array(
                'name'                       => __('Candidate Brand', 'jobster'),
                'singular_name'              => __('Candidate Brand', 'jobster'),
                'search_items'               => __('Search Candidate Brand', 'jobster'),
                'popular_items'              => __('Popular Candidate Brand', 'jobster'),
                'all_items'                  => __('All Candidate Brand', 'jobster'),
                'edit_item'                  => __('Edit Candidate Brand', 'jobster'),
                'update_item'                => __('Update Candidate Brand', 'jobster'),
                'add_new_item'               => __('Add New Candidate Brand', 'jobster'),
                'new_item_name'              => __('New Candidate Brand Name', 'jobster'),
                'separate_items_with_commas' => __('Separate candidate brands with commas', 'jobster'),
                'add_or_remove_items'        => __('Add or remove candidate brands', 'jobster'),
                'choose_from_most_used'      => __('Choose from the most used candidate brands', 'jobster'),
                'not_found'                  => __('No candidate brand found.', 'jobster'),
                'menu_name'                  => __('Candidate Brands', 'jobster'),
            ),
            'hierarchical'      => false,
            'query_var'         => true,
            'show_admin_column' => false,
            'rewrite'           => array('slug' => 'candidate-brand'),
            'show_in_rest'      => true,
        ));
    }
endif;
add_action('init', 'jobster_register_candidate_type');

if (!function_exists('jobster_change_candidate_default_title')): 
    function jobster_change_candidate_default_title($title) {
        $screen = get_current_screen();

        if ('candidate' == $screen->post_type) {
            $title = __('Add candidate name', 'jobster');
        }

        return $title;
    }
endif;
add_filter('enter_title_here', 'jobster_change_candidate_default_title');

if (!function_exists('jobster_add_candidate_metaboxes')): 
    function jobster_add_candidate_metaboxes() {
        add_meta_box('candidate-details-section', __('Candidate Details', 'jobster'), 'jobster_candidate_details_render', 'candidate', 'normal', 'default');
        add_meta_box('candidate-photo-section', __('Candidate Photo', 'jobster'), 'jobster_candidate_photo_render', 'candidate', 'side', 'default');
        add_meta_box('candidate-cover-section', __('Candidate Cover', 'jobster'), 'jobster_candidate_cover_render', 'candidate', 'side', 'default');
        add_meta_box('candidate-featured-section', __('Featured', 'jobster'), 'jobster_candidate_featured_render', 'candidate', 'side', 'default');
        add_meta_box('candidate-work-section', __('Work Experience', 'jobster'), 'jobster_candidate_work_render', 'candidate', 'normal', 'default');
        add_meta_box('candidate-edu-section', __('Education and Training', 'jobster'), 'jobster_candidate_edu_render', 'candidate', 'normal', 'default');
        add_meta_box('candidate-language-section', __('Language','jobster'), 'jobster_candidate_language_render', 'candidate', 'normal', 'default');
        add_meta_box('candidate-family-section', __('Family and Dependencies', 'jobster'), 'jobster_candidate_family_render', 'candidate', 'normal', 'default');
        add_meta_box('candidate-cv-section', __('Resume', 'jobster'), 'jobster_candidate_cv_render', 'candidate', 'normal', 'default');
        add_meta_box('candidate-social-section', __('Social Media', 'jobster'), 'jobster_candidate_social_media_render', 'candidate', 'normal', 'default');
        add_meta_box('candidate-user-section', __('User', 'jobster'), 'jobster_candidate_user_render', 'candidate', 'normal', 'default');
    }
endif;

if (!function_exists('jobster_candidate_details_render')):
    function jobster_candidate_details_render($post) {
        wp_nonce_field('jobster_candidate', 'candidate_noncename');
         $systemid = get_post_meta($post->ID, 'candidate_systemid', true);
          if($systemid == ""){
              $myuid = crc32(uniqid());
              
            }else{
            $myuid = esc_attr(get_post_meta($post->ID, 'candidate_systemid', true));
          
            }    
            
        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_systemid">' . __('Candidate ID', 'jobster') . '</label><br>
                            <input name="candidate_systemid" id="candidate_systemid" type="text" value="' .$myuid. '" readonly>
                        </div>
                    </td>
                </tr>    
                <tr>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_title">' . __('Job Title', 'jobster') . '</label><br>
                            <input name="candidate_title" id="candidate_title" type="text" value="' . esc_attr(get_post_meta($post->ID, 'candidate_title', true)) . '">
                        </div>
                    </td>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_first_name">' . __('First Name', 'jobster') . '</label><br>
                            <input name="candidate_first_name" id="candidate_first_name" type="text" value="' . esc_attr(get_post_meta($post->ID, 'candidate_first_name', true)) . '">
                        </div>
                    </td>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_last_name">' . __('Last Name', 'jobster') . '</label><br>
                            <input name="candidate_last_name" id="candidate_last_name" type="text" value="' . esc_attr(get_post_meta($post->ID, 'candidate_last_name', true)) . '">
                        </div>
                    </td>
                    </tr>

                <tr>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_email">' . __('Email', 'jobster') . '</label><br>
                            <input name="candidate_email" id="candidate_email" type="email" value="' . esc_attr(get_post_meta($post->ID, 'candidate_email', true)) . '">
                        </div>
                    </td>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_phone">' . __('Phone', 'jobster') . '</label><br>
                            <input name="candidate_phone" id="candidate_phone" type="tel" value="' . esc_attr(get_post_meta($post->ID, 'candidate_phone', true)) . '">
                        </div>
                    </td>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_whatsapp">' . __('Whats App', 'jobster') . '</label><br>
                            <input name="candidate_whatsapp" id="candidate_whatsapp" type="tel" value="' . esc_attr(get_post_meta($post->ID, 'candidate_whatsapp', true)) . '">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_botim">' . __('Botim', 'jobster') . '</label><br>
                            <input name="candidate_botim" id="candidate_botim" type="tel" value="' . esc_attr(get_post_meta($post->ID, 'candidate_botim', true)) . '">
                        </div>
                    </td>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_civil_state">' . __('Civil State', 'jobster') . '</label><br>
                            <select name="candidate_civil_state" id="candidate_civil_state">
                                <option selected value="' . esc_attr(get_post_meta($post->ID, 'candidate_civil_state', true)) . '">' . esc_attr(get_post_meta($post->ID, 'candidate_civil_state', true)) . '</option>
                                <option value="Single">Single</option>
                                <option value="Marride">Marride</option>
                                
                            </select>
                           
                        </div>
                    </td>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_origin_country">' . __('Origin Country', 'jobster') . '</label><br>
                            <input name="candidate_origin_country" id="candidate_origin_country" type="text" value="' . esc_attr(get_post_meta($post->ID, 'candidate_origin_country', true)) . '">
                        </div>
                    </td>
                </tr>

                
                <tr>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="candidate_website">' . __('Website', 'jobster') . '</label><br>
                            <input name="candidate_website" id="candidate_website" type="text" value="' . esc_url(get_post_meta($post->ID, 'candidate_website', true)) . '">
                        </div>
                    </td>
                    
                    <td width="25%" valign="top">&nbsp;</td>
                    <td width="25%" valign="top">&nbsp;</td>
            </table>';
    }
endif;

if (!function_exists('jobster_candidate_photo_render')): 
    function jobster_candidate_photo_render($post) {
        $photo_src = JOBSTER_PLUGIN_PATH . 'post-types/images/photo-placeholder.png';
        $photo_val = get_post_meta($post->ID, 'candidate_photo', true);
        $photo = wp_get_attachment_image_src($photo_val, 'pxp-icon');
        $has_image = '';

        if (is_array($photo)) {
            $has_image = 'pxp-has-image';
            $photo_src = $photo[0];
        }

        print '
            <input name="candidate_photo" id="candidate_photo" type="hidden" value="' . esc_attr($photo_val) . '">
            <div class="pxp-candidate-photo-placeholder-container ' . esc_attr($has_image) . '">
                <div class="pxp-candidate-photo-image-placeholder" style="background-image: url(' . esc_url($photo_src) . ');"></div>
                <div class="pxp-delete-candidate-photo-image"><span class="fa fa-trash-o"></span></div>
            </div>';
    }
endif;

if (!function_exists('jobster_candidate_cover_render')): 
    function jobster_candidate_cover_render($post) {
        $cover_src = JOBSTER_PLUGIN_PATH . 'post-types/images/cover-placeholder.png';
        $cover_val = get_post_meta($post->ID, 'candidate_cover', true);
        $cover = wp_get_attachment_image_src($cover_val, 'pxp-gallery');
        $has_image = '';

        if (is_array($cover)) {
            $has_image = 'pxp-has-image';
            $cover_src = $cover[0];
        }

        print '
            <input name="candidate_cover" id="candidate_cover" type="hidden" value="' . esc_attr($cover_val) . '">
            <div class="pxp-candidate-cover-placeholder-container ' . esc_attr($has_image) . '">
                <div class="pxp-candidate-cover-image-placeholder" style="background-image: url(' . esc_url($cover_src) . ');"></div>
                <div class="pxp-delete-candidate-cover-image"><span class="fa fa-trash-o"></span></div>
            </div>';
    }
endif;

if (!function_exists('jobster_candidate_featured_render')): 
    function jobster_candidate_featured_render($post) {
        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top">
                        <p class="meta-options">
                            <input type="hidden" name="candidate_featured" value="">
                            <input type="checkbox" name="candidate_featured" value="1" ';
                            if (esc_html(get_post_meta($post->ID, 'candidate_featured', true)) == 1) {
                                print ' checked ';
                            }
                            print ' />
                            <label for="candidate_featured">' . __('Set as Featured', 'jobster') . '</label>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;

if (!function_exists('jobster_candidate_work_render')):
    function jobster_candidate_work_render($post) {
        $work = get_post_meta($post->ID, 'candidate_work', true);

        $work_list = array();

        if ($work != '') {
            $work_data = json_decode(urldecode($work));

            if (isset($work_data)) {
                $work_list = $work_data->works;
            }
        }

        print '
            <input type="hidden" id="candidate_work" name="candidate_work" value="' . esc_attr($work) . '" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top">
                        <ul class="list-group" id="pxp-candidate-work-list">';
                        
        if (count($work_list) > 0) {
            foreach ($work_list as $work_item) {
                print '
                    <li class="list-group-item" 
                        data-title="' . esc_attr($work_item->title) . '" 
                        data-company="' . esc_attr($work_item->company) . '" 
                        data-period="' . esc_attr($work_item->period) . '" 
                        data-start="' . esc_attr($work_item->start) . '" 
                        data-end="' . esc_attr($work_item->end) . '" 
                        data-location="' . esc_attr($work_item->location) . '" 
                        data-description="' . esc_attr($work_item->description) . '"
                    >
                        <div class="pxp-candidate-work-list-item">
                            <div class="pxp-candidate-work-list-item-title"><b>' . esc_html($work_item->title) . '</b></div>
                            <div class="pxp-candidate-work-list-item-company">' . esc_html($work_item->company) . '</div>
                            <div class="pxp-candidate-work-list-item-btns">
                                <a href="javascript:void(0);" class="pxp-list-edit-btn pxp-edit-candidate-work"><span class="fa fa-pencil"></span></a>
                                <a href="javascript:void(0);" class="pxp-list-del-btn pxp-del-candidate-work"><span class="fa fa-trash-o"></span></a>
                            </div>
                        </div>
                    </li>';
            }
        }
        print '
                        </ul>
                    </td>
                </tr>
                <tr><td width="100%" valign="top">&nbsp;</td>
                <tr>
                    <td width="100%" valign="top"><input id="pxp-add-candidate-work-btn" type="button" class="button" value="' . esc_html__('Add Experience', 'jobster') . '" /></td>
                </tr>
            </table>
            <div class="pxp-candidate-new-work">
                <div class="pxp-candidate-new-work-container">
                    <div class="pxp-candidate-new-work-header"><b>' . esc_html__('New Work Experience', 'jobster') . '</b></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="50%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_work_title">' . __('Job title', 'jobster') . '</label><br>
                                    <input name="candidate_work_title" id="candidate_work_title" type="text">
                                </div>
                            </td>
                            <td width="30%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_work_company">' . __('Company', 'jobster') . '</label><br>
                                    <input name="candidate_work_company" id="candidate_work_company" type="text">
                                </div>
                            </td>
                            <td width="20%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_work_period">' . __('Time period', 'jobster') . '</label><br>
                                    <input name="candidate_work_period" id="candidate_work_period" type="text">
                                </div>
                            </td>
                        </tr>
                        <tr>
                        
                        <td width="20%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_work_start">' . __('Start Date', 'jobster') . '</label><br>
                                    <input name="candidate_work_start" id="candidate_work_start" type="date">
                                </div>
                        </td>
                        <td width="20%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_work_end">' . __('End Date', 'jobster') . '</label><br>
                                    <input name="candidate_work_end" id="candidate_work_end" type="date">
                                </div>
                        </td>
                        <td width="20%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_work_location">' . __('Location', 'jobster') . '</label><br>
                                    <input name="candidate_work_location" id="candidate_work_location" type="text">
                                </div>
                        </td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="3">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_work_description">' . __('Description', 'jobster') . '</label><br>
                                    <textarea name="candidate_work_description" id="candidate_work_description" style="width: 100%; height: 100px;"></textarea>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="form-field">
                        <button type="button" id="pxp-ok-work" class="button media-button button-primary">' . esc_html__('Add', 'jobster') . '</button>
                        <button type="button" id="pxp-cancel-work" class="button media-button button-default">' . esc_html__('Cancel', 'jobster') . '</button>
                    </div>
                </div>
            </div>';
    }
endif;

if (!function_exists('jobster_candidate_family_render')):
    function jobster_candidate_family_render($post) {
        $family = get_post_meta($post->ID, 'candidate_family', true);

        $family_list = array();

        if ($family != '') {
            $family_data = json_decode(urldecode($family));

            if (isset($family_data)) {
                $family_list = $family_data->familys;
            }
        }

        print '
            <input type="hidden" id="candidate_family" name="candidate_family" value="' . esc_attr($family) . '" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top">
                        <ul class="list-group" id="pxp-candidate-family-list">';
        if (count($family_list) > 0) {
            foreach ($family_list as $family_item) {
                print '
                    <li class="list-group-item" 
                        data-title="' . esc_attr($family_item->title) . '" 
                        data-relation="' . esc_attr($family_item->relation) . '" 
                        data-age="' . esc_attr($family_item->age) . '" 
                        
                    >
                        <div class="pxp-candidate-family-list-item">
                            <div class="pxp-candidate-family-list-item-title"><b>' . esc_html($family_item->title) . '</b></div>
                            <div class="pxp-candidate-family-list-item-relation">' . esc_html($family_item->relation) . '</div>
                            <div class="pxp-candidate-family-list-item-btns">
                                <a href="javascript:void(0);" class="pxp-list-edit-btn pxp-edit-candidate-family"><span class="fa fa-pencil"></span></a>
                                <a href="javascript:void(0);" class="pxp-list-del-btn pxp-del-candidate-family"><span class="fa fa-trash-o"></span></a>
                            </div>
                        </div>
                    </li>';
            }
        }
        print '
                        </ul>
                    </td>
                </tr>
                <tr><td width="100%" valign="top">&nbsp;</td>
                <tr>
                    <td width="100%" valign="top"><input id="pxp-add-candidate-family-btn" type="button" class="button" value="' . esc_html__('Add Family', 'jobster') . '" /></td>
                </tr>
            </table>
            <div class="pxp-candidate-new-family">
                <div class="pxp-candidate-new-family-container">
                    <div class="pxp-candidate-new-family-header"><b>' . esc_html__('Add Family Details', 'jobster') . '</b></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="50%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_family_title">' . __('Name', 'jobster') . '</label><br>
                                    <input name="candidate_family_title" id="candidate_family_title" type="text">
                                </div>
                            </td>
                            <td width="30%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_family_relation">' . __('Relationship', 'jobster') . '</label><br>
                                    <input name="candidate_family_relation" id="candidate_family_relation" type="text">
                                </div>
                            </td>
                            <td width="20%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_family_age">' . __('Age', 'jobster') . '</label><br>
                                    <input name="candidate_family_age" id="candidate_family_age" type="text">
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                    <div class="form-field">
                        <button type="button" id="pxp-ok-family" class="button media-button button-primary">' . esc_html__('Add', 'jobster') . '</button>
                        <button type="button" id="pxp-cancel-family" class="button media-button button-default">' . esc_html__('Cancel', 'jobster') . '</button>
                    </div>
                </div>
            </div>';
    }
endif;


if (!function_exists('jobster_candidate_edu_render')):
    function jobster_candidate_edu_render($post) {
        $edu = get_post_meta($post->ID, 'candidate_edu', true);

        $edu_list = array();

        if ($edu != '') {
            $edu_data = json_decode(urldecode($edu));

            if (isset($edu_data)) {
                $edu_list = $edu_data->edus;
            }
        }

        print '
            <input type="hidden" id="candidate_edu" name="candidate_edu" value="' . esc_attr($edu) . '" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top">
                        <ul class="list-group" id="pxp-candidate-edu-list">';
        if (count($edu_list) > 0) {
            foreach ($edu_list as $edu_item) {
                print '
                    <li class="list-group-item" 
                        data-title="' . esc_attr($edu_item->title) . '" 
                        data-school="' . esc_attr($edu_item->school) . '" 
                        data-period="' . esc_attr($edu_item->period) . '" 
                        data-description="' . esc_attr($edu_item->description) . '"
                    >
                        <div class="pxp-candidate-edu-list-item">
                            <div class="pxp-candidate-edu-list-item-title"><b>' . esc_html($edu_item->title) . '</b></div>
                            <div class="pxp-candidate-edu-list-item-school">' . esc_html($edu_item->school) . '</div>
                            <div class="pxp-candidate-edu-list-item-btns">
                                <a href="javascript:void(0);" class="pxp-list-edit-btn pxp-edit-candidate-edu"><span class="fa fa-pencil"></span></a>
                                <a href="javascript:void(0);" class="pxp-list-del-btn pxp-del-candidate-edu"><span class="fa fa-trash-o"></span></a>
                            </div>
                        </div>
                    </li>';
            }
        }
        print '
                        </ul>
                    </td>
                </tr>
                <tr><td width="100%" valign="top">&nbsp;</td>
                <tr>
                    <td width="100%" valign="top"><input id="pxp-add-candidate-edu-btn" type="button" class="button" value="' . esc_html__('Add Education', 'jobster') . '" /></td>
                </tr>
            </table>
            <div class="pxp-candidate-new-edu">
                <div class="pxp-candidate-new-edu-container">
                    <div class="pxp-candidate-new-edu-header"><b>' . esc_html__('New Education', 'jobster') . '</b></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="50%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_edu_title">' . __('Specialization/Course of study', 'jobster') . '</label><br>
                                    <input name="candidate_edu_title" id="candidate_edu_title" type="text">
                                </div>
                            </td>
                            <td width="30%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_edu_school">' . __('Institution', 'jobster') . '</label><br>
                                    <input name="candidate_edu_school" id="candidate_edu_school" type="text">
                                </div>
                            </td>
                            <td width="20%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_edu_period">' . __('Time period', 'jobster') . '</label><br>
                                    <input name="candidate_edu_period" id="candidate_edu_period" type="text">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="3">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_edu_description">' . __('Description', 'jobster') . '</label><br>
                                    <textarea name="candidate_edu_description" id="candidate_edu_description" style="width: 100%; height: 100px;"></textarea>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="form-field">
                        <button type="button" id="pxp-ok-edu" class="button media-button button-primary">' . esc_html__('Add', 'jobster') . '</button>
                        <button type="button" id="pxp-cancel-edu" class="button media-button button-default">' . esc_html__('Cancel', 'jobster') . '</button>
                    </div>
                </div>
            </div>';
    }
endif;

if (!function_exists('jobster_candidate_language_render')):
    function jobster_candidate_language_render($post) {
        $language = get_post_meta($post->ID, 'candidate_language', true);

        $language_list = array();

        if ($language != '') {
            $language_data = json_decode(urldecode($language));

            if (isset($language_data)) {
                $language_list = $language_data->languages;
            }
        }

        print '
            <input type="hidden" id="candidate_language" name="candidate_language" value="' . esc_attr($language) . '" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top">
                        <ul class="list-group" id="pxp-candidate-language-list">';
        if (count($language_list) > 0) {
            foreach ($language_list as $language_item) {
                print '
                    <li class="list-group-item" 
                        data-title="' . esc_attr($language_item->title) . '" 
                        
                    >
                        <div class="pxp-candidate-language-list-item">
                            <div class="pxp-candidate-language-list-item-title"><b>' . esc_html($language_item->title) . '</b></div>
                            
                            <div class="pxp-candidate-language-list-item-btns">
                                <a href="javascript:void(0);" class="pxp-list-edit-btn pxp-edit-candidate-language"><span class="fa fa-pencil"></span></a>
                                <a href="javascript:void(0);" class="pxp-list-del-btn pxp-del-candidate-language"><span class="fa fa-trash-o"></span></a>
                            </div>
                        </div>
                    </li>';
            }
        }
        print '
                        </ul>
                    </td>
                </tr>
                <tr><td width="100%" valign="top">&nbsp;</td>
                <tr>
                    <td width="100%" valign="top"><input id="pxp-add-candidate-language-btn" type="button" class="button" value="' . esc_html__('Add Language', 'jobster') . '" /></td>
                </tr>
            </table>
            <div class="pxp-candidate-new-language">
                <div class="pxp-candidate-new-language-container">
                    <div class="pxp-candidate-new-language-header"><b>' . esc_html__('Language', 'jobster') . '</b></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="50%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="candidate_language_title">' . __('Language', 'jobster') . '</label><br>
                                    <input name="candidate_language_title" id="candidate_language_title" type="text">
                                </div>
                            </td>
                            
                            
                        </tr> 
                    </table>
                    <div class="form-field">
                        <button type="button" id="pxp-ok-language" class="button media-button button-primary">' . esc_html__('Add', 'jobster') . '</button>
                        <button type="button" id="pxp-cancel-language" class="button media-button button-default">' . esc_html__('Cancel', 'jobster') . '</button>
                    </div>
                </div>
            </div>';
    }
endif;




if (!function_exists('jobster_candidate_cv_render')): 
    function jobster_candidate_cv_render($post) {
        $cv_val = get_post_meta($post->ID, 'candidate_cv', true);
        $cv = wp_get_attachment_url($cv_val);

        $item_class = '';
        $filename = '';
        if (!empty($cv)) {
            $item_class = 'pxp-show';
            $filename = basename($cv);
        }

        print '
            <input name="candidate_cv" id="candidate_cv" type="hidden" value="' . esc_attr($cv_val) . '">
            <div class="list-group pxp-candidate-cv-wrapper">
                <div class="list-group-item pxp-candidate-cv-container ' . esc_attr($item_class) . '">
                    <div class="pxp-candidate-cv-filename">' . esc_html($filename) . '</div>
                    <div class="pxp-candidate-cv-btns">
                        <a href="javascript:void(0);" class="pxp-list-del-btn pxp-del-candidate-cv"><span class="fa fa-trash-o"></span></a>
                    </div>
                </div>
            </div>
            <input id="pxp-add-candidate-cv-btn" type="button" class="button" value="' . esc_html__('Upload Resume', 'jobster') . '" />';
    }
endif;

if (!function_exists('jobster_candidate_social_media_render')): 
    function jobster_candidate_social_media_render($post) {
        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_facebook">' . __('Facebook', 'jobster') . '</label>
                            <input name="candidate_facebook" id="candidate_facebook" type="url" value="' . esc_attr(get_post_meta($post->ID, 'candidate_facebook', true)) . '">
                        </div>
                    </td>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="candidate_twitter">' . __('Twitter', 'jobster') . '</label>
                            <input name="candidate_twitter" id="candidate_twitter" type="url" value="' . esc_attr(get_post_meta($post->ID, 'candidate_twitter', true)) . '">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="candidate_instagram">' . __('Instagram', 'jobster') . '</label>
                            <input name="candidate_instagram" id="candidate_instagram" type="url" value="' . esc_attr(get_post_meta($post->ID, 'candidate_instagram', true)) . '">
                        </div>
                    </td>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="candidate_linkedin">' . __('Linkedin', 'jobster') . '</label>
                            <input name="candidate_linkedin" id="candidate_linkedin" type="url" value="' . esc_attr(get_post_meta($post->ID, 'candidate_linkedin', true)) . '">
                        </div>
                    </td>
                </tr>
            </table>';
    }
endif;

if (!function_exists('jobster_candidate_user_render')): 
    function jobster_candidate_user_render($post) {
        wp_nonce_field('jobster_causer', 'causer_noncename');

        $mypost        = $post->ID;
        $originalpost  = $post;
        $selected_user = get_post_meta($mypost, 'candidate_user', true);
        $users_list    = '';
        $args          = array('role' => '');

        $user_query = new WP_User_Query($args);

        foreach ($user_query->results as $user) {
            $is_company = jobster_user_is_company($user->ID);

            if (!$is_company) {
                $users_list .= '<option value="' . $user->ID . '"';
                if ($user->ID == $selected_user) {
                    $users_list .= ' selected';
                }
                $users_list .= '>' . $user->user_login . ' - ' . $user->first_name . ' ' . $user->last_name . '</option>';
            }
        }

        wp_reset_query();

        $post = $originalpost;

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="candidate_user">' . __('Assign a User', 'jobster') . '</label>
                            <select id="candidate_user" name="candidate_user">
                                <option value="">' . __('None', 'jobster') . '</option>
                                ' . $users_list . '
                            </select>
                        </div>
                    </td>
                    <td width="50%" valign="top">&nbsp;</td>
                </tr>
            </table>';
    }
endif;

if (!function_exists('jobster_candidate_meta_save')): 
    function jobster_candidate_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['candidate_noncename']) && wp_verify_nonce($_POST['candidate_noncename'], 'jobster_candidate')) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        if (isset($_POST['candidate_title'])) {
            update_post_meta($post_id, 'candidate_title', sanitize_text_field($_POST['candidate_title']));
        }
        if (isset($_POST['candidate_systemid'])) {
            update_post_meta($post_id, 'candidate_systemid', sanitize_text_field($_POST['candidate_systemid']));
        }
        if (isset($_POST['candidate_first_name'])) {
            update_post_meta($post_id, 'candidate_first_name', sanitize_text_field($_POST['candidate_first_name']));
        }
        if (isset($_POST['candidate_last_name'])) {
            update_post_meta($post_id, 'candidate_last_name', sanitize_text_field($_POST['candidate_last_name']));
        }
        if (isset($_POST['candidate_whatsapp'])) {
            update_post_meta($post_id, 'candidate_whatsapp', sanitize_text_field($_POST['candidate_whatsapp']));
        }
        if (isset($_POST['candidate_botim'])) {
            update_post_meta($post_id, 'candidate_botim', sanitize_text_field($_POST['candidate_botim']));
        }
        if (isset($_POST['candidate_civil_state'])) {
            update_post_meta($post_id, 'candidate_civil_state', sanitize_text_field($_POST['candidate_civil_state']));
        }
        
        if (isset($_POST['candidate_origin_country'])) {
            update_post_meta($post_id, 'candidate_origin_country', sanitize_text_field($_POST['candidate_origin_country']));
        }
        if (isset($_POST['candidate_email'])) {
            update_post_meta($post_id, 'candidate_email', sanitize_text_field($_POST['candidate_email']));
        }
        if (isset($_POST['candidate_phone'])) {
            update_post_meta($post_id, 'candidate_phone', sanitize_text_field($_POST['candidate_phone']));
        }
        if (isset($_POST['candidate_website'])) {
            update_post_meta($post_id, 'candidate_website', sanitize_text_field($_POST['candidate_website']));
        }
        if (isset($_POST['candidate_photo'])) {
            update_post_meta($post_id, 'candidate_photo', sanitize_text_field($_POST['candidate_photo']));
        }
        if (isset($_POST['candidate_cover'])) {
            update_post_meta($post_id, 'candidate_cover', sanitize_text_field($_POST['candidate_cover']));
        }
        if (isset($_POST['candidate_featured'])) {
            update_post_meta($post_id, 'candidate_featured', sanitize_text_field($_POST['candidate_featured']));
        }
        

        if (isset($_POST['candidate_work'])) {
            $work_list = array();
            $work_data_raw = urldecode($_POST['candidate_work']);
            $work_data = json_decode($work_data_raw);

            $work_data_encoded = '';

            if (isset($work_data)) {
                $new_data = new stdClass();
                $new_works = array();

                $work_list = $work_data->works;

                foreach ($work_list as $work_item) {
                    $new_work = new stdClass();

                    $new_work->title       = sanitize_text_field($work_item->title);
                    $new_work->company     = sanitize_text_field($work_item->company);
                    $new_work->period      = sanitize_text_field($work_item->period);
                    $new_work->start  = sanitize_text_field($work_item->start);
                    $new_work->end    = sanitize_text_field($work_item->end);
                    $new_work->location    = sanitize_text_field($work_item->location);
                    $new_work->description = sanitize_text_field($work_item->description);

                    array_push($new_works, $new_work);
                }

                $new_data->works = $new_works;

                $work_data_before = json_encode($new_data);
                $work_data_encoded = urlencode($work_data_before);
            }

            update_post_meta($post_id, 'candidate_work', $work_data_encoded);
        }
        if (isset($_POST['candidate_family'])) {
            $family_list = array();
            $family_data_raw = urldecode($_POST['candidate_family']);
            $family_data = json_decode($family_data_raw);

            $family_data_encoded = '';

            if (isset($family_data)) {
                $new_data = new stdClass();
                $new_familys = array();

                $family_list = $family_data->familys;

                foreach ($family_list as $family_item) {
                    $new_family = new stdClass();

                    $new_family->title       = sanitize_text_field($family_item->title);
                    $new_family->relation     = sanitize_text_field($family_item->relation);
                    $new_family->age      = sanitize_text_field($family_item->age);
                    
                   

                    array_push($new_familys, $new_family);
                }

                $new_data->familys = $new_familys;

                $family_data_before = json_encode($new_data);
                $family_data_encoded = urlencode($family_data_before);
            }

            update_post_meta($post_id, 'candidate_family', $family_data_encoded);
        }

        if (isset($_POST['candidate_language'])) {
            $language_list = array();
            $language_data_raw = urldecode($_POST['candidate_language']);
            $language_data = json_decode($language_data_raw);

            $language_data_encoded = '';

            if (isset($language_data)) {
                $new_data = new stdClass();
                $new_languages = array();

                $language_list = $language_data->languages;

                foreach ($language_list as $language_item) {
                    $new_language = new stdClass();

                    $new_language->title       = sanitize_text_field($language_item->title);
                    array_push($new_languages, $new_language);
                }

                $new_data->languages = $new_languages;

                $language_data_before = json_encode($new_data);
                $language_data_encoded = urlencode($language_data_before);
            }

            update_post_meta($post_id, 'candidate_language', $language_data_encoded);
        }

        if (isset($_POST['candidate_edu'])) {
            $edu_list = array();
            $edu_data_raw = urldecode($_POST['candidate_edu']);
            $edu_data = json_decode($edu_data_raw);

            $edu_data_encoded = '';

            if (isset($edu_data)) {
                $new_data_edu = new stdClass();
                $new_edus = array();

                $edu_list = $edu_data->edus;

                foreach ($edu_list as $edu_item) {
                    $new_edu = new stdClass();

                    $new_edu->title       = sanitize_text_field($edu_item->title);
                    $new_edu->school      = sanitize_text_field($edu_item->school);
                    $new_edu->period      = sanitize_text_field($edu_item->period);
                    $new_edu->description = sanitize_text_field($edu_item->description);

                    array_push($new_edus, $new_edu);
                }

                $new_data_edu->edus = $new_edus;

                $edu_data_before = json_encode($new_data_edu);
                $edu_data_encoded = urlencode($edu_data_before);
            }

            update_post_meta($post_id, 'candidate_edu', $edu_data_encoded);
        }
        if (isset($_POST['candidate_cv'])) {
            update_post_meta($post_id, 'candidate_cv', sanitize_text_field($_POST['candidate_cv']));
        }
        if (isset($_POST['candidate_facebook'])) {
            update_post_meta($post_id, 'candidate_facebook', sanitize_text_field($_POST['candidate_facebook']));
        }
        if (isset($_POST['candidate_twitter'])) {
            update_post_meta($post_id, 'candidate_twitter', sanitize_text_field($_POST['candidate_twitter']));
        }
        if (isset($_POST['candidate_instagram'])) {
            update_post_meta($post_id, 'candidate_instagram', sanitize_text_field($_POST['candidate_instagram']));
        }
        if (isset($_POST['candidate_linkedin'])) {
            update_post_meta($post_id, 'candidate_linkedin', sanitize_text_field($_POST['candidate_linkedin']));
        }
        if (isset($_POST['candidate_user'])) {
            update_post_meta($post_id, 'candidate_user', sanitize_text_field($_POST['candidate_user']));
        }
    }
endif;
add_action('save_post', 'jobster_candidate_meta_save');

if (!function_exists('jobster_get_candidate_locations_industries')): 
    function jobster_get_candidate_locations_industries() {
        $location_tax = array( 
            'candidate_location'
        );
        $location_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        ); 
        $location_terms = get_terms($location_tax, $location_args);

        $industry_tax = array( 
            'candidate_industry'
        );
        $industry_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        ); 
        $industry_terms = get_terms($industry_tax, $industry_args);

        echo json_encode(array(
            'getli' => true,
            'locations' => $location_terms,
            'industries' => $industry_terms
        ));
        exit();

        die();
    }
endif;
add_action(
    'wp_ajax_nopriv_jobster_get_candidate_locations_industries',
    'jobster_get_candidate_locations_industries'
);
add_action(
    'wp_ajax_jobster_get_candidate_locations_industries',
    'jobster_get_candidate_locations_industries'
);
?>