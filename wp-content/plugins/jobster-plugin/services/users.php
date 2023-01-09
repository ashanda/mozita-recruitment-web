<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

/**
 * Check if user is company
 */
if (!function_exists('jobster_user_is_company')): 
    function jobster_user_is_company($user_id) {
        $args = array(
            'post_type' => 'company',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key'   => 'company_user',
                    'value' => $user_id,
                )
            )
        );

        $query = new WP_Query($args);

        wp_reset_postdata();

        if ($query->have_posts()) {
            wp_reset_query();

            return true;
        } else {
            return false;
        }
    }
endif;

/**
 * Check if user is candidate
 */
if (!function_exists('jobster_user_is_candidate')): 
    function jobster_user_is_candidate($user_id) {
        $args = array(
            'post_type' => 'candidate',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key'   => 'candidate_user',
                    'value' => $user_id,
                )
            )
        );

        $query = new WP_Query($args);

        wp_reset_postdata();

        if ($query->have_posts()) {
            wp_reset_query();

            return true;
        } else {
            return false;
        }
    }
endif;

/**
 * Get company by user id
 */
if (!function_exists('jobster_get_company_by_userid')): 
    function jobster_get_company_by_userid($user_id) {
        $args = array(
            'post_type' => 'company',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key'   => 'company_user',
                    'value' => $user_id,
                )
            )
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $company_id = get_the_ID();
            }

            wp_reset_postdata();
            wp_reset_query();

            return $company_id;
        } else {
            return false;
        }
    }
endif;

/**
 * Get candidate by user id
 */
if (!function_exists('jobster_get_candidate_by_userid')): 
    function jobster_get_candidate_by_userid($user_id) {
        $args = array(
            'post_type' => 'candidate',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key'   => 'candidate_user',
                    'value' => $user_id,
                )
            )
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $candidate_id = get_the_ID();
            }

            wp_reset_postdata();
            wp_reset_query();

            return $candidate_id;
        } else {
            return false;
        }
    }
endif;

/**
 * User Sign In
 */
