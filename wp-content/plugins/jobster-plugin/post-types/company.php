<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

/**
 * Register company custom post type
 */
if (!function_exists('jobster_register_company_type')): 
    function jobster_register_company_type() {
        register_post_type('company', array(
            'labels' => array(
                'name'               => __('Companies', 'jobster'),
                'singular_name'      => __('Company', 'jobster'),
                'add_new'            => __('Add New Company', 'jobster'),
                'add_new_item'       => __('Add Company', 'jobster'),
                'edit'               => __('Edit', 'jobster'),
                'edit_item'          => __('Edit Company', 'jobster'),
                'new_item'           => __('New Company', 'jobster'),
                'view'               => __('View', 'jobster'),
                'view_item'          => __('View Company', 'jobster'),
                'search_items'       => __('Search Companies', 'jobster'),
                'not_found'          => __('No Companies found', 'jobster'),
                'not_found_in_trash' => __('No Companies found in Trash', 'jobster'),
                'parent'             => __('Parent Company', 'jobster'),
            ),
            'public'                => true,
            'exclude_from_search '  => false,
            'has_archive'           => true,
            'rewrite'               => array('slug' => _x('companies', 'URL SLUG', 'jobster')),
            'supports'              => array('title', 'editor', 'comments'),
            'show_in_rest'          => true,
            'can_export'            => true,
            'register_meta_box_cb'  => 'jobster_add_company_metaboxes',
            'menu_icon'             => 'dashicons-building',
        ));

        // add company industry taxonomy
        register_taxonomy('company_industry', 'company', array(
            'labels' => array(
                'name'                       => __('Company Industries', 'jobster'),
                'singular_name'              => __('Company Industry', 'jobster'),
                'search_items'               => __('Search Company Industries', 'jobster'),
                'popular_items'              => __('Popular Company Industries', 'jobster'),
                'all_items'                  => __('All Company Industries', 'jobster'),
                'edit_item'                  => __('Edit Company Industry', 'jobster'),
                'update_item'                => __('Update Company Industry', 'jobster'),
                'add_new_item'               => __('Add New Company Industry', 'jobster'),
                'new_item_name'              => __('New Company Industry Name', 'jobster'),
                'separate_items_with_commas' => __('Separate company industries with commas', 'jobster'),
                'add_or_remove_items'        => __('Add or remove company industries', 'jobster'),
                'choose_from_most_used'      => __('Choose from the most used company industries', 'jobster'),
                'not_found'                  => __('No company industry found.', 'jobster'),
                'menu_name'                  => __('Company Industries', 'jobster'),
            ),
            'hierarchical'      => true,
            'query_var'         => true,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'company-industry'),
            'show_in_rest'      => true,
        ));

        // add company location taxonomy
        register_taxonomy('company_location', 'company', array(
            'labels' => array(
                'name'                       => __('Company Locations', 'jobster'),
                'singular_name'              => __('Company Location', 'jobster'),
                'search_items'               => __('Search Company Locations', 'jobster'),
                'popular_items'              => __('Popular Company Locations', 'jobster'),
                'all_items'                  => __('All Company Locations', 'jobster'),
                'edit_item'                  => __('Edit Company Location', 'jobster'),
                'update_item'                => __('Update Company Location', 'jobster'),
                'add_new_item'               => __('Add New Company Location', 'jobster'),
                'new_item_name'              => __('New Company Location Name', 'jobster'),
                'separate_items_with_commas' => __('Separate company locations with commas', 'jobster'),
                'add_or_remove_items'        => __('Add or remove company locations', 'jobster'),
                'choose_from_most_used'      => __('Choose from the most used company locations', 'jobster'),
                'not_found'                  => __('No company location found.', 'jobster'),
                'menu_name'                  => __('Company Locations', 'jobster'),
            ),
            'hierarchical'      => true,
            'query_var'         => true,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'company-location'),
            'show_in_rest'      => true,
        ));
    }
endif;
add_action('init', 'jobster_register_company_type');

if (!function_exists('jobster_change_company_default_title')): 
    function jobster_change_company_default_title($title) {
        $screen = get_current_screen();

        if ('company' == $screen->post_type) {
            $title = __('Add company name', 'jobster');
        }

        return $title;
    }
endif;
add_filter('enter_title_here', 'jobster_change_company_default_title');

