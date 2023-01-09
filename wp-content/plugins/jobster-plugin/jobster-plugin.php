<?php
/*
* Plugin Name: Jobster Plugin
* Description: Core functionality for Jobster WP Theme.
* Text Domain: jobster
* Domain Path: /languages
* Version: 1.3
* Author: Pixel Prime
* Author URI: http://pixelprime.co
*/

define('JOBSTER_PLUGIN_PATH', plugin_dir_url( __FILE__ ));
define('JOBSYER_PLUGIN_BASENAME', plugin_basename(__FILE__));

add_action('plugins_loaded', 'jobster_load_textdomain');
function jobster_load_textdomain() {
    load_plugin_textdomain('jobster', false, dirname(plugin_basename( __FILE__ ) ) . '/languages');
}

/**
 * Scripts
 */
require_once 'scripts.php';

/**
 * Custom post types
 */
require_once 'post-types/init.php';

/**
 * Custom meta
 */
require_once 'meta/init.php';

/**
 * Custom Navigation
 */
require_once 'nav/init.php';

/**
 * Blocks
 */
require_once 'blocks/init.php';

/**
 * Widgets
 */
require_once 'widgets/init.php';

/**
 * Page templates
 */
require_once 'page-templates/init.php';

/**
 * Services
 */
require_once 'services/users.php';
require_once 'services/search-jobs.php';
require_once 'services/search-companies.php';
require_once 'services/search-candidates.php';
require_once 'services/favs.php';
require_once 'services/apps.php';
require_once 'services/contact-company.php';
require_once 'services/contact-candidate.php';
require_once 'services/inbox.php';
require_once 'services/notifications.php';
require_once 'services/visitors.php';
require_once 'services/upload-cover.php';
require_once 'services/upload-logo.php';
require_once 'services/upload-cv.php';
require_once 'services/update-company-profile.php';
require_once 'services/save-job.php';
require_once 'services/update-candidate-profile.php';
require_once 'services/subscription.php';
require_once 'services/contact-block.php';
require_once 'services/paypal.php';
require_once 'services/stripe.php';

/**
 * Views
 */
require_once 'views/init.php';
require_once 'views/user-nav.php';
require_once 'views/search-jobs-form.php';
require_once 'views/search-jobs-form-hero.php';
require_once 'views/filter-jobs-form.php';
require_once 'views/search-companies-form.php';
require_once 'views/search-candidates-form.php';
require_once 'views/social.php';
require_once 'views/similar-jobs.php';
require_once 'views/contact-company-form.php';
require_once 'views/company-jobs.php';
require_once 'views/contact-candidate-form.php';
require_once 'views/company-dashboard-side.php';
require_once 'views/company-dashboard-top.php';
require_once 'views/candidate-dashboard-side.php';
require_once 'views/candidate-dashboard-top.php';
require_once 'views/share-post.php';

/**
 * Admin
 */
require_once 'admin/settings.php';

/**
 * Elementor
 */
require_once 'elementor/init.php';

/**
 * Stripe
 */
$membership_settings = get_option('jobster_membership_settings', '');
$payment_type  =    isset($membership_settings['jobster_payment_type_field'])
                    ? $membership_settings['jobster_payment_type_field']
                    : '';
if ($payment_type == 'listing' || $payment_type == 'plan') {
    $payment_system =   isset($membership_settings['jobster_payment_system_field'])
                        ? $membership_settings['jobster_payment_system_field']
                        : '';
    if ($payment_system == 'stripe') {
        require_once 'libs/stripe-php-9.0.0/init.php';
        $stripe_sk =    isset($membership_settings['jobster_stripe_secret_key_field'])
                        ? $membership_settings['jobster_stripe_secret_key_field']
                        : '';
        if ($stripe_sk != '') {
            \Stripe\Stripe::setApiKey($stripe_sk);
        }
    }
}

/**
 * Custom colors
 */
if (!function_exists('jobster_add_custom_colors')): 
    function jobster_add_custom_colors() {
        echo '<style>';
        require_once 'services/colors.php';
        echo '</style>';
    }
endif;
add_action('wp_head', 'jobster_add_custom_colors');

if (!function_exists('jobster_sanitize_multi_array')) :
    function jobster_sanitize_multi_array(&$item, $key) {
        $item = sanitize_text_field($item);
    }
endif;

if (!function_exists('jobster_get_attachment')) :
    function jobster_get_attachment($id) {
        $attachment = get_post($id);

        return array(
            'alt'         => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
            'caption'     => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'title'       => $attachment->post_title
        );
    }
endif;
?>