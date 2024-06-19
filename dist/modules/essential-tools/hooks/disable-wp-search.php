<?php
// disable-wp-search.php

// Check if WordPress Search should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Prevent search queries.
add_action 'parse_query', function ( $query, $error = true ) {
	if ( is_search() && ! is_admin() ) {
		$query->is_search       = false;
		$query->query_vars['s'] = false;
		$query->query['s']      = false;
		if ( true === $error ) {
			$query->is_404 = true;
		}
	}
}, 15, 2 );

// Remove the Search Widget.
add_action( 'widgets_init', function () {
	unregister_widget( 'WP_Widget_Search' );
});

// Remove the search form.
add_filter( 'get_search_form', '__return_empty_string', 999 );

// Remove the core search block.
add_action( 'init', function () {
	if ( ! function_exists( 'unregister_block_type' ) || ! class_exists( 'WP_Block_Type_Registry' ) ) {
		return;
	}
	$block = 'core/search';
	if ( WP_Block_Type_Registry::get_instance()->is_registered( $block ) ) {
		unregister_block_type( $block );
	}
});

// Remove admin bar menu search box.
add_action( 'admin_bar_menu', function ( $wp_admin_bar ) {
	$wp_admin_bar->remove_menu( 'search' );
}, 11 );