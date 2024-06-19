<?php
// essential-wp-tools/modules/maintenance-mode/ewpt-maintenance-mode.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

// Register settings
add_action( 'init', function () {
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'ewpt_maintenance_mode_status_enable', 'boolean');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'ewpt_maintenance_mode_menu_link', 'string');
	
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'display_wp_maintenance_mode_except', 'string');
	
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'ewpt_enable_maintenance_mode_advanced_enable', 'boolean');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'ewpt_enable_maintenance_mode_upcoming_features_enable', 'boolean');
	
	// SEO
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_meta_title_enable', 'boolean');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_meta_title', 'string');
	
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_meta_description_enable', 'boolean');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_meta_description', 'string');
	
	// Global Styles
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_global_background', 'color');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_global_color', 'color');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_global_margin', 'integer');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_global_padding', 'integer');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_global_align', 'string');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_global_font', 'string');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_global_size', 'integer');
	
	
	// Page Design
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_logo_enable', 'boolean');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_logo_media_link', 'url');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_logo_media_width', 'integer');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_logo_media_height', 'integer');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_logo_media_align', 'string');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_logo_url_enable', 'boolean');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_logo_url', 'url');
	
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_h1_text_enable', 'boolean');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_h1_text_align', 'string');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_h1_text_size', 'integer');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_h1_text_color', 'color');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_h1_text', 'string');
	
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_paragraph_enable', 'boolean');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_paragraph_text_align', 'string');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_paragraph_text_size', 'integer');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_paragraph_text_color', 'color');
	ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_paragraph_text', 'html_post');
	
	$advanced_enable = get_option('ewpt_enable_maintenance_mode_advanced_enable', 0);
	// Do not update the options, if the advanced mode is disabled (would remove saved data)
	if ( empty($advanced_enable) || $advanced_enable == 0 ) {
		//HTML Text
		ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_html_enable', 'boolean');
		ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_html_placement', 'string');
		ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_html_text', 'html_raw');
		// Style and Scripts
		ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_styles_scripts_enable', 'boolean');
		ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_styles_scripts_placement', 'string');
		ewpt::register_setting_data('ewpt_maintenance_mode_settings', 'maintenance_mode_styles_scripts_text', 'html_raw');
	}
});

// Menu of the Module
add_action( 'admin_menu', function () {
	// Get the option for menu visibility
	$menu_visibility_option = get_option('ewpt_maintenance_mode_menu_link', 'sub_menu');
	// Module menu name parameters
	$module_name = 'Maintenance Mode'; // Define the module name/title here
	ewpt::assign_modules_menu_link($menu_visibility_option, $module_name);
});

