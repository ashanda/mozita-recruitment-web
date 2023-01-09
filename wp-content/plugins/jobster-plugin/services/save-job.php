<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

/**
 * Save new job offer
 */
if (!function_exists('jobster_save_new_job')): 
    function jobster_save_new_job() {
        check_ajax_referer('company_new_job_ajax_nonce', 'security');

        $company_id =   isset($_POST['company_id'])
                        ? sanitize_text_field($_POST['company_id'])
                        : '';
        $title =    isset($_POST['title'])
                    ? sanitize_text_field($_POST['title'])
                    : '';
        $category = isset($_POST['category'])
                    ? sanitize_text_field($_POST['category'])
                    : '';
        $location = isset($_POST['location'])
                    ? sanitize_text_field($_POST['location'])
                    : '';
        $cover =    isset($_POST['cover'])
                    ? sanitize_text_field($_POST['cover'])
                    : '';
        $description =  isset($_POST['description'])
                        ? $_POST['description']
                        : '';
        $type = isset($_POST['type'])
                ? sanitize_text_field($_POST['type'])
                : '';
        $level =    isset($_POST['level'])
                    ? sanitize_text_field($_POST['level'])
                    : '';
        $experience =   isset($_POST['experience'])
                        ? sanitize_text_field($_POST['experience'])
                        : '';
        $salary =   isset($_POST['salary'])
                    ? sanitize_text_field($_POST['salary'])
                    : '';
        $action =   isset($_POST['btn_action'])
                    ? sanitize_text_field($_POST['btn_action'])
                    : '';
        $draft =    isset($_POST['draft'])
                    ? sanitize_text_field($_POST['draft'])
                    : '';

        if ($title == '') {
            echo json_encode(
                array(
                    'save' => false,
                    'message' => __('Job title field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-new-job-title'
                )
            );
            exit();
        }
        if ($category == '0') {
            echo json_encode(
                array(
                    'save' => false,
                    'message' => __('Category field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-new-job-category'
                )
            );
            exit();
        }
        if ($location == '0') {
            echo json_encode(
                array(
                    'save' => false,
                    'message' => __('Location field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-new-job-location'
                )
            );
            exit();
        }
        if ($type == '0') {
            echo json_encode(
                array(
                    'save' => false,
                    'message' => __('Type of employment field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-new-job-type'
                )
            );
            exit();
        }
        if ($level == '0') {
            echo json_encode(
                array(
                    'save' => false,
                    'message' => __('Experience level field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-new-job-level'
                )
            );
            exit();
        }

        $job_status = 'publish';
        if ($draft == 'true') {
            $job_status = 'draft';
        }

        $job = array(
            'post_title'   => $title,
            'post_content' => $description,
            'post_type'    => 'job',
            'post_status'  => $job_status
        );

        $job_id = wp_insert_post($job);

        wp_set_object_terms($job_id, array(intval($category)), 'job_category');
        wp_set_object_terms($job_id, array(intval($location)), 'job_location');
        wp_set_object_terms($job_id, array(intval($type)), 'job_type');
        wp_set_object_terms($job_id, array(intval($level)), 'job_level');

        update_post_meta($job_id, 'job_cover', $cover);
        update_post_meta($job_id, 'job_experience', $experience);
        update_post_meta($job_id, 'job_salary', $salary);
        update_post_meta($job_id, 'job_company', $company_id);
        update_post_meta($job_id, 'job_featured', '');
        update_post_meta($job_id, 'job_action', $action);

        $membership_settings = get_option('jobster_membership_settings');
        $payment_type = isset($membership_settings['jobster_payment_type_field'])
                        ? $membership_settings['jobster_payment_type_field']
                        : '';
        $standard_unlim =   isset($membership_settings['jobster_free_submissions_unlim_field'])
                            ? $membership_settings['jobster_free_submissions_unlim_field']
                            : '';
        $company_payment = get_post_meta($company_id, 'company_payment', true);

        if ($company_payment == '1') {
            update_post_meta($job_id, 'job_payment_status', 'paid');
        } else {
            // update the free standard submissions number on company
            if ($payment_type == 'listing') {
                $company_free_listings = get_post_meta(
                    $company_id,
                    'company_free_listings',
                    true
                );
                $cfl_int = intval($company_free_listings);

                if ($cfl_int > 0 || $standard_unlim == '1') {
                    update_post_meta(
                        $company_id, 'company_free_listings', $cfl_int - 1
                    );
                    update_post_meta($job_id, 'job_payment_status', 'paid');
                } else {
                    if ($draft == 'true') {
                        $updated_job = array(
                            'ID' => $job_id,
                            'post_status' => 'draft'
                        );
                    } else {
                        $updated_job = array(
                            'ID' => $job_id,
                            'post_status' => 'pending'
                        );
                    }
                    wp_update_post($updated_job);
                }
            }

            // update the membership submissions number for company
            if ($payment_type == 'plan') {
                $company_plan_listings = get_post_meta(
                    $company_id,
                    'company_plan_listings',
                    true
                );
                $cpl_int = intval($company_plan_listings);

                update_post_meta(
                    $company_id, 'company_plan_listings', $cpl_int - 1
                );
                update_post_meta($job_id, 'job_payment_status', 'paid');
            }
        }

        echo json_encode(
            array(
                'save' => true,
                'message' => __('Your profile data was successfully updated. Redirecting...', 'jobster')
            )
        );
        exit();

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_save_new_job', 'jobster_save_new_job');
add_action('wp_ajax_jobster_save_new_job', 'jobster_save_new_job');

/**
 * Update existing job offer
 */
if (!function_exists('jobster_update_job')): 
    function jobster_update_job() {
        check_ajax_referer('company_edit_job_ajax_nonce', 'security');

        $company_id =   isset($_POST['company_id'])
                        ? sanitize_text_field($_POST['company_id'])
                        : '';
        $job_id =   isset($_POST['job_id'])
                    ? sanitize_text_field($_POST['job_id'])
                    : '';
        $title =    isset($_POST['title'])
                    ? sanitize_text_field($_POST['title'])
                    : '';
        $category = isset($_POST['category'])
                    ? sanitize_text_field($_POST['category'])
                    : '';
        $location = isset($_POST['location'])
                    ? sanitize_text_field($_POST['location'])
                    : '';
        $cover =    isset($_POST['cover'])
                    ? sanitize_text_field($_POST['cover'])
                    : '';
        $description =  isset($_POST['description'])
                        ? $_POST['description']
                        : '';
        $type = isset($_POST['type'])
                ? sanitize_text_field($_POST['type'])
                : '';
        $level =    isset($_POST['level'])
                    ? sanitize_text_field($_POST['level'])
                    : '';
        $experience =   isset($_POST['experience'])
                        ? sanitize_text_field($_POST['experience'])
                        : '';
        $salary =   isset($_POST['salary'])
                    ? sanitize_text_field($_POST['salary'])
                    : '';
        $action =   isset($_POST['btn_action'])
                    ? sanitize_text_field($_POST['btn_action'])
                    : '';
        $draft =    isset($_POST['draft'])
                    ? sanitize_text_field($_POST['draft'])
                    : '';

        if ($title == '') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Job title field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-new-job-title'
                )
            );
            exit();
        }
        if ($category == '0') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Category field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-new-job-category'
                )
            );
            exit();
        }
        if ($location == '0') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Location field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-new-job-location'
                )
            );
            exit();
        }
        if ($type == '0') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Type of employment field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-new-job-type'
                )
            );
            exit();
        }
        if ($level == '0') {
            echo json_encode(
                array(
                    'update' => false,
                    'message' => __('Experience level field is mandatory.', 'jobster'),
                    'field' => 'pxp-company-new-job-level'
                )
            );
            exit();
        }

        $job_status = get_post_status($job_id);

        $membership_settings = get_option('jobster_membership_settings');
        $payment_type = isset($membership_settings['jobster_payment_type_field'])
                        ? $membership_settings['jobster_payment_type_field']
                        : '';
        $standard_unlim =   isset($membership_settings['jobster_free_submissions_unlim_field'])
                            ? $membership_settings['jobster_free_submissions_unlim_field']
                            : '';
        $company_payment = get_post_meta($company_id, 'company_payment', true);

        if ($payment_type == 'listing') {
            $payment_status = get_post_meta(
                $job_id,
                'job_payment_status',
                true
            );

            if ($payment_status == 'paid') {
                if ($draft == 'true') {
                    $new_job_status = 'draft';
                } else {
                    $new_job_status = 'publish';
                }
            } else {
                if ($job_status == 'publish') {
                    if ($draft == 'true') { 
                        $new_job_status = 'draft';
                    } else {
                        $new_job_status = 'publish';
                    }
                } else if ($job_status == 'pending') {
                    if ($draft == 'true') { 
                        $new_job_status = 'draft';
                    } else {
                        $new_job_status = 'pending';
                    }
                } else {
                    $new_job_status = 'draft';
                }
            }
        } else {
            if ($draft == 'true') {
                $new_job_status = 'draft';
            } else {
                $new_job_status = 'publish';
            }
        }

        $job = array(
            'ID'           => $job_id,
            'post_title'   => $title,
            'post_content' => $description,
            'post_type'    => 'job',
            'post_status'  => $new_job_status
        );

        $job_id = wp_update_post($job);

        wp_set_object_terms($job_id, array(intval($category)), 'job_category');
        wp_set_object_terms($job_id, array(intval($location)), 'job_location');
        wp_set_object_terms($job_id, array(intval($type)), 'job_type');
        wp_set_object_terms($job_id, array(intval($level)), 'job_level');

        update_post_meta($job_id, 'job_cover', $cover);
        update_post_meta($job_id, 'job_experience', $experience);
        update_post_meta($job_id, 'job_salary', $salary);
        update_post_meta($job_id, 'job_action', $action);
        update_post_meta($job_id, 'job_company', $company_id);

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
add_action('wp_ajax_nopriv_jobster_update_job', 'jobster_update_job');
add_action('wp_ajax_jobster_update_job', 'jobster_update_job');

