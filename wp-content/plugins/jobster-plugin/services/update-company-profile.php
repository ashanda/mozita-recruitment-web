<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_update_company_profile')): 
    function jobster_update_company_profile() {
        check_ajax_referer('company_profile_ajax_nonce', 'security');

        $company_id =   isset($_POST['company_id'])
                        ? sanitize_text_field($_POST['company_id'])
                        : '';
        $name =     isset($_POST['name'])
                    ? sanitize_text_field($_POST['name'])
                    : '';
        $email =    isset($_POST['email'])
                    ? sanitize_email($_POST['email'])
                    : '';
        $phone =    isset($_POST['phone'])
                    ? sanitize_text_field($_POST['phone'])
                    : '';
        $website =  isset($_POST['website'])
                    ? sanitize_text_field($_POST['website'])
                    : '';
        $redirect = isset($_POST['redirect'])
                    ? sanitize_text_field($_POST['redirect'])
                    : '';
        $cover =    isset($_POST['cover'])
                    ? sanitize_text_field($_POST['cover'])
                    : '';
        $logo = isset($_POST['logo'])
                ? sanitize_text_field($_POST['logo'])
                : '';
        $about = isset($_POST['about']) ? $_POST['about'] : '';
        $industry = isset($_POST['industry'])
                    ? sanitize_text_field($_POST['industry'])
                    : '0';
        $location = isset($_POST['location'])
                    ? sanitize_text_field($_POST['location'])
                    : '0';
        $founded =  isset($_POST['founded'])
                    ? sanitize_text_field($_POST['founded'])
                    : '';
        $size = isset($_POST['size'])
                ? sanitize_text_field($_POST['size'])
                : '';
        $facebook = isset($_POST['facebook'])
                    ? sanitize_text_field($_POST['facebook'])
                    : '';
        $twitter =  isset($_POST['twitter'])
                    ? sanitize_text_field($_POST['twitter'])
                    : '';
        $instagram =    isset($_POST['instagram'])
                        ? sanitize_text_field($_POST['instagram'])
                        : '';
        $linkedin = isset($_POST['linkedin'])
                    ? sanitize_text_field($_POST['linkedin'])
                    : '';
        $app_notify = isset($_POST['app_notify'])
                    ? sanitize_text_field($_POST['app_notify'])
                    : '';

        if ($name == '') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Name field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-profile-name'
                )
            );
            exit();
        }
        if (!is_email($email)) {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Invalid email address.', 'jobster'),
                    'field' => 'pxp-company-profile-email'
                )
            );
            exit();
        }
        if ($industry == '0') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Industry field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-profile-industry'
                )
            );
            exit();
        }
        if ($location == '0') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Location field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-profile-location'
                )
            );
            exit();
        }

        wp_update_post(
            array(
                'ID' => $company_id,
                'post_title' => $name,
                'post_content' => $about,
                'post_status' => 'publish'
            )
        );

        
        wp_set_object_terms(
            $company_id,
            array(intval($industry)),
            'company_industry'
        );
        wp_set_object_terms(
            $company_id,
            array(intval($location)),
            'company_location'
        );

        update_post_meta($company_id, 'company_email', $email);
        update_post_meta($company_id, 'company_phone', $phone);
        update_post_meta($company_id, 'company_website', $website);
        update_post_meta($company_id, 'company_redirect', $redirect);
        update_post_meta($company_id, 'company_cover', $cover);
        update_post_meta($company_id, 'company_logo', $logo);
        update_post_meta($company_id, 'company_founded', $founded);
        update_post_meta($company_id, 'company_size', $size);
        update_post_meta($company_id, 'company_facebook', $facebook);
        update_post_meta($company_id, 'company_twitter', $twitter);
        update_post_meta($company_id, 'company_instagram', $instagram);
        update_post_meta($company_id, 'company_linkedin', $linkedin);
        update_post_meta($company_id, 'company_app_notify', $app_notify);
        
        if (isset($_POST['contact'])) {
            $contact_list = array();
            $contact_data_raw = urldecode($_POST['contact']);
            $contact_data = json_decode($contact_data_raw);

            $contact_data_encoded = '';

            if (isset($contact_data)) {
                $new_data = new stdClass();
                $new_contacts = array();

                $contact_list = $contact_data->contacts;

                foreach ($contact_list as $contact_item) {
                    $new_contact = new stdClass();

                    $new_contact->title       = sanitize_text_field($contact_item->title);
                    $new_contact->designation     = sanitize_text_field($contact_item->designation);
                    $new_contact->email      = sanitize_text_field($contact_item->email);
                    $new_contact->mobile      = sanitize_text_field($contact_item->mobile);
                    $new_contact->phone      = sanitize_text_field($contact_item->phone);
                    

                    array_push($new_contacts, $new_contact);
                }

                $new_data->contacts = $new_contacts;

                $contact_data_before = json_encode($new_data);
                $contact_data_encoded = urlencode($contact_data_before);
            }

            update_post_meta(
                $company_id,
                'company_contact',
                $contact_data_encoded
            );
        }

        echo json_encode(
            array(
                'update' => true,
                'message' => __('Your profile data was successfully updated. Redirecting...', 'jobster')
            )
        );
        exit();

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_update_company_profile', 'jobster_update_company_profile');
add_action('wp_ajax_jobster_update_company_profile', 'jobster_update_company_profile');
?>