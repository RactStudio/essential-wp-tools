<?php
// essential-wp-tools/modules/general-tools/rss-feeds-publish-later.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Function to delay posts in RSS feeds
add_filter( 'posts_where', function ( $where ) {
	global $wpdb;
	if ( is_feed() ) {
		$delay_enabled = get_option( 'enable_rss_feeds_posts_delay', 0 );
		$delay_minutes = intval(get_option('rss_feeds_posts_delay_minutes', 10));
		if ($delay_minutes < 1) {
			$delay_minutes = 1;
		} elseif ($delay_minutes > 10000) {
			$delay_minutes = 10000;
		}
		
		if ( $delay_enabled ) {
			// Timestamp in WP-format.
			$now = gmdate( 'Y-m-d H:i:s' );
			// Choose time unit.
			$unit = 'MINUTE'; // MINUTE, HOUR, DAY, WEEK, MONTH, YEAR.
			// Add SQL-syntax to default $where.
			$where .= $wpdb->prepare( " AND TIMESTAMPDIFF(%s, $wpdb->posts.post_date_gmt, %s) > %d ", $unit, $now, $delay_minutes );
		}
	}
	return $where;
});