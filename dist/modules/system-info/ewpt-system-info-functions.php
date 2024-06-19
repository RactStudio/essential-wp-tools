<?php
// essential-wp-tools/modules/system-info/ewpt-system-info-functions.php

// Define namespace
namespace EWPT\Modules\SystemInfo;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class sysinfo {
	
	// Function to retrieve WordPress version data from the API or database
	public static function get_wp_api_version_data() {
		// Check if Wordpress API  Update Interval is enabled
		$wp_api_status = get_option('enable_system_info_wordpress_api_update', 0);
		
		if ($wp_api_status) {
			// Wordpress API  Update Interval value
			// Get the minimum and maximum number to save from user input
			$wp_api_interval = intval(get_option('custom_system_info_wordpress_api_update_interval', 5));
			// Ensure between 10 and 60
			if ($wp_api_interval < 1) {
				$wp_api_interval = 1;
			} elseif ($wp_api_interval > 60) {
				$wp_api_interval = 60;
			}
			
			// Check if saved data array exists and is valid
			$saved_data = get_option('ewpt_system_info_wp_api_connected_data_array');
			$saved_datetime = get_option('ewpt_system_info_wp_api_connected_datetime');
			
			// Check if saved data array exists and is valid
			if ($saved_data && isset($saved_data['validity']) && $saved_data['validity'] === 'valid' && (strtotime($saved_datetime) + intval($wp_api_interval) * 60) > current_time('timestamp')) {
			// If saved data array is valid and timestamp is within last {$wp_api_interval} minutes, return saved data
				return $saved_data;
			}
			
			// URL of the API endpoint
			$api_url = 'https://api.wordpress.org/core/version-check/1.7/';
			
			// Fetch JSON data from the API
			$response = wp_remote_get($api_url);
			
			// Check if the request was successful
			if (is_wp_error($response)) {
				// Return error message if request failed
				return array(
					'validity' => 'invalid',
					'current_version' => 'Unable to retrieve data!',
					'download_full' => 'Unable to retrieve data!',
					'download_no_content' => 'Unable to retrieve data!',
					'wordpress_reachable' => 'WordPress.org is not reachable'
				);
			}
			
			// Get response body
			$body = wp_remote_retrieve_body($response);
			
			// Check if the response body is valid JSON
			if (!$body || !($data = json_decode($body, true))) {
				// Return error message if JSON decoding failed
				return array(
					'validity' => 'invalid',
					'current_version' => 'Unable to retrieve data!',
					'download_full' => 'Unable to retrieve data!',
					'download_no_content' => 'Unable to retrieve data!',
					'wordpress_reachable' => 'Invalid response from WordPress.org'
				);
			}
			
			// Check if 'offers' key exists and is not empty
			if (!isset($data['offers']) || !is_array($data['offers']) || empty($data['offers'])) {
				// Return error message if 'offers' key is missing or empty
				return array(
					'validity' => 'invalid',
					'current_version' => 'Unable to retrieve data!',
					'download_full' => 'Unable to retrieve data!',
					'download_no_content' => 'Unable to retrieve data!',
					'wordpress_reachable' => 'No version offers available from WordPress.org'
				);
			}
			
			// Retrieve the first offer's data
			$offer = $data['offers'][0];
			
			// Sanitize offer data
			$sanitized_offer = array(
				'validity' => 'valid',
				'current_version' => isset($offer['current']) ? sanitize_text_field($offer['current']) : '',
				'download_full' => isset($offer['packages']['full']) ? esc_url_raw($offer['packages']['full']) : '',
				'download_no_content' => isset($offer['packages']['no_content']) ? esc_url_raw($offer['packages']['no_content']) : '',
				'wordpress_reachable' => 'WordPress.org is reachable'
			);
			
			// Update register settings with sanitized data and current datetime
			update_option('ewpt_system_info_wp_api_connected_datetime', current_time('mysql'));
			update_option('ewpt_system_info_wp_api_connected_data_array', $sanitized_offer);
			
			// Return the sanitized offer data
			return $sanitized_offer;
		} else {
				// Return error message if wp api disabled
				return array(
					'validity' => 'invalid',
					'current_version' => 'Enable (WP.org API Update Interval)',
					'download_full' => 'Enable (WP.org API Update Interval)',
					'download_no_content' => 'Enable (WP.org API Update Interval)',
					'wordpress_reachable' => 'Enable (WP.org API Update Interval)'
				);
		}
	}
	
	// Function to retrieve the WordPress version
	public static function get_wp_version() {
		// Retrieve the WordPress version
		global $wp_version;
		require_once(ABSPATH . WPINC . '/version.php'); // Include version.php to get $wp_version if not already loaded
		
		// Return the WordPress version
		return $wp_version;
	}
	
	// Function to determine the environment type
	public static function get_environment_type() {
		$site_url = site_url();
		// Check if the site URL contains 'localhost' or '127.0.0.1'
		if (strpos($site_url, 'localhost') !== false || strpos($site_url, '127.0.0.1') !== false) {
			return 'localhost';
		}
		// Check for common staging environment constants or configurations
		elseif (defined('WP_STAGING') && WP_STAGING) {
			return 'Staging';
		}
		// Check for common staging environment constants or configurations
		elseif (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE) {
			return ucwords(WP_ENVIRONMENT_TYPE);
		}
		// Check for custom environment types defined in wp-config.php
		elseif (defined('ENVIRONMENT_TYPE') && in_array(ENVIRONMENT_TYPE, ['development', 'dev', 'test', 'testing', 'custom'])) {
			return ucwords(ENVIRONMENT_TYPE);
		}
		else {
			return 'Production';
		}
	}
	
}