<?php
// essential-wp-tools/modules/social-share-hub/ewpt-social-share-hub-actions.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue Color Picker Alpha
add_action( 'admin_enqueue_scripts', function () {
	// Check if current page is the target page
	if (isset($_GET['page']) && $_GET['page'] === 'ewpt-social-share-hub') {
		// Enqueue WordPress color picker style
		wp_enqueue_style( 'wp-color-picker' );
		
		// Enqueue custom color picker script
		$color_picker_alpha_script = EWPT_PLUGIN_URL . 'inc/wp-color-picker-alpha.js';
		wp_register_script( 'ssh-wp-color-picker-alpha', $color_picker_alpha_script, array( 'wp-color-picker' ), '3.0.3', true);
		wp_enqueue_script( 'ssh-wp-color-picker-alpha' );
	}
});
