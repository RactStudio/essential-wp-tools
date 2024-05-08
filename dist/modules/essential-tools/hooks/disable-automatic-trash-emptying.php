<?php
// disable-automatic-trash-emptying.php

// Check if WordPress Automatic Trash Posts Emptying should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Prevent WordPress from automatically deleting trashed posts after 30 days.
add_action(
	'init',
	function() {
		remove_action( 'wp_scheduled_delete', 'wp_scheduled_delete' );
	}
);