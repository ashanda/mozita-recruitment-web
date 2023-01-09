<?php
/*
Template Name: Candidate Dashboard - Profile
*/

/**
 * @package WordPress
 * @subpackage Jobster
 */

global $current_user;
global $candidate_id;
global $post;

if (!is_user_logged_in()) {
    wp_redirect(home_url());
}

$current_user = wp_get_current_user();

$is_candidate = jobster_user_is_candidate($current_user->ID);
if ($is_candidate) {
    $candidate_id = jobster_get_candidate_by_userid($current_user->ID);

    $candidate_name = get_the_title($candidate_id);
    $candidate_title = get_post_meta($candidate_id, 'candidate_title', true);
    $candidate_first_name = get_post_meta($candidate_id, 'candidate_first_name', true);
    $candidate_systemid = get_post_meta($candidate_id, 'candidate_systemid', true);
          if($candidate_systemid == ""){
              $myuid = crc32(uniqid());
              
            }else{
            $myuid = esc_attr(get_post_meta($candidate_id, 'candidate_systemid', true));
          
            } 
    $candidate_last_name = get_post_meta($candidate_id, 'candidate_last_name', true);
    $candidate_whatsapp = get_post_meta($candidate_id, 'candidate_whatsapp', true);
    $candidate_botim = get_post_meta($candidate_id, 'candidate_botim', true);
    $candidate_email = get_post_meta($candidate_id, 'candidate_email', true);
    $candidate_phone = get_post_meta($candidate_id, 'candidate_phone', true);
    $candidate_website = get_post_meta($candidate_id, 'candidate_website', true);
    $candidate_phone = get_post_meta($candidate_id, 'candidate_phone', true);
    $language = get_post_meta($candidate_id, 'candidate_language', true);
    $candidate_phone = get_post_meta($candidate_id, 'candidate_phone', true);
    $family = get_post_meta($candidate_id, 'candidate_family', true);
    $candidate_civilstate = get_post_meta($candidate_id, 'candidate_civil_state', true);
    $candidate_country = get_post_meta($candidate_id, 'candidate_origin_country', true);
    $cover_val = get_post_meta($candidate_id, 'candidate_cover', true);
    $cover = wp_get_attachment_image_src($cover_val, 'pxp-gallery');

    $photo_val = get_post_meta($candidate_id, 'candidate_photo', true);
    $photo = wp_get_attachment_image_src($photo_val, 'pxp-thmb');

    $candidate = get_post($candidate_id);
    $about = apply_filters('the_content', $candidate->post_content);

    $industry = wp_get_post_terms($candidate_id, 'candidate_industry', true);
    $industry_id = $industry ? $industry[0]->term_id : '';

    $location = wp_get_post_terms($candidate_id, 'candidate_location', true);
    $location_id = $location ? $location[0]->term_id : '';

    $skills = wp_get_post_terms($candidate_id, 'candidate_skill', true);
    $brands= wp_get_post_terms($candidate_id, 'candidate_brand', true);
    $work = get_post_meta($candidate_id, 'candidate_work', true);

    $education = get_post_meta($candidate_id, 'candidate_edu', true);

    $candidate_facebook = get_post_meta($candidate_id, 'candidate_facebook', true);
    $candidate_twitter = get_post_meta($candidate_id, 'candidate_twitter', true);
    $candidate_instagram = get_post_meta($candidate_id, 'candidate_instagram', true);
    $candidate_linkedin = get_post_meta($candidate_id, 'candidate_linkedin', true);

    $cv_val = get_post_meta($candidate_id, 'candidate_cv', true);
    $cv = wp_get_attachment_url($cv_val);

    $cv_filename = '';
    $cv_class = '';
    if (!empty($cv)) {
        $cv_filename = basename($cv);
        $cv_class = 'pxp-has-file';
    }
} else {
    wp_redirect(home_url());
}

get_header('dashboard', array('bg_color' => 'pxpSecondaryColorLight'));