/**
 * Bulk publish jobs
 */
if (!function_exists('jobster_publish_jobs')): 
    function jobster_publish_jobs() {
        check_ajax_referer('company_bulk_jobs_ajax_nonce', 'security');

        $jobs = isset($_POST['jobs'])
                ? sanitize_text_field($_POST['jobs'])
                : '';

        if ($jobs != '') {
            $jobs_arr = explode(',', $jobs);

            $membership_settings = get_option('jobster_membership_settings');
            $payment_type = isset($membership_settings['jobster_payment_type_field'])
                            ? $membership_settings['jobster_payment_type_field']
                            : '';

            foreach ($jobs_arr as $job) {
                if ($payment_type == 'listing') {
                    $payment_status = get_post_meta(
                        $job,
                        'job_payment_status',
                        true
                    );

                    if ($payment_status == 'paid') {
                        wp_publish_post($job);
                    }
                } else {
                    wp_publish_post($job);
                }
            }

            echo json_encode(
                array(
                    'published' => true,
                    'message' => __('Jobs were successfully published. Redirecting...', 'jobster')
                )
            );
            exit();
        } else {
            echo json_encode(
                array(
                    'published' => false,
                    'message' => __('Jobs were not published.', 'jobster')
                )
            );
            exit();
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_publish_jobs', 'jobster_publish_jobs');
add_action('wp_ajax_jobster_publish_jobs', 'jobster_publish_jobs');

/**
 * Delete job offer(s)
 */
if (!function_exists('jobster_delete_jobs')): 
    function jobster_delete_jobs() {
        check_ajax_referer('company_bulk_jobs_ajax_nonce', 'security');

        $jobs = isset($_POST['jobs'])
                ? sanitize_text_field($_POST['jobs'])
                : '';

        if ($jobs != '') {
            $jobs_arr = explode(',', $jobs);

            foreach ($jobs_arr as $job) {
                wp_delete_post($job);
            }

            echo json_encode(
                array(
                    'deleted' => true,
                    'message' => __('Jobs were successfully deleted. Redirecting...', 'jobster')
                )
            );
            exit();
        } else {
            echo json_encode(
                array(
                    'deleted' => false,
                    'message' => __('Jobs were not deleted.', 'jobster')
                )
            );
            exit();
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_delete_jobs', 'jobster_delete_jobs');
add_action('wp_ajax_jobster_delete_jobs', 'jobster_delete_jobs');

/**
 * Upgrade job offer to featured
 */
if (!function_exists('jobster_upgrade_job_featured')): 
    function jobster_upgrade_job_featured() {
        check_ajax_referer('upgradejob_ajax_nonce', 'security');

        $job_id =   isset($_POST['job_id'])
                    ? sanitize_text_field($_POST['job_id'])
                    : '';
        $company_id =   isset($_POST['company_id'])
                        ? sanitize_text_field($_POST['company_id'])
                        : '';
        $company_payment = get_post_meta($company_id, 'company_payment', true);

        $feat_job = update_post_meta($job_id, 'job_featured', 1);

        if ($feat_job) {
            $company_free_featured_listings = get_post_meta(
                $company_id,
                'company_free_featured_listings',
                true
            );
            $cffl_int = intval($company_free_featured_listings);
    
            if ($company_payment != '1') {
                update_post_meta(
                    $company_id,
                    'company_free_featured_listings',
                    $cffl_int - 1
                );
            }

            echo json_encode(array('upgrade' => true));
            exit();
        } else {
            echo json_encode(array('upgrade' => false));
            exit();
        }

        die();
    }
endif;
add_action(
    'wp_ajax_nopriv_jobster_upgrade_job_featured',
    'jobster_upgrade_job_featured');
add_action(
    'wp_ajax_jobster_upgrade_job_featured',
    'jobster_upgrade_job_featured'
);

/**
 * Set job as featured from company plan
 */
if (!function_exists('jobster_set_job_featured')): 
    function jobster_set_job_featured() {
        check_ajax_referer('featuredjob_ajax_nonce', 'security');

        $job_id =   isset($_POST['job_id']) 
                    ? sanitize_text_field($_POST['job_id'])
                    : '';
        $company_id =   isset($_POST['company_id'])
                        ? sanitize_text_field($_POST['company_id'])
                        : '';
        $company_payment = get_post_meta($company_id, 'company_payment', true);

        $feat_prop = update_post_meta($job_id, 'job_featured', 1);

        $company_plan_featured_listings = get_post_meta($company_id, 'company_plan_featured', true);
        $cpfl_int = intval($company_plan_featured_listings);

        if ($company_payment != '1') {
            update_post_meta($company_id, 'company_plan_featured', $cpfl_int - 1);
        }

        if ($feat_prop) {
            echo json_encode(array(
                'upgrade' => true,
                'message' => __('The job was successfully set as featured. Redirecting...', 'jobster')
            ));
            exit();
        } else {
            echo json_encode(array(
                'upgrade' => false,
                'message' => __('Something went wrong. The job was not set as featured.', 'jobster'))
            );
            exit();
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_set_job_featured', 'jobster_set_job_featured');
add_action('wp_ajax_jobster_set_job_featured', 'jobster_set_job_featured');
?>