// Function to render the Maintenance Mode settings page
if (!function_exists('ewpt_maintenance_mode_settings_page')) {
function ewpt_maintenance_mode_settings_page() {
    // Include the module config file
	include(plugin_dir_path(__FILE__) . 'ewpt-maintenance-mode-config.php');
?>

	<div id="ewpt-page-header" class="ewpt-page-header">
	
		<?php
		// Include the module header file
		include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-header.php';
		?>
		
	</div>
	
	<div id="ewpt-page-main" class="wrap ewpt-page-main">

		<div id="ewpt-page-body" class="ewpt-page-body">
			
			<h1>
			
				<!-- Show Mask -->
				<div id="ewpt-mask"></div>
				
				<?php
				// Include the module header file
				include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-header-sub.php';
				?>
				
			</h1>
	
			<!-- Tab -->
			<h2 class="nav-tab-wrapper">
				<a href="#<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="nav-tab">Settings</a>
				<a href="#mmhub-design" class="nav-tab">Page Design</a>
				<a href="#mmhub-seo" class="nav-tab">SEO</a>
				<?php
				$advanced_enable = get_option('ewpt_enable_maintenance_mode_advanced_enable', 0);
				if ( empty($advanced_enable) || $advanced_enable == 0 ) { ?>
				<a href="#mmhub-advanced" class="nav-tab">Advanced</a>
				<?php } ?>
				<?php
				$upcoming_features_enable = get_option('ewpt_enable_maintenance_mode_upcoming_features_enable', 0);
				if ( empty($upcoming_features_enable) || $upcoming_features_enable == 0 ) { ?>
				<a href="#upcoming-features" class="nav-tab">Upcoming Features</a>
				<?php } ?>
				<a href="#about-module" class="nav-tab">About</a>
				<div class="nav-tab ewpt-save-button"><p class="submit"><input form="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p></div>
			</h2>
			
			<form id="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" name="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" method="post" action="options.php">
			
				<?php wp_nonce_field( esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce'), esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce') ); ?>
				<?php //settings_errors(); ?>
				<?php settings_fields(esc_attr(strtolower(EWPT_SHORT_SLUG.'_'.$EWPT_MODULE_VAR.'_settings'))); ?>
				<?php //do_settings_sections(esc_attr(strtolower(EWPT_SHORT_SLUG.'_'.$EWPT_MODULE_VAR.'_settings'))); ?>
				<?php //do_settings_sections(esc_attr(strtolower(EWPT_SHORT_SLUG.'-'.$EWPT_MODULE_SLUG))); ?>
				
				<div id="<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="tab-content">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border"><?php echo esc_attr($EWPT_MODULE_NAME); ?> Settings</h3>
						
						<table class="form-table ewpt-form ewpt-form-border-bottom">
							<tr valign="top">
								<th scope="row">Maintenance Mode</th>
								<td>
									<label>
										<input type="checkbox" name="ewpt_maintenance_mode_status_enable" value="1" <?php checked(get_option('ewpt_maintenance_mode_status_enable', 0)) ?> />
										Enable
									</label>
									<label>
										<select name="display_wp_maintenance_mode_except">
											<option value="except_admin" <?php selected(get_option("display_wp_maintenance_mode_except"), 'except_admin'); ?>>Except Admin</option>
											<option value="except_admin_editor" <?php selected(get_option("display_wp_maintenance_mode_except"), 'except_admin_editor'); ?>>Except Admin, & Editor</option>
											<option value="except_admin_editor_author" <?php selected(get_option("display_wp_maintenance_mode_except"), 'except_admin_editor_author'); ?>>Except Admin, Editor, & Author</option>
											<option value="only_author" <?php selected(get_option("display_wp_maintenance_mode_except"), 'only_author'); ?>>Only Author</option>
											<option value="only_contributor" <?php selected(get_option("display_wp_maintenance_mode_except"), 'only_contributor'); ?>>Only Contributor</option>
											<option value="only_subscriber" <?php selected(get_option("display_wp_maintenance_mode_except"), 'only_subscriber'); ?>>Only Subscriber</option>
											<option value="only_logged_in_users" <?php selected(get_option("display_wp_maintenance_mode_except"), 'only_logged_in_users'); ?>>Only Logged-in Users</option>
											<option value="only_non_logged_in_users" <?php selected(get_option("display_wp_maintenance_mode_except"), 'only_non_logged_in_users'); ?>>Only Non Logged-in Users</option>
											<option value="all_users" <?php selected(get_option("display_wp_maintenance_mode_except"), 'all_users'); ?>>All Users</option>
										</select>
									</label>
								</td>
								<td>
									<div class='ewpt-info-red'>
										Enable "Maintenance Mode" for 'all visitors' (everyone) or based on various users roles combination.<br/>
										<strong>Note: Caching plugins / CDN might interrupt the "Maintenance Mode" being enabled. Make sure to disable them.</strong>
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Menu Link</th>
								<td>
										<select name="ewpt_maintenance_mode_menu_link">
											<option value="sub_menu" <?php selected(get_option("ewpt_maintenance_mode_menu_link"), 'sub_menu'); ?>>Sub Menu</option>
											<option value="main_menu" <?php selected(get_option("ewpt_maintenance_mode_menu_link"), 'main_menu'); ?>>Main Menu</option>
											<option value="hidden_menu" <?php selected(get_option("ewpt_maintenance_mode_menu_link"), 'hidden_menu'); ?>>Hide Menu</option>
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
						
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
							<tr valign="top">
								<th scope="row">Advanced Mode</th>
								<td>
									<label>
										<input type="checkbox" name="ewpt_enable_maintenance_mode_advanced_enable" value="1" <?php checked(get_option('ewpt_enable_maintenance_mode_advanced_enable', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Unchecked means "Advanced Mode" to insert <strong>HTML Content</strong> and / or <strong>Script / Styles</strong> etc are enable.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Upcoming Features</th>
								<td>
									<label>
										<input type="checkbox" name="ewpt_enable_maintenance_mode_upcoming_features_enable" value="1" <?php checked(get_option('ewpt_enable_maintenance_mode_upcoming_features_enable', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Learn more about upcoming features of "Maintenance Mode" module.<br/>
									</div>
								</td>
							</tr>
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="mmhub-design" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">Page Design Settings</h3>
						
						<!-- Global Styles -->
						<table class="form-table ewpt-form ewpt-form-border-bottom">
							<!-- Background Color -->
							<tr valign="top" class="ewpt-no-bottom-border color-2px-margin-top">
								<th scope="row">Global Styles</th>
								<td>
									<label>
										<input type="text" class="ewpt-color-field" data-alpha-enabled="true" name="maintenance_mode_global_background" value="<?php echo esc_attr(get_option('maintenance_mode_global_background', 'rgb(221, 51, 51)')); ?>" />
									</label>
									<text class="ewpt-color-left-padding">(background-color)</text>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the global BACKGROUND COLOR for the maintenance mode page.
									</div>
								</td>
							</tr>
							<!-- Text Color -->
							<tr valign="top" class="ewpt-no-bottom-border color-2px-margin-top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="ewpt-color-field" data-alpha-enabled="true" name="maintenance_mode_global_color" value="<?php echo esc_attr(get_option('maintenance_mode_global_color', 'rgb(255, 255, 255)')); ?>" />
									</label>
									<text class="ewpt-color-left-padding">(text-color)</text>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the global text COLOR for the maintenance mode page.
									</div>
								</td>
							</tr>
							<!-- Margin -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="maintenance_mode_global_margin" value="<?php echo esc_attr(get_option('maintenance_mode_global_margin', 35)); ?>" />
										PX;  (margin)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the global MARGIN of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<!-- Padding -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="maintenance_mode_global_padding" value="<?php echo esc_attr(get_option('maintenance_mode_global_padding', 5)); ?>" />
										PX;  (padding)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the global PADDING of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="maintenance_mode_global_size" value="<?php echo esc_attr(get_option('maintenance_mode_global_size', 16)); ?>" />
										PX;  (font-size)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the global FONT SIZE of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<!-- Text Align -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="maintenance_mode_global_align">
											<option value="center" <?php selected(get_option("maintenance_mode_global_align"), 'center'); ?>>Center</option>
											<option value="left" <?php selected(get_option("maintenance_mode_global_align"), 'left'); ?>>Left</option>
											<option value="right" <?php selected(get_option("maintenance_mode_global_align"), 'right'); ?>>Right</option>
										</select>
										(text-align)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the global TEXT ALIGN of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<!-- Font Family -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="size-6x" name="maintenance_mode_global_font" value="<?php echo esc_attr(get_option('maintenance_mode_global_font', '"open sans", sans-serif, Helvetica Neue')); ?>" />
										(font-family)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the global FONTS FAMILY for the maintenance mode page.<br/>
										Default: "open sans", sans-serif, Helvetica Neue
									</div>
								</td>
							</tr>
							
						</table>
						
						<!-- Page Desing -->
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						 
							<!-- Logo URL using WordPress Media Uploader -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Page Logo</th>
								<td>
									<label>
										<input type="checkbox" name="maintenance_mode_logo_enable" value="1" <?php checked(get_option('maintenance_mode_logo_enable', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="url" name="maintenance_mode_logo_media_link" id="maintenance_mode_logo_media_link" value="<?php echo esc_url(get_option('maintenance_mode_logo_media_link', '')); ?>" />
									</label>
									<input type="button" id="upload_logo_button" class="button" value="Choose Logo" />
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the link, Upload, or choose the logo to display on the maintenance mode page.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="maintenance_mode_logo_media_width" value="<?php echo esc_attr(get_option('maintenance_mode_logo_media_width', 192)); ?>" />
										PX;  (width)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the width and height of the page logo. '0' means auto
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="maintenance_mode_logo_media_height" value="<?php echo esc_attr(get_option('maintenance_mode_logo_media_height', 0)); ?>" />
										PX; (height)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the width and height of the page logo. '0' means auto
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="maintenance_mode_logo_media_align">
											<option value="center" <?php selected(get_option("maintenance_mode_logo_media_align"), 'center'); ?>>Center</option>
											<option value="left" <?php selected(get_option("maintenance_mode_logo_media_align"), 'left'); ?>>Left</option>
											<option value="right" <?php selected(get_option("maintenance_mode_logo_media_align"), 'right'); ?>>Right</option>
										</select>
										(alignment)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the page logo alignment
									</div>
								</td>
							</tr>
							<!-- Logo Link -->
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="checkbox" name="maintenance_mode_logo_url_enable" value="1" <?php checked(get_option('maintenance_mode_logo_url_enable', 0)) ?> />
										Enable
									</label>
									<label>
										<input type="url" name="maintenance_mode_logo_url" value="<?php echo esc_url(get_option('maintenance_mode_logo_url', '')); ?>" />
										(URL)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the "Maintenance Mode" page logo URL (link).
									</div>
								</td>
							</tr>

							<!-- H1 Text -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">H1 Text</th>
								<td>
									<label>
										<input type="checkbox" name="maintenance_mode_h1_text_enable" value="1" <?php checked(get_option('maintenance_mode_h1_text_enable', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border color-2px-margin-top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="ewpt-color-field" data-alpha-enabled="true" name="maintenance_mode_h1_text_color" value="<?php echo esc_attr(get_option('maintenance_mode_h1_text_color', 'rgb(255, 255, 255)')); ?>" />
									</label>
									<text class="ewpt-color-left-padding">(text-color)</text>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the H1 Text color
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="maintenance_mode_h1_text_size" value="<?php echo esc_attr(get_option('maintenance_mode_h1_text_size', 32)); ?>" />
										PX;  (font-size)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the H1 text FONT SIZE of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="maintenance_mode_h1_text_align">
											<option value="center" <?php selected(get_option("maintenance_mode_h1_text_align"), 'center'); ?>>Center</option>
											<option value="left" <?php selected(get_option("maintenance_mode_h1_text_align"), 'left'); ?>>Left</option>
											<option value="right" <?php selected(get_option("maintenance_mode_h1_text_align"), 'right'); ?>>Right</option>
										</select>
										(alignment)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the H1 Text Alignment
									</div>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="size-6x" name="maintenance_mode_h1_text" value="<?php echo esc_textarea(get_option('maintenance_mode_h1_text', "We'll be back soon!")); ?>" />
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the H1 Text for the maintenance mode page.
									</div>
								</td>
							</tr>

							<!-- Paragraph Text -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Paragraph Text</th>
								<td>
									<label>
										<input type="checkbox" name="maintenance_mode_paragraph_enable" value="1" <?php checked(get_option('maintenance_mode_paragraph_enable', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border color-2px-margin-top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="ewpt-color-field" data-alpha-enabled="true" name="maintenance_mode_paragraph_text_color" value="<?php echo esc_attr(get_option('maintenance_mode_paragraph_text_color', 'rgb(255, 255, 255)')); ?>" />
									</label>
									<text class="ewpt-color-left-padding">(text-color)</text>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the Paragraph Text  color
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="maintenance_mode_paragraph_text_size" value="<?php echo esc_attr(get_option('maintenance_mode_paragraph_text_size', 16)); ?>" />
										PX;  (font-size)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the Paragraph text FONT SIZE of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="maintenance_mode_paragraph_text_align">
											<option value="center" <?php selected(get_option("maintenance_mode_paragraph_text_align"), 'center'); ?>>Center</option>
											<option value="left" <?php selected(get_option("maintenance_mode_paragraph_text_align"), 'left'); ?>>Left</option>
											<option value="right" <?php selected(get_option("maintenance_mode_paragraph_text_align"), 'right'); ?>>Right</option>
										</select>
										(alignment)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the Paragraph Text Alignment
									</div>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<?php
									$content = get_option('maintenance_mode_paragraph_text', "<p>We're performing some maintenance at the moment. We’ll be back up shortly!</p><p>— <strong>The Team</strong></p>");
									$editor_id = 'maintenance_mode_paragraph_text';
									$settings = array(
										'textarea_name' => 'maintenance_mode_paragraph_text',
										'textarea_rows' => 8,
										'media_buttons' => true,
										'tinymce' => false, // Disable TinyMCE (visual editor)
										'quicktags' => true, // Enable Quicktags
										'teeny' => false, // Use the minimal editor
										//'editor_class' => 'ewpt-code-field', // Custom class
									);
									wp_editor($content, $editor_id, $settings);
									?>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the Paragraph Text for the maintenance mode page.
									</div>
									<br/>
									<div class='ewpt-info-green'>
										Basic <strong>HTML</strong> Tags and Attributes are supported.
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="mmhub-seo" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">SEO Settings</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						 
							<!-- Page Title -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Page Title</th>
								<td>
									<label>
										<input type="checkbox" name="maintenance_mode_meta_title_enable" value="1" <?php checked(get_option('maintenance_mode_meta_title_enable', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="size-6x" name="maintenance_mode_meta_title" value="<?php echo esc_textarea(get_option('maintenance_mode_meta_title', 'Under Maintenance!')); ?>" />
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the "Maintenance Mode" page title (browser title).
									</div>
								</td>
							</tr>

							<!-- Page Description -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Page Description</th>
								<td>
									<label>
										<input type="checkbox" name="maintenance_mode_meta_description_enable" value="1" <?php checked(get_option('maintenance_mode_meta_description_enable', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<textarea name="maintenance_mode_meta_description" rows="6" cols="42"><?php echo esc_textarea(get_option('maintenance_mode_meta_description', 'We are currently undergoing maintenance to improve your experience. Please check back soon for updates.')); ?></textarea>
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Enter the SEO meta description (head meta) for the "Maintenance Mode" page.
									</div>
								</td>
							</tr>
							
						</table>
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<?php
				$advanced_enable = get_option('ewpt_enable_maintenance_mode_advanced_enable', 0);
				if ( empty($advanced_enable) || $advanced_enable == 0 ) { ?>
				
				<div id="mmhub-advanced" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">Advanced Settings</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">

							<!-- HTML Text -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row" style="max-width:150px;">HTML Text</th>
								<td>
									<label>
										<input type="checkbox" name="maintenance_mode_html_enable" value="1" <?php checked(get_option('maintenance_mode_html_enable', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row" style="max-width:150px;"></th>
								<td>
									<label>
										<select name="maintenance_mode_html_placement">
											<option value="above_everything" <?php selected(get_option("maintenance_mode_html_placement"), 'above_everything'); ?>>Above Everything</option>
											<option value="below_logo" <?php selected(get_option("maintenance_mode_html_placement"), 'below_logo'); ?>>Below Page Logo</option>
											<option value="below_h1_text" <?php selected(get_option("maintenance_mode_html_placement"), 'below_h1_text'); ?>>Below H1 Text</option>
											<option value="below_paragraph_text" <?php selected(get_option("maintenance_mode_html_placement"), 'below_paragraph_text'); ?>>Below Paragraph Text</option>
											<option value="below_eveything" <?php selected(get_option("maintenance_mode_html_placement"), 'below_eveything'); ?>>Below Eveything</option>
										</select>
										(insert)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										HTML Insertion placement
									</div>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" style="max-width:150px;"></th>
								<td style="max-width:550px;">
									<?php
									$content = get_option('maintenance_mode_html_text', "");
									$editor_id = 'maintenance_mode_html_text';
									$settings = array(
										'textarea_name' => 'maintenance_mode_html_text',
										'textarea_rows' => 16,
										'media_buttons' => true,
										'tinymce' => false, // Disable TinyMCE (visual editor)
										'quicktags' => true, // Enable Quicktags
										'teeny' => false, // Use the minimal editor
										//'editor_class' => 'ewpt-code-field', // Custom class
									);
									wp_editor($content, $editor_id, $settings);
									?>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										All data will be insert inside <strong>BODY</strong> HTML tag.
									</div>
									<br/>
									<div class='ewpt-info-green'>
										All <strong>HTML</strong> Tags and Attributes are supported.
									</div>
									<br/>
									<div class='ewpt-info-red'>
										Bad <strong>HTML</strong> Tags and Attributes would break the page.
									</div>
								</td>
							</tr>
							
							<!-- Styles and Scripts -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row" style="max-width:150px;">Styles and Scripts</th>
								<td>
									<label>
										<input type="checkbox" name="maintenance_mode_styles_scripts_enable" value="1" <?php checked(get_option('maintenance_mode_styles_scripts_enable', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row" style="max-width:150px;"></th>
								<td>
									<label>
										<select name="maintenance_mode_styles_scripts_placement">
											<option value="head_below" <?php selected(get_option("maintenance_mode_styles_scripts_placement"), 'head_below'); ?>>Head Tag (insdie - below)</option>
											<option value="body_above" <?php selected(get_option("maintenance_mode_styles_scripts_placement"), 'body_above'); ?>>Body Tag (insdie - above)</option>
											<option value="body_below" <?php selected(get_option("maintenance_mode_styles_scripts_placement"), 'body_below'); ?>>Body Tag (insdie - below)</option>
											<option value="footer_below" <?php selected(get_option("maintenance_mode_styles_scripts_placement"), 'footer_below'); ?>>Footer Tag (insdie - below)</option>
										</select>
										(insert)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Insert the styles and scripts into the Head (below), Body (above/below), and Footer (below) area.
									</div>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" style="max-width:150px;"></th>
								<td>
									<textarea class="ewpt-code-field" name="maintenance_mode_styles_scripts_text" rows="16" cols="70"><?php echo esc_html(get_option('maintenance_mode_styles_scripts_text', '')); ?></textarea>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Mostly used to insert data (style/script) inside <strong>HEAD</strong> HTML tag.
									</div>
									<br/>
									<div class='ewpt-info-green'>
										All <strong>HTML</strong> Tags and Attributes are supported.
									</div>
									<br/>
									<div class='ewpt-info-red'>
										Bad <strong>HTML</strong> Tags and Attributes would break the page.
									</div>
								</td>
							</tr>
							
						</table>
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<?php } ?>
				
				<?php
				$upcoming_features_enable = get_option('ewpt_enable_maintenance_mode_upcoming_features_enable', 0);
				if ( empty($upcoming_features_enable) || $upcoming_features_enable == 0 ) { ?>
				
				<div id="upcoming-features" class="tab-content">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Upcoming Features (coming soon)</h3>
						
						<div class="ewpt-form">
							<div class="ewpt-info-green ewpt-info-border ewpt-info-full">
								<strong>01. Page Templates with various designs, customizations, light, dark, and colorful mode templates.</strong></br>
							</div>
						</div>
						
						<div class="ewpt-form">
							<div class="ewpt-info-green ewpt-info-border ewpt-info-full">
								<strong>02. Time Countdown (days/hours/minutes/seconds) with various designs, customizations, light, dark and colorful mode templates.</strong></br>
							</div>
						</div>
						
						<div class="ewpt-form ewpt-border-radius-bottom-5px">
							<div class="ewpt-info-green ewpt-info-border ewpt-info-full">
								<strong>03. Social share sites links with light, dark and colorful icon pack templates.</strong></br>
							</div>
						</div>
						
					</div>
				</div>
				
				<?php } ?>
				
				<?php
				// Include the module about file
				include(EWPT_PLUGIN_PATH . 'inc/ewpt-about-modules.php');
				?>
				
				<?php //submit_button(); ?>
				
			</form>
				
		</div>

		<div id="ewpt-page-footer" class="ewpt-page-footer">
			
			<script id="mmhub-uploader-script">
			(function($) {
				// Logo Uploader Script
				$(document).ready(function () {
					var mediaUploader;

					$('#upload_logo_button').click(function (e) {
						e.preventDefault();
						if (mediaUploader) {
							mediaUploader.open();
							return;
						}

						mediaUploader = wp.media.frames.file_frame = wp.media({
							title: 'Choose Logo',
							button: {
								text: 'Choose Logo'
							},
							multiple: false
						});

						mediaUploader.on('select', function () {
							var attachment = mediaUploader.state().get('selection').first().toJSON();
							$('#maintenance_mode_logo_media_link').val(attachment.url);
						});

						mediaUploader.open();
					});
					
					// Initialize color picker for elements with class 'ewpt-color-field'
					$(".ewpt-color-field").wpColorPicker();
					
					// Initialize color mirror for elements with class 'ewpt-textarea-code'
					wp.codeEditor.initialize($('.ewpt-code-field'), cm_settings);
					
				});
			})(jQuery);
			</script>
			
			<?php
				// Enqueue necessary scripts for media uploader
				wp_enqueue_media();
			?>

			<?php
			// Include the module footer file
			include(EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php');
			?>
						
		</div>
		
    </div>
	
	
    <?php
}

	// Include the actions (mostly ajax call)
	include plugin_dir_path(__FILE__) . 'ewpt-maintenance-mode-actions.php';

} // if (!function_exists('ewpt_maintenance_mode_settings_page'))