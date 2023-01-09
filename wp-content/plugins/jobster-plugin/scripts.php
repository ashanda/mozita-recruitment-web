<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_enqueue_admin_scripts')): 
    function jobster_enqueue_admin_scripts() {
        wp_enqueue_media();

        // Font Awesome Style
        wp_enqueue_style('font-awesome', JOBSTER_PLUGIN_PATH . 'css/font-awesome.min.css', array(), '4.7.0', 'all');

        // Custom Navigation Style and Script
        wp_register_style('pxp-nav-style', JOBSTER_PLUGIN_PATH . 'nav/css/nav.css', array(), '1.0', 'all');
        wp_register_script('pxp-nav-js', JOBSTER_PLUGIN_PATH . 'nav/js/nav.js', array(), '1.0', 'all');
        wp_enqueue_style('pxp-nav-style');
        wp_enqueue_script('pxp-nav-js');
        wp_localize_script('pxp-nav-js', 'nav_vars', 
            array(
                'admin_url'  => get_admin_url(),
                'ajaxurl'    => admin_url('admin-ajax.php'),
                'plugin_url' => JOBSTER_PLUGIN_PATH,
                'icon_title' => __('Menu Icon', 'jobster'),
                'icon_btn'   => __('Insert Icon', 'jobster'),
            )
        );

        // Post Types Style and Script
        wp_register_style('pxp-pt-style', JOBSTER_PLUGIN_PATH . 'post-types/css/post-types.css', array(), '1.0', 'all');
        wp_register_script('pxp-pt-js', JOBSTER_PLUGIN_PATH . 'post-types/js/post-types.js', array(), '1.0', 'all');
        wp_enqueue_style('pxp-pt-style');
        wp_enqueue_script('pxp-pt-js');
        wp_localize_script('pxp-pt-js', 'pt_vars', 
            array(
                'admin_url'                        => get_admin_url(),
                'ajaxurl'                          => admin_url('admin-ajax.php'),
                'plugin_url'                       => JOBSTER_PLUGIN_PATH,
                'company_logo_title'               => __('Company Logo', 'jobster'),
                'company_logo_btn'                 => __('Insert Logo', 'jobster'),
                'company_cover_title'              => __('Company Cover', 'jobster'),
                'company_cover_btn'                => __('Insert Cover', 'jobster'),
                'candidate_photo_title'            => __('Candidate Photo', 'jobster'),
                'candidate_photo_btn'              => __('Insert Photo', 'jobster'),
                'candidate_cover_title'            => __('Candidate Cover', 'jobster'),
                'candidate_cover_btn'              => __('Insert Cover', 'jobster'),
                'candidate_edit_work_header'       => __('Edit Work Experience', 'jobster'),
                'candidate_work_title_label'       => __('Job title', 'jobster'),
                'candidate_work_company_label'     => __('Company', 'jobster'),
                'candidate_work_period_label'      => __('Time period', 'jobster'),
                'candidate_work_description_label' => __('Description', 'jobster'),
                'ok_btn_label'                     => __('Ok', 'jobster'),
                'add_btn_label'                    => __('Add', 'jobster'),
                'cancel_btn_label'                 => __('Cancel', 'jobster'),
                'candidate_edit_edu_header'        => __('Edit Education', 'jobster'),
                'candidate_edu_title_label'        => __('Specialization/Course of study', 'jobster'),
                'candidate_edu_school_label'       => __('Institution', 'jobster'),
                'candidate_edu_period_label'       => __('Time period', 'jobster'),
                'candidate_edu_description_label'  => __('Description', 'jobster'),
                'candidate_cv_title'               => __('Candidate Resume', 'jobster'),
                'candidate_cv_btn'                 => __('Insert Resume', 'jobster'),
                'job_cover_title'                  => __('Job Cover', 'jobster'),
                'job_cover_btn'                    => __('Insert Cover', 'jobster'),
                'icons_label'                      => __('Icons', 'jobster'),
                'search_icons_placeholder'         => __('Search icons', 'jobster'),
            )
        );

        // Meta scripts
        wp_register_style('pxp-meta-style', JOBSTER_PLUGIN_PATH . 'meta/css/meta.css', array(), '1.0', 'all');
        wp_register_script('pxp-meta-js', JOBSTER_PLUGIN_PATH . 'meta/js/meta.js', array(), '1.0', 'all');
        wp_enqueue_style('pxp-meta-style');
        wp_enqueue_script('pxp-meta-js');
        wp_localize_script('pxp-meta-js', 'meta_vars', 
            array(
                'admin_url'          => get_admin_url(),
                'ajaxurl'            => admin_url('admin-ajax.php'),
                'plugin_url'         => JOBSTER_PLUGIN_PATH,
                'logo_image_title'   => __('Logo Image', 'jobster'),
                'logo_image_btn'     => __('Insert Logo', 'jobster'),
                'edit_logo'          => __('Edit Logo', 'jobster'),
                'image_label'        => __('Image', 'jobster'),
                'link_label'         => __('Link', 'jobster'),
                'ok_btn_label'       => __('Ok', 'jobster'),
                'cancel_btn_label'   => __('Cancel', 'jobster'),
                'cards_photo_title'  => __('Cards Photo', 'jobster'),
                'cards_photo_btn'    => __('Insert Photo', 'jobster'),
                'edit_info'          => __('Edit Info', 'jobster'),
                'number_label'       => __('Number', 'jobster'),
                'label'              => __('Label', 'jobster'),
                'text'               => __('Text', 'jobster'),
                'photo_title'        => __('Photo', 'jobster'),
                'photo_btn'          => __('Insert Photo', 'jobster'),
                'edit_photo'         => __('Edit Photo', 'jobster'),
                'illustration_title' => __('Illustration', 'jobster'),
                'illustration_btn'   => __('Insert Illustration', 'jobster'),
                'icon_title'         => __('Icon', 'jobster'),
                'icon_btn'           => __('Insert Icon', 'jobster'),
                'image_bg_title'     => __('Image Background', 'jobster'),
                'image_bg_btn'       => __('Insert Image', 'jobster'),
                'card_photo_title'   => __('Card Photo', 'jobster'),
                'card_photo_btn'     => __('Insert Photo', 'jobster'),
            )
        );
    }
