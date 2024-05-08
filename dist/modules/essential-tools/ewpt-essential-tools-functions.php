<?php
// essential-wp-tools/modules/essential-tools/ewpt-essential-tools-functions.php

// Define namespace
namespace ethub;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class ethub {
	
	
	// Sanitize image sizes
	public static function sanitize_image_sizes($input) {
		$all_image_sizes = get_intermediate_image_sizes();
		// Check if input is an array
		if (!is_array($input)) {
			return [];
		}
		// Intersect arrays only if input is not empty
		if (!empty($input)) {
			$input = array_intersect($input, $all_image_sizes);
		}
		
		return $input;
	}
	
	
	// Sanitize excluded categories
	public static function sanitize_excluded_categories($input) {
		if (!is_array($input)) {
			$input = explode(',', $input);
		}
		return array_map('absint', $input);
	}
	
	
}