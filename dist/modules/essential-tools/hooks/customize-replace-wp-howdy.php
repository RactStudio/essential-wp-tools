<?php
// customize-replace-wp-howdy.php
/**
 * Replace WP Howdy Message
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Replace WP Howdy function
add_filter(
	'admin_bar_menu', 
	function ($wp_admin_bar) {
		$new_howdy = wp_kses(get_option('replace_wp_howdy_message', ''), array());
		$my_account = $wp_admin_bar->get_node('my-account');
		$wp_admin_bar->add_node(
			array(
				'id'    => 'my-account',
				'title' => str_replace('Howdy,', $new_howdy . ' ', $my_account->title),
			)
		);
	},
	25
);