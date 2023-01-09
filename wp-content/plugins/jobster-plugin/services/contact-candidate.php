<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_contact_candidate')): 
    function jobster_contact_candidate() {
        check_ajax_referer('contact_candidate_ajax_nonce', 'security');

        $user_id        = isset($_POST['user_id'])
                        ? sanitize_text_field($_POST['user_id'])
                        : '';
        $company_id     = isset($_POST['company_id'])
                        ? sanitize_text_field($_POST['company_id'])
                        : '';
        $candidate_id   = isset($_POST['candidate_id'])
                        ? sanitize_text_field($_POST['candidate_id'])
                        : '';

        $candidate_email =  isset($_POST['candidate_email'])
                            ? sanitize_email($_POST['candidate_email'])
                            : '';
        $name               = isset($_POST['name'])
                            ? sanitize_text_field($_POST['name'])
                            : '';
        $email =            isset($_POST['email'])
                            ? sanitize_email($_POST['email'])
                            : '';
        $message =          isset($_POST['message'])
                            ? sanitize_text_field($_POST['message'])
                            : '';

        if (empty($name) || empty($email) || empty($message)) {
            echo json_encode(
                array(
                    'sent' => false,
                    'message' => __('Your message failed to be sent. Please check your fields.', 'jobster')
                )
            );
            exit();
        }

        $inbox_fields = array(
            'candidate_id' => $candidate_id,
            'company_id'   => $company_id,
            'user_id'      => $user_id,
            'message'      => $message
        );
        $comment_id = jobster_insert_comment($inbox_fields, $candidate_id);
        $comment = get_comment($comment_id);
        $time = date("H:i", strtotime($comment->comment_date));

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: '. $email,
            'Reply-To: ' . $email
        );

        $body = __('You received the following message from ', 'jobster') . 
                $name . ' [' . __('Email', 'jobster') . ': ' . $email . ']' . '<br /><br />
                <i>' . $message . '</i>';

        $send = wp_mail(
            $candidate_email,
            sprintf( __('[%s] Message from company', 'jobster'), get_option('blogname') ),
            $body,
            $headers
        );

        if ($send) {
            echo json_encode(
                array(
                    'sent' => true,
                    'message' => __('Your message was successfully sent.', 'jobster'),
                    'time' => $time
                )
            );
            exit();
        } else {
            $send_fallback = wp_mail(
                $candidate_email,
                sprintf( __('[%s] Message from company', 'jobster'), get_option('blogname') ),
                $body
            );

            if ($send_fallback) {
                echo json_encode(
                    array(
                        'sent' => true,
                        'message' => __('Your message was successfully sent.', 'jobster'),
                        'time' => $time
                    )
                );
                exit();
            } else {
                echo json_encode(
                    array(
                        'sent' => false,
                        'message' => __('Your message failed to be sent.', 'jobster')
                    )
                );
                exit();
            }
        }

        die();
    }
endif;
add_action('wp_ajax_nopriv_jobster_contact_candidate', 'jobster_contact_candidate');
add_action('wp_ajax_jobster_contact_candidate', 'jobster_contact_candidate');
?>