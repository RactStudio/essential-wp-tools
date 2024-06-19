<?php
// disable-auto-generated-images-sizes.php

/**
 * Disable Auto Generated Images Sizes Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Get the selected image sizes from settings
$ewpt_enable_selected_image_sizes = get_option('enable_selected_image_sizes', []);

// Ensure $ewpt_enable_selected_image_sizes is always an array
if (!is_array($ewpt_enable_selected_image_sizes)) {
	$ewpt_enable_selected_image_sizes = [];
}

// Disable Auto Generated Images Sizes
add_filter( 'intermediate_image_sizes_advanced', function ($sizes) {
	global $ewpt_enable_selected_image_sizes;
	
	if (!is_array($ewpt_enable_selected_image_sizes)) {
		$ewpt_enable_selected_image_sizes = [];
	}
	
	foreach ($sizes as $size => $value) {
		if (!in_array($size, $ewpt_enable_selected_image_sizes)) {
			unset($sizes[$size]);
		}
	}

	return $sizes;
});

// Remove all other Images Sizes
add_action( 'init', function () {
	global $ewpt_enable_selected_image_sizes;
	
	if (!is_array($ewpt_enable_selected_image_sizes)) {
		$ewpt_enable_selected_image_sizes = [];
	}
	
	foreach ($ewpt_enable_selected_image_sizes as $size) {
		remove_image_size($size);
	}
});

add_filter('big_image_size_threshold', '__return_false');