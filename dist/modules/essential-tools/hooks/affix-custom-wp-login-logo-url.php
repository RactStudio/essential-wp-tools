<?php
// affix-custom-wp-login-logo-url.php

// Check if WordPress Version Number should be removed
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if ( !empty(esc_url(get_option('affix_custom_wp_login_page_logo_url_link'))) ){
	add_filter(
		'login_headerurl',
		function ($url) {
			$user_custom_logo_link = get_option('affix_custom_wp_login_page_logo_url_link');
			return esc_url($user_custom_logo_link);
		}
	);
}