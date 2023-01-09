<?php
/**
 * @package WordPress
 * @subpackage Jobster
 */

require_once 'animated_cards.php';
require_once 'image_rotator.php';
require_once 'illustration.php';
require_once 'boxed.php';
require_once 'image_bg.php';
require_once 'top_search.php';
require_once 'image_card.php';

if (!function_exists('jobster_get_page_header')):
    function jobster_get_page_header($header_data) {
        switch ($header_data['header_type']) {
            case 'animated_cards':
                jobster_get_animated_cards_header($header_data['post_id']);
            break;
            case 'image_rotator':
                jobster_get_image_rotator_header($header_data['post_id']);
            break;
            case 'illustration':
                jobster_get_illustration_header($header_data['post_id']);
            break;
            case 'boxed':
                jobster_get_boxed_header($header_data['post_id']);
            break;
            case 'image_bg':
                jobster_get_image_bg_header($header_data['post_id']);
            break;
            case 'top_search':
                jobster_get_top_search_header($header_data['post_id']);
            break;
            case 'image_card':
                jobster_get_image_card_header($header_data['post_id']);
            break;
        }
    }
endif;
?>