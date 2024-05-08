<?php
// disable-wp-editor-code-editing.php

// Check if WordPress Search should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Prevent non-admin users from using "Edit as HTML" or "Code editor" in the Gutenberg Editor.
add_filter(
	'block_editor_settings_all',
	function ( $settings ) {
		$settings['codeEditingEnabled'] = current_user_can( 'manage_options' );
		return $settings;
	}
);