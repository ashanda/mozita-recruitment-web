<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

class Elementor_Jobster_Job_Categories extends \Elementor\Widget_Base {
    public function get_name() {
        return 'job_categories';
    }

    public function get_title() {
        return __('Job Categories', 'jobster');
    }

    public function get_icon() {
        return 'eicon-folder';
    }

    public function get_categories() {
        return ['jobster'];
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
                'toggle' => false,
                'condition' => [
                    'layout' => 'g'
                ]
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
            'layout',
            [
                'label' => __('Layout', 'jobster'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'g' => [
                        'title' => __('Grid', 'jobster'),
                        'icon' => 'eicon-gallery-grid',
                    ],
                    'c' => [
                        'title' => __('Carousel', 'jobster'),
                        'icon' => 'eicon-slider-3d',
                    ]
                ],
                'default' => 'g',
                'toggle' => false,
            ]
        );

        $this->add_control(
            'card',
            [
                'label' => __('Card Design', 'jobster'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'v' => [
                        'title' => __('Vertical', 'jobster'),
                        'icon' => 'eicon-icon-box',
                    ],
                    'h' => [
                        'title' => __('Horizontal', 'jobster'),
                        'icon' => 'eicon-call-to-action',
                    ]
                ],
                'default' => 'v',
                'toggle' => false,
                'condition' => [
                    'layout' => 'g'
                ]
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Icon Background', 'jobster'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    't' => [
                        'title' => __('Transparent', 'jobster'),
                        'icon' => 'eicon-minus-square-o',
                    ],
                    'o' => [
                        'title' => __('Opaque', 'jobster'),
                        'icon' => 'eicon-square',
                    ]
                ],
                'default' => 't',
                'toggle' => false
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

