<?php
// remove-pages-from-search-result.php

// Check if Pages from WordPress Search Results should be removed
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Remove pages from search results
add_action(
	'pre_get_posts',
	function () {
		if ( is_search() ) {
			global $wp_post_types;
			$wp_post_types['page']->exclude_from_search = true;
		}
	}
);