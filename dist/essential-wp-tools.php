<?php
// essential-wp-tools/essential-wp-tools.php

/**
 * Essential WP Tools - All-in-one solution for security, performance, and beyond.
 *
 * @package essential_wp_tools
 * @author    ractstudio, mhrubel
 * @license   GPL-2.0+
 * @link      https://ewpt.ractstudio.com/
 * @copyright 2024 RactStudio, and Mahamudul Hasan Rubel
 *
 * @wordpress-plugin
 * Plugin Name: Essential WP Tools
 * Plugin URI: https://ewpt.ractstudio.com/
 * Description: Essential WP Tools is a must-have plugin that offers everything you need to customize, optimize, secure, and enhance your WordPress website in one powerful plugin.
 * Version: 2.0.0
 * Author: RactStudio
 * Author URI: https://ractstudio.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: essential-wp-tools
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

//Defined Parameters
DEFINE("EWPT_FULL_NAME", "Essential WP Tools");
DEFINE("EWPT_SHORT_NAME", "EWPT");
DEFINE("EWPT_VERSION_NO", "2.0.0");
DEFINE("EWPT_PLUGIN_DESC", "A must-have plugin for every WordPress site, providing essential features for security, performance, and beyond.");
DEFINE("EWPT_FULL_SLUG", "essential-wp-tools");
DEFINE("EWPT_SHORT_SLUG", "ewpt");
DEFINE("EWPT_FULL_VAR", "essential_wp_tools");
DEFINE("EWPT_THIS_SITE_URL", get_site_url(__FILE__));
DEFINE("EWPT_THIS_ADMIN_URL", get_admin_url(__FILE__));
DEFINE("EWPT_PLUGIN_PATH", plugin_dir_path(__FILE__));
DEFINE("EWPT_PLUGIN_URL", plugin_dir_url(__FILE__));
DEFINE("EWPT_DASH_URL", EWPT_THIS_ADMIN_URL."admin.php?page=".EWPT_FULL_SLUG);
DEFINE("EWPT_DASH_SHORT_URL", EWPT_THIS_ADMIN_URL."admin.php?page=".EWPT_SHORT_SLUG);
DEFINE("EWPT_MODULES_PATH", EWPT_PLUGIN_PATH . 'modules/');
DEFINE("EWPT_SITE_URL", "https://ewpt.ractstudio.com/");
DEFINE("EWPT_PLUGIN_WP_URL", "https://wordpress.org/plugins/".EWPT_FULL_SLUG."/");
DEFINE("EWPT_GITHUB_REPO_URL", "https://github.com/RactStudio/".EWPT_FULL_SLUG."/");
DEFINE("EWPT_GITHUB_MODOULE_DOWNLOAD", "https://raw.githubusercontent.com/RactStudio/ewpt-modules/main/");
DEFINE("EWPT_DEV1_NAM", "RactStudio");
DEFINE("EWPT_DEV1_SHORT", "RS");
DEFINE("EWPT_DEV1_URL", "https://ractstudio.com/");
DEFINE("EWPT_DEV2_NAM", "Mahamudul Hasan Rubel");
DEFINE("EWPT_DEV2_SHORT", "MHR");
DEFINE("EWPT_DEV2_URL", "https://mhr.ractstudio.com/");
DEFINE("EWPT_MODULES_REPO_URL", EWPT_SITE_URL."modules/");
DEFINE("EWPT_UPCOMING_MODULES_URL", EWPT_SITE_URL."upcoming/");
DEFINE("EWPT_DOCS_URL", EWPT_SITE_URL."docs/");
DEFINE("EWPT_FEATURE_REQ", EWPT_SITE_URL."features/request/");
DEFINE("EWPT_DONATE_URL1", "https://www.patreon.com/RactStudio/");
DEFINE("EWPT_DONATE_URL2", "https://www.buymeacoffee.com/ractstudio/");
DEFINE("EWPT_HIREUS_URL", EWPT_DASH_SHORT_URL."-about#services");
//Load All Modules Folder Array
DEFINE("EWPT_MODULES_FOLDERS_ARRAY", glob(EWPT_MODULES_PATH . '*', GLOB_ONLYDIR));// Step 1: Initialize the array
global $EWPT_MODULES_FOLDERS_COUNT;
$EWPT_MODULES_FOLDERS_COUNT = 0;

// Include EWPT Functions
require_once(EWPT_PLUGIN_PATH . 'inc/ewpt-functions.php');

use Essential\WP\Tools\ewpt as ewpt;

// EWPT Dashboard page
require_once(EWPT_PLUGIN_PATH . 'admin/ewpt-admin-settings.php');

// Add Modules and its hooks files
// Loop through each module folder
foreach (EWPT_MODULES_FOLDERS_ARRAY as $module_folder) {
    // Get the folder name without path
    $folder_name = strtolower(basename($module_folder));

    // Define the option name based on the folder name
    $option_name = "ewpt_enable_" . str_replace('-', '_', $folder_name);

    // Construct the path to the module directory
    $module_dir = EWPT_MODULES_PATH . $folder_name . DIRECTORY_SEPARATOR;

    // Validate the module before proceeding
    if (ewpt::validate_module($module_dir, $folder_name)) {
		$EWPT_MODULES_FOLDERS_COUNT++;
		//Check if the module is active
		if (get_option($option_name, 0) == 1) {
			// Construct the path to the module file
			$module_files = glob($module_folder . "/ewpt-{$folder_name}.php");

			// Include the module files if found
			foreach ($module_files as $module_file) {
				// Main Module File
				require_once($module_file);
			}

			// Include the functions file if found
			$functions_file_path = plugin_dir_path(__FILE__) . 'modules/' . $folder_name . '/ewpt-' . $folder_name . '-functions.php';
			if (file_exists($functions_file_path)) {
				include_once($functions_file_path);
			}

			// Include the hooks file if found
			$hooks_file_path = plugin_dir_path(__FILE__) . 'modules/' . $folder_name . '/ewpt-' . $folder_name . '-hooks.php';
			if (file_exists($hooks_file_path)) {
				include_once($hooks_file_path);
			}
		}
    }
}

// EWPT About page
require_once(EWPT_PLUGIN_PATH . 'admin/ewpt-about.php');

// Include EWPT admin Actions
include(EWPT_PLUGIN_PATH . 'inc/ewpt-actions.php');

// Add action links of ewpt
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), function ( $actions ) {
	$ewptActionLinks = array(
		'<a href="' . EWPT_DASH_URL . '">Settings</a>',
		'<a target="_blank" href="' . EWPT_DONATE_URL1 . '">Donate</a>',
	);
	$actions = array_merge( $ewptActionLinks, $actions  );
	return $actions;
});

// Register module loading on plugin activation
register_activation_hook( __FILE__, function () {
	// Module loading on activation
	if (get_option('ewpt_auto_enabled_modules_activation_completed') !== 'yes') {
		// Auto activate modules array
		$ewpt_auto_enabled_modules = array(
			"ad-insert-hub",
			"essential-tools",
			"maintenance-mode",
			"social-share-hub",
			"system-info",
		);
		
		// Sanitize and prepare the modules array
		$sanitized_modules = array_map('esc_attr', $ewpt_auto_enabled_modules);
		
		// Check if the plugin is being activated for the first time on a network
		if (is_plugin_active_for_network(plugin_basename(__FILE__))) {
			// Enable specific modules on activation for network
			foreach ($sanitized_modules as $module) {
				$option_name = str_replace('-', '_', strtolower($module));
				update_site_option('ewpt_enable_' . $option_name, 1);
			}
		} else {
			// Enable specific modules on activation
			foreach ($sanitized_modules as $module) {
				$option_name = str_replace('-', '_', strtolower($module));
				update_option('ewpt_enable_' . $option_name, 1);
			}
		}
		
		// Load each module's primary options / code execution on EWPT activation ( only first time on this site)
		// Loop through each module folder
		foreach (EWPT_MODULES_FOLDERS_ARRAY as $module_folder) {
			// Get the folder name without path
			$folder_name = strtolower(basename($module_folder));
			
			// Construct the path to the module directory
			$module_dir = EWPT_MODULES_PATH . $folder_name . DIRECTORY_SEPARATOR;

			$activation_file_path = plugin_dir_path(__FILE__) . 'modules/' . $folder_name . '/lib/ewpt-' . $folder_name . '-activation.php';
			
			// Check if the activation file exists before including it
			if (file_exists($activation_file_path)) {
				// Validate the module before proceeding
				if (ewpt::validate_module($module_dir, $folder_name)) {
					include_once($activation_file_path);
				}
			}
			
		}
		
		// Update the EWPT first activated date time
		// Get the WordPress timezone
		$timezone = get_option('timezone_string');
		// Use UTC 0 if the timezone is empty
		if (empty($timezone)) {
			$timezone = 'UTC';
		}
		// Concatenate the current time and the WordPress timezone
		$timestamp_with_timezone = current_time('mysql') . ' ' . $timezone;
		// Update the site option with the timestamp including the WordPress timezone
		update_site_option('ewpt_first_activated_datetime', $timestamp_with_timezone);
		
		// Mark the activation as completed
		update_option('ewpt_auto_enabled_modules_activation_completed', 'yes');
	}
	
});

// Register deactivation hook
register_deactivation_hook( __FILE__, function () {
	// Perform tasks on deactivation
	
	// Load each module's primary options / code execution on EWPT deactivation ( each time on this site)
	// Loop through each module folder
	foreach (EWPT_MODULES_FOLDERS_ARRAY as $module_folder) {
		// Get the folder name without path
		$folder_name = strtolower(basename($module_folder));
		
		// Construct the path to the module directory
		$module_dir = EWPT_MODULES_PATH . $folder_name . DIRECTORY_SEPARATOR;

		$deactivation_file_path = plugin_dir_path(__FILE__) . 'modules/' . $folder_name . '/lib/ewpt-' . $folder_name . '-deactivation.php';
		
		// Check if the deactivation file exists before including it
		if (file_exists($deactivation_file_path)) {
			// Validate the module before proceeding
			if (ewpt::validate_module($module_dir, $folder_name)) {
				include_once($deactivation_file_path);
			}
		}
		
	}
	
});

// Action for updating all form by Ajax
add_action( 'wp_ajax_ewpt_form_submit', function () {
	// Check if nonce is set and verify it
	$nonce_key = strtolower(EWPT_SHORT_SLUG) . '_nonce';
	if (!ewpt::check_nonce( esc_attr($nonce_key) )) {
		wp_send_json_error(array('message' => '<strong>Security (nonce) verification failed!</strong><br/>Reload the page and try again.'));
		exit;
	}

	// Check if option_page is set and retrieve the option group
	if (!isset($_POST['option_page'])) {
		wp_send_json_error(array('message' => '<strong>Option page (input) not specified!</strong><br/>Reload the page and try again.'));
		exit;
	}
	
	$option_group = sanitize_text_field(wp_unslash($_POST['option_page']));

	// Get registered settings for the option group
	$registered_settings = get_registered_settings($option_group);
	
	// Initialize an empty array to store sanitized data
	$sanitized_data_array = [];

	foreach ($registered_settings as $key => $settings) {
		// Skip nonce, action, and option_page fields
		if ($key === $nonce_key || $key === 'option_page' || $key === 'action' || $key === '_wp_http_referer' || $key === '_wpnonce') {
			continue;
		}

		// Get the data type for the option
		$type = $settings['type'];

		// Check if the option is present in the form submission
		if (!isset($_POST[$key])) {
			continue;
		}

		// Sanitize the value
		$value = wp_unslash($_POST[$key]);

		// Store the sanitized value in the array
		$sanitized_data_array[$key] = $value;
	}

	// Update setting based on the option group
	ewpt::update_settings_data($sanitized_data_array, $registered_settings);
	
	// Return success response
	wp_send_json_success(array('message' => '<strong>Settings saved successfully!</strong>'));
	
});