if (!function_exists('jobster_user_signin')): 
    function jobster_user_signin() {
        if (is_user_logged_in()) {
            echo json_encode(array('signedin' => true, 'message' => __('You are already signed in, redirecting...', 'jobster')));
            exit();
        }

        check_ajax_referer('signin_ajax_nonce', 'security');

        $signin_user = isset($_POST['signin_user']) ? sanitize_text_field($_POST['signin_user']) : '';
        $signin_pass = isset($_POST['signin_pass']) ? $_POST['signin_pass'] : '';

        if ($signin_user == '' || $signin_pass == '') {
            echo json_encode(array('signedin' => false, 'message' => __('Invalid username or password!', 'jobster')));
            exit();
        }

        $data = array();
        $data['user_login']    = $signin_user;
        $data['user_password'] = $signin_pass;

        $user_signon = wp_signon($data);

        if (is_wp_error($user_signon)) {
            echo json_encode(array('signedin' => false, 'message' => __('Invalid username or password!', 'jobster')));
            exit();
        } else {
            $auth_settings = get_option('jobster_authentication_settings', '');
            $redirect_page = 'default';
            if (jobster_user_is_company($user_signon->ID)) {
                $redirect_page = isset($auth_settings['jobster_signin_redirect_company_field'])
                                ? $auth_settings['jobster_signin_redirect_company_field']
                                : 'default';
            }
            if (jobster_user_is_candidate($user_signon->ID)) {
                $redirect_page = isset($auth_settings['jobster_signin_redirect_candidate_field'])
                                ? $auth_settings['jobster_signin_redirect_candidate_field']
                                : 'default';
            }

            echo json_encode(array(
                'signedin' => true,
                'newuser'  => $user_signon->ID,
                'redirect' =>   ($redirect_page == 'default') 
                                ? get_permalink($redirect_page)
                                :  $redirect_page,
                'message'  => __('Sign in successful, redirecting...', 'jobster'),
            ));
            exit();
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_user_signin', 'jobster_user_signin');
add_action('wp_ajax_jobster_user_signin', 'jobster_user_signin');

/**
 * Sign Up notifications
 */
if (!function_exists('jobster_signup_notifications')): 
    function jobster_signup_notifications($user, $user_pass = '') {
        $new_user = new WP_User($user);

        $user_login      = stripslashes($new_user->user_login);
        $user_email      = stripslashes($new_user->user_email);
        $user_first_name = stripslashes($new_user->first_name);

        $message = sprintf( __('New user Sign Up on %s:', 'jobster'), get_option('blogname') ) . "\n\n";
        $message .= sprintf( __('Username: %s', 'jobster'), esc_html($user_login) ) . "\n";
        $message .= sprintf( __('E-mail: %s', 'jobster'), esc_html($user_email) );

        wp_mail(
            get_option('admin_email'),
            sprintf(__('Mozita Recruitment - New User Sign Up', 'jobster'), get_option('blogname') ),
            $message
        );

        if (empty($user_pass)) return;

        $message  = sprintf( __('Welcome, %s!', 'jobster'), esc_html($user_first_name) ) . "\n";
        $message .= __('Thank you for signing up with us. Your new account has been setup and you can now sign in using the details below.', 'jobster') . "\n\n";
        $message .= sprintf( __('Username: %s', 'jobster'), esc_html($user_login) ) . "\n";
        $message .= sprintf( __('Password: %s', 'jobster'), esc_html($user_pass) ) . "\n\n";
        $message .= __('Thank you,', 'jobster') . "\n";
        $message .= sprintf( __('%s Team', 'jobster'), get_option('blogname') );

        wp_mail(
            esc_html($user_email),
            sprintf( __('Mozita Recruitment - Your Username and Password', 'jobster'), get_option('blogname') ),
            $message
        );
    }
endif;

/**
 * User Sign Up
 */
if (!function_exists('jobster_user_signup')): 
    function jobster_user_signup() {
        check_ajax_referer('signin_ajax_nonce', 'security');

        $signup_firstname = isset($_POST['signup_firstname']) ? sanitize_text_field($_POST['signup_firstname']) : '';
        $signup_lastname  = isset($_POST['signup_lastname']) ? sanitize_text_field($_POST['signup_lastname']) : '';
        $signup_company   = isset($_POST['signup_company']) ? sanitize_text_field($_POST['signup_company']) : '';
        $signup_email     = isset($_POST['signup_email']) ? sanitize_email($_POST['signup_email']) : '';
        $signup_pass      = isset($_POST['signup_pass']) ? $_POST['signup_pass'] : '';
        $user_type        = isset($_POST['user_type']) ? sanitize_text_field($_POST['user_type']) : '';
        $terms            = isset($_POST['terms']) ? sanitize_text_field($_POST['terms']) : '';

        $auth_settings = get_option('jobster_authentication_settings');
        $terms_setting = isset($auth_settings['jobster_terms_field']) ? $auth_settings['jobster_terms_field'] : '';

        if ($user_type == 'candidate') {
            if (empty($signup_firstname) || empty($signup_lastname) || empty($signup_pass)) {
                echo json_encode(array('signedup' => false, 'message' => __('Required form fields are empty!', 'jobster')));
                exit();
            }

            $user_data = array(
                'user_login' => $signup_email,
                'user_email' => $signup_email,
                'user_pass'  => $signup_pass,
                'first_name' => $signup_firstname,
                'last_name'  => $signup_lastname
            );
        }
        if ($user_type == 'company') {
            if (empty($signup_company) || empty($signup_pass)) {
                echo json_encode(array('signedup' => false, 'message' => __('Required form fields are empty!', 'jobster')));
                exit();
            }

            $user_data = array(
                'user_login' => $signup_email,
                'user_email' => $signup_email,
                'user_pass'  => $signup_pass,
            );
        }

        if (!is_email($signup_email)) {
            echo json_encode(array('signedup' => false, 'message' => __('Invalid Email!', 'jobster')));
            exit();
        }
        if (email_exists($signup_email)) {
            echo json_encode(array('signedup' => false, 'message' => __('Email already exists!', 'jobster')));
            exit();
        }
        if (6 > strlen($signup_pass)) {
            echo json_encode(array('signedup' => false, 'message' => __('Password too short. Please enter at least 6 characters!', 'jobster')));
            exit();
        }

        if ($terms_setting && $terms_setting != '') {
            if ($terms == '' || $terms != 'true') {
                echo json_encode(array('signedup' => false, 'message' => __('You need to agree with Terms and Conditions', 'jobster')));
                exit();
            }
        }

        $new_user = wp_insert_user($user_data);

        if (is_wp_error($new_user)) {
            echo json_encode(array('signedup' => false, 'message' => __('Something went wrong!', 'jobster')));
            exit();
        } else {
            echo json_encode(array('signedup' => true, 'message' => __('Congratulations! You have successfully signed up.', 'jobster')));

            jobster_signup_notifications($new_user, $signup_pass);

            if ($user_type != '') {
                jobster_register_user_type($new_user, $user_type, $signup_company);
            }
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_user_signup', 'jobster_user_signup');
add_action('wp_ajax_jobster_user_signup', 'jobster_user_signup');

/**
 * Register user type - candidate/company
 */
if (!function_exists('jobster_register_user_type')): 
    function jobster_register_user_type($user_id, $user_type, $company_name) {
        $user = get_user_by('id', $user_id);

        if ($user_type == 'candidate') {
            $candidate_name = $user->first_name . ' ' . $user->last_name;
            $candidate = array(
                'post_title' => $candidate_name,
                'post_type' => 'candidate',
                'post_author' => $user->ID,
                'post_status' => 'publish'
            );

            $candidate_id = wp_insert_post($candidate);
            update_post_meta($candidate_id, 'candidate_email', $user->user_email);
            update_post_meta($candidate_id, 'candidate_user', $user->ID);
        }

        if ($user_type == 'company') {
            $company = array(
                'post_title' => $company_name,
                'post_type' => 'company',
                'post_author' => $user->ID,
                'post_status' => 'publish'
            );

            $company_id = wp_insert_post($company);
            update_post_meta($company_id, 'company_email', $user->user_email);
            update_post_meta($company_id, 'company_user', $user->ID);

            // Set default payment settings
            $membership_settings = get_option('jobster_membership_settings');
            $payment_type = isset($membership_settings['jobster_payment_type_field'])
                            ? $membership_settings['jobster_payment_type_field']
                            : '';
            $free_standard =    isset($membership_settings['jobster_free_submissions_no_field'])
                                ? $membership_settings['jobster_free_submissions_no_field']
                                : '';
            $free_featured = isset($membership_settings['jobster_free_featured_submissions_no_field']) 
                            ? $membership_settings['jobster_free_featured_submissions_no_field']
                            : '';

            if ($payment_type == 'listing') {
                update_post_meta(
                    $company_id,
                    'company_free_listings',
                    $free_standard
                );
                update_post_meta(
                    $company_id,
                    'company_free_featured_listings',
                    $free_featured
                );
            }
        }
    }
endif;

/**
 * Register candidate - anonymous user
 */
if (!function_exists('jobster_register_candidate')): 
    function jobster_register_candidate($data = array()) {
        $candidate = array(
            'post_title' => $data['name'],
            'post_type' => 'candidate',
            'post_status' => 'draft'
        );

        $candidate_id = wp_insert_post($candidate);

        if ($candidate_id) {
            update_post_meta($candidate_id, 'candidate_email', $data['email']);
            update_post_meta($candidate_id, 'candidate_phone', $data['phone']);
            update_post_meta($candidate_id, 'candidate_cv', $data['cv']);

            return $candidate_id;
        }

        return false;
    }
endif;

/**
 * Forgot Password
 */
if (!function_exists('jobster_forgot_password')): 
    function jobster_forgot_password() {
        global $wpdb, $wp_hasher;

        check_ajax_referer('signin_ajax_nonce', 'security');

        $forgot_email = isset($_POST['forgot_email']) ? sanitize_email($_POST['forgot_email']) : '';

        if ($forgot_email == '') {
            echo json_encode(array('sent' => false, 'message' => __('Invalid email address!', 'jobster')));
            exit();
        }

        $user_input = trim($forgot_email);

        if (strpos($user_input, '@')) {
            $user_data = get_user_by('email', $user_input);

            if (empty($user_data)) {
                echo json_encode(array('sent' => false, 'message' => __('Invalid email address!', 'jobster')));
                exit();
            }
        } else {
            $user_data = get_user_by('login', $user_input);

            if (empty($user_data)) {
                echo json_encode(array('sent' => false, 'message' => __('Invalid username!', 'jobster')));
                exit();
            }
        }

        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;

        $key = wp_generate_password(20, false);
        do_action('retrieve_password_key', $user_login, $key);

        if (empty($wp_hasher)) {
            require_once ABSPATH . WPINC . '/class-phpass.php';

            $wp_hasher = new PasswordHash( 8, true );
        }

        $hashed = time() . ':' . $wp_hasher->HashPassword($key);
        $wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $user_login));

        $message = __('Someone has asked to reset the password for the following site and username.', 'jobster') . "\n\n";
        $message .= get_option('siteurl') . "\n\n";
        $message .= sprintf(__('Username: %s', 'jobster'), $user_login) . "\n\n";
        $message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.', 'jobster') . "\n\n";
        $message .= network_site_url("?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";

        if ($message && !wp_mail($user_email, __('Password Reset Request', 'jobster'), $message)) {
            echo json_encode(array('sent' => false, 'message' => __('Email failed to be sent for some unknown reason.', 'jobster')));
            exit();
        } else {
            echo json_encode(array('sent' => true, 'message' => __('An email with password reset instructions was sent to you.', 'jobster')));
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_forgot_password', 'jobster_forgot_password');
add_action('wp_ajax_jobster_forgot_password', 'jobster_forgot_password');

/**
 * Reset Password
 */
if (!function_exists('jobster_reset_pass')): 
    function jobster_reset_pass() {
        check_ajax_referer('signin_ajax_nonce', 'security');

        $allowed_html = array();
        $pass         = isset($_POST['pass']) ? wp_kses($_POST['pass'], $allowed_html) : '';
        $key          = isset($_POST['key']) ? wp_kses($_POST['key'], $allowed_html) : '';
        $login        = isset($_POST['login']) ? wp_kses($_POST['login'], $allowed_html) : '';

        if ($pass == '') {
            echo json_encode(array('reset' => false, 'message' => __('Password field empty!', 'jobster')));
            exit();
        }

        $user = check_password_reset_key($key, $login);

        if (is_wp_error($user)) {
            if ($user->get_error_code() === 'expired_key') {
                echo json_encode(array('reset' => false, 'message' => __('Sorry, the link does not appear to be valid or is expired!', 'jobster')));
                exit();
            } else {
                echo json_encode(array('reset' => false, 'message' => __('Sorry, the link does not appear to be valid or is expired!', 'jobster')));
                exit();
            }
        }

        reset_password($user, $pass);
        echo json_encode(array('reset' => true, 'message' => __('Your password has been reset.', 'jobster')));

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_reset_password', 'jobster_reset_password');
add_action('wp_ajax_jobster_reset_password', 'jobster_reset_password');

/**
 * Save New Password from Dashboard
 */
if (!function_exists('jobster_save_pass')): 
    function jobster_save_pass() {
        check_ajax_referer('password_ajax_nonce', 'security');

        $old_pass        =  isset($_POST['old_pass'])
                            ? sanitize_text_field($_POST['old_pass'])
                            :'';
        $new_pass        =  isset($_POST['new_pass'])
                            ? sanitize_text_field($_POST['new_pass'])
                            : '';
        $new_pass_repeat =  isset($_POST['new_pass_repeat'])
                            ? sanitize_text_field($_POST['new_pass_repeat'])
                            : '';

        if ($old_pass == '') {
            echo json_encode(
                array(
                    'save' => false,
                    'message' => __('Old password field is mandatory.', 'jobster'),
                    'field' => 'old'
                )
            );
            exit();
        }

        if ($new_pass == '') {
            echo json_encode(
                array(
                    'save' => false,
                    'message' => __('New password field is mandatory.', 'jobster'),
                    'field' => 'new'
                )
            );
            exit();
        }

        if ($new_pass_repeat == '') {
            echo json_encode(
                array(
                    'save' => false,
                    'message' => __('New password repeat field is mandatory.', 'jobster'),
                    'field' => 'new_r'
                )
            );
            exit();
        }

        if ($new_pass != $new_pass_repeat) {
            echo json_encode(
                array(
                    'save' => false,
                    'message' => __('The passwords do not match.', 'jobster'),
                    'field' => 'new,new_r'
                )
            );
            exit();
        }

        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();

            if ($current_user
                && wp_check_password(
                    $old_pass,
                    $current_user->data->user_pass,
                    $current_user->ID
                )) {
                wp_update_user(
                    array(
                        'ID' => $current_user->ID,
                        'user_pass' => $new_pass
                    )
                );
                echo json_encode(
                    array(
                        'save' => true,
                        'message' => __('Your password has successfuly been reset.', 'jobster')
                    )
                );
                exit();
            } else {
                echo json_encode(
                    array(
                        'save' => false,
                        'message' => __('Old password is incorrect.', 'jobster'),
                        'field' => 'old'
                    )
                );
                exit();
            }
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_save_pass', 'jobster_save_pass');
add_action('wp_ajax_jobster_save_pass', 'jobster_save_pass');
?>