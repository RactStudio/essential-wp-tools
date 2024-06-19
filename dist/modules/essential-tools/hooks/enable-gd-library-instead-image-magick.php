<?php
// essential-wp-tools/modules/enable-gd-library-instead-image-magick.php

/**
 * Enable GD Library instead of ImageMagick for image processing
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Use GD Library instead of ImageMagick for image processing
add_filter( 'wp_image_editors', function($editors) {
	return ['WP_Image_Editor_GD', 'WP_Image_Editor_Imagick'];
});