<?php
// change-outgoing-email-form-address.php

/**
 * Change Outgoing Email Form Address
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Check if the module is enabled in the settings
$em_change_outgoing_email_form_address = get_option('em_change_outgoing_email_form_address', 0);

// Check if the checkbox is enabled and if a valid email address is provided
if ($em_change_outgoing_email_form_address == 1 && is_email(get_option('em_change_outgoing_email_form_address_text'))) {
	
	// Change the From address globally
	add_filter(
		'wp_mail_from',
		function ($original_email_address) {
			// Get the email address from the plugin's settings
			$new_email_address = is_email(get_option('em_change_outgoing_email_form_address_text'));
			
			// If the email address is set and valid, return it, otherwise, return the original address
			return !empty($new_email_address) && $new_email_address ? $new_email_address : $original_email_address;
		}
	);
	
}