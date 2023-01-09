<?php
/**
 * Recent jobs block
 */
if (!function_exists('jobster_recent_jobs_block')): 
    function jobster_recent_jobs_block() {
        wp_register_script(
            'jobster-recent-jobs-block',
            plugins_url('js/recent-jobs.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-components',
                'wp-editor',
                'wp-i18n'
            )
        );

        wp_enqueue_style(
            'jobster-recent-jobs-block-editor',
            plugins_url('css/recent-jobs.css', __FILE__),
            array('wp-edit-blocks')
        );

        register_block_type('jobster-plugin/recent-jobs', array(
            'editor_script' => 'jobster-recent-jobs-block',
            'attributes' => array(
                'data_content' => array('type' => 'string')
            ),
            'render_callback' => 'jobster_recent_jobs_block_render'
        ));
    }
endif;
add_action('init', 'jobster_recent_jobs_block');

if (!function_exists('jobster_recent_jobs_block_render')): 
    function jobster_recent_jobs_block_render($attrs, $content = null) {
        extract(shortcode_atts(array('data_content'), $attrs));

        if (!isset($attrs['data_content'])) {
            return null;
        }

        $data = json_decode(urldecode($attrs['data_content']), true);

        $number =   isset($data['number']) && is_numeric($data['number'])
                    ? $data['number']
                    : '6';
        $location = isset($data['location']) && is_numeric($data['location'])
                    ? $data['location']
                    : '0';
        $category = isset($data['category']) && is_numeric($data['category'])
                    ? $data['category']
                    : '0';
        $animation =    isset($data['animation']) && $data['animation'] == 'e'
                        ? 'pxp-animate-in pxp-animate-in-top'
                        : '';
        $card_design =  isset($data['design']) && $data['design'] == 'b'
                        ? 'pxp-has-border'
                        : 'pxp-has-shadow';

        $section_padding = '';
        $bg_color = 'transparent';
        $margin = 'mt-100';
        if (isset($data['bg']) && $data['bg'] != '') {
            $section_padding = 'pt-100 pb-100';
            $bg_color = $data['bg'];

            if (isset($data['margin']) && $data['margin'] == 'n') {
                $margin = '';
            }
        }

        $align_text = '';
        $align_cards = '';
        if (isset($data['align']) && $data['align'] == 'c') {
            $align_text = 'text-center';
            $align_cards = 'justify-content-center';
        }

        $search_jobs_url = jobster_get_page_link('job-search.php');

        $args = array(
            'numberposts'      => $number,
            'post_type'        => 'job',
            'order'            => 'DESC',
            'suppress_filters' => false,
            'post_status'      => 'publish'
        );

        if ($location != '0' && $category != '0') {
            $args['tax_query'] = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'job_location',
                    'field'    => 'term_id',
                    'terms'    => $location,
                ),
                array(
                    'taxonomy' => 'job_category',
                    'field'    => 'term_id',
                    'terms'    => $category,
                ),
            );
        } else if ($location != '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'job_location',
                    'field'    => 'term_id',
                    'terms'    => $location,
                ),
            );
        } else if ($category != '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'job_category',
                    'field'    => 'term_id',
                    'terms'    => $category,
                ),
            );
        }

        $posts = wp_get_recent_posts($args);

        $return_string = 
            '<section 
                class="' . esc_attr($margin) . ' ' . esc_attr($section_padding) . '" 
                style="background-color: ' . esc_attr($bg_color) . '"
            >
                <div class="pxp-container">';
        if (isset($data['title']) && $data['title'] != '') {
            $return_string .=
                    '<h2 class="pxp-section-h2 ' . esc_attr($align_text) . '">
                        ' . esc_html($data['title']) . '
                    </h2>';
        }
        if (isset($data['subtitle']) && $data['subtitle'] != '') {
            $return_string .=
                    '<p class="pxp-text-light ' . esc_attr($align_text) . '">
                        ' . esc_html($data['subtitle']) . '
                    </p>';
        }

        switch ($data['type']) {
            case 'b':
                $return_string .=
                    '<div class="row mt-4 mt-md-5 ' . esc_attr($animation) . ' ' . esc_attr($align_cards) . '">';
                foreach($posts as $post) : 
                    $job_link = get_permalink($post['ID']);

                    $job_category = wp_get_post_terms(
                        $post['ID'], 'job_category'
                    );
                    $job_category_id =  $job_category
                                        ? $job_category[0]->term_id
                                        : '';
                    $job_category_icon = 'fa fa-folder-o';
                    if ($job_category_id != '') {
                        $job_category_icon = get_term_meta(
                            $job_category_id, 'job_category_icon', true
                        );
                    }

                    $job_location = wp_get_post_terms(
                        $post['ID'], 'job_location'
                    );
                    $job_location_id = $job_location ? $job_location[0]->term_id : '';

                    $job_type = wp_get_post_terms(
                        $post['ID'], 'job_type'
                    );

                    $job_company_id = get_post_meta(
                        $post['ID'], 'job_company', true
                    );
                    $job_company =  ($job_company_id != '')
                                    ? get_post($job_company_id)
                                    : '';

                    $return_string .=
                        '<div class="col-md-6 col-xl-4 col-xxl-3 pxp-jobs-card-1-container">
                            <div class="pxp-jobs-card-1 ' . esc_attr($card_design) . '">
                                <div class="pxp-jobs-card-1-top">';
                    if ($job_category_id != '') {
                        $job_category_link = add_query_arg(
                            'category',
                            $job_category_id,
                            $search_jobs_url
                        );
                        $return_string .=
                                    '<a 
                                        href="' . esc_url($job_category_link) . '" 
                                        class="pxp-jobs-card-1-category"
                                    >
                                        <div class="pxp-jobs-card-1-category-icon">
                                            <span class="' . esc_attr($job_category_icon) . '"></span>
                                        </div>
                                        <div class="pxp-jobs-card-1-category-label">
                                            ' . esc_html($job_category[0]->name) . '
                                        </div>
                                    </a>';
                    }
                    $return_string .=
                                    '<a 
                                        href="' . esc_url($job_link) . '" 
                                        class="pxp-jobs-card-1-title"
                                    >
                                        ' . esc_html($post['post_title']) . '
                                    </a>
                                    <div class="pxp-jobs-card-1-details">';
                    if ($job_location_id != '') { 
                        $job_location_link = add_query_arg(
                            'location',
                            $job_location_id,
                            $search_jobs_url
                        );
                        $return_string .= 
                                        '<a 
                                            href="' . esc_url($job_location_link) . '" 
                                            class="pxp-jobs-card-1-location"
                                        >
                                            <span class="fa fa-globe"></span>
                                            ' . esc_html($job_location[0]->name) . '
                                        </a>';
                    }
                    if ($job_type != '') {
                        $return_string .= 
                                        '<div class="pxp-jobs-card-1-type">
                                            ' . esc_html($job_type[0]->name) . '
                                        </div>';
                    }
                    $return_string .= 
                                    '</div>
                                </div>
                                <div class="pxp-jobs-card-1-bottom">
                                    <div class="pxp-jobs-card-1-bottom-left">
                                        <div class="pxp-jobs-card-1-date pxp-text-light">
                                            ' . get_the_date('', $post['ID']);
                    if ($job_company != '') {
                        $return_string .=
                                            '<span class="d-inline">
                                                ' . esc_html__('by', 'jobster') . '
                                            </span>';
                    }
                    $return_string .=
                                        '</div>';
                    if ($job_company != '') {
                        $return_string .=
                                        '<a 
                                            href="' . esc_url(get_permalink($job_company_id)) . '" 
                                            class="pxp-jobs-card-1-company"
                                        >
                                            ' . esc_html($job_company->post_title) . '
                                        </a>';
                    }
                    $return_string .=
                                    '</div>';
                    if ($job_company != '') {
                        $job_company_logo_val = get_post_meta(
                            $job_company_id,
                            'company_logo',
                            true
                        );
                        $job_company_logo = wp_get_attachment_image_src(
                            $job_company_logo_val,
                            'pxp-thmb'
                        );
                        if (is_array($job_company_logo)) {
                            $return_string .=
                                    '<a 
                                        href="' . esc_url(get_permalink($job_company_id)) . '" 
                                        class="pxp-jobs-card-1-company-logo" 
                                        style="background-image: url(' . esc_url($job_company_logo[0]) . ');"
                                    ></a>';
                        } else {
                            $job_company_name = $job_company->post_title;
                            $return_string .=
                                    '<a 
                                        href="' . esc_url(get_permalink($job_company_id)) . '" 
                                        class="pxp-jobs-card-1-company-logo pxp-no-img"
                                    >
                                        ' . esc_html($job_company_name[0]) . '
                                    </a>';
                        }
                    }
                    $return_string .=
                                '</div>
                            </div>
                        </div>';
                endforeach;
                $return_string .=
                    '</div>';
                break;
            case 's':
                $return_string .= 
                    '<div class="row mt-4 mt-md-5 ' . esc_attr($animation) . ' ' . esc_attr($align_cards) . '">';
                foreach($posts as $post) : 
                    $job_link = get_permalink($post['ID']);

                    $job_category = wp_get_post_terms(
                        $post['ID'], 'job_category'
                    );
                    $job_category_id =  $job_category
                                        ? $job_category[0]->term_id
                                        : '';
                    $job_category_icon = 'fa fa-folder-o';
                    if ($job_category_id != '') {
                        $job_category_icon = get_term_meta(
                            $job_category_id, 'job_category_icon', true
                        );
                    }

                    $job_location = wp_get_post_terms(
                        $post['ID'], 'job_location'
                    );
                    $job_location_id = $job_location ? $job_location[0]->term_id : '';

                    $job_type = wp_get_post_terms(
                        $post['ID'], 'job_type'
                    );

                    $job_company_id = get_post_meta(
                        $post['ID'], 'job_company', true
                    );
                    $job_company =  ($job_company_id != '')
                                    ? get_post($job_company_id)
                                    : '';

                    $return_string .=
                        '<div class="col-xl-6 pxp-jobs-card-2-container">
                            <div class="pxp-jobs-card-2 ' . esc_attr($card_design) . '">
                                <div class="pxp-jobs-card-2-top">';
                    if ($job_company != '') {
                        $job_company_logo_val = get_post_meta(
                            $job_company_id,
                            'company_logo',
                            true
                        );
                        $job_company_logo = wp_get_attachment_image_src(
                            $job_company_logo_val,
                            'pxp-thmb'
                        );
                        if (is_array($job_company_logo)) {
                            $return_string .=
                                    '<a 
                                        href="' . esc_url(get_permalink($job_company_id)) . '" 
                                        class="pxp-jobs-card-2-company-logo" 
                                        style="background-image: url(' . esc_url($job_company_logo[0]) . ');"
                                    ></a>';
                        } else {
                            $job_company_name = $job_company->post_title;
                            $return_string .=
                                    '<a 
                                        href="' . esc_url(get_permalink($job_company_id)) . '" 
                                        class="pxp-jobs-card-2-company-logo pxp-no-img"
                                    >
                                        ' . esc_html($job_company_name[0]) . '
                                    </a>';
                        }
                    }
                    $return_string .=
                                    '<div class="pxp-jobs-card-2-info">
                                        <a 
                                            href="' . esc_url($job_link) . '" 
                                            class="pxp-jobs-card-2-title"
                                        >
                                            ' . esc_html($post['post_title']) . '
                                        </a>
                                        <div class="pxp-jobs-card-2-details">';
                    if ($job_location_id != '') {
                        $job_location_link = add_query_arg(
                            'location',
                            $job_location_id,
                            $search_jobs_url
                        );
                        $return_string .=
                                            '<a 
                                                href="' . esc_url($job_location_link) . '" 
                                                class="pxp-jobs-card-2-location"
                                            >
                                                <span class="fa fa-globe"></span>
                                                ' . esc_html($job_location[0]->name) . '
                                            </a>';
                    }
                    if ($job_type != '') {
                        $return_string .=
                                            '<div class="pxp-jobs-card-2-type">
                                                ' . esc_html($job_type[0]->name) . '
                                            </div>';
                    }
                    $return_string .=
                                        '</div>
                                    </div>
                                </div>
                                <div class="pxp-jobs-card-2-bottom">';
                    if ($job_category_id != '') {
                        $job_category_link = add_query_arg(
                            'category',
                            $job_category_id,
                            $search_jobs_url
                        );
                        $return_string .=
                                    '<a 
                                        href="' . esc_url($job_category_link) . '" 
                                        class="pxp-jobs-card-2-category"
                                    >
                                        <div class="pxp-jobs-card-2-category-label">
                                            ' . esc_html($job_category[0]->name) . '
                                        </div>
                                    </a>';
                    }
                    $return_string .=
                                    '<div class="pxp-jobs-card-2-bottom-right">
                                        <span class="pxp-jobs-card-2-date pxp-text-light">
                                            ' . get_the_date('', $post['ID']);
                    if ($job_company != '') {
                        $return_string .=
                                            '<span class="d-inline">
                                                ' . esc_html__('by', 'jobster') . '
                                            </span>';
                    }
                    $return_string .=
                                        '</span>';
                    if ($job_company != '') {
                        $return_string .=
                                        '<a 
                                            href="' . esc_url(get_permalink($job_company_id)) . '" 
                                            class="pxp-jobs-card-2-company"
                                        >
                                            ' . esc_html($job_company->post_title) . '
                                        </a>';
                    }
                    $return_string .=
                                    '</div>
                                </div>
                            </div>
                        </div>';
                endforeach;
                $return_string .=
                    '</div>';
                break;
            case 'l':
                $return_string .= 
                    '<div class="mt-4 mt-md-5 ' . esc_attr($animation) . ' ' . esc_attr($align_cards) . '">';
                foreach($posts as $post) : 
                    $job_link = get_permalink($post['ID']);

                    $job_category = wp_get_post_terms(
                        $post['ID'], 'job_category'
                    );
                    $job_category_id =  $job_category
                                        ? $job_category[0]->term_id
                                        : '';
                    $job_category_icon = 'fa fa-folder-o';
                    if ($job_category_id != '') {
                        $job_category_icon = get_term_meta(
                            $job_category_id, 'job_category_icon', true
                        );
                    }

                    $job_location = wp_get_post_terms(
                        $post['ID'], 'job_location'
                    );
                    $job_location_id = $job_location ? $job_location[0]->term_id : '';

                    $job_type = wp_get_post_terms(
                        $post['ID'], 'job_type'
                    );

                    $job_company_id = get_post_meta(
                        $post['ID'], 'job_company', true
                    );
                    $job_company =  ($job_company_id != '')
                                    ? get_post($job_company_id)
                                    : '';

                    $return_string .=
                        '<div class="pxp-jobs-card-3 ' . esc_attr($card_design) . '">
                            <div class="row align-items-center justify-content-between">';
                    if ($job_company != '') { 
                        $job_company_logo_val = get_post_meta(
                            $job_company_id,
                            'company_logo',
                            true
                        );
                        $job_company_logo = wp_get_attachment_image_src(
                            $job_company_logo_val,
                            'pxp-thmb'
                        );
                        if (is_array($job_company_logo)) {
                            $return_string .=
                                '<div class="col-sm-3 col-md-2 col-xxl-auto">
                                    <a 
                                        href="' . esc_url(get_permalink($job_company_id)) . '" 
                                        class="pxp-jobs-card-3-company-logo" 
                                        style="background-image: url(' . esc_url($job_company_logo[0]) . ');"
                                    ></a>
                                </div>';
                        } else {
                            $job_company_name = $job_company->post_title;
                            $return_string .=
                                '<div class="col-sm-3 col-md-2 col-xxl-auto">
                                    <a 
                                        href="' . esc_url(get_permalink($job_company_id)) . '" 
                                        class="pxp-jobs-card-3-company-logo pxp-no-img"
                                    >
                                        ' . esc_html($job_company_name[0]) . '
                                    </a>
                                </div>';
                        }
                    }
                    $return_string .=
                                '<div class="col-sm-9 col-md-10 col-xxl-4">
                                    <a 
                                        href="' . esc_url($job_link) . '" 
                                        class="pxp-jobs-card-3-title mt-3 mt-sm-0"
                                    >
                                        ' . esc_html($post['post_title']) . '
                                    </a>
                                    <div class="pxp-jobs-card-3-details">';
                    if ($job_location_id != '') {
                        $job_location_link = add_query_arg(
                            'location',
                            $job_location_id,
                            $search_jobs_url
                        );
                        $return_string .=
                                        '<a 
                                            href="' . esc_url($job_location_link) . '" 
                                            class="pxp-jobs-card-3-location"
                                        >
                                            <span class="fa fa-globe"></span>
                                            ' . esc_html($job_location[0]->name) . '
                                        </a>';
                    }
                    if ($job_type != '') {
                        $return_string .=
                                        '<div class="pxp-jobs-card-3-type">
                                            ' . esc_html($job_type[0]->name) . '
                                        </div>';
                    }
                    $return_string .=
                                    '</div>
                                </div>
                                <div class="col-sm-8 col-xxl-4 mt-3 mt-xxl-0">';
                    if ($job_category_id != '') { 
                        $job_category_link = add_query_arg(
                            'category',
                            $job_category_id,
                            $search_jobs_url
                        );
                        $return_string .=
                                    '<a 
                                        href="' . esc_url($job_category_link) . '" 
                                        class="pxp-jobs-card-3-category"
                                    >
                                        <div class="pxp-jobs-card-3-category-label">
                                            ' . esc_html($job_category[0]->name) . '
                                        </div>
                                    </a>';
                    }
                    $return_string .=
                                    '<div class="pxp-jobs-card-3-date-company">
                                        <span class="pxp-jobs-card-3-date pxp-text-light">
                                            ' . get_the_date('', $post['ID']);
                    if ($job_company != '') {
                        $return_string .=
                                            '<span class="d-inline">
                                                ' . esc_html__('by', 'jobster') . '
                                            </span>';
                    }
                    $return_string .=
                                        '</span>';
                    if ($job_company != '') {
                        $return_string .=
                                        '<a 
                                            href="' . esc_url(get_permalink($job_company_id)) . '" 
                                            class="pxp-jobs-card-3-company"
                                        >
                                            ' . esc_html($job_company->post_title) . '
                                        </a>';
                    }
                    $return_string .=
                                    '</div>
                                </div>
                                <div class="col-sm-4 col-xxl-auto mt-3 mt-xxl-0 pxp-text-right">
                                    <a 
                                        href="' . esc_url($job_link) . '" 
                                        class="btn rounded-pill pxp-card-btn"
                                    >
                                        ' . esc_html__('Apply', 'jobster') . '
                                    </a>
                                </div>
                            </div>
                        </div>';
                endforeach;
                $return_string .=
                    '</div>';
                break;
            default:
                $return_string .=
                    '<div class="row mt-4 mt-md-5 ' . esc_attr($animation) . ' ' . esc_attr($align_cards) . '">';
                foreach($posts as $post) : 
                    $job_link = get_permalink($post['ID']);

                    $job_category = wp_get_post_terms(
                        $post['ID'], 'job_category'
                    );
                    $job_category_id =  $job_category
                                        ? $job_category[0]->term_id
                                        : '';
                    $job_category_icon = 'fa fa-folder-o';
                    if ($job_category_id != '') {
                        $job_category_icon = get_term_meta(
                            $job_category_id, 'job_category_icon', true
                        );
                    }

                    $job_location = wp_get_post_terms(
                        $post['ID'], 'job_location'
                    );
                    $job_location_id = $job_location ? $job_location[0]->term_id : '';

                    $job_type = wp_get_post_terms(
                        $post['ID'], 'job_type'
                    );

                    $job_company_id = get_post_meta(
                        $post['ID'], 'job_company', true
                    );
                    $job_company =  ($job_company_id != '')
                                    ? get_post($job_company_id)
                                    : '';

                    $return_string .=
                        '<div class="col-md-6 col-xl-4 col-xxl-3 pxp-jobs-card-1-container">
                            <div class="pxp-jobs-card-1 ' . esc_attr($card_design) . '">
                                <div class="pxp-jobs-card-1-top">';
                    if ($job_category_id != '') {
                        $job_category_link = add_query_arg(
                            'category',
                            $job_category_id,
                            $search_jobs_url
                        );
                        $return_string .=
                                    '<a 
                                        href="' . esc_url($job_category_link) . '" 
                                        class="pxp-jobs-card-1-category"
                                    >
                                        <div class="pxp-jobs-card-1-category-icon">
                                            <span class="' . esc_attr($job_category_icon) . '"></span>
                                        </div>
                                        <div class="pxp-jobs-card-1-category-label">
                                            ' . esc_html($job_category[0]->name) . '
                                        </div>
                                    </a>';
                    }
                    $return_string .=
                                    '<a 
                                        href="' . esc_url($job_link) . '" 
                                        class="pxp-jobs-card-1-title"
                                    >
                                        ' . esc_html($post['post_title']) . '
                                    </a>
                                    <div class="pxp-jobs-card-1-details">';
                    if ($job_location_id != '') { 
                        $job_location_link = add_query_arg(
                            'location',
                            $job_location_id,
                            $search_jobs_url
                        );
                        $return_string .= 
                                        '<a 
                                            href="' . esc_url($job_location_link) . '" 
                                            class="pxp-jobs-card-1-location"
                                        >
                                            <span class="fa fa-globe"></span>
                                            ' . esc_html($job_location[0]->name) . '
                                        </a>';
                    }
                    if ($job_type != '') {
                        $return_string .= 
                                        '<div class="pxp-jobs-card-1-type">
                                            ' . $job_type[0]->name . '
                                        </div>';
                    }
                    $return_string .= 
                                    '</div>
                                </div>
                                <div class="pxp-jobs-card-1-bottom">
                                    <div class="pxp-jobs-card-1-bottom-left">
                                        <div class="pxp-jobs-card-1-date pxp-text-light">
                                            ' . get_the_date('', $post['ID']);
                    if ($job_company != '') {
                        $return_string .=
                                            '<span class="d-inline">
                                                ' . esc_html__('by', 'jobster') . '
                                            </span>';
                    }
                    $return_string .=
                                        '</div>';
                    if ($job_company != '') {
                        $return_string .=
                                        '<a 
                                            href="' . esc_url(get_permalink($job_company_id)) . '" 
                                            class="pxp-jobs-card-1-company"
                                        >
                                            ' . esc_html($job_company->post_title) . '
                                        </a>';
                    }
                    $return_string .=
                                    '</div>';
                    if ($job_company != '') {
                        $job_company_logo_val = get_post_meta(
                            $job_company_id,
                            'company_logo',
                            true
                        );
                        $job_company_logo = wp_get_attachment_image_src(
                            $job_company_logo_val,
                            'pxp-thmb'
                        );
                        if (is_array($job_company_logo)) {
                            $return_string .=
                                    '<a 
                                        href="' . esc_url(get_permalink($job_company_id)) . '" 
                                        class="pxp-jobs-card-1-company-logo" 
                                        style="background-image: url(' . esc_url($job_company_logo[0]) . ');"
                                    ></a>';
                        } else {
                            $job_company_name = $job_company->post_title;
                            $return_string .=
                                    '<a 
                                        href="' . esc_url(get_permalink($job_company_id)) . '" 
                                        class="pxp-jobs-card-1-company-logo pxp-no-img"
                                    >
                                        ' . esc_html($job_company_name[0]) . '
                                    </a>';
                        }
                    }
                    $return_string .=
                                '</div>
                            </div>
                        </div>';
                endforeach;
                $return_string .=
                    '</div>';
                break;
        }

        $return_string .=
                    '<div class="mt-4 mt-md-5 ' . esc_attr($animation) . ' ' . esc_attr($align_text) . '">
                        <a 
                            href="' . esc_url($search_jobs_url) . '" 
                            class="btn rounded-pill pxp-section-cta"
                        >
                            ' . esc_html__('All Job Offers', 'jobster') . '
                            <span class="fa fa-angle-right"></span>
                        </a>
                    </div>
                </div>
            </section>';


        return $return_string;
    }
endif;
?>