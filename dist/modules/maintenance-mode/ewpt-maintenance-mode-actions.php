<?php
// essential-wp-tools/modules/maintenance-mode/ewpt-maintenance-mode-actions.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue Color Picker Alpha
add_action( 'admin_enqueue_scripts', function () {
	// Check if current page is the target page
	if (isset($_GET['page']) && $_GET['page'] === 'ewpt-maintenance-mode') {
		// Enqueue WordPress color picker style
		wp_enqueue_style( 'wp-color-picker' );
		// Enqueue custom color picker script
		$color_picker_alpha_script = EWPT_PLUGIN_URL . 'inc/wp-color-picker-alpha.js';
		wp_register_script( 'mmhub-wp-color-picker-alpha', $color_picker_alpha_script, array( 'wp-color-picker' ), '3.0.3', true);
		wp_enqueue_script( 'mmhub-wp-color-picker-alpha' );
	}
});

$mmhub_advanced_enable = get_option('ewpt_enable_maintenance_mode_advanced_enable', 0);
// If the advanced mode is disabled (do not enqueue)
if ( empty($mmhub_advanced_enable) || $mmhub_advanced_enable == 0 ) {
	// Enqueue Code Mirror Editor
	add_action( 'admin_enqueue_scripts', function () {
		// Check if the current page is the target page
		if (isset($_GET['page']) && $_GET['page'] === 'ewpt-maintenance-mode') {
		  $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
		  wp_localize_script('jquery', 'cm_settings', $cm_settings);
			// Enqueue WordPress code mirror
		  wp_enqueue_script('wp-theme-plugin-editor');
		  wp_enqueue_style('wp-codemirror');
		}
	});
}