endif;
add_action('admin_enqueue_scripts', 'jobster_enqueue_admin_scripts');

if (!function_exists('jobster_enqueue_frontend_scripts')): 
    function jobster_enqueue_frontend_scripts() {
        $max_file_size = 100 * 1000 * 1000;

        wp_register_script(
            'pxp-cover-upload',
            JOBSTER_PLUGIN_PATH . 'js/cover-upload.js',
            array('plupload-handlers'),
            '1.0',
            true
        );
        wp_enqueue_script('pxp-cover-upload');
        wp_localize_script('pxp-cover-upload', 'cover_upload_vars', 
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('jobster_upload_cover'),
                'remove' => wp_create_nonce('jobster_remove_cover'),
                'number' => 1,
                'upload_enabled' => true,
                'confirmMsg' => __('Are you sure you want to delete this?', 'jobster'),
                'plupload' => array(
                    'runtimes' => 'html5,flash,html4',
                    'browse_button' => 'pxp-uploader-cover',
                    'container' => 'pxp-upload-container-cover',
                    'file_data_name' => 'pxp_upload_file_cover',
                    'max_file_size' => $max_file_size . 'b',
                    'max_files' => 1,
                    'url' => admin_url('admin-ajax.php') . '?action=jobster_upload_cover&nonce=' . wp_create_nonce('jobster_allow'),
                    'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
                    'filters' => array(
                        array(
                            'title' => __('Allowed Files', 'jobster'),
                            'extensions' => "jpg,jpeg,gif,png"
                        )
                    ),
                    'multipart' => true,
                    'urlstream_upload' => true
                ),
                'dic_text' => __('Are you sure?', 'jobster'),
                'dic_yes' => __('Delete', 'jobster'),
                'dic_no' => __('Cancel', 'jobster'),
                'plugin_url' => JOBSTER_PLUGIN_PATH,
            )
        );

        wp_register_script(
            'pxp-logo-upload',
            JOBSTER_PLUGIN_PATH . 'js/logo-upload.js',
            array('plupload-handlers'),
            '1.0',
            true
        );
        wp_enqueue_script('pxp-logo-upload');
        wp_localize_script('pxp-logo-upload', 'logo_upload_vars', 
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('jobster_upload_logo'),
                'remove' => wp_create_nonce('jobster_remove_logo'),
                'number' => 1,
                'upload_enabled' => true,
                'confirmMsg' => __('Are you sure you want to delete this?', 'jobster'),
                'plupload' => array(
                    'runtimes' => 'html5,flash,html4',
                    'browse_button' => 'pxp-uploader-logo',
                    'container' => 'pxp-upload-container-logo',
                    'file_data_name' => 'pxp_upload_file_logo',
                    'max_file_size' => $max_file_size . 'b',
                    'max_files' => 1,
                    'url' => admin_url('admin-ajax.php') . '?action=jobster_upload_logo&nonce=' . wp_create_nonce('jobster_allow'),
                    'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
                    'filters' => array(
                        array(
                            'title' => __('Allowed Files', 'jobster'),
                            'extensions' => "jpg,jpeg,gif,png"
                        )
                    ),
                    'multipart' => true,
                    'urlstream_upload' => true
                ),
                'dic_text' => __('Are you sure?', 'jobster'),
                'dic_yes' => __('Delete', 'jobster'),
                'dic_no' => __('Cancel', 'jobster'),
                'plugin_url' => JOBSTER_PLUGIN_PATH,
            )
        );

        wp_register_script(
            'pxp-cv-upload',
            JOBSTER_PLUGIN_PATH . 'js/cv-upload.js',
            array('plupload-handlers'),
            '1.0',
            true
        );
        wp_enqueue_script('pxp-cv-upload');
        wp_localize_script('pxp-cv-upload', 'cv_upload_vars', 
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('jobster_upload_cv'),
                'remove' => wp_create_nonce('jobster_remove_cv'),
                'number' => 1,
                'upload_enabled' => true,
                'confirmMsg' => __('Are you sure you want to delete this?', 'jobster'),
                'plupload' => array(
                    'runtimes' => 'html5,flash,html4',
                    'browse_button' => 'pxp-uploader-cv',
                    'container' => 'pxp-upload-container-cv',
                    'file_data_name' => 'pxp_upload_file_cv',
                    'max_file_size' => $max_file_size . 'b',
                    'max_files' => 1,
                    'url' => admin_url('admin-ajax.php') . '?action=jobster_upload_cv&nonce=' . wp_create_nonce('jobster_allow'),
                    'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
                    'filters' => array(
                        array(
                            'title' => __('Allowed Files', 'jobster'),
                            'extensions' => "pdf"
                        )
                    ),
                    'multipart' => true,
                    'urlstream_upload' => true
                ),
                'dic_text' => __('Are you sure?', 'jobster'),
                'dic_yes' => __('Delete', 'jobster'),
                'dic_no' => __('Cancel', 'jobster'),
                'plugin_url' => JOBSTER_PLUGIN_PATH,
                'no_cv' => __('No resume uploaded', 'jobster')
            )
        );
    }
endif;
add_action('wp_enqueue_scripts', 'jobster_enqueue_frontend_scripts');
?>