if (!function_exists('jobster_add_company_metaboxes')): 
    function jobster_add_company_metaboxes() {
        add_meta_box('company-details-section', __('Company Details', 'jobster'), 'jobster_company_details_render', 'company', 'normal', 'default');
        add_meta_box('company-social-section', __('Social Media', 'jobster'), 'jobster_company_social_media_render', 'company', 'normal', 'default');
        add_meta_box('company-logo-section', __('Company Logo', 'jobster'), 'jobster_company_logo_render', 'company', 'side', 'default');
        add_meta_box('company-cover-section', __('Company Cover', 'jobster'), 'jobster_company_cover_render', 'company', 'side', 'default');
        add_meta_box('company-contact-section', __('Contact Person', 'jobster'), 'jobster_company_contact_render', 'company', 'normal', 'default');
        add_meta_box('company-featured-section', __('Featured', 'jobster'), 'jobster_company_featured_render', 'company', 'side', 'default');
        add_meta_box('company-notificaitons-section', __('Notifications', 'jobster'), 'jobster_company_notifications_render', 'company', 'normal', 'default');
        add_meta_box('company-payment-section', __('Membership & Payment', 'jobster'), 'jobster_company_payment_render', 'company', 'normal', 'default');
        add_meta_box('company-user-section', __('User', 'jobster'), 'jobster_company_user_render', 'company', 'normal', 'default');
    }
endif;