        switch($data['layout']) {
            case 'g': ?>
                <section class="mt-100">
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
                        <?php } ?>
                        <div class="row mt-4 mt-md-5 <?php echo esc_attr($animation); ?> <?php echo esc_attr($align_cards); ?>">
                            <?php foreach ($category_terms as $category_term) {
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

                                if (isset($data['card']) && $data['card'] == 'h') { ?>
                                    <div class="col-lg-6 col-xxl-4 pxp-categories-card-3-container">
                                        <a 
                                            href="<?php echo esc_url($category_link); ?>" 
                                            class="pxp-categories-card-3"
                                        >
                                            <div class="pxp-categories-card-3-icon">
                                                <?php if (!empty($category_icon)) { ?>
                                                    <span class="<?php echo esc_attr($category_icon); ?>"></span>
                                                <?php } else { ?>
                                                    <span class="fa fa-folder-o"></span>
                                                <?php } ?>
                                            </div>
                                            <div class="pxp-categories-card-3-text">
                                                <div class="pxp-categories-card-3-title">
                                                    <?php echo esc_html($category_term->name); ?>
                                                </div>
                                                <div class="pxp-categories-card-3-subtitle">
                                                    <?php echo esc_html($category_term->count); ?> 
                                                    <?php esc_html_e('open positions', 'jobster'); ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-12 col-md-4 col-lg-3 col-xxl-2 <?php echo esc_attr($v_card); ?>-container">
                                        <a 
                                            href="<?php echo esc_url($category_link); ?>" 
                                            class="<?php echo esc_attr($v_card); ?>"
                                        >
                                            <div class="<?php esc_attr($v_card); ?>-icon-container">
                                                <div class="<?php echo esc_attr($v_card); ?>-icon">
                                                    <?php if (!empty($category_icon)) { ?>
                                                        <span class="<?php echo esc_attr($category_icon); ?>"></span>
                                                    <?php } else { ?>
                                                        <span class="fa fa-folder-o"></span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="<?php echo esc_attr($v_card); ?>-title">
                                                <?php echo esc_html($category_term->name); ?>
                                            </div>
                                            <div class="<?php echo esc_attr($v_card); ?>-subtitle">
                                                <?php echo esc_html($category_term->count); ?> 
                                                <?php esc_html_e('open positions', 'jobster'); ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                        <div class="mt-4 mt-md-5 <?php echo esc_attr($align_text); ?> <?php echo esc_attr($animation); ?>">
                            <a 
                                href="<?php echo esc_url($search_jobs_url); ?>" 
                                class="btn rounded-pill pxp-section-cta"
                            >
                                <?php esc_html_e('All Categories', 'jobster'); ?>
                                <span class="fa fa-angle-right"></span>
                            </a>
                        </div>
                    </div>
                </section>
                <?php break;
            case 'c': ?>
                <section class="mt-100">
                    <div class="pxp-container">
                        <div class="row justify-content-between align-items-end">
                            <div class="col-auto">
                                <?php if (isset($data['title']) && $data['title'] != '') { ?>
                                    <h2 class="pxp-section-h2">
                                        <?php echo esc_html($data['title']); ?>
                                    </h2>
                                <?php }
                                if (isset($data['subtitle']) && $data['subtitle'] != '') { ?>
                                    <p class="pxp-text-light">
                                        <?php echo esc_html($data['subtitle']); ?>
                                    </p>
                                <?php } ?>
                            </div>
                            <div class="col-auto">
                                <div class="text-right">
                                    <a 
                                        href="<?php echo esc_url($search_jobs_url); ?>" 
                                        class="btn pxp-section-cta-o"
                                    >
                                        <?php esc_html_e('All Categories', 'jobster'); ?>
                                        <span class="fa fa-angle-right"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="pxp-categories-carousel owl-carousel mt-4 mt-md-5 <?php echo esc_attr($animation); ?>">
                            <?php foreach ($category_terms as $category_term) {
                                $category_link = add_query_arg(
                                    'category',
                                    $category_term->term_id,
                                    $search_jobs_url
                                );
                                $category_icon = get_term_meta(
                                    $category_term->term_id,
                                    'job_category_icon',
                                    true
                                ); ?>

                                <a 
                                    href="<?php echo esc_url($category_link); ?>" 
                                    class="<?php echo esc_attr($v_card); ?>"
                                >
                                    <div class="<?php echo esc_attr($v_card); ?>'-icon-container">
                                        <div class="<?php echo esc_attr($v_card); ?>-icon">
                                            <?php if (!empty($category_icon)) { ?>
                                                <span class="<?php echo esc_attr($category_icon); ?>"></span>
                                            <?php } else { ?>
                                                <span class="fa fa-folder-o"></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="<?php echo esc_attr($v_card); ?>-title">
                                        <?php echo esc_html($category_term->name); ?>
                                    </div>
                                    <div class="<?php echo esc_attr($v_card); ?>-subtitle">
                                        <?php echo esc_html($category_term->count); ?> 
                                        <?php esc_html_e('open positions', 'jobster'); ?>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </section>
                <?php break;
            default: ?>
                <section class="mt-100">
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
                        <?php } ?>
                        <div class="row mt-4 mt-md-5 <?php echo esc_attr($animation); ?> <?php echo esc_attr($align_cards); ?>">
                            <?php foreach ($category_terms as $category_term) {
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

                                if (isset($data['card']) && $data['card'] == 'h') { ?>
                                    <div class="col-lg-6 col-xxl-4 pxp-categories-card-3-container">
                                        <a 
                                            href="<?php echo esc_url($category_link); ?>" 
                                            class="pxp-categories-card-3"
                                        >
                                            <div class="pxp-categories-card-3-icon">
                                                <?php if (!empty($category_icon)) { ?>
                                                    <span class="<?php echo esc_attr($category_icon); ?>"></span>
                                                <?php } else { ?>
                                                    <span class="fa fa-folder-o"></span>
                                                <?php } ?>
                                            </div>
                                            <div class="pxp-categories-card-3-text">
                                                <div class="pxp-categories-card-3-title">
                                                    <?php echo esc_html($category_term->name); ?>
                                                </div>
                                                <div class="pxp-categories-card-3-subtitle">
                                                    <?php echo esc_html($category_term->count); ?> 
                                                    <?php esc_html_e('open positions', 'jobster'); ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-12 col-md-4 col-lg-3 col-xxl-2 <?php echo esc_attr($v_card); ?>-container">
                                        <a 
                                            href="<?php echo esc_url($category_link); ?>" 
                                            class="<?php echo esc_attr($v_card); ?>"
                                        >
                                            <div class="<?php esc_attr($v_card); ?>-icon-container">
                                                <div class="<?php echo esc_attr($v_card); ?>-icon">
                                                    <?php if (!empty($category_icon)) { ?>
                                                        <span class="<?php esc_attr($category_icon); ?>"></span>
                                                    <?php } else { ?>
                                                        <span class="fa fa-folder-o"></span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="<?php echo esc_attr($v_card); ?>-title">
                                                <?php echo esc_html($category_term->name); ?>
                                            </div>
                                            <div class="<?php echo esc_attr($v_card); ?>-subtitle">
                                                <?php echo esc_html($category_term->count); ?> 
                                                <?php esc_html_e('open positions', 'jobster'); ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                        <div class="mt-4 mt-md-5 <?php echo esc_attr($align_text); ?> <?php echo esc_attr($animation); ?>">
                            <a 
                                href="<?php echo esc_url($search_jobs_url); ?>" 
                                class="btn rounded-pill pxp-section-cta"
                            >
                                <?php esc_html_e('All Categories', 'jobster'); ?>
                                <span class="fa fa-angle-right"></span>
                            </a>
                        </div>
                    </div>
                </section>
                <?php break;
        }
    }
}
?>