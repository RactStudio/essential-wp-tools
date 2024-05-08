<?php
// enable-fonts-files-upload.php

/**
 * Enable SVG Files Upload Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Allow the upload of font files (.ttf, .otf, .woff & .woff2) to WordPress media library
add_filter(
	'upload_mimes',
	function( $mimes ) {
		$mimes['woff']  = 'application/x-font-woff';
		$mimes['woff2'] = 'application/x-font-woff2';
		$mimes['ttf']   = 'application/x-font-ttf';
		$mimes['otf']   = 'application/x-font-otf';
		//$mimes['svg']   = 'image/svg+xml';
		$mimes['eot']   = 'application/vnd.ms-fontobject';
		return $mimes;
	}
);