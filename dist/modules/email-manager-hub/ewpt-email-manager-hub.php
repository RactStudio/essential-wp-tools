<?php
// essential-wp-tools/modules/email-manager-hub/ewpt-email-manager-hub.php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// importing the 'ewpt' class
// essential-wp-tools/inc/ewpt-functions.php
use ewpt\ewpt as ewpt;

// Register settings
add_action(
	'init',
	function () {
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'ewpt_disable_all_email_manager_hub_options', 'boolean');
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'ewpt_email_manager_hub_menu_link', 'string');
		
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'em_change_outgoing_email_form_name', 'boolean');
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'em_change_outgoing_email_form_name_text', 'string');
		
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'em_change_outgoing_email_form_address', 'boolean');
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'em_change_outgoing_email_form_address_text', 'email');
		
	}
);

// Menu of the Module
add_action(
	'admin_menu',
	function () {
		// Get the option for menu visibility
		$menu_visibility_option = get_option('ewpt_email_manager_hub_menu_link', 'sub_menu');
		// Module menu name
		$module_name = 'Email Manager Hub'; // Define the module name/title here
		ewpt::assign_modules_menu_link($menu_visibility_option, $module_name);
	}
);

// Callback function to render the settings page
if (!function_exists('ewpt_email_manager_hub_settings_page_rsmhr')) {
function ewpt_email_manager_hub_settings_page_rsmhr() {
	// Include the module config file
	include(plugin_dir_path(__FILE__) . 'ewpt-email-manager-hub-config.php');
	
?>
	
	<div class="wrap">
		
		<?php
		// Include the module header file
		include(EWPT_PLUGIN_PATH . 'inc/ewpt-modules-header.php');
		?>
		
		<!-- Tab -->
        <h2 class="nav-tab-wrapper">
			<a href="#<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="nav-tab">Settings</a>
			<a href="#emails-settings" class="nav-tab">Emails</a>
			<a href="#templates-settings" class="nav-tab">Templates</a>
            <a href="#about-module" class="nav-tab">About</a>
			<div class="nav-tab ewpt-save-button"><p class="submit"><input form="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p></div>
		</h2>
		
		<form id="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" name="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" method="post" action="options.php">
		
			<?php wp_nonce_field( sanitize_html_class(strtolower($EWPT_MODULE_VAR).'_nonce'), sanitize_html_class(strtolower($EWPT_MODULE_VAR).'_nonce') ); ?>
			<?php //settings_errors(); ?>
			<?php settings_fields(sanitize_html_class(strtolower(EWPT_SHORT_SLUG.'_'.$EWPT_MODULE_VAR.'_settings'))); ?>
			<?php do_settings_sections(sanitize_html_class(strtolower(EWPT_SHORT_SLUG.'-'.$EWPT_MODULE_SLUG))); ?>
			
			<div id="emails-settings" class="tab-content">
				<div class="tab-pane">
					
					<h3 class="ewpt-no-top-border">Emails Settings</h3>
					<table class="form-table ewpt-form">
					
						<tr valign="top">
							<th scope="row">Outgoing Email Form Name</th>
							<td>
								<label>
									<input type="checkbox" name="em_change_outgoing_email_form_name" value="1" <?php checked(get_option('em_change_outgoing_email_form_name'), 1); ?> />
									Enable
									<input type="text" name="em_change_outgoing_email_form_name_text" value="<?php echo esc_attr(get_option('em_change_outgoing_email_form_name_text', '')); ?>" />
								</label>
							</td>
							<td>
								<div class='ewpt-info-blue'>
									Change all of the outgoing email sender name
								</div>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row">Outgoing Email Form Address</th>
							<td>
								<label>
									<input type="checkbox" name="em_change_outgoing_email_form_address" value="1" <?php checked(get_option('em_change_outgoing_email_form_address'), 1); ?> />
									Enable
									<input type="email" name="em_change_outgoing_email_form_address_text" value="<?php echo esc_attr(get_option('em_change_outgoing_email_form_address_text', '')); ?>" />
								</label>
							</td>
							<td>
								<div class='ewpt-info-blue'>
									Change all of the outgoing email sender address
								</div>
							</td>
						</tr>
						
					</table>
					
					<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						<tr valign="top">
							<th scope="row">Notice:</th>
							<td>
								More options for customizing various email settings will be added here soon.<br/>
								Please sit tight and have a coffee for the time being.<br/>
								If you'd like, you can <a target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL2); ?>">share a coffee with me</a>.
							</td>
						</tr>
						
					</table>
					
				</div>
			</div>
						
			<div id="templates-settings" class="tab-content">
				<div class="tab-pane">
					
					<h3 class="ewpt-no-top-border">Email Templates</h3>
					<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">

						<tr valign="top">
							<th scope="row">Notice:</th>
							<td>
								We will soon be adding an outgoing email template customizer here.<br/>
								Please sit tight and have a coffee for the time being.<br/>
								If you'd like, you can <a target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL2); ?>">share a coffee with me</a>.
							</td>
						</tr>
						
					</table>
					
				</div>
			</div>
			
			<?php
			// Include the module about file
			include(EWPT_PLUGIN_PATH . 'inc/ewpt-about-modules.php');
			?>
			
			<div id="<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border"><?php echo esc_attr($EWPT_MODULE_NAME); ?> Settings</h3>
					
					<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						<tr valign="top">
							<th scope="row">All Options</th>
							<td>
								<label>
									<input type="checkbox" name="ewpt_disable_all_email_manager_hub_options" value="1" <?php checked(get_option('ewpt_disable_all_email_manager_hub_options', 0)) ?> />
									Disable
								</label>
							</td>
							<td>
								<div class='ewpt-info-red'>
									Disable all options action and won't load hooks files, unchecked means all actions are active.
								</div>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row">Menu Link</th>
							<td>
									<select name="ewpt_email_manager_hub_menu_link">
										<option value="sub_menu" <?php selected(get_option("ewpt_email_manager_hub_menu_link"), 'sub_menu'); ?>>Sub Menu</option>
										<option value="main_menu" <?php selected(get_option("ewpt_email_manager_hub_menu_link"), 'main_menu'); ?>>Main Menu</option>
										<option value="hidden_menu" <?php selected(get_option("ewpt_email_manager_hub_menu_link"), 'hidden_menu'); ?>>Hide Menu</option>
									</select>
							</td>
							<td>
								<div class='ewpt-info-blue'>
									'Sub Menu': Add this module settings page link inside 'EWPT Dashboard' menu.<br/>
									'Main Menu': Add this module settings page link as main menu link (standalone).<br/>
									'Hide menu': Hide this settings page link. Link only available on 'EWPT Dashboard' page.
								</div>
							</td>
						</tr>
					</table>
					
				</div>
			</div>
							
			<?php submit_button('Save Changes'); ?>
					
		</form>
		
	</div>
	
	<?php
	// Include the module footer file
	include(EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php');
	?>
	
	<?php
}

} // if (!function_exists('ewpt_email_manager_hub_settings_page_rsmhr'))