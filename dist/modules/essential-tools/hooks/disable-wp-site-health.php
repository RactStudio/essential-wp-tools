<?php
// disable-wp-site-health.php

// Check if Widget Blocks should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Remove Tools Submenu Item for Site Health.
add_action( 'admin_menu', function () {
	remove_submenu_page( 'tools.php', 'site-health.php' );
});

// Prevent direct access to the Site Health page.
add_action( 'current_screen', function () {
	$screen = get_current_screen();
	if ( 'site-health' === $screen->id ) {
		wp_safe_redirect( admin_url() );
		exit;
	}
});

// Disable the Site Health Dashboard Widget.
add_action( 'wp_dashboard_setup', function () {
	global $wp_meta_boxes;
	if ( isset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health'] ) ) {
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health'] );
	}
});