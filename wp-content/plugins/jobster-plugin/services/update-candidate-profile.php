<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_update_candidate_profile')): 
    function jobster_update_candidate_profile() {
        check_ajax_referer('candidate_profile_ajax_nonce', 'security');

        $candidate_id = isset($_POST['candidate_id'])
                        ? sanitize_text_field($_POST['candidate_id'])
                        : '';
        $name = isset($_POST['name'])
                ? sanitize_text_field($_POST['name'])
                : '';
        $first_name =  isset($_POST['fname'])
        ? sanitize_text_field($_POST['fname'])
        : '';  
        $candidate_systemid = isset($_POST['systemid']) 
        ? sanitize_text_field($_POST['systemid'])
        : '';
        $last_name =  isset($_POST['lname'])
        ? sanitize_text_field($_POST['lname'])
        : '';   
        $whatsapp =  isset($_POST['whatsapp'])
        ? sanitize_text_field($_POST['whatsapp'])
        : ''; 
        $botim =  isset($_POST['botim'])
        ? sanitize_text_field($_POST['botim'])
        : ''; 
        $email =    isset($_POST['email'])
                    ? sanitize_email($_POST['email'])
                    : '';
        $civil_state =    isset($_POST['civil_state'])
                    ? sanitize_text_field($_POST['civil_state'])
                    : '';
        $origin_country =    isset($_POST['country'])
                    ? sanitize_text_field($_POST['country'])
                    : '';            
        $phone =    isset($_POST['phone'])
                    ? sanitize_text_field($_POST['phone'])
                    : '';
        $title =    isset($_POST['title'])
                    ? sanitize_text_field($_POST['title'])
                    : '';
        $website =  isset($_POST['website'])
                    ? sanitize_text_field($_POST['website'])
                    : '';
        $cover =    isset($_POST['cover'])
                    ? sanitize_text_field($_POST['cover'])
                    : '';
        $logo =     isset($_POST['logo'])
                    ? sanitize_text_field($_POST['logo'])
                    : '';
        $about =  isset($_POST['about']) ? $_POST['about'] : '';
        $industry = isset($_POST['industry'])
                    ? sanitize_text_field($_POST['industry'])
                    : '0';
        $location = isset($_POST['location'])
                    ? sanitize_text_field($_POST['location'])
                    : '0';
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
        $cv =   isset($_POST['cv'])
                ? sanitize_text_field($_POST['cv'])
                : '';

        if ($name == '') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Name field is mandatory.', 'jobster'),
                    'field' => 'pxp-candidate-profile-name'
                )
            );
            exit();
        }
        
        if (!is_email($email)) {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Invalid email address.', 'jobster'),
                    'field' => 'pxp-candidate-profile-email'
                )
            );
            exit();
        }
        if ($industry == '0') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Industry field is mandatory.', 'jobster'),
                    'field' => 'pxp-candidate-profile-industry'
                )
            );
            exit();
        }
        if ($location == '0') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Location field is mandatory.', 'jobster'),
                    'field' => 'pxp-candidate-profile-location'
                )
            );
            exit();
        }

        wp_update_post(
            array(
                'ID' => $candidate_id,
                'post_title' => $name,
                'post_content' => $about,
                'post_status' => 'publish'
            )
        );
        update_post_meta($candidate_id, 'candidate_first_name', $first_name);
        update_post_meta($candidate_id, 'candidate_systemid', $candidate_systemid);
        update_post_meta($candidate_id, 'candidate_last_name', $last_name);
        update_post_meta($candidate_id, 'candidate_email', $email);
        update_post_meta($candidate_id, 'candidate_phone', $phone);
        update_post_meta($candidate_id, 'candidate_whatsapp', $whatsapp);
        update_post_meta($candidate_id, 'candidate_botim', $botim);
        update_post_meta($candidate_id, 'candidate_civil_state', $civil_state);
        update_post_meta($candidate_id, 'candidate_origin_country', $origin_country);
        update_post_meta($candidate_id, 'candidate_title', $title);
        update_post_meta($candidate_id, 'candidate_website', $website);
        update_post_meta($candidate_id, 'candidate_cover', $cover);
        update_post_meta($candidate_id, 'candidate_logo', $logo);
        update_post_meta($candidate_id, 'candidate_facebook', $facebook);
        update_post_meta($candidate_id, 'candidate_twitter', $twitter);
        update_post_meta($candidate_id, 'candidate_instagram', $instagram);
        update_post_meta($candidate_id, 'candidate_linkedin', $linkedin);

        wp_set_object_terms(
            $candidate_id,
            array(intval($industry)),
            'candidate_industry'
        );
        wp_set_object_terms(
            $candidate_id,
            array(intval($location)),
            'candidate_location'
        );

        if (isset($_POST['skills'])) {
            $skills_data_raw = urldecode($_POST['skills']);
            $skills_data = json_decode($skills_data_raw);

            $new_skills = array();

            if (isset($skills_data)) {
                if (is_array($skills_data) && count($skills_data) > 0) {
                    foreach ($skills_data as $skill_data) {
                        if ($skill_data->id == '') {
                            $skill_exist = term_exists(
                                $skill_data->name,
                                'candidate_skill'
                            );

                            if ($skill_exist) {
                                array_push(
                                    $new_skills,
                                    intval($skill_exist['term_id'])
                                );
                            } else {
                                $new_skill = wp_insert_term(
                                    sanitize_text_field($skill_data->name),
                                    'candidate_skill'
                                );
                                array_push(
                                    $new_skills,
                                    intval($new_skill['term_id'])
                                );
                            }
                        } else {
                            array_push(
                                $new_skills,
                                intval(intval($skill_data->id))
                            );
                        }
                    }
                }
            }
            wp_set_object_terms(
                $candidate_id,
                $new_skills,
                'candidate_skill'
            );
        }
        
        if (isset($_POST['brands'])) {
            $brands_data_raw = urldecode($_POST['brands']);
            $brands_data = json_decode($brands_data_raw);

            $new_brands = array();

            if (isset($brands_data)) {
                if (is_array($brands_data) && count($brands_data) > 0) {
                    foreach ($brands_data as $brand_data) {
                        if ($brand_data->id == '') {
                            $brand_exist = term_exists(
                                $brand_data->name,
                                'candidate_brand'
                            );

                            if ($brand_exist) {
                                array_push(
                                    $new_brands,
                                    intval($brand_exist['term_id'])
                                );
                            } else {
                                $new_brand = wp_insert_term(
                                    sanitize_text_field($brand_data->name),
                                    'candidate_brand'
                                );
                                array_push(
                                    $new_brands,
                                    intval($new_brand['term_id'])
                                );
                            }
                        } else {
                            array_push(
                                $new_brands,
                                intval(intval($brand_data->id))
                            );
                        }
                    }
                }
            }
            wp_set_object_terms(
                $candidate_id,
                $new_brands,
                'candidate_brand'
            );
        }

        if (isset($_POST['language'])) {
            $language_list = array();
            $language_data_raw = urldecode($_POST['language']);
            $language_data = json_decode($language_data_raw);

            $language_data_encoded = '';

            if (isset($language_data)) {
                $new_data = new stdClass();
                $new_languages = array();

                $language_list = $language_data->languages;

                foreach ($language_list as $language_item) {
                    $new_language = new stdClass();

                    $new_language->title       = sanitize_text_field($language_item->title);
                    array_push($new_languages, $new_language);
                }

                $new_data->languages = $new_languages;

                $language_data_before = json_encode($new_data);
                $language_data_encoded = urlencode($language_data_before);
            }

            update_post_meta(
                $candidate_id,
                'candidate_language',
                $language_data_encoded
            );
        }
        
        
        if (isset($_POST['family'])) {
            $family_list = array();
            $family_data_raw = urldecode($_POST['family']);
            $family_data = json_decode($family_data_raw);

            $family_data_encoded = '';

            if (isset($family_data)) {
                $new_data = new stdClass();
                $new_familys = array();

                $family_list = $family_data->familys;

                foreach ($family_list as $family_item) {
                    $new_family = new stdClass();

                    $new_family->title       = sanitize_text_field($family_item->title);
                    $new_family->relation     = sanitize_text_field($family_item->relation);
                    $new_family->age      = sanitize_text_field($family_item->age);
                    

                    array_push($new_familys, $new_family);
                }

                $new_data->familys = $new_familys;

                $family_data_before = json_encode($new_data);
                $family_data_encoded = urlencode($family_data_before);
            }

            update_post_meta(
                $candidate_id,
                'candidate_family',
                $family_data_encoded
            );
        }
        
        if (isset($_POST['work'])) {
            $work_list = array();
            $work_data_raw = urldecode($_POST['work']);
            $work_data = json_decode($work_data_raw);

            $work_data_encoded = '';

            if (isset($work_data)) {
                $new_data = new stdClass();
                $new_works = array();

                $work_list = $work_data->works;

                foreach ($work_list as $work_item) {
                    $new_work = new stdClass();

                    $new_work->title       = sanitize_text_field($work_item->title);
                    $new_work->company     = sanitize_text_field($work_item->company);
                    $new_work->period      = sanitize_text_field($work_item->period);
                    $new_work->start      = sanitize_text_field($work_item->start);
                    $new_work->end      = sanitize_text_field($work_item->end);
                    $new_work->location      = sanitize_text_field($work_item->location);
                    $new_work->description = sanitize_text_field($work_item->description);

                    array_push($new_works, $new_work);
                }

                $new_data->works = $new_works;

                $work_data_before = json_encode($new_data);
                $work_data_encoded = urlencode($work_data_before);
            }

            update_post_meta(
                $candidate_id,
                'candidate_work',
                $work_data_encoded
            );
        }

        if (isset($_POST['education'])) {
            $edu_list = array();
            $edu_data_raw = urldecode($_POST['education']);
            $edu_data = json_decode($edu_data_raw);

            $edu_data_encoded = '';

            if (isset($edu_data)) {
                $new_data_edu = new stdClass();
                $new_edus = array();

                $edu_list = $edu_data->edus;

                foreach ($edu_list as $edu_item) {
                    $new_edu = new stdClass();

                    $new_edu->title       = sanitize_text_field($edu_item->title);
                    $new_edu->school      = sanitize_text_field($edu_item->school);
                    $new_edu->period      = sanitize_text_field($edu_item->period);
                    $new_edu->description = sanitize_text_field($edu_item->description);

                    array_push($new_edus, $new_edu);
                }

                $new_data_edu->edus = $new_edus;

                $edu_data_before = json_encode($new_data_edu);
                $edu_data_encoded = urlencode($edu_data_before);
            }

            update_post_meta(
                $candidate_id,
                'candidate_edu',
                $edu_data_encoded
            );
        }

        update_post_meta($candidate_id, 'candidate_cv', $cv);

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
add_action(
    'wp_ajax_nopriv_jobster_update_candidate_profile',
    'jobster_update_candidate_profile'
);
add_action(
    'wp_ajax_jobster_update_candidate_profile',
    'jobster_update_candidate_profile'
);
?>