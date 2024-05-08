<?php
// change-outgoing-email-form-name.php

/**
 * Change Outgoing Email Form Name
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Check if the module is enabled in the settings
$em_change_outgoing_email_form_name = get_option('em_change_outgoing_email_form_name', 0);

// Check if the checkbox is enabled and input field is not empty
if ($em_change_outgoing_email_form_name == 1 && !empty(get_option('em_change_outgoing_email_form_name_text'))) {
	
	// Change the From name globally
	add_filter(
		'wp_mail_from_name',
		function ($original_email_from) {
			// Get the From name from the plugin's settings
			$new_from_name = wp_kses(get_option('em_change_outgoing_email_form_name_text'), array());
			
			// If the From name is set, return it, otherwise, return the original From name
			return !empty($new_from_name) ? $new_from_name : $original_email_from;
		}
	);
	
}