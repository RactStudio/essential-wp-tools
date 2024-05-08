<?php
// affix-custom-wp-login-page-logo.php

// Check if WordPress Version Number should be removed
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if ( !empty(esc_url(get_option('affix_custom_wp_login_page_logo_media'))) ) {
	add_action(
		'login_enqueue_scripts',
		function ($url) {
			$user_custom_logo_media = get_option('affix_custom_wp_login_page_logo_media');
		?>
			<style type="text/css">
				#login h1 a, .login h1 a {
				background-image: url(<?php echo esc_url($user_custom_logo_media); ?>);
				max-width:256px;
				max-height:256px;
				background-repeat: no-repeat;
				padding-bottom: 5px;
				}
			</style>
		<?php
		}
	);
}