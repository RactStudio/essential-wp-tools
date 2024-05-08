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
 * Description: A must-have plugin for every WordPress site, providing essential features for security, performance, and beyond.
 * Version: 1.0.0
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
DEFINE("EWPT_VERSION_NO", "1.0.0");
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
DEFINE("EWPT_HIREUS_URL", EWPT_DASH_SHORT_URL."-hireus");
//Load All Modules Folder Array
DEFINE("EWPT_MODULES_FOLDERS_ARRAY", glob(EWPT_MODULES_PATH . '*', GLOB_ONLYDIR));
DEFINE("EWPT_MODULES_FOLDERS_COUNT", count(EWPT_MODULES_FOLDERS_ARRAY));

// Include EWPT Functions
require_once(EWPT_PLUGIN_PATH . 'inc/ewpt-functions.php');

// EWPT Dashboard page
require_once(EWPT_PLUGIN_PATH . 'admin/ewpt-admin-settings.php');

// Add Modules and it's hooks files
// Loop through each module folder
foreach (EWPT_MODULES_FOLDERS_ARRAY as $module_folder) {
	// Get the folder name without path
	$folder_name = strtolower(basename($module_folder));

	// Define the option name based on the folder name
	$option_name = "ewpt_disable_" . str_replace('-', '_', $folder_name);

	// Check if the option is set to disable the module
	if (get_option($option_name, 0) == 1) {
		
		// Construct the path to the module file
		$module_files = glob($module_folder . "/ewpt-{$folder_name}.php");
		
		// Module Functions File
		$functions_file_path = plugin_dir_path(__FILE__) . 'modules/' . $folder_name . '/ewpt-' . $folder_name . '-functions.php';
		if (file_exists($functions_file_path)) {
			include_once($functions_file_path);
		}
		
		// Include the module file if found
		foreach ($module_files as $module_file) {
			// Main Module File
			require_once($module_file);
		}
		
		// Module Hooks File
		$hooks_file_path = plugin_dir_path(__FILE__) . 'modules/' . $folder_name . '/ewpt-' . $folder_name . '-hooks.php';
		if (file_exists($hooks_file_path)) {
			include_once($hooks_file_path);
		}
		
	}
}

// EWPT Hireus page
require_once(EWPT_PLUGIN_PATH . 'admin/ewpt-hireus.php');

// EWPT Donate page
require_once(EWPT_PLUGIN_PATH . 'admin/ewpt-donate.php');


// Add action links of ewpt
add_filter(
	'plugin_action_links_' . plugin_basename(__FILE__),
	function ( $actions ) {
		$ewptActionLinks = array(
			'<a href="' . EWPT_DASH_URL . '">Settings</a>',
			'<a target="_blank" href="' . EWPT_DONATE_URL1 . '">Donate</a>',
		);
		$actions = array_merge( $ewptActionLinks, $actions  );
		return $actions;
	}
);

// Register module loading on plugin activation
register_activation_hook(
	__FILE__,
	function () {
		// Module loading on activation
		if (get_option('ewpt_auto_enabled_modules_activation_completed') !== 'yes') {
			// Auto activate modules array
			$ewpt_auto_enabled_modules = array(
				"ad-insert-hub",
				"email-manager-hub",
				"essential-tools",
				"maintenance-mode",
				"social-share-hub",
				"system-info",
			);
			
			// Sanitize and prepare the modules array
			$sanitized_modules = array_map('sanitize_key', $ewpt_auto_enabled_modules);
			
			// Check if the plugin is being activated for the first time on a network
			if (is_plugin_active_for_network(plugin_basename(__FILE__))) {
				// Enable specific modules on activation for network
				foreach ($sanitized_modules as $module) {
					$option_name = str_replace('-', '_', strtolower($module));
					update_site_option('ewpt_disable_' . $option_name, 1);
				}
			} else {
				// Enable specific modules on activation
				foreach ($sanitized_modules as $module) {
					$option_name = str_replace('-', '_', strtolower($module));
					update_option('ewpt_disable_' . $option_name, 1);
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
		
	}
);

// Register deactivation hook
register_deactivation_hook(
	__FILE__,
	function () {
		// Perform tasks on deactivation
	}
);