jobster_get_candidate_dashboard_side($candidate_id, 'profile'); ?>

<div class="pxp-dashboard-content">

    <?php jobster_get_candidate_dashboard_top($candidate_id); ?>

    <div class="pxp-dashboard-content-details">
        <h1><?php esc_html_e('Edit Profile', 'jobster'); ?></h1>
        
        <p class="pxp-text-light">
            <?php esc_html_e('Edit your candidate profile page info.', 'jobster'); ?>
        </p>

        <form class="pxp-dashboard-form">
            <input 
                type="hidden" 
                id="pxp-candidate-profile-id" 
                value="<?php echo esc_attr($candidate_id); ?>"
            >
            <?php wp_nonce_field(
                'candidate_profile_ajax_nonce',
                'pxp-candidate-profile-security',
                true
            ); ?>

            <div class="row mt-4 mt-lg-5">
                <div class="col-xxl-8">
                    <div class="mb-3">
                        <label 
                            for="pxp-candidate-profile-name" 
                            class="form-label"
                        >
                            <?php esc_html_e('Name', 'jobster'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="pxp-candidate-profile-name" 
                            class="form-control pxp-is-required" 
                            placeholder="<?php esc_html_e('Add your name', 'jobster'); ?>" 
                            value="<?php echo esc_attr($candidate_name); ?>" 
                            required
                        >
                        <input id="pxp-candidate-systemid" type="hidden" value="<?php echo esc_attr($myuid );?>" readonly>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-profile-first-name" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('First Name', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-profile-fname" 
                                    class="form-control" 
                                    placeholder="<?php esc_html_e('Add your first name', 'jobster'); ?>" 
                                    value="<?php echo esc_attr($candidate_first_name); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-profile-lname" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Last Name', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-profile-lname" 
                                    class="form-control" 
                                    placeholder="<?php esc_html_e('Add your first name', 'jobster'); ?>" 
                                    value="<?php echo esc_attr($candidate_last_name); ?>"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-profile-email" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Email', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="pxp-candidate-profile-email" 
                                    class="form-control pxp-is-required" 
                                    placeholder="candidate@email.com" 
                                    value="<?php echo esc_attr($candidate_email); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-profile-phone" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Phone', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="pxp-candidate-profile-phone" 
                                    class="form-control" 
                                    placeholder="(+12) 345 6789" 
                                    value="<?php echo esc_attr($candidate_phone); ?>"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-profile-email" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Whats app', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="pxp-candidate-profile-whatsapp" 
                                    class="form-control" 
                                    placeholder="(+12) 345 6789" 
                                    value="<?php echo esc_attr($candidate_whatsapp); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-profile-botim" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Botim', 'jobster'); ?>
                                    
                                </label>
                                <input 
                                    type="tel" 
                                    id="pxp-candidate-profile-botim" 
                                    class="form-control" 
                                    placeholder="(+12) 345 6789" 
                                    value="<?php echo esc_attr($candidate_botim); ?>"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-profile-civilstate" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Civil Status', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                               <?php /* <input 
                                    type="text" 
                                    id="pxp-candidate-profile-civil_state" 
                                    class="form-control" 
                                    placeholder="Single/Marride" 
                                    value="<?php echo esc_attr($candidate_civilstate); ?>"
                                >*/?>
                                <select name="pxp-candidate-profile-civil_state" id="pxp-candidate-profile-civil_state" class="form-select pxp-is-required">
                                <option selected value="<?php echo esc_attr($candidate_civilstate); ?>"><?php echo esc_attr($candidate_civilstate); ?></option>
                                <option value="Single">Single</option>
                                <option value="Marride">Married</option>
                                
                                </select>
                               
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-profile-country" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Origin Country', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-profile-country" 
                                    class="form-control" 
                                    placeholder="Origin Country" 
                                    value="<?php echo esc_attr($candidate_country); ?>"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label 
                            for="pxp-candidate-profile-title" 
                            class="form-label"
                        >
                            <?php esc_html_e('Job Title', 'jobster'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="pxp-candidate-profile-title" 
                            class="form-control" 
                            placeholder="<?php esc_attr_e('Add your title', 'jobster'); ?>" 
                            value="<?php echo esc_attr($candidate_title); ?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label 
                            for="pxp-candidate-profile-website" 
                            class="form-label"
                        >
                            <?php esc_html_e('Website', 'jobster'); ?>
                        </label>
                        <input 
                            type="text" 
                            id="pxp-candidate-profile-website" 
                            class="form-control" 
                            placeholder="<?php esc_attr_e('Add your website URL', 'jobster'); ?>" 
                            value="<?php echo esc_attr($candidate_website); ?>"
                        >
                    </div>
                </div>
                <div class="mt-4 mt-lg-5">
                <h2><?php esc_html_e('Language', 'jobster'); ?></h2>

                <div class="table-responsive">
                    <table class="table align-middle pxp-candidate-dashboard-language-list">
                        <tbody>
                            <?php 
                            $language_list = array();

                            if ($language != '') {
                                $language_data = json_decode(urldecode($language));

                                if (isset($language_data)) {
                                    $language_list = $language_data->languages;
                                }
                            }
                            if (count($language_list) > 0) {
                                foreach ($language_list as $language_item) { ?>
                                    <tr>
                                        <td style="width: 30%;">
                                            <div class="pxp-candidate-dashboard-language-cell-title">
                                                <?php echo esc_html($language_item->title); ?>
                                            </div>
                                        </td>
                                        
                                        
                                        <td>
                                            <div class="pxp-dashboard-table-options">
                                                <ul 
                                                    class="list-unstyled" 
                                                    data-title="<?php echo esc_attr($language_item->title); ?>" 
                                                    
                                                >
                                                    <li>
                                                        <button 
                                                            class="pxp-candidate-dashboard-edit-language-btn" 
                                                            title="<?php esc_attr_e('Edit', 'jobster'); ?>"
                                                        >
                                                            <span class="fa fa-pencil"></span>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button 
                                                            class="pxp-candidate-dashboard-delete-language-btn" 
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
                    id="pxp-candidate-dashboard-language" 
                    name="pxp-candidate-dashboard-language" 
                    value="<?php echo esc_attr($language); ?>"
                >
                <div class="pxp-candidate-dashboard-language-form mt-3 mt-lg-4 d-none">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-language-title" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Language', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-language-title" 
                                    class="form-control pxp-is-required" 
                                    placeholder="<?php esc_attr_e('E.g. Dutch,English', 'jobster'); ?>"
                                >
                            </div>
                        </div>
                      
                       
                    </div>
    
                    

                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-subsection-cta pxp-candidate-dashboard-ok-language-btn"
                    >
                        <?php esc_html_e('Add', 'jobster'); ?>
                    </a>
                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-subsection-cta-o ms-e pxp-candidate-dashboard-cancel-language-btn"
                    >
                        <?php esc_html_e('Cancel', 'jobster'); ?>
                    </a>
                </div>

                <div class="pxp-candidate-dashboard-edit-language-form">
                </div>

                <a 
                    href="javascript:void(0);" 
                    class="btn mt-3 mt-lg-4 rounded-pill pxp-subsection-cta pxp-candidate-dashboard-add-language-btn"
                >
                    <?php esc_html_e('Add Language', 'jobster'); ?>
                </a>
            </div>

            
            <div class="mt-4 mt-lg-5">
                <h2><?php esc_html_e('Family and Dependencies', 'jobster'); ?></h2>

                <div class="table-responsive">
                    <table class="table align-middle pxp-candidate-dashboard-family-list">
                        <tbody>
                            <?php 
                            $family_list = array();

                            if ($family != '') {
                                $family_data = json_decode(urldecode($family));

                                if (isset($family_data)) {
                                    $family_list = $family_data->familys;
                                }
                            }
                            if (count($family_list) > 0) {
                                foreach ($family_list as $family_item) { ?>
                                    <tr>
                                        <td style="width: 30%;">
                                            <div class="pxp-candidate-dashboard-family-cell-title">
                                                <?php echo esc_html($family_item->title); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-candidate-dashboard-family-cell-relation">
                                                <?php echo esc_html($family_item->relation); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-candidate-dashboard-family-cell-time">
                                                <?php echo esc_html($family_item->age); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pxp-dashboard-table-options">
                                                <ul 
                                                    class="list-unstyled" 
                                                    data-title="<?php echo esc_attr($family_item->title); ?>" 
                                                    data-relation="<?php echo esc_attr($family_item->relation); ?>" 
                                                    data-age="<?php echo esc_attr($family_item->age); ?>" 
                                                    
                                                >
                                                    <li>
                                                        <button 
                                                            class="pxp-candidate-dashboard-edit-family-btn" 
                                                            title="<?php esc_attr_e('Edit', 'jobster'); ?>"
                                                        >
                                                            <span class="fa fa-pencil"></span>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button 
                                                            class="pxp-candidate-dashboard-delete-family-btn" 
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
                    id="pxp-candidate-dashboard-family" 
                    name="pxp-candidate-dashboard-family" 
                    value="<?php echo esc_attr($family); ?>"
                >
                <div class="pxp-candidate-dashboard-family-form mt-3 mt-lg-4 d-none">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-family-title" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Name', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-family-title" 
                                    class="form-control pxp-is-required" 
                                    placeholder="<?php esc_attr_e('E.g. Jhone Snow', 'jobster'); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-family-relation" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Realation', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-family-relation" 
                                    class="form-control pxp-is-required" 
                                    placeholder="<?php esc_attr_e('Relationship', 'jobster'); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-family-time" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Age', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-family-time" 
                                    class="form-control pxp-is-required" 
                                    placeholder="13 Years"
                                >
                            </div>
                        </div>
                    </div>
    
                    

                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-subsection-cta pxp-candidate-dashboard-ok-family-btn"
                    >
                        <?php esc_html_e('Add', 'jobster'); ?>
                    </a>
                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-subsection-cta-o ms-e pxp-candidate-dashboard-cancel-family-btn"
                    >
                        <?php esc_html_e('Cancel', 'jobster'); ?>
                    </a>
                </div>

                <div class="pxp-candidate-dashboard-edit-family-form">
                </div>

                <a 
                    href="javascript:void(0);" 
                    class="btn mt-3 mt-lg-4 rounded-pill pxp-subsection-cta pxp-candidate-dashboard-add-family-btn"
                >
                    <?php esc_html_e('Add Family Details', 'jobster'); ?>
                </a>
            </div>
                <div class="col-xxl-4">
                    <div class="form-label">&nbsp;</div>
                    <div class="position-relative mb-3" style="display: none;">
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
                    <div class="position-relative mb-3" style="display: none;">
                        <div id="pxp-upload-container-logo">
                            <div class="pxp-dashboard-logo">
                                <?php if (is_array($photo)) { ?>
                                    <div 
                                        class="pxp-dashboard-logo-photo pxp-cover has-animation pxp-no-border" 
                                        style="background-image: url(<?php echo esc_url($photo[0]); ?>);" 
                                        data-id="<?php echo esc_attr($photo_val); ?>"
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
                                <?php if (!is_array($photo)) {
                                    esc_html_e('Upload Photo', 'jobster');
                                } ?>
                            </a>
                            <input 
                                type="hidden" 
                                name="pxp-dashboard-logo" 
                                id="pxp-dashboard-logo" 
                                value="<?php echo esc_attr($photo_val); ?>"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="pxp-is-tinymce">
                <label class="form-label">
                    <?php esc_html_e('About', 'jobster'); ?>
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
                wp_editor($about, 'pxp-candidate-profile-about', $about_settings); ?>
            </div>

            <div class="row">
                <div class="col-md-6 col-xxl-3">
                    <div class="mb-3">
                        <?php $industry_tax = array( 
                            'candidate_industry'
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
                            for="pxp-candidate-profile-industry" 
                            class="form-label"
                        >
                        Current Industry
                            <span class="text-danger">*</span>
                        </label>
                        <select 
                            id="pxp-candidate-profile-industry" 
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
                            'candidate_location'
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
                            for="pxp-candidate-profile-location" 
                            class="form-label"
                        >
                            <?php esc_html_e('Location', 'jobster'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <select 
                            id="pxp-candidate-profile-location" 
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
            </div>

            <div class="mt-4 mt-lg-5">
                <h2>Brands and Experts</h2>
                <div class="pxp-candidate-dashboard-brands mb-3">
                    <ul class="list-unstyled">
                        <?php if ($brands) { 
                            foreach ($brands as $brand) { ?>
                                <li data-id="<?php echo esc_attr($brand->term_id); ?>">
                                    <?php echo esc_html($brand->name); ?>
                                    <span class="fa fa-trash-o"></span>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
                <div class="input-group mb-3">
                    <input 
                        type="text" 
                        class="form-control" 
                        id="pxp-candidate-profile-brands" 
                        placeholder="<?php esc_html_e('Brands and Experts', 'jobster'); ?>"
                    >
                    <a 
                        href="javascript:void(0);" 
                        role="button" 
                        class="btn pxp-candidate-dashboard-add-brands-btn"
                    >
                        <?php esc_html_e('Add', 'jobster'); ?>
                    </a>
                </div>
            </div>
            <div class="mt-4 mt-lg-5">
                <h2>Skills</h2>
                <div class="pxp-candidate-dashboard-skills mb-3">
                    <ul class="list-unstyled">
                        <?php if ($skills) { 
                            foreach ($skills as $skill) { ?>
                                <li data-id="<?php echo esc_attr($skill->term_id); ?>">
                                    <?php echo esc_html($skill->name); ?>
                                    <span class="fa fa-trash-o"></span>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
                <div class="input-group mb-3">
                    <input 
                        type="text" 
                        class="form-control" 
                        id="pxp-candidate-profile-skills" 
                        placeholder="<?php esc_html_e('Skill', 'jobster'); ?>"
                    >
                    <a 
                        href="javascript:void(0);" 
                        role="button" 
                        class="btn pxp-candidate-dashboard-add-skill-btn"
                    >
                        <?php esc_html_e('Add Skill', 'jobster'); ?>
                    </a>
                </div>
            </div>

            <div class="mt-4 mt-lg-5">
                <h2><?php esc_html_e('Work Experience', 'jobster'); ?></h2>

                <div class="table-responsive">
                    <table class="table align-middle pxp-candidate-dashboard-work-list">
                        <tbody>
                            <?php 
                            $work_list = array();

                            if ($work != '') {
                                $work_data = json_decode(urldecode($work));
                                
                                if (isset($work_data)) {
                                    $work_list = $work_data->works;
                                }
                            }
                            if (count($work_list) > 0) {
                                
                                foreach ($work_list as $work_item) { ?>
                                    <tr>
                                        <td style="width: 30%;">
                                            <div class="pxp-candidate-dashboard-work-cell-title">
                                                <?php echo esc_html($work_item->title); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-candidate-dashboard-work-cell-company">
                                                <?php echo esc_html($work_item->company); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-candidate-dashboard-work-cell-time">
                                                <?php echo esc_html($work_item->period); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <td style="width: 25%;">
                                            <div class="pxp-candidate-dashboard-work-cell-start">
                                                <?php echo esc_html($work_item->start); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-candidate-dashboard-work-cell-end">
                                                <?php echo esc_html($work_item->end); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-candidate-dashboard-work-cell-location">
                                                <?php echo esc_html($work_item->location); ?>
                                            </div>
                                        </td>
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="pxp-dashboard-table-options">
                                                <ul 
                                                    class="list-unstyled" 
                                                    data-title="<?php echo esc_attr($work_item->title); ?>" 
                                                    data-company="<?php echo esc_attr($work_item->company); ?>" 
                                                    data-period="<?php echo esc_attr($work_item->period); ?>" 
                                                    data-start="<?php echo esc_attr($work_item->start); ?>" 
                                                    data-end="<?php echo esc_attr($work_item->end); ?>" 
                                                    data-location="<?php echo esc_attr($work_item->location); ?>"
                                                    data-description="<?php echo esc_attr($work_item->description); ?>"
                                                >
                                                    <li>
                                                        <button 
                                                            class="pxp-candidate-dashboard-edit-work-btn" 
                                                            title="<?php esc_attr_e('Edit', 'jobster'); ?>"
                                                        >
                                                            <span class="fa fa-pencil"></span>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button 
                                                            class="pxp-candidate-dashboard-delete-work-btn" 
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
                    id="pxp-candidate-dashboard-work" 
                    name="pxp-candidate-dashboard-work" 
                    value="<?php echo esc_attr($work); ?>"
                >
                <div class="pxp-candidate-dashboard-work-form mt-3 mt-lg-4 d-none">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-work-title" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Job title', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-work-title" 
                                    class="form-control pxp-is-required" 
                                    placeholder="<?php esc_attr_e('E.g. Web Designer', 'jobster'); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-work-company" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Company', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-work-company" 
                                    class="form-control pxp-is-required" 
                                    placeholder="<?php esc_attr_e('Company name', 'jobster'); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-work-time" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Time periode', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-work-time" 
                                    class="form-control pxp-is-required" 
                                    placeholder="E.g. 5Y and 3M"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-work-start" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Start date', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    id="pxp-candidate-dashboard-work-start" 
                                    class="form-control pxp-is-required" 
                                    
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-work-end" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('End date', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    id="pxp-candidate-dashboard-work-end" 
                                    class="form-control pxp-is-required" 
                                   
                                >
                            </div>
                        </div>
                        <!-- New location sect -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-work-location" 
                                    class="form-label"
                                >
                                    Location
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-work-location" 
                                    class="form-control pxp-is-required" 
                                    placeholder="Work Location"
                                >
                            </div>
                        </div>
                        
                    </div>
                    <div class="mb-3">
                        <label 
                            for="pxp-candidate-dashboard-work-about" 
                            class="form-label"
                        >
                            <?php esc_html_e('Description', 'jobster'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            class="form-control pxp-smaller pxp-is-required" 
                            id="pxp-candidate-dashboard-work-about" 
                            placeholder="<?php esc_attr_e('Type a short description...', 'jobster'); ?>"
                        ></textarea>
                    </div>

                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-subsection-cta pxp-candidate-dashboard-ok-work-btn"
                    >
                        <?php esc_html_e('Add', 'jobster'); ?>
                    </a>
                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-subsection-cta-o ms-e pxp-candidate-dashboard-cancel-work-btn"
                    >
                        <?php esc_html_e('Cancel', 'jobster'); ?>
                    </a>
                </div>

                <div class="pxp-candidate-dashboard-edit-work-form">
                </div>

                <a 
                    href="javascript:void(0);" 
                    class="btn mt-3 mt-lg-4 rounded-pill pxp-subsection-cta pxp-candidate-dashboard-add-work-btn"
                >
                    <?php esc_html_e('Add Experience', 'jobster'); ?>
                </a>
            </div>

            <div class="mt-4 mt-lg-5">
                <h2><?php esc_html_e('Education & Training', 'jobster'); ?></h2>

                <div class="table-responsive">
                    <table class="table align-middle pxp-candidate-dashboard-edu-list">
                        <tbody>
                            <?php 
                            $edu_list = array();

                            if ($education != '') {
                                $edu_data = json_decode(urldecode($education));

                                if (isset($edu_data)) {
                                    $edu_list = $edu_data->edus;
                                }
                            }
                            if (count($edu_list) > 0) {
                                foreach ($edu_list as $edu_item) { ?>
                                    <tr>
                                        <td style="width: 30%;">
                                            <div class="pxp-candidate-dashboard-edu-cell-title">
                                                <?php echo esc_html($edu_item->title); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-candidate-dashboard-edu-cell-school">
                                                <?php echo esc_html($edu_item->school); ?>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="pxp-candidate-dashboard-edu-cell-time">
                                                <?php echo esc_html($edu_item->period); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="pxp-dashboard-table-options">
                                                <ul 
                                                    class="list-unstyled" 
                                                    data-title="<?php echo esc_attr($edu_item->title); ?>" 
                                                    data-school="<?php echo esc_attr($edu_item->school); ?>" 
                                                    data-period="<?php echo esc_attr($edu_item->period); ?>" 
                                                    data-description="<?php echo esc_attr($edu_item->description); ?>"
                                                >
                                                    <li>
                                                        <button 
                                                            class="pxp-candidate-dashboard-edit-edu-btn" 
                                                            title="<?php esc_attr_e('Edit', 'jobster'); ?>"
                                                        >
                                                            <span class="fa fa-pencil"></span>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button 
                                                            class="pxp-candidate-dashboard-delete-edu-btn" 
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
                    id="pxp-candidate-dashboard-edu" 
                    name="pxp-candidate-dashboard-edu" 
                    value="<?php echo esc_attr($education); ?>"
                >
                <div class="pxp-candidate-dashboard-edu-form mt-3 mt-lg-4 d-none">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-edu-title" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Specialization/Course of study', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-edu-title" 
                                    class="form-control pxp-is-required" 
                                    placeholder="<?php esc_attr_e('E.g. Architecure', 'jobster'); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-edu-school" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Institution', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-edu-school" 
                                    class="form-control pxp-is-required" 
                                    placeholder="<?php esc_attr_e('Institution name', 'jobster'); ?>"
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label 
                                    for="pxp-candidate-dashboard-edu-time" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Time period', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pxp-candidate-dashboard-edu-time" 
                                    class="form-control pxp-is-required" 
                                    placeholder="2 years"
                                >
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <label 
                            for="pxp-candidate-dashboard-edu-about" 
                            class="form-label"
                        >
                            <?php esc_html_e('Description', 'jobster'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            class="form-control pxp-smaller pxp-is-required" 
                            id="pxp-candidate-dashboard-edu-about" 
                            placeholder="<?php esc_attr_e('Type a short description...', 'jobster'); ?>"
                        ></textarea>
                    </div>

                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-subsection-cta pxp-candidate-dashboard-ok-edu-btn"
                    >
                        <?php esc_html_e('Add', 'jobster'); ?>
                    </a>
                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-subsection-cta-o ms-e pxp-candidate-dashboard-cancel-edu-btn"
                    >
                        <?php esc_html_e('Cancel', 'jobster'); ?>
                    </a>
                </div>

                <div class="pxp-candidate-dashboard-edit-edu-form">
                </div>

                <a 
                    href="javascript:void(0);" 
                    class="btn mt-3 mt-lg-4 rounded-pill pxp-subsection-cta pxp-candidate-dashboard-add-edu-btn"
                >
                    <?php esc_html_e('Add Education', 'jobster'); ?>
                </a>
            </div>

            <div class="mt-4 mt-lg-5">
                <h2><?php esc_html_e('Social Media', 'jobster'); ?></h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label 
                                for="pxp-candidate-profile-facebook" 
                                class="form-label"
                            >
                                <?php esc_html_e('Facebook', 'jobster'); ?>
                            </label>
                            <input 
                                type="url" 
                                id="pxp-candidate-profile-facebook" 
                                class="form-control" 
                                placeholder="https://" 
                                value="<?php echo esc_attr($candidate_facebook); ?>"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label 
                                for="pxp-candidate-profile-twitter" 
                                class="form-label"
                            >
                                <?php esc_html_e('Twitter', 'jobster'); ?>
                            </label>
                            <input 
                                type="url" 
                                id="pxp-candidate-profile-twitter" 
                                class="form-control" 
                                placeholder="https://" 
                                value="<?php echo esc_attr($candidate_twitter); ?>"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label 
                                for="pxp-candidate-profile-instagram" 
                                class="form-label"
                            >
                                <?php esc_html_e('Instagram', 'jobster'); ?>
                            </label>
                            <input 
                                type="url" 
                                id="pxp-candidate-profile-instagram" 
                                class="form-control" 
                                placeholder="https://" 
                                value="<?php echo esc_attr($candidate_instagram); ?>"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label 
                                for="pxp-candidate-profile-linkedin" 
                                class="form-label"
                            >
                                <?php esc_html_e('Linkedin', 'jobster'); ?>
                            </label>
                            <input 
                                type="url" 
                                id="pxp-candidate-profile-linkedin" 
                                class="form-control" 
                                placeholder="https://" 
                                value="<?php echo esc_attr($candidate_linkedin); ?>"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 mt-lg-5">
                <h2>
                    Attachment
                </h2>

                <div 
                    id="pxp-upload-container-cv" 
                    class="<?php echo esc_attr($cv_class); ?>"
                >
                    <div class="pxp-candidate-dashboard-cv-icon">
                        <span class="fa fa-file-pdf-o"></span>
                    </div>
                    <div class="pxp-dashboard-cv w-100">
                        <?php if (!empty($cv)) { ?>
                            <div 
                                class="pxp-dashboard-cv-file" 
                                data-id="<?php echo esc_attr($cv_val); ?>"
                            >
                                <?php echo esc_html($cv_filename); ?>
                            </div>
                        <?php } else { ?>
                            <div 
                                class="pxp-dashboard-cv-file" 
                                data-id=""
                            >
                                <?php esc_html_e('No PDF uploaded.'); ?>
                            </div>
                        <?php } ?>
                        <div class="pxp-dashboard-upload-cv-status"></div>
                    </div>
                    <a 
                        role="button" 
                        id="pxp-uploader-cv" 
                        class="btn rounded-pill pxp-subsection-cta pxp-dashboard-upload-cv-btn"
                    >
                        <?php esc_html_e('Upload Passport Copy', 'jobster'); ?>
                    </a>
                    <input 
                        type="hidden" 
                        name="pxp-dashboard-cv" 
                        id="pxp-dashboard-cv" 
                        value="<?php echo esc_attr($cv_val); ?>"
                    >
                    <div class="pxp-candidate-dashboard-cv-options">
                        <ul class="list-unstyled">
                            <li>
                                <a 
                                    href="<?php echo esc_url($cv); ?>" 
                                    target="_blank" 
                                    class="pxp-candidate-dashboard-download-cv-btn" 
                                    title="<?php esc_html_e('Download', 'jobster'); ?>"
                                >
                                    <span class="fa fa-download"></span>
                                </a>
                            </li>
                            <li>
                                <button 
                                    class="pxp-candidate-dashboard-delete-cv-btn" 
                                    title="<?php esc_html_e('Delete', 'jobster'); ?>"
                                >
                                    <span class="fa fa-trash-o"></span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-4 mt-lg-5">
                <div class="pxp-candidate-profile-response"></div>
                <a 
                    href="javascript:void(0);" 
                    class="btn rounded-pill pxp-submit-btn pxp-candidate-profile-update-btn"
                >
                    <span class="pxp-candidate-profile-update-btn-text">
                        <?php esc_html_e('Update Profile', 'jobster'); ?>
                    </span>
                    <span class="pxp-candidate-profile-update-btn-loading pxp-btn-loading">
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