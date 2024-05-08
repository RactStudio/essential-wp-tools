<?php
// remove-attachments-from-search-result.php

// Check if Attachments from WordPress Search Results should be removed
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Remove attachments from search results
add_filter(
	'pre_get_posts',
	function () {
		if ( is_search() ) {
			global $wp_post_types;
			$wp_post_types['attachment']->exclude_from_search = true;
		}
	}
);