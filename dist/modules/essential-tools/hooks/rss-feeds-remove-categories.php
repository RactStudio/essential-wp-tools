<?php
// essential-wp-tools/modules/general-tools/rss-feeds-remove-categories.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Exclude a category or multiple categories from the feeds.
 */
add_action( 'pre_get_posts',  function ( $query ) {
	if ( $query->is_feed ) {
		$exclude_categories = get_option( 'exclude_feed_categories', '' );
		if ( ! empty( $exclude_categories ) ) {
			$query->set( 'cat', $exclude_categories );
		}
	}
});