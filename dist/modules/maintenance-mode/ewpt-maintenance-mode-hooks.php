<?php
// essential-wp-tools/modules/maintenance-mode/ewpt-maintenance-mode-hooks.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add Modules Action/Hooks files
$ewpt_maintenance_mode_status_enable = get_option('ewpt_maintenance_mode_status_enable', 0);
if ( $ewpt_maintenance_mode_status_enable == 1 && ! is_admin() ) {
	
	add_action( 'init', function () {
		// Enable Maintenance Mode
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-maintenance-mode.php');
	});
	
}