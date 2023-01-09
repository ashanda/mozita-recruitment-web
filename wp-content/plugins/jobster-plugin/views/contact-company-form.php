<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_get_company_contact_form')):
    function jobster_get_company_contact_form($user_id, $candidate_id, $company_id) { 
        $candidate_name = get_the_title($candidate_id);
        $candidate_email = get_post_meta($candidate_id, 'candidate_email', true);
        $company_email = get_post_meta($company_id, 'company_email', true); ?>

        <h3><?php esc_html_e('Contact Company', 'jobster'); ?></h3>
        <form class="mt-4">
            <div class="mb-4 pxp-single-company-contact-response"></div>
            <input 
                type="hidden" 
                id="pxp-single-company-contact-user-id" 
                value="<?php echo esc_attr($user_id); ?>"
            >
            <input 
                type="hidden" 
                id="pxp-single-company-contact-company-id" 
                value="<?php echo esc_attr($company_id); ?>"
            >
            <input 
                type="hidden" 
                id="pxp-single-company-contact-candidate-id" 
                value="<?php echo esc_attr($candidate_id); ?>"
            >
            <input 
                type="hidden" 
                id="pxp-single-company-contact-company-email" 
                value="<?php echo esc_attr($company_email); ?>"
            >
            <div class="mb-3">
                <label 
                    for="pxp-single-company-contact-name" 
                    class="form-label"
                >
                    <?php esc_html_e('Name', 'jobster'); ?>
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="pxp-single-company-contact-name" 
                    placeholder="<?php esc_attr_e('Enter your name', 'jobster'); ?>" 
                    value="<?php echo esc_attr($candidate_name); ?>" 
                    disabled
                >
            </div>
            <div class="mb-3">
                <label 
                    for="pxp-single-company-contact-email" 
                    class="form-label"
                >
                    <?php esc_html_e('Email', 'jobster'); ?>
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="pxp-single-company-contact-email" 
                    placeholder="<?php esc_attr_e('Enter your email address', 'jobster'); ?>" 
                    value="<?php echo esc_attr($candidate_email); ?>" 
                    disabled
                >
            </div>
            <div class="mb-3">
                <label 
                    for="pxp-single-company-contact-message" 
                    class="form-label"
                >
                    <?php esc_html_e('Message', 'jobster'); ?>
                </label>
                <textarea 
                    class="form-control" 
                    id="pxp-single-company-contact-message" 
                    placeholder="<?php esc_attr_e('Type your message here...', 'jobster'); ?>"
                ></textarea>
            </div>

            <?php wp_nonce_field(
                'contact_company_ajax_nonce',
                'pxp-single-company-contact-security',
                true
            ); ?>
            <a 
                href="javascript:void(0);" 
                class="btn rounded-pill d-block pxp-single-company-contact-btn"
            >
                <span class="pxp-single-company-contact-btn-text">
                    <?php esc_html_e('Send Message', 'jobster'); ?>
                </span>
                <span class="pxp-single-company-contact-btn-loading pxp-btn-loading">
                    <img 
                        src="<?php echo esc_url(JOBSTER_LOCATION . '/images/loader-light.svg'); ?>" 
                        class="pxp-btn-loader" 
                        alt="..."
                    >
                </span>
            </a>
        </form>
    <?php }
endif;