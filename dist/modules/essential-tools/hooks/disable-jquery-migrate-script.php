<?php
// disable-jquery-migrate-script.php

/**
 * Disable jQuery Migrate Script Hook
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

add_action(
	'wp_default_scripts',
	function ( $scripts ) {
		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
			$script = $scripts->registered['jquery'];
			if ( ! empty( $script->deps ) ) {
				$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
			}
		}
	},
	150
);