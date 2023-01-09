<?php
/*
Template Name: Company Dashboard - Profile
*/

/**
 * @package WordPress
 * @subpackage Jobster
 */

global $current_user;
global $company_id;
global $post;

if (!is_user_logged_in()) {
    wp_redirect(home_url());
}

$current_user = wp_get_current_user();

$is_company = jobster_user_is_company($current_user->ID);
if ($is_company) {
    $company_id = jobster_get_company_by_userid($current_user->ID);

    $company_name = get_the_title($company_id);
    $company_email = get_post_meta($company_id, 'company_email', true);
    $company_phone = get_post_meta($company_id, 'company_phone', true);
    $company_website = get_post_meta($company_id, 'company_website', true);
    $company_redirect = get_post_meta($company_id, 'company_redirect', true);
    $contact = get_post_meta($company_id, 'company_contact', true);
    $cover_val = get_post_meta($company_id, 'company_cover', true);
    $cover = wp_get_attachment_image_src($cover_val, 'pxp-gallery');

    $logo_val = get_post_meta($company_id, 'company_logo', true);
    $logo = wp_get_attachment_image_src($logo_val, 'pxp-thmb');

    $company = get_post($company_id);
    $about = apply_filters('the_content', $company->post_content);

    $industry = wp_get_post_terms($company_id, 'company_industry', true);
    $industry_id = $industry ? $industry[0]->term_id : '';

    $location = wp_get_post_terms($company_id, 'company_location', true);
    $location_id = $location ? $location[0]->term_id : '';

    $company_founded = get_post_meta($company_id, 'company_founded', true);
    $company_size = get_post_meta($company_id, 'company_size', true);

    $company_facebook = get_post_meta($company_id, 'company_facebook', true);
    $company_twitter = get_post_meta($company_id, 'company_twitter', true);
    $company_instagram = get_post_meta($company_id, 'company_instagram', true);
    $company_linkedin = get_post_meta($company_id, 'company_linkedin', true);

    $app_notify = get_post_meta($company_id, 'company_app_notify', true);
} else {
    wp_redirect(home_url());
}

get_header('dashboard', array('bg_color' => 'pxpMainColorLight'));

jobster_get_company_dashboard_side($company_id, 'profile'); ?>

