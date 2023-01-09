<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

while (have_posts()) : the_post();
    $company_id = get_the_ID();

    $cover_val = get_post_meta($company_id, 'company_cover', true);
    $cover = wp_get_attachment_image_src($cover_val, 'pxp-full');

    $logo_val = get_post_meta($company_id, 'company_logo', true);
    $logo = wp_get_attachment_image_src($logo_val, 'pxp-thmb');

    $name = get_the_title($company_id);
    $location = wp_get_post_terms($company_id, 'company_location');

    $is_candidate = false;
    if (is_user_logged_in()) {
        global $current_user;

        $current_user = wp_get_current_user();
        $is_candidate = function_exists('jobster_user_is_candidate')
                        ? jobster_user_is_candidate($current_user->ID)
                        : false;
    } ?>

    <section>
        <div class="pxp-container">
            <div class="pxp-single-company-container">
                <div class="row justify-content-center">
                    <div class="col-xl-9">
                        <?php if (is_array($cover)) { ?>
                            <div 
                                class="pxp-single-company-hero pxp-cover pxp-boxed" 
                                style="background-image: url(<?php echo esc_url($cover[0]); ?>);"
                            >
                                <div class="pxp-hero-opacity"></div>
                        <?php } else { ?>
                            <div class="pxp-single-company-hero pxp-no-cover pxp-boxed mt-4">
                        <?php } ?>
                            <div class="pxp-single-company-hero-caption">
                                <div class="pxp-single-company-hero-content d-block text-center">
                                    <?php if (is_array($logo)) { ?>
                                        <div 
                                            class="pxp-single-company-hero-logo d-inline-block" 
                                            style="background-image: url(<?php echo esc_url($logo[0]); ?>);"
                                        ></div>
                                    <?php } else { ?>
                                        <div class="pxp-single-company-hero-logo pxp-no-img">
                                            <?php echo esc_html($name[0]); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="pxp-single-company-hero-title ms-0 mt-3">
                                        <h1><?php echo esc_html($name); ?></h1>
                                        <?php if ($location) { ?>
                                            <div class="pxp-single-company-hero-location">
                                                <span class="fa fa-globe"></span><?php echo esc_html($location[0]->name); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 mt-lg-5">
                            <div class="col-lg-7 col-xxl-8">
                                <div class="pxp-single-company-content">
                                    <h2><?php esc_html_e('About', 'jobster'); ?> <?php the_title(); ?></h2>
                                    <div>
                                        <?php the_content(); ?>
                                    </div>
                                </div>

                                <div class="mt-4 mt-lg-5">
                                    <h2 class="pxp-subsection-h2">
                                        <?php esc_html_e('Available Jobs', 'jobster'); ?>
                                    </h2>
                                    <p class="pxp-text-light">
                                        <?php printf(
                                            __('Jobs posted by %s', 'jobster'),
                                            get_the_title($company_id)
                                        ); ?>
                                    </p>

                                    <?php if (function_exists('jobster_get_company_jobs')) {
                                        jobster_get_company_jobs(true);
                                    } ?>
                                </div>
                            </div>

                            <div class="col-lg-5 col-xxl-4">
                                <div class="pxp-single-company-side-panel mt-5 mt-lg-0">
                                    <?php $industry = wp_get_post_terms(
                                        $company_id, 'company_industry'
                                    );
                                    if ($industry) { ?>
                                        <div>
                                            <div class="pxp-single-company-side-info-label pxp-text-light">
                                                <?php esc_html_e('Industry', 'jobster'); ?>
                                            </div>
                                            <div class="pxp-single-company-side-info-data">
                                                <?php echo esc_html($industry[0]->name); ?>
                                            </div>
                                        </div>
                                    <?php }

                                    $company_size = get_post_meta(
                                        $company_id, 'company_size', true
                                    );
                                    if (!empty($company_size)) { ?>
                                        <div class="mt-4">
                                            <div class="pxp-single-company-side-info-label pxp-text-light">
                                                <?php esc_html_e('Company size', 'jobster'); ?>
                                            </div>
                                            <div class="pxp-single-company-side-info-data">
                                                <?php printf(
                                                    __('%s employees', 'jobster'),
                                                    esc_html($company_size)) 
                                                ?>
                                            </div>
                                        </div>
                                    <?php }

                                    $founded = get_post_meta(
                                        $company_id, 'company_founded', true
                                    );
                                    if (!empty($founded)) { ?>
                                        <div class="mt-4">
                                            <div class="pxp-single-company-side-info-label pxp-text-light">
                                                <?php esc_html_e('Founded in', 'jobster'); ?>
                                            </div>
                                            <div class="pxp-single-company-side-info-data">
                                                <?php echo esc_html($founded); ?>
                                            </div>
                                        </div>
                                    <?php }

                                    $phone = get_post_meta(
                                        $company_id, 'company_phone', true
                                    );
                                    if (!empty($phone)) {
                                        $phone_short = substr_replace(
                                            $phone, '****', -4
                                        ); ?>
                                        <div class="mt-4">
                                            <div class="pxp-single-company-side-info-label pxp-text-light">
                                                <?php esc_html_e('Phone', 'jobster'); ?>
                                            </div>
                                            <div class="pxp-single-company-side-info-data">
                                                <div class="pxp-single-company-side-info-phone">
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

                                    $email = get_post_meta(
                                        $company_id, 'company_email', true
                                    );
                                    if (!empty($email)) { ?>
                                        <div class="mt-4">
                                            <div class="pxp-single-company-side-info-label pxp-text-light">
                                                <?php esc_html_e('Email', 'jobster'); ?>
                                            </div>
                                            <div class="pxp-single-company-side-info-data">
                                                <a href="mailto:<?php echo esc_attr($email); ?>">
                                                    <?php echo esc_html($email); ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php }

                                    if ($location) { ?>
                                        <div class="mt-4">
                                            <div class="pxp-single-company-side-info-label pxp-text-light">
                                                <?php esc_html_e('Location', 'jobster'); ?>
                                            </div>
                                            <div class="pxp-single-company-side-info-data">
                                                <?php echo esc_html($location[0]->name); ?>
                                            </div>
                                        </div>
                                    <?php }

                                    $website = get_post_meta(
                                        $company_id, 'company_website', true
                                    );
                                    if (!empty($website)) { ?>
                                        <div class="mt-4">
                                            <div class="pxp-single-company-side-info-label pxp-text-light">
                                                <?php esc_html_e('Website', 'jobster'); ?>
                                            </div>
                                            <div class="pxp-single-company-side-info-data">
                                                <a href="<?php echo esc_url($website); ?>">
                                                    <?php echo esc_url($website); ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php }

                                    $facebook = get_post_meta(
                                        $company_id, 'company_facebook', true
                                    );
                                    $twitter = get_post_meta(
                                        $company_id, 'company_twitter', true
                                    );
                                    $instagram = get_post_meta(
                                        $company_id, 'company_instagram', true
                                    );
                                    $linkedin = get_post_meta(
                                        $company_id, 'company_linkedin', true
                                    );

                                    if (!empty($facebook)
                                        || !empty($twitter)
                                        || !empty($instagram)
                                        || !empty($linkedin)) { ?>
                                        <div class="mt-4">
                                            <div class="pxp-single-company-side-info-data">
                                                <ul class="list-unstyled pxp-single-company-side-info-social">
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
                                    <?php } ?>
                                </div>

                                <?php if ($is_candidate) {
                                    $candidate_id = jobster_get_candidate_by_userid($current_user->ID);

                                    if (function_exists('jobster_get_company_contact_form')) { ?>
                                        <div class="pxp-single-company-side-panel mt-4 mt-lg-5">
                                            <?php jobster_get_company_contact_form(
                                                $current_user->ID,
                                                $candidate_id,
                                                $company_id
                                            ); ?>
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endwhile;
?>