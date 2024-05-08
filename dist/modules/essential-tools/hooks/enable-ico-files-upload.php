<?php
// enable-ico-files-upload.php

/**
 * Enable ICO Files Upload Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Allow ICO uploads for administrator users.
add_filter(
	'upload_mimes',
	function ($upload_mimes) {
		// By default, only administrator users are allowed to add ICOs.
		// To enable more user types edit or comment the lines below but beware of
		// the security risks if you allow any user to upload ICO files.
		if (!current_user_can('administrator')) {
			return $upload_mimes;
		}
		$upload_mimes['ico']  = 'image/x-icon';
		$upload_mimes['icon']  = 'image/x-icon';
		return $upload_mimes;
	}
);

/**
 * Add ICO files mime check.
 *
 * @param array        $wp_check_filetype_and_ext Values for the extension, mime type, and corrected filename.
 * @param string       $file Full path to the file.
 * @param string       $filename The name of the file (may differ from $file due to $file being in a tmp directory).
 * @param string[]     $mimes Array of mime types keyed by their file extension regex.
 * @param string|false $real_mime The actual mime type or false if the type cannot be determined.
 */
add_filter(
	'wp_check_filetype_and_ext',
	function ($wp_check_filetype_and_ext, $file, $filename, $mimes, $real_mime) {
		if (!$wp_check_filetype_and_ext['type']) {
			$check_filetype  = wp_check_filetype($filename, $mimes);
			$ext             = $check_filetype['ext'];
			$type            = $check_filetype['type'];
			$proper_filename = $filename;
			if ($type && 0 === strpos($type, 'image/') && 'ico' !== $ext) {
				$ext  = false;
				$type = false;
			}
			$wp_check_filetype_and_ext = compact('ext', 'type', 'proper_filename');
		}
		return $wp_check_filetype_and_ext;
	},
	10,
	5
);