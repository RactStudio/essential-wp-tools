<?php
// remove-frontend-styles-version.php

// Check if WordPress Version Number should be removed
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_filter(
	'style_loader_src',
    function ( $src ) {
		// Pick out the version number from scripts and styles
		if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}
);