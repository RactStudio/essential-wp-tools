<?php
// remove-frontend-scripts-version.php

// Check if WordPress Version Number should be removed
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Pick out the version number from scripts and styles
add_filter(
	'script_loader_src', 
    function ( $src ) {
		if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}
);