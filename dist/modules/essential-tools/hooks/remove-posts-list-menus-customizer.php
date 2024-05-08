<?php
// remove-posts-list-menus-customizer.php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Remove Posts List appearing on Appearance > Menus page and Customizer.
add_filter(
	'register_post_type_args',
	function ($args, $post_type) {
		if($post_type == 'post') {
			$args['show_in_nav_menus'] = false;
		}
		return $args;
	},
	20,
	2
);