<div class="pxp-dashboard-content">
    <?php jobster_get_company_dashboard_top($company_id); ?>

    <div class="pxp-dashboard-content-details">
        <h1><?php esc_html_e('Edit Profile', 'jobster'); ?></h1>
        <p class="pxp-text-light">
            <?php esc_html_e('Edit your company profile page info.', 'jobster'); ?>
        </p>

        <form class="pxp-dashboard-form">
            <input 
                type="hidden" 
                id="pxp-company-profile-id" 
                value="<?php echo esc_attr($company_id); ?>"
            >

            <div class="row mt-4 mt-lg-5">
                <div class="col-xxl-8">
                    <div class="mb-3">
                        <label 
                            for="pxp-company-profile-name" 
                            class="form-label"
                        >
                            <?php esc_html_e('Company name', 'jobster'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="pxp-company-profile-name" 
                            class="form-control pxp-is-required" 
                            placeholder="<?php esc_html_e('Add company name', 'jobster'); ?>" 
                            value="<?php echo esc_attr($company_name); ?>" 
                            required
                        >
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label 
                                    for="pxp-company-profile-email" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Email', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="pxp-company-profile-email" 
                                    class="form-control pxp-is-required" 
                                    placeholder="company@email.com" 
                                    value="<?php echo esc_attr($company_email); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label 
                                    for="pxp-company-profile-phone" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Phone', 'jobster'); ?>
                                </label>
                                <input 
                                    type="tel" 
                                    id="pxp-company-profile-phone" 
                                    class="form-control" 
                                    placeholder="(+12) 345 6789" 
                                    value="<?php echo esc_attr($company_phone); ?>"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label 
                            for="pxp-company-profile-website" 
                            class="form-label"
                        >
                            <?php esc_html_e('Website', 'jobster'); ?>
                        </label>
                        <input 
                            type="url" 
                            id="pxp-company-profile-website" 
                            class="form-control" 
                            placeholder="https://" 
                            value="<?php echo esc_url($company_website); ?>"
                        >
                    </div>
                    <div class="mt-1">
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                id="pxp-company-profile-redirect" 
                                value="1" 
                                <?php checked($company_redirect, '1'); ?>
                            >
                            <label 
                                class="form-check-label" 
                                for="pxp-company-profile-redirect"
                            >
                                <?php esc_html_e('Redirect company page to this URL', 'jobster'); ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4">
                    <div class="form-label">&nbsp;</div>
                    <div class="position-relative mb-3">
                        <div id="pxp-upload-container-cover">
                            <div class="pxp-dashboard-cover">
                                <?php if (is_array($cover)) { ?>
                                    <div 
                                        class="pxp-dashboard-cover-photo pxp-cover has-animation pxp-no-border" 
                                        style="background-image: url(<?php echo esc_url($cover[0]); ?>);" 
                                        data-id="<?php echo esc_attr($cover_val); ?>"
                                    ></div>
                                <?php } else { ?>
                                    <div 
                                        class="pxp-dashboard-cover-photo pxp-cover has-animation" 
                                        data-id=""
                                    ></div>
                                <?php } ?>
                            </div>
                            <div class="pxp-dashboard-upload-cover-status"></div>
                            <a 
                                role="button" 
                                id="pxp-uploader-cover" 
                                class="pxp-dashboard-upload-cover-btn"
                            >
                                <?php if (!is_array($cover)) {
                                    esc_html_e('Upload Cover Image', 'jobster');
                                } ?>
                            </a>
                            <input 
                                type="hidden" 
                                name="pxp-dashboard-cover" 
                                id="pxp-dashboard-cover" 
                                value="<?php echo esc_attr($cover_val); ?>"
                            >
                        </div>
                    </div>
                    <div class="position-relative mb-3">
                        <div id="pxp-upload-container-logo">
                            <div class="pxp-dashboard-logo">
                                <?php if (is_array($logo)) { ?>
                                    <div 
                                        class="pxp-dashboard-logo-photo pxp-cover has-animation pxp-no-border" 
                                        style="background-image: url(<?php echo esc_url($logo[0]); ?>);" 
                                        data-id="<?php echo esc_attr($logo_val); ?>"
                                    ></div>
                                <?php } else { ?>
                                    <div 
                                        class="pxp-dashboard-logo-photo pxp-cover has-animation" 
                                        data-id=""
                                    ></div>
                                <?php } ?>
                            </div>
                            <div class="pxp-dashboard-upload-logo-status"></div>
                            <a 
                                role="button" 
                                id="pxp-uploader-logo" 
                                class="pxp-dashboard-upload-logo-btn"
                            >
                                <?php if (!is_array($logo)) {
                                    esc_html_e('Upload Logo', 'jobster');
                                } ?>
                            </a>
                            <input 
                                type="hidden" 
                                name="pxp-dashboard-logo" 
                                id="pxp-dashboard-logo" 
                                value="<?php echo esc_attr($logo_val); ?>"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="pxp-is-tinymce mt-4">
                <label class="form-label">
                    <?php esc_html_e('About the company', 'jobster'); ?>
                </label>
                <?php $about_settings = array(
                    'teeny'         => true,
                    'media_buttons' => false,
                    'editor_height' => 240,
                    'editor_css'    => '
                        <style>
                            .wp-editor-tabs {
                                float: none;
                                padding: 1rem 0 .5rem 0;
                                position: relative;
                                display: inline-flex;
                                vertical-align: middle;
                            }
                            .wp-switch-editor {
                                float: none;
                                top: 0;
                                height: auto;
                                background: transparent;
                                color: var(--pxpMainColor);
                                border: 1px solid var(--pxpMainColorLight);
                                padding: 7px 16px;
                                border-radius: 20px;
                                margin: 0;
                                font-weight: 400;
                                font-size: .8rem;
                                text-transform: uppercase;
                                transition: var(--pxpHoverTransition);
                                transition-property: color, background-color, border-color;
                            }
                            .wp-switch-editor:hover {
                                color: #fff;
                                border-color: var(--pxpMainColor);
                                background-color: var(--pxpMainColor);
                            }
                            .wp-switch-editor.switch-tmce {
                                border-top-right-radius: 0;
                                border-bottom-right-radius: 0;
                            }
                            .wp-switch-editor.switch-html {
                                border-top-left-radius: 0;
                                border-bottom-left-radius: 0;
                                margin-left: -1px;
                            }
                            .tmce-active .switch-tmce,
                            .html-active .switch-html {
                                color: #fff;
                                background-color: var(--pxpMainColorDark);
                                border-color: var(--pxpMainColorDark);
                            }
                            div.mce-panel {
                                background: #fff;
                            }
                            div.mce-edit-area {
                                box-shadow: none;
                                overflow: hidden;
                                border: 1px solid rgba(0,0,0,.2) !important;
                                border-radius: 30px;
                                padding: 1rem;
                            }
                            div.mce-fullscreen div.mce-edit-area {
                                box-shadow: none;
                                border-radius: 0;
                            }
                            div.mce-fullscreen div.mce-panel {
                                background: #fff;
                            }
                            div.mce-toolbar-grp {
                                background: transparent;
                                border-bottom: 0 none;
                            }
                            div.mce-fullscreen div.mce-toolbar-grp {
                                background: #fff;
                                border-bottom: 1px solid #ddd;
                            }
                            .wp-editor-container {
                                border: 0 none;
                            }
                            div.mce-toolbar-grp > div {
                                padding: 8px 0;
                            }
                            div.mce-fullscreen div.mce-toolbar-grp > div {
                                padding: 3px;
                            }
                            div.mce-statusbar {
                                border-top: 0 none;
                                margin-bottom: 1rem;
                            }
                            .quicktags-toolbar {
                                padding: 10px 0;
                                border-bottom: 0 none;
                                background: transparent;
                            }
                            .wp-editor-container textarea.wp-editor-area {
                                border: 1px solid rgba(0,0,0,.2);
                                font-weight: 300;
                                color: var(--pxpTextColor);
                                background-color: #fff;
                                border-radius: 30px;
                                padding: calc(1rem + 10px);
                            }
                            .mce-top-part::before {
                                content: none;
                            }
                            .mce-ico {
                                color: var(--pxpTextColor);
                            }
                            .mce-btn button {
                                color: var(--pxpTextColor);
                                border-radius: 
                            }
                            .mce-toolbar .mce-btn-group .mce-btn, 
                            .qt-dfw {
                                border-radius: 5px;
                                transition: var(--pxpHoverTransition);
                                transition-property: color, background-color, border-color;
                            }
                            .mce-toolbar .mce-btn-group .mce-btn:focus, 
                            .mce-toolbar .mce-btn-group .mce-btn:hover, 
                            .qt-dfw:focus, 
                            .qt-dfw:hover {
                                box-shadow: none;
                                color: var(--pxpTextColor);
                                background: transparent;
                                border-color: rgba(0,0,0,.2);
                            }
                            .mce-toolbar .mce-btn-group .mce-btn.mce-active, 
                            .mce-toolbar .mce-btn-group .mce-btn:active, 
                            .qt-dfw.active {
                                box-shadow: none;
                                color: #fff;
                                background-color: var(--pxpMainColorDark);
                                border-color: var(--pxpMainColorDark);
                            }
                            .wp-core-ui .quicktags-toolbar input.button.button-small {
                                background-color: var(--pxpMainColorLight);
                                border: 0 none;
                                border-radius: 5px;
                                color: var(--pxpMainColorDark);
                                transition: var(--pxpHoverTransition);
                                transition-property: background-color, color;
                            }
                            .wp-core-ui .quicktags-toolbar input.button.button-small:hover {
                                color: #fff;
                                background-color: var(--pxpMainColor);
                            }
                        </style>
                    ',
                );
                wp_editor($about, 'pxp-company-profile-about', $about_settings); ?>
            </div>

            <div class="row">
                <div class="col-md-6 col-xxl-3">
                    <div class="mb-3">
                        <?php $industry_tax = array( 
                            'company_industry'
                        );
                        $industry_args = array(
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                            'hide_empty' => false
                        );
                        $industry_terms = get_terms(
                            $industry_tax,
                            $industry_args
                        ); ?>

                        <label 
                            for="pxp-company-profile-industry" 
                            class="form-label"
                        >
                        Current Industry
                            <span class="text-danger">*</span>
                        </label>
                        <select 
                            id="pxp-company-profile-industry" 
                            class="form-select pxp-is-required" 
                        >
                            <option value="0">
                                <?php esc_html_e('Select industry', 'jobster'); ?>
                            </option>
                            <?php foreach ($industry_terms as $industry_term) { ?>
                                <option 
                                    value="<?php echo esc_attr($industry_term->term_id);?>" 
                                    <?php selected($industry_id == $industry_term->term_id); ?>
                                >
                                    <?php echo esc_html($industry_term->name); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-xxl-3">
                    <div class="mb-3">
                        <?php $location_tax = array( 
                            'company_location'
                        );
                        $location_args = array(
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                            'hide_empty' => false
                        );
                        $location_terms = get_terms(
                            $location_tax,
                            $location_args
                        ); ?>

                        <label 
                            for="pxp-company-profile-location" 
                            class="form-label"
                        >
                            <?php esc_html_e('Location', 'jobster'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <select 
                            id="pxp-company-profile-location" 
                            class="form-select pxp-is-required" 
                        >
                            <option value="0">
                                <?php esc_html_e('Select location', 'jobster'); ?>
                            </option>
                            <?php foreach ($location_terms as $location_term) { ?>
                                <option 
                                    value="<?php echo esc_attr($location_term->term_id);?>" 
                                    <?php selected($location_id == $location_term->term_id); ?>
                                >
                                    <?php echo esc_html($location_term->name); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-xxl-3">
                    <div class="mb-3">
                        <label 
                            for="pxp-company-profile-founded" 
                            class="form-label"
                        >
                            <?php esc_html_e('NZBN No', 'jobster'); ?>
                        </label>
                        <input 
                            type="number" 
                            id="pxp-company-profile-founded" 
                            class="form-control" 
                            placeholder="NZBN No" 
                            value="<?php echo esc_attr($company_founded); ?>"
                        >
                    </div>
                </div>

                <div class="col-md-6 col-xxl-3">
                    <div class="mb-3">
                        <label 
                            for="pxp-company-profile-size" 
                            class="form-label"
                        >
                            <?php esc_html_e('Size (number of employees)', 'jobster'); ?>
                        </label>
                        <input 
                            type="text" 
                            id="pxp-company-profile-size" 
                            class="form-control" 
                            placeholder="E.g. 1 - 50" 
                            value="<?php echo esc_attr($company_size); ?>"
                        >
                    </div>
                </div>
            </div>
            <div class="mt-4 mt-lg-5">
                <h2><?php esc_html_e('Contact Person', 'jobster'); ?></h2>

                <div class="table-responsive">
                    <table class="table align-middle pxp-company-dashboard-contact-list">
                        <tbody>
                            <?php 
                            
                            $contact_list = array();

                            if ($contact != '') {
                                $contact_data = json_decode(urldecode($contact));

                                if (isset($contact_data)) {
                                    $contact_list = $contact_data->contacts;
                                }
                            }
                            if (count($contact_list) > 0) {
                                foreach ($contact_list as $contact_item) { ?>
                                    <tr>
                                        <td style="width: 30%;">
                                            <div class="pxp-company-dashboard-contact-cell-title">
                                                <?php echo esc_html($contact_item->title); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-company-dashboard-contact-cell-designation">
                                                <?php echo esc_html($contact_item->designation); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-company-dashboard-contact-cell-email">
                                                <?php echo esc_html($contact_item->email); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-company-dashboard-contact-cell-mobile">
                                                <?php echo esc_html($contact_item->mobile); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-company-dashboard-contact-cell-phone">
                                                <?php echo esc_html($contact_item->phone); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pxp-dashboard-table-options">
                                                <ul 
                                                    class="list-unstyled" 
                                                    data-title="<?php echo esc_attr($contact_item->title); ?>" 
                                                    data-designation="<?php echo esc_attr($contact_item->designation); ?>" 
                                                    data-email="<?php echo esc_attr($contact_item->email); ?>" 
                                                    data-mobile="<?php echo esc_attr($contact_item->mobile); ?>"
                                                    data-phone="<?php echo esc_attr($contact_item->phone); ?>"
                                                    
                                                    
                                                >
                                                    <li>
                                                        <button 
                                                            class="pxp-company-dashboard-edit-contact-btn" 
                                                            title="<?php esc_attr_e('Edit', 'jobster'); ?>"
                                                        >
                                                            <span class="fa fa-pencil"></span>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button 
                                                            class="pxp-company-dashboard-delete-contact-btn" 
                                                            title="<?php esc_attr_e('Delete', 'jobster'); ?>"
                                                        >
                                                            <span class="fa fa-trash-o"></span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>

                <input 
                    type="hidden" 
                    id="pxp-company-dashboard-contact" 
                    name="pxp-company-dashboard-contact" 
                    value="<?php echo esc_attr($contact); ?>"
                >
                <div class="pxp-company-dashboard-contact-form mt-3 mt-lg-4 d-none">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-company-dashboard-contact-title" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Name', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-company-dashboard-contact-title" 
                                    class="form-control pxp-is-required" 
                                    placeholder="<?php esc_attr_e('E.g. Jhone Snow', 'jobster'); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-company-dashboard-contact-designation" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Designation', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-company-dashboard-contact-designation" 
                                    class="form-control pxp-is-required" 
                                    placeholder="<?php esc_attr_e('Designation', 'jobster'); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-company-dashboard-contact-email" 
                                    class="form-label"
                                >
                                    Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="pxp-company-dashboard-contact-email" 
                                    class="form-control pxp-is-required" 
                                    placeholder="Email"
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-company-dashboard-contact-mobile" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Mobile', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="pxp-company-dashboard-contact-mobile" 
                                    class="form-control pxp-is-required" 
                                    placeholder="(+94)123 456 789"
                                >
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-company-dashboard-contact-phone" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Phone', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="pxp-company-dashboard-contact-phone" 
                                    class="form-control pxp-is-required" 
                                    placeholder="(+94)123 456 789"
                                >
                            </div>
                        </div>
                    </div>
    
                    

                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-subsection-cta pxp-company-dashboard-ok-contact-btn"
                    >
                        <?php esc_html_e('Add', 'jobster'); ?>
                    </a>
                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-subsection-cta-o ms-e pxp-company-dashboard-cancel-contact-btn"
                    >
                        <?php esc_html_e('Cancel', 'jobster'); ?>
                    </a>
                </div>

                <div class="pxp-company-dashboard-edit-contact-form">
                </div>

                <a 
                    href="javascript:void(0);" 
                    class="btn mt-3 mt-lg-4 rounded-pill pxp-subsection-cta pxp-company-dashboard-add-contact-btn"
                >
                    <?php esc_html_e('Add Contact Person Details', 'jobster'); ?>
                </a>
            </div>
            <div class="mt-4 mt-lg-5">
                <h2><?php esc_html_e('Social Media', 'jobster'); ?></h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label 
                                for="pxp-company-profile-facebook" 
                                class="form-label"
                            >
                                <?php esc_html_e('Facebook', 'jobster'); ?>
                            </label>
                            <input 
                                type="url" 
                                id="pxp-company-profile-facebook" 
                                class="form-control" 
                                placeholder="https://" 
                                value="<?php echo esc_attr($company_facebook); ?>"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label 
                                for="pxp-company-profile-twitter" 
                                class="form-label"
                            >
                                <?php esc_html_e('Twitter', 'jobster'); ?>
                            </label>
                            <input 
                                type="url" 
                                id="pxp-company-profile-twitter" 
                                class="form-control" 
                                placeholder="https://" 
                                value="<?php echo esc_attr($company_twitter); ?>"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label 
                                for="pxp-company-profile-instagram" 
                                class="form-label"
                            >
                                <?php esc_html_e('Instagram', 'jobster'); ?>
                            </label>
                            <input 
                                type="url" 
                                id="pxp-company-profile-instagram" 
                                class="form-control" 
                                placeholder="https://" 
                                value="<?php echo esc_attr($company_instagram); ?>"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label 
                                for="pxp-company-profile-linkedin" 
                                class="form-label"
                            >
                                <?php esc_html_e('Linkedin', 'jobster'); ?>
                            </label>
                            <input 
                                type="url" 
                                id="pxp-company-profile-linkedin" 
                                class="form-control" 
                                placeholder="https://" 
                                value="<?php echo esc_attr($company_linkedin); ?>"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="mt-4 mtlg-5">
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="pxp-company-profile-app-notify" 
                        value="1" 
                        <?php checked($app_notify, '1'); ?>
                    >
                    <label class="form-check-label" for="pxp-company-profile-app-notify">
                        <?php esc_html_e('Notify the company when a new candidate applies for a job', 'jobster'); ?>
                    </label>
                </div>
            </div> -->

            <div class="mt-4 mt-lg-5">
                <div class="pxp-company-profile-response"></div>
                <?php wp_nonce_field(
                    'company_profile_ajax_nonce',
                    'pxp-company-profile-security',
                    true
                ); ?>
                <a 
                    href="javascript:void(0);" 
                    class="btn rounded-pill pxp-submit-btn pxp-company-profile-update-btn"
                >
                    <span class="pxp-company-profile-update-btn-text">
                        <?php esc_html_e('Update Profile', 'jobster'); ?>
                    </span>
                    <span class="pxp-company-profile-update-btn-loading pxp-btn-loading">
                        <img 
                            src="<?php echo esc_url(JOBSTER_LOCATION . '/images/loader-light.svg'); ?>" 
                            class="pxp-btn-loader" 
                            alt="..."
                        >
                    </span>
                </a>
            </div>
        </form>
    </div>

    <?php get_footer('dashboard'); ?>
</div>