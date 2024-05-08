<?php
// essential-wp-tools/modules/hooks/disable-big-image-threshold.php

/**
 * Disable Big Image Threshold Errors
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Disable Big Image Threshold Errors
add_filter( 'big_image_size_threshold', '__return_false' );