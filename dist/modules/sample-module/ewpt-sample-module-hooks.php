<?php
// essential-wp-tools/modules/sample-module/ewpt-sample-module-hooks.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add Modules Action/Hooks files
$ewpt_disable_all_sample_module_options = get_option('ewpt_disable_all_sample_module_options', 0);
if ($ewpt_disable_all_sample_module_options != 1) {
	
	//include_once(plugin_dir_path(__FILE__) . 'hooks/the_hook.php');
	// Add more include statements for other files as needed
	
}