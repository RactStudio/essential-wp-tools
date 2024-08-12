<?php
// essential-wp-tools/modules/social-share-hub/ewpt-social-share-hub-actions.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

// Check if current page is the target page
if (isset($_GET['page']) && $_GET['page'] === 'ewpt-social-share-hub') {
	
	// Enqueue EWPT Admin Assets
	ewpt::enqueue_ewpt_admin_assets();

	// Enqueue Color Picker Alpha
	add_action( 'admin_enqueue_scripts', function () {
		// Enqueue WordPress color picker style
		wp_enqueue_style( 'wp-color-picker' );
		// Enqueue custom color picker script (footer)
		$color_picker_alpha_script = EWPT_PLUGIN_URL . 'inc/wp-color-picker-alpha.min.js';
		wp_register_script( 'ssh-wp-color-picker-alpha', $color_picker_alpha_script, array( 'wp-color-picker' ), '3.0.3', true);
		wp_enqueue_script( 'ssh-wp-color-picker-alpha' );
	});

}

$ewpt_disable_all_social_share_hub_options = get_option('ewpt_disable_all_social_share_hub_options');
if ($ewpt_disable_all_social_share_hub_options != 1 && !is_admin()) {

    add_action('wp_enqueue_scripts', function () {
        // Social Share Hub Frontend Style (header)
        wp_register_style('ewpt-ssh-style', plugin_dir_url(__FILE__) . 'inc/css/ssh-style.min.css', array(), '1.0.0');
        wp_enqueue_style('ewpt-ssh-style');

        // Social Share Hub Frontend Script (footer)
        wp_register_script('ewpt-ssh-script', plugin_dir_url(__FILE__) . 'inc/js/ssh-script.min.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('ewpt-ssh-script');
    });

}
