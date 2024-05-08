<?php
// limit-wp-post-revisions-number.php
/**
 * Limit WP Post Revisions Number Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Limit WP Post Revisions Number function
add_filter(
	'wp_revisions_to_keep',
	function ($limit) {
		// Get the custom number of post revisions from settings
		$custom_post_rev_number = intval(get_option('custom_post_rev_number', 20));
		// Limit to the specified number of revisions.
		return max(2, min(300, $custom_post_rev_number));
	}
);