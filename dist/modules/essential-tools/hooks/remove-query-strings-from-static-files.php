<?php
// remove-query-strings-from-static-files.php

/**
 * Remove Query Strings From Static Files Hook
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Remove Query Strings From Static Files
add_action( 'init', function () {
	add_filter( 'script_loader_src', function ( $src ) {
		$output = preg_split( "/(&ver|\?ver)/", $src );
		return $output ? $output[0] : '';
	}, 15 );
	add_filter( 'style_loader_src', function ( $src ) {
		$output = preg_split( "/(&ver|\?ver)/", $src );
		return $output ? $output[0] : '';
	}, 15 );
});