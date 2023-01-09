<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_get_hero_search_jobs_form')):
    function jobster_get_hero_search_jobs_form($hero = 'animated_cards') {
        $search_submit = jobster_get_page_link('job-search.php');

        $location_tax = array( 
            'job_location'
        );
        $location_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false
        );
        $location_terms = get_terms(
            $location_tax,
            $location_args
        );

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

        if ($hero == 'animated_cards'
            || $hero == 'image_rotator'
            || $hero == 'illustration'
            || $hero == 'image_card') { ?>
            <div class="pxp-hero-form pxp-hero-form-round mt-3 mt-lg-4">
                <form 
                    class="row gx-3 align-items-center" 
                    role="search" 
                    method="get" 
                    action="<?php echo esc_url($search_submit); ?>"
                >
                    <div class="col-12 col-sm">
                        <div class="mb-3 mb-sm-0">
                            <input 
                                type="text" 
                                class="form-control" 
                                name="keywords" 
                                id="keywords" 
                                placeholder="<?php esc_attr_e('Job Title or Keyword', 'jobster'); ?>"
                            >
                        </div>
                    </div>
                    <div class="col-12 col-sm pxp-has-left-border">
                        <div class="input-group mb-3 mb-sm-0">
                            <span class="input-group-text">
                                <span class="fa fa-globe"></span>
                            </span>
                            <select 
                                class="form-select" 
                                name="location" 
                                id="location"
                            >
                                <option value="0">
                                    <?php esc_html_e('All Locations', 'jobster'); ?>
                                </option>
                                <?php foreach ($location_terms as $location_term) { ?>
                                    <option value="<?php echo esc_attr($location_term->term_id);?>">
                                        <?php echo esc_html($location_term->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-auto">
                        <button>
                            <span class="fa fa-search"></span>
                        </button>
                    </div>
                </form>
            </div>
        <?php }

        if ($hero == 'boxed') { ?>
            <div class="pxp-hero-form pxp-hero-form-round pxp-bigger mt-3 mt-lg-4">
                <form 
                    class="row gx-3 align-items-center" 
                    role="search" 
                    method="get" 
                    action="<?php echo esc_url($search_submit); ?>"
                >
                    <div class="col-12 col-md">
                        <div class="form-floating">
                            <input 
                                type="text" 
                                class="form-control pxp-has-floating-label" 
                                name="keywords" 
                                id="keywords" 
                                placeholder="<?php esc_attr_e('Job Title or Keyword', 'jobster'); ?>" 
                                value="<?php esc_attr_e('Job Title or Keyword', 'jobster'); ?>"
                            >
                            <label for="keywords">
                                <?php esc_html_e('What', 'jobster'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-md pxp-has-left-border">
                        <div class="form-floating">
                            <select 
                                class="form-select" 
                                name="location" 
                                id="location"
                            >
                                <option value="0">
                                    <?php esc_html_e('All Locations', 'jobster'); ?>
                                </option>
                                <?php foreach ($location_terms as $location_term) { ?>
                                    <option value="<?php echo esc_attr($location_term->term_id);?>">
                                        <?php echo esc_html($location_term->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <label for="pxpHeroFormLocation">
                                <?php esc_html_e('Where', 'jobster'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-md-auto">
                        <button>
                            <?php esc_html_e('Find Jobs', 'jobster'); ?>
                        </button>
                    </div>
                </form>
            </div>
        <?php }

        if ($hero == 'image_bg') { ?>
            <div class="pxp-hero-form pxp-hero-form-round pxp-large mt-4 mt-lg-5">
                <form 
                    class="row gx-3 align-items-center" 
                    role="search" 
                    method="get" 
                    action="<?php echo esc_url($search_submit); ?>"
                >
                    <div class="col-12 col-lg">
                        <div class="input-group mb-3 mb-lg-0">
                            <span class="input-group-text">
                                <span class="fa fa-search"></span>
                            </span>
                            <input 
                                type="text" 
                                class="form-control pxp-has-floating-label" 
                                name="keywords" 
                                id="keywords" 
                                placeholder="<?php esc_attr_e('Job Title or Keyword', 'jobster'); ?>"
                            >
                        </div>
                    </div>
                    <div class="col-12 col-lg pxp-has-left-border">
                        <div class="input-group mb-3 mb-lg-0">
                            <span class="input-group-text">
                                <span class="fa fa-globe"></span>
                            </span>
                            <select 
                                class="form-select" 
                                name="location" 
                                id="location"
                            >
                                <option value="0">
                                    <?php esc_html_e('All Locations', 'jobster'); ?>
                                </option>
                                <?php foreach ($location_terms as $location_term) { ?>
                                    <option value="<?php echo esc_attr($location_term->term_id);?>">
                                        <?php echo esc_html($location_term->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg pxp-has-left-border">
                        <div class="input-group mb-3 mb-lg-0">
                            <span class="input-group-text"><span class="fa fa-folder-o"></span></span>
                            <select 
                                class="form-select" 
                                name="category" 
                                id="category"
                            >
                                <option value="0">
                                    <?php esc_html_e('All Categories', 'jobster'); ?>
                                </option>
                                <?php foreach ($category_terms as $category_term) { ?>
                                    <option 
                                        value="<?php echo esc_attr($category_term->term_id);?>"
                                    >
                                        <?php echo esc_html($category_term->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-auto">
                        <button>
                            <?php esc_html_e('Find Jobs', 'jobster'); ?>
                        </button>
                    </div>
                </form>
            </div>
        <?php }

        if ($hero == 'top_search') { ?>
            <div class="pxp-search-container d-none d-xl-block">
                <div class="pxp-hero-form pxp-hero-form-round pxp-smaller">
                    <form 
                        class="row gx-3 align-items-center" 
                        role="search" 
                        method="get" 
                        action="<?php echo esc_url($search_submit); ?>"
                    >
                        <div class="col">
                            <input 
                                type="text" 
                                class="form-control pxp-has-floating-label" 
                                name="keywords" 
                                id="keywords" 
                                placeholder="<?php esc_attr_e('Job Title or Keyword', 'jobster'); ?>"
                            >
                        </div>
                        <div class="col pxp-has-left-border">
                            <select 
                                class="form-select" 
                                name="location" 
                                id="location"
                            >
                                <option value="0">
                                    <?php esc_html_e('All Locations', 'jobster'); ?>
                                </option>
                                <?php foreach ($location_terms as $location_term) { ?>
                                    <option value="<?php echo esc_attr($location_term->term_id);?>">
                                        <?php echo esc_html($location_term->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button><span class="fa fa-search"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        <?php }
    }
endif;