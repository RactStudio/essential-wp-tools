<?php
// limit-wp-post-revisions-number.php
/**
 * Limit WP Post Revisions Number Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Limit WP Post Revisions Number function
add_filter( 'wp_revisions_to_keep', function ($limit) {
	$post_rev_number = intval(get_option('custom_post_rev_number', 20));
	if ($post_rev_number < 2) {
		$post_rev_number = 2;
	} elseif ($post_rev_number > 200) {
		$post_rev_number = 200;
	}
	// Limit to the specified number of revisions.
	return max(2, min(200, $post_rev_number));
});