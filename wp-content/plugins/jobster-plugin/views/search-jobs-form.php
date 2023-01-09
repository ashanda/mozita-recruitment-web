<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_get_search_jobs_form')):
    function jobster_get_search_jobs_form($pos = 'top') {
        $search_submit = jobster_get_page_link('job-search.php');

        $keywords = isset($_GET['keywords']) 
                    ? stripslashes(sanitize_text_field($_GET['keywords'])) 
                    : '';
        $location = isset($_GET['location']) 
                    ? stripslashes(sanitize_text_field($_GET['location'])) 
                    : '';
        $category = isset($_GET['category']) 
                    ? stripslashes(sanitize_text_field($_GET['category'])) 
                    : '';
        $type = isset($_GET['type']) 
                ? stripslashes(sanitize_text_field($_GET['type'])) 
                : '';
        $level = isset($_GET['level']) 
                ? stripslashes(sanitize_text_field($_GET['level'])) 
                : '';

        $sort = isset($_GET['sort'])
                ? sanitize_text_field($_GET['sort'])
                : 'newest';

        if ($pos == 'top') { ?>
            <div class="pxp-hero-form pxp-hero-form-round pxp-large mt-3 mt-lg-4">
                <form 
                    id="pxp-jobs-page-search-form" 
                    class="row gx-3 align-items-center" 
                    role="search" 
                    method="get" 
                    action="<?php echo esc_url($search_submit); ?>"
                >
                    <input 
                        type="hidden" 
                        name="sort" 
                        id="sort" 
                        value="<?php echo esc_attr($sort); ?>" 
                        autocomplete="off"
                    >
                    <input 
                        type="hidden" 
                        name="type" 
                        id="type" 
                        value="<?php echo esc_attr($type); ?>"
                    >
                    <input 
                        type="hidden" 
                        name="level" 
                        id="level" 
                        value="<?php echo esc_attr($level); ?>"
                    >
                    <div class="col-12 col-lg">

                        <!-- Keywords field -->

                        <div class="input-group mb-3 mb-lg-0">
                            <span class="input-group-text">
                                <span class="fa fa-search"></span>
                            </span>
                            <input 
                                type="text" 
                                name="keywords" 
                                id="keywords" 
                                class="form-control" 
                                value="<?php echo esc_attr($keywords); ?>"
                                placeholder="<?php esc_attr_e('Job Title or Keyword', 'jobster'); ?>"
                            >
                        </div>
                    </div>
                    <div class="col-12 col-lg pxp-has-left-border">

                        <!-- Location field -->

                        <?php $location_tax = array( 
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
                        ); ?>

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
                                    <option 
                                        value="<?php echo esc_attr($location_term->term_id);?>" 
                                        <?php selected($location == $location_term->term_id); ?>
                                    >
                                        <?php echo esc_html($location_term->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg pxp-has-left-border">

                        <!-- Category field -->

                        <?php $category_tax = array( 
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
                        ); ?>

                        <div class="input-group mb-3 mb-lg-0">
                            <span class="input-group-text">
                                <span class="fa fa-folder-o"></span>
                            </span>
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
                                        <?php selected($category == $category_term->term_id); ?>
                                    >
                                        <?php echo esc_html($category_term->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-auto">
                        <button><?php esc_html_e('Find Jobs', 'jobster') ?></button>
                    </div>
                </form>
            </div>
        <?php } else { ?>
            <div class="pxp-jobs-list-side-filter">
                <div class="pxp-list-side-filter-header d-flex d-lg-none">
                    <div class="pxp-list-side-filter-header-label">
                        <?php esc_html_e('Search Jobs', 'jobster'); ?>
                    </div>
                    <a role="button"><span class="fa fa-sliders"></span></a>
                </div>
                <div class="mt-4 mt-lg-0 d-lg-block pxp-list-side-filter-panel">
                    <form 
                        id="pxp-jobs-page-search-form" 
                        role="search" 
                        method="get" 
                        action="<?php echo esc_url($search_submit); ?>"
                    >
                        <input 
                            type="hidden" 
                            name="sort" 
                            id="sort" 
                            value="<?php echo esc_attr($sort); ?>" 
                            autocomplete="off"
                        >
                        <input 
                            type="hidden" 
                            name="type" 
                            id="type" 
                            value="<?php echo esc_attr($type); ?>"
                        >
                        <input 
                            type="hidden" 
                            name="level" 
                            id="level" 
                            value="<?php echo esc_attr($level); ?>"
                        >

                        <!-- Keywords field -->

                        <h3>
                            <?php esc_html_e('Search by Keywords', 'jobster'); ?>
                        </h3>
                        <div class="mt-2 mt-lg-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <span class="fa fa-search"></span>
                                </span>
                                <input 
                                    type="text" 
                                    name="keywords" 
                                    id="keywords" 
                                    class="form-control" 
                                    value="<?php echo esc_attr($keywords); ?>"
                                    placeholder="<?php esc_attr_e('Job Title or Keyword', 'jobster'); ?>"
                                >
                            </div>
                        </div>

                        <!-- Location field -->

                        <?php $location_tax = array( 
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
                        ); ?>

                        <h3 class="mt-3 mt-lg-4">
                            <?php esc_html_e('Location', 'jobster'); ?>
                        </h3>
                        <div class="input-group mt-2 mt-lg-3">
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
                                    <option 
                                        value="<?php echo esc_attr($location_term->term_id);?>" 
                                        <?php selected($location == $location_term->term_id); ?>
                                    >
                                        <?php echo esc_html($location_term->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Category field -->

                        <?php $category_tax = array( 
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
                        ); ?>

                        <h3 class="mt-3 mt-lg-4">
                            <?php esc_html_e('Category', 'jobster'); ?>
                        </h3>
                        <div class="input-group mt-2 mt-lg-3">
                            <span class="input-group-text">
                                <span class="fa fa-folder-o"></span>
                            </span>
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
                                        <?php selected($category == $category_term->term_id); ?>
                                    >
                                        <?php echo esc_html($category_term->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mt-3 mt-lg-4">
                            <button><?php esc_html_e('Find Jobs', 'jobster') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        <?php }
    }
endif;