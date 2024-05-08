<?php
// disable-wp-rest-api.php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Check if it's an AJAX or Cron call
if (wp_doing_ajax() || wp_doing_cron()) {
	return; // Do not disable REST API for AJAX or Cron calls
}

// Hook the function to the init action
add_action(
	'init',
	function () {
		// Retrieve the REST API message
		$rest_api_message = get_option('wp_rest_api_error_message_text', 'REST API has been disabled.');
		if (empty($rest_api_message)) {
			$rest_api_message = 'REST API has been disabled.';
		}
		
		// Retrieve the option value to determine where to enable "Maintenance Mode"
		$condition_value = get_option('disable_wp_rest_api_frontend_backend', 'except_admin');
		
		switch ($condition_value) {
			case 'except_admin':
				if (!current_user_can('administrator')) {
					// Except Admin
					// Disable REST API
					add_filter(
						'rest_authentication_errors',
						function() use ($rest_api_message) {
							return new WP_Error(
								'rest_disabled',
								$rest_api_message,
								array(
									'status' => rest_authorization_required_code(),
								)
							);
						}
					);
				}
				break;
			case 'except_admin_editor':
				if (!current_user_can('administrator') && !current_user_can('editor')) {
					// Except Admin, & Editor
					// Disable REST API
					add_filter(
						'rest_authentication_errors',
						function() use ($rest_api_message) {
							return new WP_Error(
								'rest_disabled',
								$rest_api_message,
								array(
									'status' => rest_authorization_required_code(),
								)
							);
						}
					);
				}
				break;
			case 'except_admin_editor_author':
				if (!current_user_can('administrator') && !current_user_can('editor') && !current_user_can('author')) {
					// Except Admin, Editor, & Author
					// Disable REST API
					add_filter(
						'rest_authentication_errors',
						function() use ($rest_api_message) {
							return new WP_Error(
								'rest_disabled',
								$rest_api_message,
								array(
									'status' => rest_authorization_required_code(),
								)
							);
						}
					);
				}
				break;
			case 'only_author':
				if (current_user_can('author')) {
					// Only Author
					// Disable REST API
					add_filter(
						'rest_authentication_errors',
						function() use ($rest_api_message) {
							return new WP_Error(
								'rest_disabled',
								$rest_api_message,
								array(
									'status' => rest_authorization_required_code(),
								)
							);
						}
					);
				}
				break;
			case 'only_contributor':
				if (current_user_can('contributor')) {
					// Only Contributor
					// Disable REST API
					add_filter(
						'rest_authentication_errors',
						function() use ($rest_api_message) {
							return new WP_Error(
								'rest_disabled',
								$rest_api_message,
								array(
									'status' => rest_authorization_required_code(),
								)
							);
						}
					);
				}
				break;
			case 'only_subscriber':
				if (current_user_can('subscriber')) {
					// Only Subscriber
					// Disable REST API
					add_filter(
						'rest_authentication_errors',
						function() use ($rest_api_message) {
							return new WP_Error(
								'rest_disabled',
								$rest_api_message,
								array(
									'status' => rest_authorization_required_code(),
								)
							);
						}
					);
				}
				break;
			case 'only_logged_in_users':
				if (is_user_logged_in()) {
					// Only Logged-in Users
					// Disable REST API
					add_filter(
						'rest_authentication_errors',
						function() use ($rest_api_message) {
							return new WP_Error(
								'rest_disabled',
								$rest_api_message,
								array(
									'status' => rest_authorization_required_code(),
								)
							);
						}
					);
				}
				break;
			case 'only_non_logged_in_users':
				if (!is_user_logged_in()) {
					// Only Non Logged-in Users
					// Disable REST API
					add_filter(
						'rest_authentication_errors',
						function() use ($rest_api_message) {
							return new WP_Error(
								'rest_disabled',
								$rest_api_message,
								array(
									'status' => rest_authorization_required_code(),
								)
							);
						}
					);
				}
				break;
			case 'all_users':
				// All Users
					// Disable REST API
					add_filter(
						'rest_authentication_errors',
						function() use ($rest_api_message) {
							return new WP_Error(
								'rest_disabled',
								$rest_api_message,
								array(
									'status' => rest_authorization_required_code(),
								)
							);
						}
					);
				break;
			default:
				// Default case, do nothing
				break;
		}
	}
);