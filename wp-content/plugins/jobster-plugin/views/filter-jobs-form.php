<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

if (!function_exists('jobster_get_filter_jobs_form')):
    function jobster_get_filter_jobs_form($pos = 'top', $has_margin = false) {
        $type = isset($_GET['type']) 
                ? stripslashes(sanitize_text_field($_GET['type'])) 
                : '';
        $level = isset($_GET['level']) 
                ? stripslashes(sanitize_text_field($_GET['level'])) 
                : '';

        if ($pos == 'top') { 
            $margin_class = '';
            if ($has_margin) {
                $margin_class = 'mt-4 mt-lg-0';
            } ?>
            <div class="pxp-hero-form-filter pxp-has-bg-color <?php echo esc_attr($margin_class); ?>">
                <div class="row justify-content-start">

                    <!-- Type of employment field -->

                    <?php $type_tax = array( 
                        'job_type'
                    );
                    $type_args = array(
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hide_empty' => false
                    );
                    $type_terms = get_terms(
                        $type_tax,
                        $type_args
                    );

                    if (count($type_terms) > 0) { ?>
                        <div class="col-12 col-sm-auto">
                            <div class="mb-3 mb-lg-0">
                                <select 
                                    name="pxp-jobs-page-type" 
                                    id="pxp-jobs-page-type" 
                                    class="form-select"
                                >
                                    <option value="">
                                        <?php esc_html_e('Type of employment', 'jobster') ?>
                                    </option>
                                    <?php foreach ($type_terms as $type_term) { ?>
                                        <option 
                                            value="<?php echo esc_attr($type_term->term_id); ?>"
                                            <?php selected(
                                                $type_term->term_id,
                                                $type
                                            ); ?>
                                        >
                                            <?php echo esc_html($type_term->name); ?> (<?php echo esc_html($type_term->count); ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- Experience level field -->

                    <?php $level_tax = array( 
                        'job_level'
                    );
                    $level_args = array(
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hide_empty' => false
                    );
                    $level_terms = get_terms(
                        $level_tax,
                        $level_args
                    ); 

                    if (count($level_terms) > 0) { ?>
                        <div class="col-12 col-sm-auto">
                            <div class="mb-3 mb-lg-0">
                                <select 
                                    name="pxp-jobs-page-level" 
                                    id="pxp-jobs-page-level" 
                                    class="form-select"
                                >
                                    <option value="">
                                        <?php esc_html_e('Experience level', 'jobster') ?>
                                    </option>
                                    <?php foreach ($level_terms as $level_term) { ?>
                                        <option 
                                            value="<?php echo esc_attr($level_term->term_id); ?>"
                                            <?php selected(
                                                $level_term->term_id,
                                                $level
                                            ); ?>
                                        >
                                            <?php echo esc_html($level_term->name); ?> (<?php echo esc_html($level_term->count); ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } else { 
            $margin_class = '';
            if ($has_margin) {
                $margin_class = 'mt-3 mt-lg-4';
            } ?>
            <div class="pxp-jobs-list-side-filter <?php echo esc_attr($margin_class); ?>">
                <div class="pxp-list-side-filter-header d-flex d-lg-none">
                    <div class="pxp-list-side-filter-header-label">
                        <?php esc_html_e('Filter Jobs', 'jobster'); ?>
                    </div>
                    <a role="button"><span class="fa fa-sliders"></span></a>
                </div>
                <div class="mt-4 mt-lg-0 d-lg-block pxp-list-side-filter-panel">

                    <!-- Type of employment field -->

                    <?php $type_tax = array( 
                        'job_type'
                    );
                    $type_args = array(
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hide_empty' => false
                    );
                    $type_terms = get_terms(
                        $type_tax,
                        $type_args
                    ); 

                    $types = explode(',', $type);

                    if (count($type_terms) > 0) { ?>
                        <h3><?php esc_html_e('Type of Employment', 'jobster'); ?></h3>
                        <div class="list-group mt-2 mt-lg-3">
                            <?php $count_types = 0;
                            foreach ($type_terms as $type_term) {
                                $type_label_default_classes = array(
                                    'list-group-item',
                                    'd-flex',
                                    'justify-content-between',
                                    'align-items-center'
                                );
                                if (in_array($type_term->term_id, $types)) {
                                    array_push($type_label_default_classes, 'pxp-checked');
                                }
                                if ($count_types > 0) {
                                    array_push($type_label_default_classes, 'mt-2 mt-lg-3');
                                }
                                $type_label_classes = implode(' ', $type_label_default_classes); ?>

                                <label 
                                    for="pxp-jobs-page-type-<?php echo esc_attr($type_term->term_id); ?>"
                                    class="<?php echo esc_attr($type_label_classes); ?>"
                                >
                                    <span class="d-flex">
                                        <input 
                                            class="form-check-input me-2 pxp-jobs-page-type" 
                                            type="checkbox" 
                                            id="pxp-jobs-page-type-<?php echo esc_attr($type_term->term_id); ?>" 
                                            value="<?php echo esc_attr($type_term->term_id); ?>" 
                                            <?php checked(
                                                in_array(
                                                    $type_term->term_id,
                                                    $types
                                                )
                                            ); ?>
                                        >
                                        <?php echo esc_html($type_term->name); ?>
                                    </span>
                                    <span class="badge rounded-pill">
                                        <?php echo esc_html($type_term->count); ?>
                                    </span>
                                </label>
                                <?php $count_types++;
                            } ?>
                        </div>
                    <?php } ?>

                    <!-- Level field -->

                    <?php $level_tax = array( 
                        'job_level'
                    );
                    $level_args = array(
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hide_empty' => false
                    );
                    $level_terms = get_terms(
                        $level_tax,
                        $level_args
                    ); 

                    $levels = explode(',', $level);

                    if (count($level_terms) > 0) { ?>
                        <h3 class="mt-3 mt-lg-4"><?php esc_html_e('Experience Level', 'jobster'); ?></h3>
                        <div class="list-group mt-2 mt-lg-3">
                            <?php $count_levels = 0;
                            foreach ($level_terms as $level_term) {
                                $level_label_default_classes = array(
                                    'list-group-item',
                                    'd-flex',
                                    'justify-content-between',
                                    'align-items-center'
                                );
                                if (in_array($level_term->term_id, $levels)) {
                                    array_push($level_label_default_classes, 'pxp-checked');
                                }
                                if ($count_levels > 0) {
                                    array_push($level_label_default_classes, 'mt-2 mt-lg-3');
                                }
                                $level_label_classes = implode(' ', $level_label_default_classes); ?>

                                <label 
                                    for="pxp-jobs-page-level-<?php echo esc_attr($level_term->term_id); ?>"
                                    class="<?php echo esc_attr($level_label_classes); ?>"
                                >
                                    <span class="d-flex">
                                        <input 
                                            class="form-check-input me-2 pxp-jobs-page-level" 
                                            type="checkbox" 
                                            id="pxp-jobs-page-level-<?php echo esc_attr($level_term->term_id); ?>" 
                                            value="<?php echo esc_attr($level_term->term_id); ?>" 
                                            <?php checked(
                                                in_array(
                                                    $level_term->term_id,
                                                    $levels
                                                )
                                            ); ?>
                                        >
                                        <?php echo esc_html($level_term->name); ?>
                                    </span>
                                    <span class="badge rounded-pill">
                                        <?php echo esc_html($level_term->count); ?>
                                    </span>
                                </label>
                                <?php $count_levels++;
                            } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
    }
endif;