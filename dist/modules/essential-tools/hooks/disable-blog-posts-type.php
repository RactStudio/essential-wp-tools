<?php
// disable-blog-posts-type.php

/**
 * Disable Blog Posts Type Hook
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Remove side menu
add_action( 'admin_menu', function () {
	remove_menu_page( 'edit.php' );
});

// Remove +New post in top Admin Menu Bar
add_action( 'admin_bar_menu', function ( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'new-post' );
}, 999 );

// Remove Quick Draft Dashboard Widget
add_action( 'wp_dashboard_setup', function () {
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
}, 999 );