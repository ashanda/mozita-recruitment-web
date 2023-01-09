<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

class Elementor_Jobster_Recent_Jobs extends \Elementor\Widget_Base {
    public function get_name() {
        return 'recent_jobs';
    }

    public function get_title() {
        return __('Recent Jobs', 'jobster');
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return ['jobster'];
    }

    private function jobster_get_locations() {
        $location_taxonomies = array( 
            'job_location'
        );
        $location_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        ); 
        $location_terms = get_terms($location_taxonomies, $location_args);

        $locations = array('0' => __('All', 'jobster'));
        for ($jl = 0; $jl < count($location_terms); $jl++) {
            $locations[$location_terms[$jl]->term_id] = $location_terms[$jl]->name;
        }

        return $locations;
    }

    private function jobster_get_categories() {
        $category_taxonomies = array( 
            'job_category'
        );
        $category_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        ); 
        $category_terms = get_terms($category_taxonomies, $category_args);

        $categories = array('0' => __('All', 'jobster'));
        for ($jc = 0; $jc < count($category_terms); $jc++) {
            $categories[$category_terms[$jc]->term_id] = $category_terms[$jc]->name;
        }

        return $categories;
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'title_section',
            [
                'label' => __('Title', 'jobster'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'jobster'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'placeholder' => __('Enter title', 'jobster'),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'jobster'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'input_type' => 'string',
                'placeholder' => __('Enter subtitle', 'jobster'),
            ]
        );

        $this->add_control(
            'location',
            [
                'label' => __('Location', 'jobster'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '0',
                'options' => $this->jobster_get_locations(),
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => __('Category', 'jobster'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '0',
                'options' => $this->jobster_get_categories(),
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => __('Number of Jobs', 'jobster'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 6,
                'placeholder' => __('Enter number of jobs', 'jobster'),
            ]
        );

        $this->add_control(
            'align',
            [
                'label' => __('Align', 'jobster'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    's' => [
                        'title' => __('Start', 'jobster'),
                        'icon' => 'eicon-align-start-h',
                    ],
                    'c' => [
                        'title' => __('Center', 'jobster'),
                        'icon' => 'eicon-align-center-h',
                    ]
                ],
                'default' => 's',
                'toggle' => false
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'layout_section',
            [
                'label' => __('Layout', 'jobster'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => __('Card Type', 'jobster'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'b' => [
                        'title' => __('Big', 'jobster'),
                        'icon' => 'eicon-info-box',
                    ],
                    's' => [
                        'title' => __('Small', 'jobster'),
                        'icon' => 'eicon-call-to-action',
                    ],
                    'l' => [
                        'title' => __('List', 'jobster'),
                        'icon' => 'eicon-post-list',
                    ]
                ],
                'default' => 'b',
                'toggle' => false
            ]
        );

        $this->add_control(
            'design',
            [
                'label' => __('Card Design', 'jobster'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    's' => [
                        'title' => __('Shadow', 'jobster'),
                        'icon' => 'eicon-instagram-nested-gallery',
                    ],
                    'b' => [
                        'title' => __('Border', 'jobster'),
                        'icon' => 'eicon-minus-square-o',
                    ]
                ],
                'default' => 's',
                'toggle' => false
            ]
        );

        $this->add_control(
            'bg',
            [
                'label' => __('Background Color', 'jobster'),
                'type' => \Elementor\Controls_Manager::COLOR
            ]
        );

        $this->add_control(
            'margin',
            [
                'label' => __('Margin', 'jobster'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'jobster'),
                'label_off' => __('No', 'jobster'),
                'return_value' => 'y',
                'default' => 'y'
            ]
        );

        $this->add_control(
            'animation',
            [
                'label' => __('Reveal Animation', 'jobster'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'e',
                'options' => array(
                    'e' => __('Enabled', 'jobster'),
                    'd' => __('Disabled', 'jobster')
                )
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $data = $this->get_settings_for_display();

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

            if (isset($data['margin']) && $data['margin'] != 'y') {
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

        $posts = wp_get_recent_posts($args); ?>

        <section 
            class="<?php echo esc_attr($margin); ?> <?php echo esc_attr($section_padding); ?>" 
            style="background-color: <?php echo esc_attr($bg_color); ?>"
        >
            <div class="pxp-container">
                <?php if (isset($data['title']) && $data['title'] != '') { ?>
                    <h2 class="pxp-section-h2 <?php echo esc_attr($align_text); ?>">
                        <?php echo esc_html($data['title']); ?>
                    </h2>
                <?php }
                if (isset($data['subtitle']) && $data['subtitle'] != '') { ?>
                    <p class="pxp-text-light <?php echo esc_attr($align_text); ?>">
                        <?php echo esc_html($data['subtitle']); ?>
                    </p>
                <?php }

                switch ($data['type']) {
                    case 'b': ?>
                        <div class="row mt-4 mt-md-5 <?php echo esc_attr($animation); ?> <?php echo esc_attr($align_cards); ?>">
                            <?php foreach($posts as $post) : 
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
                                                : ''; ?>
                                <div class="col-md-6 col-xl-4 col-xxl-3 pxp-jobs-card-1-container">
                                    <div class="pxp-jobs-card-1 <?php echo esc_attr($card_design); ?>">
                                        <div class="pxp-jobs-card-1-top">
                                            <?php if ($job_category_id != '') {
                                                $job_category_link = add_query_arg(
                                                    'category',
                                                    $job_category_id,
                                                    $search_jobs_url
                                                ); ?>
                                                <a 
                                                    href="<?php echo esc_url($job_category_link); ?>" 
                                                    class="pxp-jobs-card-1-category"
                                                >
                                                    <div class="pxp-jobs-card-1-category-icon">
                                                        <span class="<?php echo esc_attr($job_category_icon); ?>"></span>
                                                    </div>
                                                    <div class="pxp-jobs-card-1-category-label">
                                                        <?php echo esc_html($job_category[0]->name); ?>
                                                    </div>
                                                </a>
                                            <?php } ?>
                                            <a 
                                                href="<?php echo esc_url($job_link); ?>" 
                                                class="pxp-jobs-card-1-title"
                                            >
                                                <?php echo esc_html($post['post_title']); ?>
                                            </a>
                                            <div class="pxp-jobs-card-1-details">
                                                <?php if ($job_location_id != '') { 
                                                    $job_location_link = add_query_arg(
                                                        'location',
                                                        $job_location_id,
                                                        $search_jobs_url
                                                    ); ?>
                                                    <a 
                                                        href="<?php echo esc_url($job_location_link); ?>" 
                                                        class="pxp-jobs-card-1-location"
                                                    >
                                                        <span class="fa fa-globe"></span>
                                                        <?php echo esc_html($job_location[0]->name); ?>
                                                    </a>
                                                <?php }
                                                if ($job_type != '') { ?>
                                                    <div class="pxp-jobs-card-1-type">
                                                        <?php echo esc_html($job_type[0]->name); ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="pxp-jobs-card-1-bottom">
                                            <div class="pxp-jobs-card-1-bottom-left">
                                                <div class="pxp-jobs-card-1-date pxp-text-light">
                                                    <?php echo get_the_date('', $post['ID']);
                                                    if ($job_company != '') { ?>
                                                        <span class="d-inline">
                                                            <?php esc_html_e('by', 'jobster'); ?>
                                                        </span>
                                                    <?php } ?>
                                                </div>
                                                <?php if ($job_company != '') { ?>
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-1-company"
                                                    >
                                                        <?php echo esc_html($job_company->post_title); ?>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                            <?php if ($job_company != '') {
                                                $job_company_logo_val = get_post_meta(
                                                    $job_company_id,
                                                    'company_logo',
                                                    true
                                                );
                                                $job_company_logo = wp_get_attachment_image_src(
                                                    $job_company_logo_val,
                                                    'pxp-thmb'
                                                );
                                                if (is_array($job_company_logo)) { ?>
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-1-company-logo" 
                                                        style="background-image: url(<?php echo esc_url($job_company_logo[0]); ?>);"
                                                    ></a>
                                                <?php } else {
                                                    $job_company_name = $job_company->post_title; ?>
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-1-company-logo pxp-no-img"
                                                    >
                                                        <?php echo esc_html($job_company_name[0]); ?>
                                                    </a>
                                                <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php break;
                    case 's': ?>
                        <div class="row mt-4 mt-md-5 <?php echo esc_attr($animation); ?> <?php echo esc_attr($align_cards); ?>">
                            <?php foreach($posts as $post) : 
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
                                                : ''; ?>
                                <div class="col-xl-6 pxp-jobs-card-2-container">
                                    <div class="pxp-jobs-card-2 <?php echo esc_attr($card_design); ?>">
                                        <div class="pxp-jobs-card-2-top">
                                            <?php if ($job_company != '') {
                                                $job_company_logo_val = get_post_meta(
                                                    $job_company_id,
                                                    'company_logo',
                                                    true
                                                );
                                                $job_company_logo = wp_get_attachment_image_src(
                                                    $job_company_logo_val,
                                                    'pxp-thmb'
                                                );
                                                if (is_array($job_company_logo)) { ?>
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-2-company-logo" 
                                                        style="background-image: url('<?php echo esc_url($job_company_logo[0]); ?>);"
                                                    ></a>
                                                <?php } else {
                                                    $job_company_name = $job_company->post_title; ?>
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-2-company-logo pxp-no-img"
                                                    >
                                                        <?php echo esc_html($job_company_name[0]); ?>
                                                    </a>
                                                <?php }
                                            } ?>
                                            <div class="pxp-jobs-card-2-info">
                                                <a 
                                                    href="<?php echo esc_url($job_link); ?>" 
                                                    class="pxp-jobs-card-2-title"
                                                >
                                                    <?php echo esc_html($post['post_title']); ?>
                                                </a>
                                                <div class="pxp-jobs-card-2-details">
                                                    <?php if ($job_location_id != '') {
                                                        $job_location_link = add_query_arg(
                                                            'location',
                                                            $job_location_id,
                                                            $search_jobs_url
                                                        ); ?>
                                                        <a 
                                                            href="<?php echo esc_url($job_location_link); ?>" 
                                                            class="pxp-jobs-card-2-location"
                                                        >
                                                            <span class="fa fa-globe"></span>
                                                            <?php echo esc_html($job_location[0]->name); ?>
                                                        </a>
                                                    <?php }
                                                    if ($job_type != '') { ?>
                                                        <div class="pxp-jobs-card-2-type">
                                                            <?php echo esc_html($job_type[0]->name); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pxp-jobs-card-2-bottom">
                                            <?php if ($job_category_id != '') {
                                                $job_category_link = add_query_arg(
                                                    'category',
                                                    $job_category_id,
                                                    $search_jobs_url
                                                ); ?>
                                                <a 
                                                    href="<?php echo esc_url($job_category_link); ?>" 
                                                    class="pxp-jobs-card-2-category"
                                                >
                                                    <div class="pxp-jobs-card-2-category-label">
                                                        <?php echo esc_html($job_category[0]->name); ?>
                                                    </div>
                                                </a>
                                            <?php } ?>
                                            <div class="pxp-jobs-card-2-bottom-right">
                                                <span class="pxp-jobs-card-2-date pxp-text-light">
                                                    <?php echo get_the_date('', $post['ID']);
                                                    if ($job_company != '') { ?>
                                                        <span class="d-inline">
                                                            <?php esc_html_e('by', 'jobster'); ?>
                                                        </span>
                                                    <?php } ?>
                                                </span>
                                                <?php if ($job_company != '') { ?>
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-2-company"
                                                    >
                                                        <?php echo esc_html($job_company->post_title); ?>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php break;
                    case 'l': ?>
                        <div class="mt-4 mt-md-5 <?php echo esc_attr($animation); ?> <?php echo esc_attr($align_cards); ?>">
                            <?php foreach($posts as $post) : 
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
                                                : ''; ?>
                                <div class="pxp-jobs-card-3 <?php echo esc_attr($card_design); ?>">
                                    <div class="row align-items-center justify-content-between">
                                        <?php if ($job_company != '') { 
                                            $job_company_logo_val = get_post_meta(
                                                $job_company_id,
                                                'company_logo',
                                                true
                                            );
                                            $job_company_logo = wp_get_attachment_image_src(
                                                $job_company_logo_val,
                                                'pxp-thmb'
                                            );
                                            if (is_array($job_company_logo)) { ?>
                                                <div class="col-sm-3 col-md-2 col-xxl-auto">
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-3-company-logo" 
                                                        style="background-image: url(<?php echo esc_url($job_company_logo[0]); ?>);"
                                                    ></a>
                                                </div>
                                            <?php } else {
                                                $job_company_name = $job_company->post_title; ?>
                                                <div class="col-sm-3 col-md-2 col-xxl-auto">
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-3-company-logo pxp-no-img"
                                                    >
                                                        <?php echo esc_html($job_company_name[0]); ?>
                                                    </a>
                                                </div>
                                            <?php }
                                        } ?>
                                        <div class="col-sm-9 col-md-10 col-xxl-4">
                                            <a 
                                                href="<?php echo esc_url($job_link); ?>" 
                                                class="pxp-jobs-card-3-title mt-3 mt-sm-0"
                                            >
                                                <?php echo esc_html($post['post_title']); ?>
                                            </a>
                                            <div class="pxp-jobs-card-3-details">
                                                <?php if ($job_location_id != '') {
                                                    $job_location_link = add_query_arg(
                                                        'location',
                                                        $job_location_id,
                                                        $search_jobs_url
                                                    ); ?>
                                                    <a 
                                                        href="<?php echo esc_url($job_location_link); ?>" 
                                                        class="pxp-jobs-card-3-location"
                                                    >
                                                        <span class="fa fa-globe"></span>
                                                        <?php echo esc_html($job_location[0]->name); ?>
                                                    </a>
                                                <?php }
                                                if ($job_type != '') { ?>
                                                    <div class="pxp-jobs-card-3-type">
                                                        <?php echo esc_html($job_type[0]->name); ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-8 col-xxl-4 mt-3 mt-xxl-0">
                                            <?php if ($job_category_id != '') { 
                                                $job_category_link = add_query_arg(
                                                    'category',
                                                    $job_category_id,
                                                    $search_jobs_url
                                                ); ?>
                                                <a 
                                                    href="<?php echo esc_url($job_category_link); ?>" 
                                                    class="pxp-jobs-card-3-category"
                                                >
                                                    <div class="pxp-jobs-card-3-category-label">
                                                        <?php echo esc_html($job_category[0]->name); ?>
                                                    </div>
                                                </a>
                                            <?php } ?>
                                            <div class="pxp-jobs-card-3-date-company">
                                                <span class="pxp-jobs-card-3-date pxp-text-light">
                                                    <?php echo get_the_date('', $post['ID']);
                                                    if ($job_company != '') { ?>
                                                        <span class="d-inline">
                                                            <?php esc_html_e('by', 'jobster'); ?>
                                                        </span>
                                                    <?php } ?>
                                                </span>
                                                <?php if ($job_company != '') { ?>
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-3-company"
                                                    >
                                                        <?php echo esc_html($job_company->post_title); ?>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xxl-auto mt-3 mt-xxl-0 pxp-text-right">
                                            <a 
                                                href="<?php echo esc_url($job_link); ?>" 
                                                class="btn rounded-pill pxp-card-btn"
                                            >
                                                <?php esc_html_e('Apply', 'jobster'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php break;
                    default: ?>
                        <div class="row mt-4 mt-md-5 <?php echo esc_attr($animation); ?> <?php echo esc_attr($align_cards); ?>">
                            <?php foreach($posts as $post) : 
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
                                                : ''; ?>
                                <div class="col-md-6 col-xl-4 col-xxl-3 pxp-jobs-card-1-container">
                                    <div class="pxp-jobs-card-1 <?php echo esc_attr($card_design); ?>">
                                        <div class="pxp-jobs-card-1-top">
                                            <?php if ($job_category_id != '') {
                                                $job_category_link = add_query_arg(
                                                    'category',
                                                    $job_category_id,
                                                    $search_jobs_url
                                                ); ?>
                                                <a 
                                                    href="<?php echo esc_url($job_category_link); ?>" 
                                                    class="pxp-jobs-card-1-category"
                                                >
                                                    <div class="pxp-jobs-card-1-category-icon">
                                                        <span class="<?php echo esc_attr($job_category_icon); ?>"></span>
                                                    </div>
                                                    <div class="pxp-jobs-card-1-category-label">
                                                        <?php echo esc_html($job_category[0]->name); ?>
                                                    </div>
                                                </a>
                                            <?php } ?>
                                            <a 
                                                href="<?php echo esc_url($job_link); ?>" 
                                                class="pxp-jobs-card-1-title"
                                            >
                                                <?php echo esc_html($post['post_title']); ?>
                                            </a>
                                            <div class="pxp-jobs-card-1-details">
                                                <?php if ($job_location_id != '') { 
                                                    $job_location_link = add_query_arg(
                                                        'location',
                                                        $job_location_id,
                                                        $search_jobs_url
                                                    ); ?>
                                                    <a 
                                                        href="<?php echo esc_url($job_location_link); ?>" 
                                                        class="pxp-jobs-card-1-location"
                                                    >
                                                        <span class="fa fa-globe"></span>
                                                        <?php echo esc_html($job_location[0]->name); ?>
                                                    </a>
                                                <?php }
                                                if ($job_type != '') { ?>
                                                    <div class="pxp-jobs-card-1-type">
                                                        <?php echo esc_html($job_type[0]->name); ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="pxp-jobs-card-1-bottom">
                                            <div class="pxp-jobs-card-1-bottom-left">
                                                <div class="pxp-jobs-card-1-date pxp-text-light">
                                                    <?php echo get_the_date('', $post['ID']);
                                                    if ($job_company != '') { ?>
                                                        <span class="d-inline">
                                                            <?php esc_html_e('by', 'jobster'); ?>
                                                        </span>
                                                    <?php } ?>
                                                </div>
                                                <?php if ($job_company != '') { ?>
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-1-company"
                                                    >
                                                        <?php echo esc_html($job_company->post_title); ?>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                            <?php if ($job_company != '') {
                                                $job_company_logo_val = get_post_meta(
                                                    $job_company_id,
                                                    'company_logo',
                                                    true
                                                );
                                                $job_company_logo = wp_get_attachment_image_src(
                                                    $job_company_logo_val,
                                                    'pxp-thmb'
                                                );
                                                if (is_array($job_company_logo)) { ?>
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-1-company-logo" 
                                                        style="background-image: url(<?php echo esc_url($job_company_logo[0]); ?>);"
                                                    ></a>
                                                <?php } else {
                                                    $job_company_name = $job_company->post_title; ?>
                                                    <a 
                                                        href="<?php echo esc_url(get_permalink($job_company_id)); ?>" 
                                                        class="pxp-jobs-card-1-company-logo pxp-no-img"
                                                    >
                                                        <?php echo esc_html($job_company_name[0]); ?>
                                                    </a>
                                                <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php break;
                } ?>

                <div class="mt-4 mt-md-5 <?php echo esc_attr($animation); ?> <?php echo esc_attr($align_text); ?>">
                    <a 
                        href="<?php echo esc_url($search_jobs_url); ?>" 
                        class="btn rounded-pill pxp-section-cta"
                    >
                        <?php esc_html_e('All Job Offers', 'jobster'); ?>
                        <span class="fa fa-angle-right"></span>
                    </a>
                </div>
            </div>
        </section>
        <?php 
    }
}
?>