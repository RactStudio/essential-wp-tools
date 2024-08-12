<?php
// disable-wp-admin-bar.php

// Check if WordPress Admin Bar should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Hook the function to the init action
add_action( 'init', function () {
	// Retrieve the option value to determine where to enable "Maintenance Mode"
	$condition_value = get_option('display_wp_admin_bar_except', 'except_admin');
	switch ($condition_value) {
		case 'except_admin':
			if (!current_user_can('administrator')) {
				add_filter( 'show_admin_bar', '__return_false' ); // Except Admin
			}
			break;
		case 'except_admin_editor':
			if (!current_user_can('administrator') && !current_user_can('editor')) {
				add_filter( 'show_admin_bar', '__return_false' ); // Except Admin, & Editor
			}
			break;
		case 'except_admin_editor_author':
			if (!current_user_can('administrator') && !current_user_can('editor') && !current_user_can('author')) {
				add_filter( 'show_admin_bar', '__return_false' ); // Except Admin, Editor, & Author
			}
			break;
		case 'only_author':
			if (current_user_can('author')) {
				add_filter( 'show_admin_bar', '__return_false' ); // Only Author
			}
			break;
		case 'only_contributor':
			if (current_user_can('contributor')) {
				add_filter( 'show_admin_bar', '__return_false' ); // Only Contributor
			}
			break;
		case 'only_subscriber':
			if (current_user_can('subscriber')) {
				add_filter( 'show_admin_bar', '__return_false' ); // Only Subscriber
			}
			break;
		case 'all_logged_in_users':
			if (is_user_logged_in()) {
				add_filter( 'show_admin_bar', '__return_false' ); // all Logged-in Users
			}
			break;
		default:
			// Default case, do nothing
			break;
	}
});
