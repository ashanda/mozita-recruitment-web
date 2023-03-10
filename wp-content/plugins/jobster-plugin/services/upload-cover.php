<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_upload_cover')): 
    function jobster_upload_cover() {
        $file = array(
            'name'     => sanitize_text_field($_FILES['pxp_upload_file_cover']['name']),
            'type'     => sanitize_text_field($_FILES['pxp_upload_file_cover']['type']),
            'tmp_name' => sanitize_text_field($_FILES['pxp_upload_file_cover']['tmp_name']),
            'error'    => sanitize_text_field($_FILES['pxp_upload_file_cover']['error']),
            'size'     => sanitize_text_field($_FILES['pxp_upload_file_cover']['size'])
        );

        $file = jobster_fileupload_process_cover($file);
    }
endif;
add_action('wp_ajax_jobster_upload_cover', 'jobster_upload_cover');
add_action('wp_ajax_nopriv_jobster_upload_cover', 'jobster_upload_cover');

if (!function_exists('jobster_delete_file_cover')): 
    function jobster_delete_file_cover() {
        $attach_id = intval(sanitize_text_field($_POST['attach_id']));

        wp_delete_attachment($attach_id, true);
        exit;
    }
endif;
add_action('wp_ajax_jobster_delete_file_cover', 'jobster_delete_file_cover');
add_action('wp_ajax_nopriv_jobster_delete_file_cover', 'jobster_delete_file_cover');

if (!function_exists('jobster_fileupload_process_cover')): 
    function jobster_fileupload_process_cover($file) {
        $attachment = jobster_handle_file_cover($file);

        if (is_array($attachment)) {
            $html = jobster_get_html_cover($attachment);
            $response = array(
                'success' => true,
                'html'    => $html,
                'attach'  => $attachment['id']
            );

            echo json_encode($response);
            exit;
        }

        $response = array('success' => false);

        echo json_encode($response);
        exit;
    }
endif;

if (!function_exists('jobster_handle_file_cover')): 
    function jobster_handle_file_cover($upload_data) {
        $return        = false;
        $uploaded_file = wp_handle_upload(
                            $upload_data, 
                            array('test_form' => false)
                        );

        if (isset($uploaded_file['file'])) {
            $file_loc  = $uploaded_file['file'];
            $file_name = basename($upload_data['name']);
            $file_type = wp_check_filetype($file_name);

            $attachment = array(
                'post_mime_type' => $file_type['type'],
                'post_title'     => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            $attach_id   = wp_insert_attachment($attachment, $file_loc);
            $attach_data = wp_generate_attachment_metadata($attach_id, $file_loc);

            wp_update_attachment_metadata($attach_id, $attach_data);

            $return = array('data' => $attach_data, 'id' => $attach_id);

            return $return;
        }

        return $return;
    }
endif;

if (!function_exists('jobster_get_html_cover')): 
    function jobster_get_html_cover($attachment) {
        $attach_id = $attachment['id'];
        $post      = get_post($attach_id);
        $dir       = wp_upload_dir();
        $path      = $dir['baseurl'];
        $file      = $attachment['data']['file'];
        $html      = '';
        $html      .= $path . '/' . $file;

        return $html;
    }
endif;
?>