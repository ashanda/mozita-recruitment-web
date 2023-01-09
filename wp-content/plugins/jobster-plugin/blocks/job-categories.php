<?php
/**
 * Job categories block
 */
if (!function_exists('jobster_job_categories_block')): 
    function jobster_job_categories_block() {
        wp_register_script(
            'jobster-job-categories-block',
            plugins_url('js/job-categories.js', __FILE__),
            array(
                'wp-blocks',
                'wp-element',
                'wp-components',
                'wp-editor',
                'wp-i18n'
            )
        );

        wp_enqueue_style(
            'jobster-job-categories-block-editor',
            plugins_url('css/job-categories.css', __FILE__),
            array('wp-edit-blocks')
        );

        register_block_type('jobster-plugin/job-categories', array(
            'editor_script' => 'jobster-job-categories-block',
            'attributes' => array(
                'data_content' => array('type' => 'string')
            ),
            'render_callback' => 'jobster_job_categories_block_render'
        ));
    }
endif;
add_action('init', 'jobster_job_categories_block');

if (!function_exists('jobster_job_categories_block_render')): 
    function jobster_job_categories_block_render($attrs, $content = null) {
        extract(shortcode_atts(array('data_content'), $attrs));

        if (!isset($attrs['data_content'])) {
            return null;
        }

        $data = json_decode(urldecode($attrs['data_content']), true);

        $animation =    isset($data['animation']) && $data['animation'] == 'e'
                    ? 'pxp-animate-in pxp-animate-in-top'
                    : '';
        $v_card =   isset($data['icon']) && $data['icon'] == 'o'
                    ? 'pxp-categories-card-1'
                    : 'pxp-categories-card-2';

        $align_text = '';
        $align_cards = '';
        if (isset($data['align']) && $data['align'] == 'c') {
            $align_text = 'text-center';
            $align_cards = 'justify-content-center';
        }

        $search_jobs_url = jobster_get_page_link('job-search.php');

        $category_tax = array( 
            'job_category'
        );
        $category_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        );
        $category_terms = get_terms(
            $category_tax,
            $category_args
        );

        $return_string = '';

        switch($data['layout']) {
            case 'g':
                $return_string .=
                    '<section class="mt-100">
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
                $return_string .=
                            '<div class="row mt-4 mt-md-5 ' . esc_attr($animation) . ' ' . esc_attr($align_cards) . '">';

                foreach ($category_terms as $category_term) {
                    $category_link = add_query_arg(
                        'category',
                        $category_term->term_id,
                        $search_jobs_url
                    );
                    $category_icon = get_term_meta(
                        $category_term->term_id,
                        'job_category_icon',
                        true
                    );

                    if (isset($data['card']) && $data['card'] == 'h') {
                        $return_string .=
                                    '<div class="col-lg-6 col-xxl-4 pxp-categories-card-3-container">
                                        <a 
                                            href="' . esc_url($category_link) . '" 
                                            class="pxp-categories-card-3"
                                        >
                                            <div class="pxp-categories-card-3-icon">';
                        if (!empty($category_icon)) {
                            $return_string .= 
                                                '<span class="' . esc_attr($category_icon) . '"></span>';
                        } else {
                            $return_string .= 
                                                '<span class="fa fa-folder-o"></span>';
                        }
                        $return_string .= 
                                            '</div>
                                            <div class="pxp-categories-card-3-text">
                                                <div class="pxp-categories-card-3-title">
                                                    ' . esc_html($category_term->name) . '
                                                </div>
                                                <div class="pxp-categories-card-3-subtitle">
                                                    ' . esc_html($category_term->count) . ' '
                                                    . esc_html__('open positions', 'jobster') . '
                                                </div>
                                            </div>
                                        </a>
                                    </div>';
                    } else {
                        $return_string .= 
                                    '<div class="col-12 col-md-4 col-lg-3 col-xxl-2 ' . esc_attr($v_card) . '-container">
                                        <a 
                                            href="' . esc_url($category_link) . '" 
                                            class="' . esc_attr($v_card) . '"
                                        >
                                            <div class="' . esc_attr($v_card) . '-icon-container">
                                                <div class="' . esc_attr($v_card) . '-icon">';
                        if (!empty($category_icon)) {
                            $return_string .= 
                                                    '<span class="' . esc_attr($category_icon) . '"></span>';
                        } else {
                            $return_string .= 
                                                    '<span class="fa fa-folder-o"></span>';
                        }
                        $return_string .= 
                                                '</div>
                                            </div>
                                            <div class="' . esc_attr($v_card) . '-title">
                                                ' . esc_html($category_term->name) . '
                                            </div>
                                            <div class="' . esc_attr($v_card) . '-subtitle">
                                                ' . esc_html($category_term->count) . ' '
                                                . esc_html__('open positions', 'jobster') . '
                                            </div>
                                        </a>
                                    </div>';
                    }
                }

                $return_string .=
                            '</div>
                            <div class="mt-4 mt-md-5 ' . esc_attr($align_text) . ' ' . esc_attr($animation) . '">
                                <a 
                                    href="' . esc_url($search_jobs_url) . '" 
                                    class="btn rounded-pill pxp-section-cta"
                                >
                                    ' . esc_html__('All Categories', 'jobster') . '
                                    <span class="fa fa-angle-right"></span>
                                </a>
                            </div>
                        </div>
                    </section>';
                break;
            case 'c':
                $return_string .= 
                    '<section class="mt-100">
                        <div class="pxp-container">
                            <div class="row justify-content-between align-items-end">
                                <div class="col-auto">';
                if (isset($data['title']) && $data['title'] != '') {
                    $return_string .=
                                    '<h2 class="pxp-section-h2">
                                        ' . esc_html($data['title']) . '
                                    </h2>';
                }
                if (isset($data['subtitle']) && $data['subtitle'] != '') {
                    $return_string .=
                                    '<p class="pxp-text-light">
                                        ' . esc_html($data['subtitle']) . '
                                    </p>';
                }
                $return_string .=
                                '</div>
                                <div class="col-auto">
                                    <div class="text-right">
                                        <a 
                                            href="' . esc_url($search_jobs_url) . '" 
                                            class="btn pxp-section-cta-o"
                                        >
                                            ' . esc_html__('All Categories', 'jobster') . '
                                            <span class="fa fa-angle-right"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="pxp-categories-carousel owl-carousel mt-4 mt-md-5 ' . esc_attr($animation) . '">';

                foreach ($category_terms as $category_term) {
                    $category_link = add_query_arg(
                        'category',
                        $category_term->term_id,
                        $search_jobs_url
                    );
                    $category_icon = get_term_meta(
                        $category_term->term_id,
                        'job_category_icon',
                        true
                    );

                    $return_string .= 
                                '<a 
                                    href="' . esc_url($category_link) . '" 
                                    class="' . esc_attr($v_card) . '"
                                >
                                    <div class="' . esc_attr($v_card) . '-icon-container">
                                        <div class="' . esc_attr($v_card) . '-icon">';
                    if (!empty($category_icon)) {
                        $return_string .= 
                                            '<span class="' . esc_attr($category_icon) . '"></span>';
                    } else {
                        $return_string .= 
                                            '<span class="fa fa-folder-o"></span>';
                    }
                    $return_string .= 
                                        '</div>
                                    </div>
                                    <div class="' . esc_attr($v_card) . '-title">
                                        ' . esc_html($category_term->name) . '
                                    </div>
                                    <div class="' . esc_attr($v_card) . '-subtitle">
                                        ' . esc_html($category_term->count) . ' '
                                        . esc_html__('open positions', 'jobster') . '
                                    </div>
                                </a>';
                }

                $return_string .=
                            '</div>
                        </div>
                    </section>';
                break;
            default: 
                $return_string .=
                    '<section class="mt-100">
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
                $return_string .=
                            '<div class="row mt-4 mt-md-5 ' . esc_attr($animation) . ' ' . esc_attr($align_cards) . '">';

                foreach ($category_terms as $category_term) {
                    $category_link = add_query_arg(
                        'category',
                        $category_term->term_id,
                        $search_jobs_url
                    );
                    $category_icon = get_term_meta(
                        $category_term->term_id,
                        'job_category_icon',
                        true
                    );

                    if (isset($data['card']) && $data['card'] == 'h') {
                        $return_string .=
                                    '<div class="col-lg-6 col-xxl-4 pxp-categories-card-3-container">
                                        <a 
                                            href="' . esc_url($category_link) . '" 
                                            class="pxp-categories-card-3"
                                        >
                                            <div class="pxp-categories-card-3-icon">';
                        if (!empty($category_icon)) {
                            $return_string .= 
                                                '<span class="' . esc_attr($category_icon) . '"></span>';
                        } else {
                            $return_string .= 
                                                '<span class="fa fa-folder-o"></span>';
                        }
                        $return_string .= 
                                            '</div>
                                            <div class="pxp-categories-card-3-text">
                                                <div class="pxp-categories-card-3-title">
                                                    ' . esc_html($category_term->name) . '
                                                </div>
                                                <div class="pxp-categories-card-3-subtitle">
                                                    ' . esc_html($category_term->count) . ' '
                                                    . esc_html__('open positions', 'jobster') . '
                                                </div>
                                            </div>
                                        </a>
                                    </div>';
                    } else {
                        $return_string .= 
                                    '<div class="col-12 col-md-4 col-lg-3 col-xxl-2 ' . esc_attr($v_card) . '-container">
                                        <a 
                                            href="' . esc_url($category_link) . '" 
                                            class="' . esc_attr($v_card) . '"
                                        >
                                            <div class="' . esc_attr($v_card) . '-icon-container">
                                                <div class="' . esc_attr($v_card) . '-icon">';
                        if (!empty($category_icon)) {
                            $return_string .= 
                                                    '<span class="' . esc_attr($category_icon) . '"></span>';
                        } else {
                            $return_string .= 
                                                    '<span class="fa fa-folder-o"></span>';
                        }
                        $return_string .= 
                                                '</div>
                                            </div>
                                            <div class="' . esc_attr($v_card) . '-title">
                                                ' . esc_html($category_term->name) . '
                                            </div>
                                            <div class="' . esc_attr($v_card) . '-subtitle">
                                                ' . esc_html($category_term->count) . ' '
                                                . esc_html__('open positions', 'jobster') . '
                                            </div>
                                        </a>
                                    </div>';
                    }
                }

                $return_string .=
                            '</div>
                            <div class="mt-4 mt-md-5 ' . esc_attr($align_text) . ' ' . esc_attr($animation) . '">
                                <a 
                                    href="' . esc_url($search_jobs_url) . '" 
                                    class="btn rounded-pill pxp-section-cta"
                                >
                                    ' . esc_html__('All Categories', 'jobster') . '
                                    <span class="fa fa-angle-right"></span>
                                </a>
                            </div>
                        </div>
                    </section>';
                break;
        }

        return $return_string;
    }
endif;
?>