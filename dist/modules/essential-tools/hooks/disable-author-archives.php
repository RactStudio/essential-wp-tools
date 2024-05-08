<?php
// disable-author-archives.php

/**
 * Disable Author Archives Hook
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Return a 404 page for author pages if accessed directly.
add_action(
	'template_redirect',
	function () {
		if ( is_author() ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			nocache_headers();
		}
	}
);

// Remove the author links.
add_filter( 'author_link', '__return_empty_string', 1000 );
add_filter( 'the_author_posts_link', 'get_the_author', 1000, 0 );

// Remove the author pages from the WP 5.5+ sitemap.
add_filter(
		'wp_sitemaps_add_provider',
		function ( $provider, $name ) {
			if ( 'users' === $name ) {
				return false;
			}
			return $provider;
		},
		10, 2
);

// Remove admin links in the list of users.
add_filter(
	'user_row_actions',
	function ( $actions, $user ) {
		unset( $actions['view'] );
		unset( $actions['posts'] );
		return $actions;
	},
	10, 2
);