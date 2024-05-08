<?php
// customize-wp-admin-footer-text.php
/**
 * Customize WP Admin Footer Text Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Customize WP Admin Footer Text function
add_filter(
	'admin_footer_text',
	function ($footer_text) {
		$custom_footer_text = wp_kses_post(get_option('customize_wp_admin_footer_text', 'Thank you for creating with <a href="https://wordpress.org/" previewlistener="true">WordPress</a>.'));
		return $custom_footer_text;
	}
);