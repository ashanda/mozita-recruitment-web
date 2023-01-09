<?php
/*
Template Name: Company Dashboard - Edit Job
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
    $jobs_url = jobster_get_page_link('company-dashboard-jobs.php');

    $job_id =   isset($_GET['id']) 
                ? sanitize_text_field($_GET['id'])
                : '';
    $job = get_post($job_id);

    if ($job) {
        $job_company = get_post_meta($job_id, 'job_company', true);
        $job_status = get_post_status($job_id);

        if ($company_id != $job_company) {
            wp_redirect($jobs_url);
        }
    } else {
        wp_redirect($jobs_url);
    }
} else {
    wp_redirect(home_url());
}

get_header('dashboard', array('bg_color' => 'pxpMainColorLight'));

jobster_get_company_dashboard_side($company_id, 'jobs');

$membership_settings = get_option('jobster_membership_settings', '');
$payment_type  =    isset($membership_settings['jobster_payment_type_field'])
                    ? $membership_settings['jobster_payment_type_field']
                    : '';
$payment_currency = isset($membership_settings['jobster_payment_currency_field'])
                    ? $membership_settings['jobster_payment_currency_field']
                    : '';
$standard_price  =  isset($membership_settings['jobster_submission_price_field'])
                    ? $membership_settings['jobster_submission_price_field']
                    : __('Free', 'jobster');
$featured_price =   isset($membership_settings['jobster_featured_price_field'])
                    ? $membership_settings['jobster_featured_price_field']
                    : __('Free', 'jobster');
$standard_unlim =   isset($membership_settings['jobster_free_submissions_unlim_field'])
                    ? $membership_settings['jobster_free_submissions_unlim_field']
                    : '';
$company_payment = get_post_meta($company_id, 'company_payment', true);
$featured = get_post_meta($job_id, 'job_featured', true); ?>

<div class="pxp-dashboard-content">
    <?php jobster_get_company_dashboard_top($company_id); ?>

    <div class="pxp-dashboard-content-details">
        <div class="pxp-edit-job-statuses">
            <?php if ($job_status == 'publish') { ?>
                <span class="badge rounded-pill bg-success">
                    <?php esc_html_e('Published', 'jobster'); ?>
                </span>
            <?php } else if ($job_status == 'pending') { ?>
                <span class="badge rounded-pill bg-warning">
                    <?php esc_html_e('Pending', 'jobster'); ?>
                </span>
            <?php } else { ?>
                <span class="badge rounded-pill bg-secondary">
                    <?php esc_html_e('Draft', 'jobster'); ?>
                </span>
            <?php }

            if ($payment_type == 'listing') {
                $payment_status = get_post_meta(
                    $job_id,
                    'job_payment_status',
                    true
                );

                if ($payment_status == 'paid') { ?>
                    <span class="badge rounded-pill bg-success">
                        <?php esc_html_e('Paid', 'jobster'); ?>
                    </span>
                <?php } else if (get_post_status($job_id) != 'publish') { ?>
                    <span class="badge rounded-pill bg-danger">
                        <?php esc_html_e('Payment required', 'jobster'); ?>
                    </span>
                <?php }
            } ?>
        </div>
        <h1 class="mt-3">
            <?php esc_html_e('Edit', 'jobster'); ?> <i><?php echo get_the_title($job_id); ?></i>
            <?php if ($featured == '1') { ?>
                <span class="badge rounded-pill pxp-company-dashboard-job-feat-label">
                    <span class="fa fa-star"></span>
            </span>
            <?php } ?>
        </h1>
        <p class="pxp-text-light">
            <?php esc_html_e('Edit the job offer details.', 'jobster'); ?>
        </p>

        <form class="pxp-dashboard-form">
            <input 
                type="hidden" 
                id="pxp-company-edit-job-company-id" 
                value="<?php echo esc_attr($company_id); ?>"
            >
            <input 
                type="hidden" 
                id="pxp-company-edit-job-id" 
                value="<?php echo esc_attr($job_id); ?>"
            >
            <div class="row mt-4 mt-lg-5">
                <div class="col-xxl-8">
                    <div class="mb-3">
                        <?php $title = get_the_title($job_id); ?>
                        <label 
                            for="pxp-company-edit-job-title" 
                            class="form-label"
                        >
                            <?php esc_html_e('Job title', 'jobster'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="pxp-company-edit-job-title" 
                            class="form-control pxp-is-required" 
                            placeholder="<?php esc_html_e('Add job title', 'jobster'); ?>" 
                            value="<?php echo esc_attr($title); ?>"
                            required
                        >
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <?php $category_tax = array( 
                                    'job_category'
                                );
                                $category_args = array(
                                    'orderby'    => 'name',
                                    'order'      => 'ASC',
                                    'hide_empty' => false
                                );
                                $category_terms = get_terms(
                                    $category_tax,
                                    $category_args
                                );
                                $category = wp_get_post_terms(
                                    $job_id, 'job_category'
                                );
                                $category_id =  $category 
                                                ? $category[0]->term_id
                                                : ''; ?>

                                <label 
                                    for="pxp-company-edit-job-category" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Category', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <select 
                                    id="pxp-company-edit-job-category" 
                                    class="form-select pxp-is-required" 
                                >
                                    <option value="0">
                                        <?php esc_html_e('Select category', 'jobster'); ?>
                                    </option>
                                    <?php foreach ($category_terms as $category_term) { ?>
                                        <option 
                                            value="<?php echo esc_attr($category_term->term_id);?>" 
                                            <?php selected($category_id, $category_term->term_id) ?>
                                        >
                                            <?php echo esc_html($category_term->name); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <?php $location_tax = array( 
                                    'job_location'
                                );
                                $location_args = array(
                                    'orderby'    => 'name',
                                    'order'      => 'ASC',
                                    'hide_empty' => false
                                );
                                $location_terms = get_terms(
                                    $location_tax,
                                    $location_args
                                );
                                $location = wp_get_post_terms(
                                    $job_id, 'job_location'
                                );
                                $location_id =  $location 
                                                ? $location[0]->term_id
                                                : ''; ?>

                                <label 
                                    for="pxp-company-edit-job-location" 
                                    class="form-label"
                                >
                                    <?php esc_html_e('Location', 'jobster'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <select 
                                    id="pxp-company-edit-job-location" 
                                    class="form-select pxp-is-required" 
                                >
                                    <option value="0">
                                        <?php esc_html_e('Select location', 'jobster'); ?>
                                    </option>
                                    <?php foreach ($location_terms as $location_term) { ?>
                                        <option 
                                            value="<?php echo esc_attr($location_term->term_id);?>" 
                                            <?php selected($location_id, $location_term->term_id) ?>
                                        > 
                                            <?php echo esc_html($location_term->name); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4">
                    <div class="form-label">&nbsp;</div>
                    <div class="position-relative mb-3">
                        <?php $cover_val = get_post_meta($job_id, 'job_cover', true);
                        $cover = wp_get_attachment_image_src($cover_val,'pxp-gallery'); ?>
                        <div id="pxp-upload-container-cover">
                            <div class="pxp-dashboard-cover">
                                <?php if (is_array($cover)) { ?>
                                    <div 
                                        class="pxp-dashboard-cover-photo pxp-cover has-animation" 
                                        style="background-image:url(<?php echo esc_url($cover[0]); ?>)" 
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
                </div>
            </div>

            <div class="pxp-is-tinymce">
                <label class="form-label">
                    <?php esc_html_e('Job description', 'jobster'); ?>
                </label>
                <?php $description = apply_filters('the_content', $job->post_content);
                $description_settings = array(
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
                wp_editor($description, 'pxp-company-edit-job-description', $description_settings); ?>
            </div>

            <div class="row">
                <div class="col-md-6 col-xxl-3">
                    <div class="mb-3">
                        <?php $type_tax = array( 
                            'job_type'
                        );
                        $type_args = array(
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                            'hide_empty' => false
                        );
                        $type_terms = get_terms(
                            $type_tax,
                            $type_args
                        );
                        $type = wp_get_post_terms(
                            $job_id, 'job_type'
                        );
                        $type_id =  $type
                                    ? $type[0]->term_id
                                    : ''; ?>

                        <label 
                            for="pxp-company-edit-job-type" 
                            class="form-label"
                        >
                            <?php esc_html_e('Type of employment', 'jobster'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <select 
                            id="pxp-company-edit-job-type" 
                            class="form-select pxp-is-required" 
                        >
                            <option value="0">
                                <?php esc_html_e('Select type', 'jobster'); ?>
                            </option>
                            <?php foreach ($type_terms as $type_term) { ?>
                                <option 
                                    value="<?php echo esc_attr($type_term->term_id);?>" 
                                    <?php selected($type_id, $type_term->term_id) ?>
                                >
                                    <?php echo esc_html($type_term->name); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-xxl-3">
                    <div class="mb-3">
                        <?php $level_tax = array( 
                            'job_level'
                        );
                        $level_args = array(
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                            'hide_empty' => false
                        );
                        $level_terms = get_terms(
                            $level_tax,
                            $level_args
                        );
                        $level = wp_get_post_terms(
                            $job_id, 'job_level'
                        );
                        $level_id =  $level
                                    ? $level[0]->term_id
                                    : ''; ?>

                        <label 
                            for="pxp-company-edit-job-level" 
                            class="form-label"
                        >
                            <?php esc_html_e('Experience level', 'jobster'); ?>
                            <span class="text-danger">*</span>
                        </label>
                        <select 
                            id="pxp-company-edit-job-level" 
                            class="form-select pxp-is-required" 
                        >
                            <option value="0">
                                <?php esc_html_e('Select type', 'jobster'); ?>
                            </option>
                            <?php foreach ($level_terms as $level_term) { ?>
                                <option 
                                    value="<?php echo esc_attr($level_term->term_id);?>" 
                                    <?php selected($level_id, $level_term->term_id) ?>
                                >
                                    <?php echo esc_html($level_term->name); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-xxl-3">
                    <div class="mb-3">
                        <?php $experience = get_post_meta(
                            $job_id,
                            'job_experience',
                            true
                        ); ?>
                        <label 
                            for="pxp-company-edit-job-experience" 
                            class="form-label"
                        >
                            <?php esc_html_e('Required experience', 'jobster'); ?>
                        </label>
                        <input 
                            type="text" 
                            id="pxp-company-edit-job-experience" 
                            class="form-control" 
                            placeholder="<?php esc_html_e('E.g. Minimum 1 year', 'jobster'); ?>" 
                            value="<?php echo esc_attr($experience); ?>"
                        >
                    </div>
                </div>
                <div class="col-md-6 col-xxl-3">
                    <div class="mb-3">
                        <?php $salary = get_post_meta(
                            $job_id,
                            'job_salary',
                            true
                        ); ?>
                        <label 
                            for="pxp-company-edit-job-salary" 
                            class="form-label"
                        >
                            <?php esc_html_e('Salary', 'jobster'); ?>
                        </label>
                        <input 
                            type="text" 
                            id="pxp-company-edit-job-salary" 
                            class="form-control" 
                            placeholder="<?php esc_html_e('E.g. $100k / year', 'jobster'); ?>" 
                            value="<?php echo esc_attr($salary); ?>"
                        >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <?php $action = get_post_meta(
                            $job_id,
                            'job_action',
                            true
                        ); ?>
                        <label 
                            for="pxp-company-edit-job-action" 
                            class="form-label"
                        >
                            <?php esc_html_e('Apply Job External URL', 'jobster'); ?>
                        </label>
                        <input 
                            type="text" 
                            id="pxp-company-edit-job-action" 
                            class="form-control" 
                            placeholder="https://" 
                            value="<?php echo esc_attr($action); ?>"
                        >
                    </div>
                </div>
            </div>

            <div class="mt-4 mt-lg-5">
                <div class="pxp-company-edit-job-response"></div>
                <?php wp_nonce_field(
                    'company_edit_job_ajax_nonce',
                    'pxp-company-edit-job-security',
                    true
                );

                $show_publish_btn = false;
                $show_update_btn = false;
                $show_save_btn = false;

                if ($payment_type == 'listing') {
                    $payment_status = get_post_meta(
                        $job_id,
                        'job_payment_status',
                        true
                    );

                    if ($job_status == 'publish') {
                        $show_update_btn = true;
                        $show_save_btn = true;
                    } else if ($job_status == 'pending') {
                        $show_update_btn = true;
                        $show_save_btn = true;
                    } else {
                        if ($payment_status == 'paid') {
                            $show_publish_btn = true;
                            $show_save_btn = true;
                        } else {
                            $show_update_btn = true;
                        }
                    }
                } else {
                    if ($job_status == 'publish') {
                        $show_update_btn = true;
                        $show_save_btn = true;
                    } else {
                        $show_publish_btn = true;
                        $show_save_btn = true;
                    }
                }

                if ($show_publish_btn === true) { ?>
                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-submit-btn pxp-company-edit-job-save-btn"
                    >
                        <span class="pxp-company-edit-job-save-btn-text">
                            <?php esc_html_e('Publish', 'jobster'); ?>
                        </span>
                        <span class="pxp-company-edit-job-save-btn-loading pxp-btn-loading">
                            <img 
                                src="<?php echo esc_url(JOBSTER_LOCATION . '/images/loader-light.svg'); ?>" 
                                class="pxp-btn-loader" 
                                alt="..."
                            >
                        </span>
                    </a>
                <?php }

                if ($show_update_btn === true) { ?>
                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-submit-btn pxp-company-edit-job-save-btn"
                    >
                        <span class="pxp-company-edit-job-save-btn-text">
                            <?php esc_html_e('Update', 'jobster'); ?>
                        </span>
                        <span class="pxp-company-edit-job-save-btn-loading pxp-btn-loading">
                            <img 
                                src="<?php echo esc_url(JOBSTER_LOCATION . '/images/loader-light.svg'); ?>" 
                                class="pxp-btn-loader" 
                                alt="..."
                            >
                        </span>
                    </a>
                <?php }

                if ($show_save_btn === true) { ?>
                    <a 
                        href="javascript:void(0);" 
                        class="btn rounded-pill pxp-submit-btn-o pxp-company-edit-job-save-btn pxp-is-draft ms-3"
                    >
                        <span class="pxp-company-edit-job-save-btn-text">
                            <?php esc_html_e('Save Draft', 'jobster'); ?>
                        </span>
                        <span class="pxp-company-edit-job-save-btn-loading pxp-btn-loading">
                            <img 
                                src="<?php echo esc_url(JOBSTER_LOCATION . '/images/loader-blue.svg'); ?>" 
                                class="pxp-btn-loader" 
                                alt="..."
                            >
                        </span>
                    </a>
                <?php } ?>
            </div>
        </form>
    </div>

    <?php get_footer('dashboard'); ?>
</div>