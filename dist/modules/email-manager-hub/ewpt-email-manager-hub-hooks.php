<?php
// essential-wp-tools/modules/email-manager-hub/ewpt-email-manager-hub-hooks.php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Add Modules Action/Hooks files
$ewpt_disable_all_email_manager_hub_options = get_option('ewpt_disable_all_email_manager_hub_options', 0);
if ($ewpt_disable_all_email_manager_hub_options != 1) {
	
	$em_change_outgoing_email_form_name = get_option('em_change_outgoing_email_form_name', 0);
	if ($em_change_outgoing_email_form_name == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/change-outgoing-email-form-name.php');
	}
	
	$em_change_outgoing_email_form_address = get_option('em_change_outgoing_email_form_address', 0);
	if ($em_change_outgoing_email_form_address == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/change-outgoing-email-form-address.php');
	}
	
}
