<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

while (have_posts()) : the_post();
    $candidate_id = get_the_ID();

    $cover_val = get_post_meta($candidate_id, 'candidate_cover', true);
    $cover = wp_get_attachment_image_src($cover_val, 'pxp-full');

    $photo_val = get_post_meta($candidate_id, 'candidate_photo', true);
    $photo = wp_get_attachment_image_src($photo_val, 'pxp-thmb');

    $name = get_the_title($candidate_id);
    $title = get_post_meta($candidate_id, 'candidate_title', true);

    $is_company = false;
    if (is_user_logged_in()) {
        global $current_user;

        $current_user = wp_get_current_user();
        $is_company = function_exists('jobster_user_is_company')
                        ? jobster_user_is_company($current_user->ID)
                        : false;

        if ($is_company) {
            $company_id = jobster_get_company_by_userid($current_user->ID);
            $visitors = get_post_meta($candidate_id, 'candidate_visitors', true);

            if (!is_array($visitors)) {
                $visitors = array();
            }

            if (!array_key_exists($company_id, $visitors)) {
                $visitors[$company_id] = current_time('mysql');

                update_post_meta($candidate_id, 'candidate_visitors', $visitors);

                $notifications = get_post_meta(
                    $candidate_id,
                    'candidate_notifications',
                    true
                );
    
                if (empty($notifications)) {
                    $notifications = array();
                }

                array_push(
                    $notifications,
                    array(
                        'type'       => 'visit',
                        'company_id' => $company_id,
                        'read'       => false,
                        'date'       => current_time('mysql')
                    )
                );
    
                update_post_meta(
                    $candidate_id,
                    'candidate_notifications',
                    $notifications
                );
            }
        }
    }

    $candidates_settings = get_option('jobster_candidates_settings');
    $restrict_profile = isset($candidates_settings['jobster_candidate_restrict_profile_field']) 
                        ? $candidates_settings['jobster_candidate_restrict_profile_field'] 
                        : '';
    $restrict_contact = isset($candidates_settings['jobster_candidate_restrict_contact_field']) 
                        ? $candidates_settings['jobster_candidate_restrict_contact_field'] 
                        : ''; 
    $restrict_resume =  isset($candidates_settings['jobster_candidate_restrict_resume_field']) 
                        ? $candidates_settings['jobster_candidate_restrict_resume_field'] 
                        : '';
    $show_profile = true;
    $show_contact = true;
    $show_resume = true;
    if ($restrict_profile == '1' && !$is_company) {
        $show_profile = false;
    }
    if ($restrict_contact == '1' && !$is_company) {
        $show_contact = false;
    }
    if ($restrict_resume == '1' && !$is_company) {
        $show_resume = false;
    } ?>

    <section>
        <div class="pxp-container">
            <div class="pxp-single-candidate-container">
                <div class="row justify-content-center">
                    <div class="col-xl-9">
                        <?php if (is_array($cover)) { ?>
                            <div 
                                class="pxp-single-candidate-hero pxp-cover pxp-boxed" 
                                style="background-image: url(<?php echo esc_url($cover[0]); ?>);"
                            >
                                <div class="pxp-hero-opacity"></div>
                        <?php } else { ?>
                            <div class="pxp-single-candidate-hero pxp-no-cover pxp-boxed mt-4">
                        <?php } ?>
                            <div class="pxp-single-candidate-hero-caption">
                                <div class="pxp-single-candidate-hero-content d-block text-center">
                                    <?php if (is_array($photo)) { ?>
                                        <div 
                                            class="pxp-single-candidate-hero-avatar d-inline-block" 
                                            style="background-image: url(<?php echo esc_url($photo[0]); ?>);"
                                        ></div>
                                    <?php } else { ?>
                                        <div class="pxp-single-candidate-hero-avatar pxp-no-img">
                                            <?php echo esc_html($name[0]); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="pxp-single-candidate-hero-name ms-0 mt-3">
                                        <h1><?php echo esc_html($name); ?></h1>
                                        <?php if ($title) { ?>
                                            <div class="pxp-single-candidate-hero-title">
                                                <?php echo esc_html($title); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 mt-lg-5">
                            <?php if ($show_profile === true) { ?>
                                <div class="col-lg-7 col-xxl-8">
                                    <div class="pxp-single-candidate-content">
                                        <?php $candidate_firstname = trim(
                                            strstr(
                                                get_the_title($candidate_id), ' ', true
                                            )
                                        ); ?>
                                        <h2>
                                            <?php printf(
                                                __('About %s', 'jobster'),
                                                esc_html($candidate_firstname)
                                            ); ?>
                                        </h2>
                                        <div>
                                            <?php the_content(); ?>
                                        </div>

                                        <?php $skills = wp_get_post_terms(
                                            $candidate_id,
                                            'candidate_skill'
                                        );

                                        if ($skills) { ?>
                                            <div class="mt-4 mt-lg-5">
                                                <h2><?php esc_attr_e('Skills', 'jobster'); ?></h2>
                                                <div class="pxp-single-candidate-skills">
                                                    <ul class="list-unstyled">
                                                        <?php foreach ($skills as $skill) { ?>
                                                            <li>
                                                                <?php echo esc_html($skill->name); ?>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php }

                                        $work = get_post_meta(
                                            $candidate_id,
                                            'candidate_work',
                                            true
                                        );
                                        $work_list = array();

                                        if (!empty($work)) {
                                            $work_data = json_decode(urldecode($work));

                                            if (isset($work_data)) {
                                                $work_list = $work_data->works;
                                            }
                                        }

                                        if (count($work_list) > 0) { ?>
                                            <div class="mt-4 mt-lg-5">
                                                <h2>
                                                    <?php esc_attr_e('Work Experience', 'jobster'); ?>
                                                </h2>
                                                <div class="pxp-single-candidate-timeline">
                                                    <?php foreach ($work_list as $work_item) { ?>
                                                        <div class="pxp-single-candidate-timeline-item">
                                                            <div class="pxp-single-candidate-timeline-dot"></div>
                                                            <div class="pxp-single-candidate-timeline-info ms-3">
                                                                <div class="pxp-single-candidate-timeline-time">
                                                                    <span class="me-3">
                                                                        <?php echo esc_html($work_item->period); ?>
                                                                    </span>
                                                                </div>
                                                                <div class="pxp-single-candidate-timeline-position mt-2">
                                                                    <?php echo esc_html($work_item->title); ?>
                                                                </div>
                                                                <div class="pxp-single-candidate-timeline-company pxp-text-light">
                                                                    <?php echo esc_html($work_item->company); ?>
                                                                </div>
                                                                <div class="pxp-single-candidate-timeline-about mt-2 pb-4">
                                                                    <?php echo esc_html($work_item->description); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php }

                                        $edu = get_post_meta(
                                            $candidate_id,
                                            'candidate_edu',
                                            true
                                        );
                                        $edu_list = array();

                                        if (!empty($edu)) {
                                            $edu_data = json_decode(urldecode($edu));

                                            if (isset($edu_data)) {
                                                $edu_list = $edu_data->edus;
                                            }
                                        }

                                        if (count($edu_list) > 0) { ?>
                                            <div class="mt-4 mt-lg-5">
                                                <h2>
                                                    <?php esc_attr_e('Education & Training', 'jobster'); ?>
                                                </h2>
                                                <div class="pxp-single-candidate-timeline">
                                                    <?php foreach ($edu_list as $edu_item) { ?>
                                                        <div class="pxp-single-candidate-timeline-item">
                                                            <div class="pxp-single-candidate-timeline-dot"></div>
                                                            <div class="pxp-single-candidate-timeline-info ms-3">
                                                                <div class="pxp-single-candidate-timeline-time">
                                                                    <span class="me-3">
                                                                        <?php echo esc_html($edu_item->period); ?>
                                                                    </span>
                                                                </div>
                                                                <div class="pxp-single-candidate-timeline-position mt-2">
                                                                    <?php echo esc_html($edu_item->title); ?>
                                                                </div>
                                                                <div class="pxp-single-candidate-timeline-company pxp-text-light">
                                                                    <?php echo esc_html($edu_item->school); ?>
                                                                </div>
                                                                <div class="pxp-single-candidate-timeline-about mt-2 pb-4">
                                                                    <?php echo esc_html($edu_item->description); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="col-lg-5 col-xxl-4">
                                    <div class="pxp-single-candidate-side-panel mt-5 mt-lg-0">
                                        <?php if ($show_contact === true) {
                                            $email = get_post_meta(
                                                $candidate_id, 'candidate_email', true
                                            );
                                            if (!empty($email)) { ?>
                                                <div>
                                                    <div class="pxp-single-candidate-side-info-label pxp-text-light">
                                                        <?php esc_html_e('Email', 'jobster'); ?>
                                                    </div>
                                                    <div class="pxp-single-candidate-side-info-data">
                                                        <a href="mailto:<?php echo esc_attr($email); ?>">
                                                            <?php echo esc_html($email); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php }

                                            $location = wp_get_post_terms(
                                                $candidate_id, 'candidate_location'
                                            );
                                            if ($location) { ?>
                                                <div class="mt-4">
                                                    <div class="pxp-single-candidate-side-info-label pxp-text-light">
                                                        <?php esc_html_e('Location', 'jobster'); ?>
                                                    </div>
                                                    <div class="pxp-single-candidate-side-info-data">
                                                        <?php echo esc_html($location[0]->name); ?>
                                                    </div>
                                                </div>
                                            <?php }

                                            $phone = get_post_meta(
                                                $candidate_id, 'candidate_phone', true
                                            );
                                            if (!empty($phone)) {
                                                $phone_short = substr_replace(
                                                    $phone, '****', -4
                                                ); ?>
                                                <div class="mt-4">
                                                    <div class="pxp-single-candidate-side-info-label pxp-text-light">
                                                        <?php esc_html_e('Phone', 'jobster'); ?>
                                                    </div>
                                                    <div class="pxp-single-candidate-side-info-data">
                                                        <div class="pxp-single-candidate-side-info-phone">
                                                            <a class="d-none"
                                                                href="tel:<?php echo esc_attr($phone); ?>"
                                                            >
                                                                <?php echo esc_html($phone); ?>
                                                            </a>
                                                            <span 
                                                                class="d-flex align-items-center" 
                                                                onclick="this.parentNode.classList.add('pxp-show');"
                                                            >
                                                                <?php echo esc_html($phone_short); ?>
                                                                <span class="btn btn-sm rounded-pill">
                                                                    <?php esc_html_e('Show', 'jobster'); ?>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }

                                            $website = get_post_meta(
                                                $candidate_id, 'candidate_website', true
                                            );
                                            if (!empty($website)) { ?>
                                                <div class="mt-4">
                                                    <div class="pxp-single-candidate-side-info-label pxp-text-light">
                                                        <?php esc_html_e('Website', 'jobster'); ?>
                                                    </div>
                                                    <div class="pxp-single-candidate-side-info-data">
                                                        <a href="<?php echo esc_url($website); ?>">
                                                            <?php echo esc_url($website); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php }

                                            $facebook = get_post_meta(
                                                $candidate_id, 'candidate_facebook', true
                                            );
                                            $twitter = get_post_meta(
                                                $candidate_id, 'candidate_twitter', true
                                            );
                                            $instagram = get_post_meta(
                                                $candidate_id, 'candidate_instagram', true
                                            );
                                            $linkedin = get_post_meta(
                                                $candidate_id, 'candidate_linkedin', true
                                            );

                                            if (!empty($facebook)
                                                || !empty($twitter)
                                                || !empty($instagram)
                                                || !empty($linkedin)) { ?>
                                                <div class="mt-4">
                                                    <div class="pxp-single-candidate-side-info-data">
                                                        <ul class="list-unstyled pxp-single-candidate-side-info-social">
                                                            <?php if (!empty($facebook)) { ?>
                                                                <li>
                                                                    <a href="<?php echo esc_url($facebook); ?>">
                                                                        <span class="fa fa-facebook"></span>
                                                                    </a>
                                                                </li>
                                                            <?php }
                                                            if (!empty($twitter)) { ?>
                                                                <li>
                                                                    <a href="<?php echo esc_url($twitter); ?>">
                                                                        <span class="fa fa-twitter"></span>
                                                                    </a>
                                                                </li>
                                                            <?php }
                                                            if (!empty($instagram)) { ?>
                                                                <li>
                                                                    <a href="<?php echo esc_url($instagram); ?>">
                                                                        <span class="fa fa-instagram"></span>
                                                                    </a>
                                                                </li>
                                                            <?php }
                                                            if (!empty($linkedin)) { ?>
                                                                <li>
                                                                    <a href="<?php echo esc_url($linkedin); ?>">
                                                                        <span class="fa fa-linkedin"></span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <?php }
                                        } else { ?>
                                            <p><i><?php esc_html_e('Restricted contact info. You need company account to have access.', 'jobster') ?></i></p>
                                            <?php if (!is_user_logged_in()) { ?>
                                                <button 
                                                    class="btn pxp-single-job-apply-btn pxp-section-cta rounded-pill" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#pxp-signin-modal"
                                                >
                                                    <?php esc_html_e('Sign In Now', 'jobster'); ?>
                                                </button>
                                            <?php }
                                        }

                                        $show_download_btn = true;
                                        $cv = get_post_meta(
                                            $candidate_id, 'candidate_cv', true
                                        );
                                        $membership_settings = get_option('jobster_membership_settings');
                                        $payment_type = isset($membership_settings['jobster_payment_type_field'])
                                                        ? $membership_settings['jobster_payment_type_field']
                                                        : '';
                                        if ($payment_type == 'plan') {
                                            if ($is_company) {
                                                $company_id = jobster_get_company_by_userid($current_user->ID);
                                                $plan_cv_access = get_post_meta(
                                                    $company_id, 'company_plan_cv_access', true
                                                );
                                                if ($plan_cv_access != 1) {
                                                    $show_download_btn = false;
                                                }
                                            }
                                        } else {
                                            if (!$show_resume) {
                                                $show_download_btn = false;
                                            }
                                        }

                                        if (!empty($cv) && $show_download_btn) {
                                            $cv_url = wp_get_attachment_url($cv); ?>

                                            <div class="mt-4">
                                               
                                                <form>
                                                    <a 
                                                        href="<?php echo esc_url($cv_url); ?>" 
                                                        class="btn rounded-pill d-block"
                                                    >
                                                        <?php echo esc_html_e('Download Resume', 'jobster'); ?>
                                                    </a>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <?php if ($is_company) {
                                        $company_id = jobster_get_company_by_userid($current_user->ID);

                                        if (function_exists('jobster_get_candidate_contact_form')) { ?>
                                            <div class="pxp-single-candidate-side-panel mt-4 mt-lg-5">
                                                <?php jobster_get_candidate_contact_form(
                                                    $current_user->ID,
                                                    $company_id,
                                                    $candidate_id
                                                ); ?>
                                            </div>
                                        <?php }
                                    } ?>
                                </div>
                            <?php } else { ?>
                                <div class="mt-4 mt-lg-5">
                                    <p><i><?php esc_html_e('Restricted content. You need company account to have access.', 'jobster') ?></i></p>
                                    <?php if (!is_user_logged_in()) { ?>
                                        <button 
                                            class="btn pxp-single-job-apply-btn pxp-section-cta rounded-pill" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#pxp-signin-modal"
                                        >
                                            <?php esc_html_e('Sign In Now', 'jobster'); ?>
                                        </button>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endwhile;
?>