if (!function_exists('jobster_company_details_render')):
    function jobster_company_details_render($post) {
        wp_nonce_field('jobster_company', 'company_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="company_email">' . __('Email', 'jobster') . '</label>
                            <input name="company_email" id="company_email" type="email" value="' . esc_attr(get_post_meta($post->ID, 'company_email', true)) . '">
                        </div>
                    </td>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="company_phone">' . __('Phone', 'jobster') . '</label>
                            <input name="company_phone" id="company_phone" type="tel" value="' . esc_attr(get_post_meta($post->ID, 'company_phone', true)) . '">
                        </div>
                    </td>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="company_website">' . __('Website', 'jobster') . '</label>
                            <input name="company_website" id="company_website" type="url" value="' . esc_attr(get_post_meta($post->ID, 'company_website', true)) . '">
                            <label for="company_redirect" style="margin-top:10px;">
                                <input type="hidden" name="company_redirect" value="">
                                <input type="checkbox" name="company_redirect" id="company_redirect" value="1" ';
                                    if (esc_html(get_post_meta($post->ID, 'company_redirect', true)) == 1) {
                                        print ' checked ';
                                    }
                                print ' /> ' . __('Redirect company page to this URL', 'jobster') . '
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="company_founded">' . __('Founded in', 'jobster') . '</label>
                            <input name="company_founded" id="company_founded" type="number" value="' . esc_attr(get_post_meta($post->ID, 'company_founded', true)) . '">
                        </div>
                    </td>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="company_size">' . __('Size (number of employees)', 'jobster') . '</label>
                            <input name="company_size" id="company_size" type="text" value="' . esc_attr(get_post_meta($post->ID, 'company_size', true)) . '">
                        </div>
                    </td>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="company_address">' . __('Address', 'jobster') . '</label>
                            <input name="company_address" id="company_address" type="text" value="' . esc_attr(get_post_meta($post->ID, 'company_address', true)) . '">
                        </div>
                    </td>
                    <td width="50%" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="nzbn">' . __('NZBN', 'jobster') . '</label>
                            <input name="nzbn" id="nzbn" type="text" value="' . esc_attr(get_post_meta($post->ID, 'nzbn', true)) . '">
                        </div>
                    </td>
                    <td width="25%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="company_trading_name">' . __('Trading Business Name', 'jobster') . '</label>
                            <input name="company_trading_name" id="company_trading_name" type="text" value="' . esc_attr(get_post_meta($post->ID, 'company_trading_name', true)) . '">
                        </div>
                    </td>
                    <td width="50%" valign="top">&nbsp;</td>
                </tr>
            </table>';
    }
endif;
if (!function_exists('jobster_company_contact_render')):
    function jobster_company_contact_render($post) {
        $contact = get_post_meta($post->ID, 'company_contact', true);

        $contact_list = array();

        if ($contact != '') {
            $contact_data = json_decode(urldecode($contact));

            if (isset($contact_data)) {
                $contact_list = $contact_data->contacts;
            }
        }

        print '
            <input type="hidden" id="company_contact" name="company_contact" value="' . esc_attr($contact) . '" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top">
                        <ul class="list-group" id="pxp-company-contact-list">';
        if (count($contact_list) > 0) {
            foreach ($contact_list as $contact_item) {
                print '
                    <li class="list-group-item" 
                        data-title="' . esc_attr($contact_item->title) . '" 
                        data-designation="' . esc_attr($contact_item->designation) . '" 
                        data-email="' . esc_attr($contact_item->email) . '" 
                        data-phone="' . esc_attr($contact_item->phone) . '" 
                        data-mobile="' . esc_attr($contact_item->mobile) . '"
                        
                    >
                        <div class="pxp-company-contact-list-item">
                            <div class="pxp-company-contact-list-item-title"><b>' . esc_html($contact_item->title) . '</b></div>
                            <div class="pxp-company-contact-list-item-designation">' . esc_html($contact_item->designation) . '</div>
                            <div class="pxp-company-contact-list-item-btns">
                                <a href="javascript:void(0);" class="pxp-list-edit-btn pxp-edit-company-contact"><span class="fa fa-pencil"></span></a>
                                <a href="javascript:void(0);" class="pxp-list-del-btn pxp-del-company-contact"><span class="fa fa-trash-o"></span></a>
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
                    <td width="100%" valign="top"><input id="pxp-add-company-contact-btn" type="button" class="button" value="' . esc_html__('Add Contact Person', 'jobster') . '" /></td>
                </tr>
            </table>
            <div class="pxp-company-new-contact">
                <div class="pxp-company-new-contact-container">
                    <div class="pxp-company-new-contact-header"><b>' . esc_html__('Add Contact Person Details', 'jobster') . '</b></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="50%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="company_contact_title">' . __('Name', 'jobster') . '</label><br>
                                    <input name="company_contact_title" id="company_contact_title" type="text">
                                </div>
                            </td>
                            
                        </tr>
                        <tr>
                        <td width="30%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="company_contact_designation">' . __('Designation', 'jobster') . '</label><br>
                                    <input name="company_contact_designation" id="company_contact_designation" type="text">
                                </div>
                            </td>
                            <td width="30%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="company_contact_email">' . __('Email', 'jobster') . '</label><br>
                                    <input name="company_contact_age" id="company_contact_email" type="email">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="company_contact_mobile">' . __('mobile', 'jobster') . '</label><br>
                                    <input name="company_contact_mobile" id="company_contact_mobile" type="text">
                                </div>
                            </td>
                            <td width="30%" valign="top">
                                <div class="form-field pxp-is-custom">
                                    <label for="company_contact_phone">' . __('Phone', 'jobster') . '</label><br>
                                    <input name="company_contact_phone" id="company_contact_phone" type="text">
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                    <div class="form-field">
                        <button type="button" id="pxp-ok-contact" class="button media-button button-primary">' . esc_html__('Add', 'jobster') . '</button>
                        <button type="button" id="pxp-cancel-contact" class="button media-button button-default">' . esc_html__('Cancel', 'jobster') . '</button>
                    </div>
                </div>
            </div>';
    }
endif;


if (!function_exists('jobster_company_social_media_render')): 
    function jobster_company_social_media_render($post) {
        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="company_facebook">' . __('Facebook', 'jobster') . '</label>
                            <input name="company_facebook" id="company_facebook" type="url" value="' . esc_attr(get_post_meta($post->ID, 'company_facebook', true)) . '">
                        </div>
                    </td>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom">
                            <label for="company_twitter">' . __('Twitter', 'jobster') . '</label>
                            <input name="company_twitter" id="company_twitter" type="url" value="' . esc_attr(get_post_meta($post->ID, 'company_twitter', true)) . '">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="company_instagram">' . __('Instagram', 'jobster') . '</label>
                            <input name="company_instagram" id="company_instagram" type="url" value="' . esc_attr(get_post_meta($post->ID, 'company_instagram', true)) . '">
                        </div>
                    </td>
                    <td width="50%" valign="top">
                        <div class="form-field pxp-is-custom pxp-is-last">
                            <label for="company_linkedin">' . __('Linkedin', 'jobster') . '</label>
                            <input name="company_linkedin" id="company_linkedin" type="url" value="' . esc_attr(get_post_meta($post->ID, 'company_linkedin', true)) . '">
                        </div>
                    </td>
                </tr>
            </table>';
    }
endif;

if (!function_exists('jobster_company_logo_render')): 
    function jobster_company_logo_render($post) {
        $logo_src = JOBSTER_PLUGIN_PATH . 'post-types/images/logo-placeholder.png';
        $logo_val = get_post_meta($post->ID, 'company_logo', true);
        $logo = wp_get_attachment_image_src($logo_val, 'pxp-icon');
        $has_image = '';

        if (is_array($logo)) {
            $has_image = 'pxp-has-image';
            $logo_src = $logo[0];
        }

        print '
            <input name="company_logo" id="company_logo" type="hidden" value="' . esc_attr($logo_val) . '">
            <div class="pxp-company-logo-placeholder-container ' . esc_attr($has_image) . '">
                <div class="pxp-company-logo-image-placeholder" style="background-image: url(' . esc_url($logo_src) . ');"></div>
                <div class="pxp-delete-company-logo-image"><span class="fa fa-trash-o"></span></div>
            </div>';
    }
endif;

if (!function_exists('jobster_company_cover_render')): 
    function jobster_company_cover_render($post) {
        $cover_src = JOBSTER_PLUGIN_PATH . 'post-types/images/cover-placeholder.png';
        $cover_val = get_post_meta($post->ID, 'company_cover', true);
        $cover = wp_get_attachment_image_src($cover_val, 'pxp-gallery');
        $has_image = '';

        if (is_array($cover)) {
            $has_image = 'pxp-has-image';
            $cover_src = $cover[0];
        }

        print '
            <input name="company_cover" id="company_cover" type="hidden" value="' . esc_attr($cover_val) . '">
            <div class="pxp-company-cover-placeholder-container ' . esc_attr($has_image) . '">
                <div class="pxp-company-cover-image-placeholder" style="background-image: url(' . esc_url($cover_src) . ');"></div>
                <div class="pxp-delete-company-cover-image"><span class="fa fa-trash-o"></span></div>
            </div>';
    }
endif;

if (!function_exists('jobster_company_featured_render')): 
    function jobster_company_featured_render($post) {
        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top">
                        <p class="meta-options">
                            <input type="hidden" name="company_featured" value="">
                            <input type="checkbox" name="company_featured" value="1" ';
                            if (esc_html(get_post_meta($post->ID, 'company_featured', true)) == 1) {
                                print ' checked ';
                            }
                            print ' />
                            <label for="company_featured">' . __('Set as Featured', 'jobster') . '</label>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;

if (!function_exists('jobster_company_payment_render')): 
    function jobster_company_payment_render($post) {
        $membership_settings = get_option('jobster_membership_settings');
        $pay_type            = isset($membership_settings['jobster_payment_type_field']) ? $membership_settings['jobster_payment_type_field'] : '';

        if ($pay_type == 'listing' || $pay_type == 'plan') {

            print '<input type="hidden" name="company_payment" value="">
                   <input type="checkbox" name="company_payment" value="1" ';
            if (esc_html(get_post_meta($post->ID, 'company_payment', true)) == 1) {
                print ' checked ';
            }
            print ' /> <label for="company_payment">' . __('Allow the company to post jobs regardless of payment method', 'jobster') . '</label>';

            if ($pay_type == 'plan') {
                $plans_list = '';
                $selected_plan = esc_html(get_post_meta($post->ID, 'company_plan', true));

                $args = array(
                    'posts_per_page'   => -1,
                    'post_type'        => 'membership',
                    'order'            => 'ASC',
                    'post_status'      => 'publish,',
                    'meta_key'         => 'membership_plan_price',
                    'orderby'          => 'meta_value_num',
                    'suppress_filters' => false,
                );

                $plans_selection = new WP_Query($args);
                $plans_selection_arr  = get_object_vars($plans_selection);

                if (is_array($plans_selection_arr['posts']) && count($plans_selection_arr['posts']) > 0) {
                    foreach ($plans_selection_arr['posts'] as $plan) {
                        $plans_list .= '<option value="' . esc_attr($plan->ID) . '"';
                        if ($plan->ID == $selected_plan) {
                            $plans_list .= ' selected';
                        }
                        $plans_list .= '>' . $plan->post_title . '</option>';
                    }
                }

                print '
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="50%" valign="bottom">
                                <div class="form-field pxp-is-custom pxp-is-last" style="margin-top: 15px;">
                                    <label for="company_plan_manual">' . __('Manually Assign a Membership Plan', 'jobster') . '</label><br />
                                    <select id="company_plan_manual" name="company_plan_manual">
                                        <option value="">' . __('None', 'jobster') . '</option>
                                        ' . $plans_list . '
                                    </select>
                                </div>
                            </td>
                            <td width="50%" valign="bottom">
                                <button id="pxp-set-plan-manually-btn" type="button" class="button" data-id="' . esc_attr($post->ID) . '">
                                    <span class="pxp-set-plan-manually-btn-text">' . __('Set Plan', 'jobster') . '</span>
                                    <span class="pxp-set-plan-manually-btn-loading" style="display:none;">' . __('Setting Plan...', 'jobster') . '</span>
                                </button>
                            </td>
                        </tr>
                    </table>';
            }
        } else {
            print '<i>' . __('Payment type is disabled.', 'jobster') . '</i>';
        }
    }
endif;

if (!function_exists('jobster_company_user_render')): 
    function jobster_company_user_render($post) {
        wp_nonce_field('jobster_cuser', 'cuser_noncename');

        $mypost        = $post->ID;
        $originalpost  = $post;
        $selected_user = get_post_meta($mypost, 'company_user', true);
        $users_list    = '';
        $args          = array('role' => '');

        $user_query = new WP_User_Query($args);

        foreach ($user_query->results as $user) {
            $is_candidate = jobster_user_is_candidate($user->ID);

            if (!$is_candidate) {
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
                            <label for="company_user">' . __('Assign a User', 'jobster') . '</label>
                            <select id="company_user" name="company_user">
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

if (!function_exists('jobster_company_notifications_render')):
    function jobster_company_notifications_render($post) {
        wp_nonce_field('jobster_company', 'company_noncename'); ?>

        <div class="form-field pxp-is-custom pxp-is-last">
            &nbsp;<br>
            <label for="company_app_notify">
                <input 
                    type="hidden" 
                    name="company_app_notify" 
                    value="0"
                >
                <input 
                    type="checkbox" 
                    name="company_app_notify" 
                    id="company_app_notify" 
                    value="1" 
                    <?php checked(
                        get_post_meta($post->ID, 'company_app_notify', true), true, true
                    ); ?>
                >
                <?php esc_html_e('Notify the company when a new candidate applies for a job', 'jobster'); ?>
            </label>
        </div>
    <?php }
endif;

if (!function_exists('jobster_company_meta_save')): 
    function jobster_company_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['company_noncename']) && wp_verify_nonce($_POST['company_noncename'], 'jobster_company')) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        if (isset($_POST['company_email'])) {
            update_post_meta($post_id, 'company_email', sanitize_text_field($_POST['company_email']));
        }
        if (isset($_POST['company_phone'])) {
            update_post_meta($post_id, 'company_phone', sanitize_text_field($_POST['company_phone']));
        }
        if (isset($_POST['company_website'])) {
            update_post_meta($post_id, 'company_website', sanitize_text_field($_POST['company_website']));
        }
        if (isset($_POST['company_redirect'])) {
            update_post_meta($post_id, 'company_redirect', sanitize_text_field($_POST['company_redirect']));
        }
        if (isset($_POST['company_founded'])) {
            update_post_meta($post_id, 'company_founded', sanitize_text_field($_POST['company_founded']));
        }
        if (isset($_POST['company_aaddress'])) {
            update_post_meta($post_id, 'company_aaddress', sanitize_text_field($_POST['company_aaddress']));
        }
        if (isset($_POST['nzbn'])) {
            update_post_meta($post_id, 'nzbn', sanitize_text_field($_POST['nzbn']));
        }
        if (isset($_POST['company_trading_name'])) {
            update_post_meta($post_id, 'company_trading_name', sanitize_text_field($_POST['company_trading_name']));
        }    
        if (isset($_POST['company_address'])) {
            update_post_meta($post_id, 'company_address', sanitize_text_field($_POST['company_address']));
        } 
        if (isset($_POST['company_size'])) {
            update_post_meta($post_id, 'company_size', sanitize_text_field($_POST['company_size']));
        }
        if (isset($_POST['neighborhood'])) {
            update_post_meta($post_id, 'neighborhood', sanitize_text_field($_POST['neighborhood']));
        }
        if (isset($_POST['company_facebook'])) {
            update_post_meta($post_id, 'company_facebook', sanitize_text_field($_POST['company_facebook']));
        }
        if (isset($_POST['company_twitter'])) {
            update_post_meta($post_id, 'company_twitter', sanitize_text_field($_POST['company_twitter']));
        }
        if (isset($_POST['company_instagram'])) {
            update_post_meta($post_id, 'company_instagram', sanitize_text_field($_POST['company_instagram']));
        }
        if (isset($_POST['company_linkedin'])) {
            update_post_meta($post_id, 'company_linkedin', sanitize_text_field($_POST['company_linkedin']));
        }
        if (isset($_POST['company_logo'])) {
            update_post_meta($post_id, 'company_logo', sanitize_text_field($_POST['company_logo']));
        }
        if (isset($_POST['company_cover'])) {
            update_post_meta($post_id, 'company_cover', sanitize_text_field($_POST['company_cover']));
        }
        if (isset($_POST['company_featured'])) {
            update_post_meta($post_id, 'company_featured', sanitize_text_field($_POST['company_featured']));
        }
        if (isset($_POST['company_user'])) {
            update_post_meta($post_id, 'company_user', sanitize_text_field($_POST['company_user']));
        }
        if (isset($_POST['company_app_notify'])) {
            update_post_meta($post_id, 'company_app_notify', sanitize_text_field($_POST['company_app_notify']));
        }
        if (isset($_POST['company_payment'])) {
            update_post_meta($post_id, 'company_payment', sanitize_text_field($_POST['company_payment']));
        }
        if (isset($_POST['company_contact'])) {
            $contact_list = array();
            $contact_data_raw = urldecode($_POST['company_contact']);
            $contact_data = json_decode($contact_data_raw);

            $contact_data_encoded = '';

            if (isset($contact_data)) {
                $new_data = new stdClass();
                $new_contacts = array();

                $contact_list = $contact_data->contacts;

                foreach ($contact_list as $contact_item) {
                    $new_contact = new stdClass();

                    $new_contact->title       = sanitize_text_field($contact_item->title);
                    $new_contact->designation = sanitize_text_field($contact_item->designation);
                    $new_contact->email      = sanitize_text_field($contact_item->email);
                    $new_contact->phone      = sanitize_text_field($contact_item->phone);

                    array_push($new_contacts, $new_contact);
                }

                $new_data->contacts = $new_contacts;

                $contact_data_before = json_encode($new_data);
                $contact_data_encoded = urlencode($contact_data_before);
            }

            update_post_meta($post_id, 'company_contact', $contact_data_encoded);
        }
    }
endif;


add_action('save_post', 'jobster_company_meta_save');

if (!function_exists('jobster_get_company_locations_industries')): 
    function jobster_get_company_locations_industries() {
        $location_tax = array( 
            'company_location'
        );
        $location_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        ); 
        $location_terms = get_terms($location_tax, $location_args);

        $industry_tax = array( 
            'company_industry'
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
    'wp_ajax_nopriv_jobster_get_company_locations_industries',
    'jobster_get_company_locations_industries'
);
add_action(
    'wp_ajax_jobster_get_company_locations_industries',
    'jobster_get_company_locations_industries'
);

if (!function_exists('jobster_set_company_membership_manually')):
    function jobster_set_company_membership_manually() {
        check_ajax_referer('jobster_company', 'security');

        $company_id =   isset($_POST['company_id'])
                        ? sanitize_text_field($_POST['company_id'])
                        : '';
        $plan_id =  isset($_POST['plan_id'])
                    ? sanitize_text_field($_POST['plan_id'])
                    : '';

        $plan_listings = get_post_meta($plan_id, 'membership_submissions_no', true);
        $plan_unlimited  = get_post_meta($plan_id, 'membership_unlim_submissions', true);
        $plan_featured_listings = get_post_meta($plan_id, 'membership_featured_submissions_no', true);
        $plan_cv_access = get_post_meta($plan_id, 'membership_cv_access', true);
        $plan_free = get_post_meta($plan_id, 'membership_free_plan', true);

        update_post_meta($company_id, 'company_plan', $plan_id);
        update_post_meta($company_id, 'company_plan_listings', $plan_listings);
        update_post_meta($company_id, 'company_plan_unlimited', $plan_unlimited);
        update_post_meta($company_id, 'company_plan_featured', $plan_featured_listings);
        update_post_meta($company_id, 'company_plan_cv_access', $plan_cv_access);

        if ($plan_free == 1) {
            update_post_meta($company_id, 'company_plan_free', 1);
        } else {
            update_post_meta($company_id, 'company_plan_free', '');
        }

        $time = time(); 
        $date = date('Y-m-d H:i:s', $time);

        update_post_meta($company_id, 'company_plan_activation', $date);

        echo json_encode(array(
            'set' => true
        ));
        exit();

        die();
    }
endif;
add_action(
    'wp_ajax_nopriv_jobster_set_company_membership_manually',
    'jobster_set_company_membership_manually'
);
add_action(
    'wp_ajax_jobster_set_company_membership_manually',
    'jobster_set_company_membership_manually'
);
?>