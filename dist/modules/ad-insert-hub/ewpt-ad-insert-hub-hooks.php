<?php
// essential-wp-tools/modules/ad-insert-hub/ewpt-ad-insert-hub-hooks.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add Modules Action/Hooks files
$ewpt_disable_all_ad_insert_hub_options = get_option('ewpt_disable_all_ad_insert_hub_options');
if ($ewpt_disable_all_ad_insert_hub_options != 1 && !is_admin()) {
	
	// Array to keep track of included hook files
	$included_hook_files = array();
	
	// The hooks to display content based on user settings
	$hook_files = array(
		'the_content_hook.php',
	);
	
	foreach ($hook_files as $hook_file) {
		$file_path = plugin_dir_path(__FILE__) . 'hooks/' . $hook_file;
		if (file_exists($file_path) && !in_array($file_path, $included_hook_files)) {
			include_once($file_path);
			$included_hook_files[] = $file_path;
		}
	}
	
	if (get_option("ewpt_enable_all_ads_shortcodes", 0) == 1) {
		// Include the ads shortcode generator file
		include_once (plugin_dir_path(__FILE__) . 'ewpt-ad-insert-hub-shortcodes-generator.php');
	}
	
}
