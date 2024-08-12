<?php
// remove-posts-from-search-result.php

// Check if Posts from WordPress Search Results should be removed
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Remove posts from search results
add_action( 'pre_get_posts', function () {
	if ( is_search() ) {
		global $wp_post_types;
		$wp_post_types['post']->exclude_from_search = true;
	}
});