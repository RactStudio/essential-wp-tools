<?php
// essential-wp-tools/modules/social-share-hub/ewpt-social-share-hub.php

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
		ewpt::register_setting_data('ewpt_social_share_hub_settings', 'ewpt_disable_all_social_share_hub_options', 'boolean');
		ewpt::register_setting_data('ewpt_social_share_hub_settings', 'ewpt_social_share_hub_menu_link', 'string');
		
		ewpt::register_setting_data('ewpt_social_share_hub_settings', 'enable_total_share_buttons_counter', 'integer');
		ewpt::register_setting_data('ewpt_social_share_hub_settings', 'enable_ewpt_share_buttons_custom_post_types', 'boolean');
		ewpt::register_setting_data('ewpt_social_share_hub_settings', 'ewpt_share_buttons_custom_post_types_lists', 'string');
		ewpt::register_setting_data('ewpt_social_share_hub_settings', 'ewpt_enable_all_social_share_hub_shortcodes', 'boolean');

		// Main Social Share Hub Buttons Options / Settings Loop :-)
		$total_share_buttons_slots = get_option('enable_total_share_buttons_counter', 5);
		for ($i = 1; $i <= $total_share_buttons_slots; $i++) {
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_slot", 'boolean');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_title", 'string');
			
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_design_template", 'string');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_icons_sizes", 'integer');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_icons_border_radius", 'integer');
			
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_css_style", 'boolean');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_padding", 'integer');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_alignment", 'string');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_place_singlepost", 'boolean');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_place_singlepage", 'boolean');
			
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_selected_buttons", 'array');
			
			//ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_headline", 'boolean');
			//ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_headline_position", 'string');
			//ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_headline_text", 'string');
			
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_background_color", 'color');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_border_color", 'color');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_border_radius", 'integer');

			// Custom Post Types Conditions with options Register
			if ( (get_option('enable_ewpt_share_buttons_custom_post_types', 0) == 1) && ! empty(get_option('ewpt_share_buttons_custom_post_types_lists', ''))) { 
				$ewpt_post_types = explode (",", get_option('ewpt_share_buttons_custom_post_types_lists', ''));
				foreach ($ewpt_post_types as $post_type) {
					ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_place_{$post_type}", 'boolean');
				}
			}
			
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_insert_hook", 'string');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_placement_position", 'string');
			ewpt::register_setting_data('ewpt_social_share_hub_settings', "share_buttons_{$i}_shortcode", 'boolean');
		}
		
	}
);

// Menu of the Module
add_action(
	'admin_menu',
	function () {
		// Get the option for menu visibility
		$menu_visibility_option = get_option('ewpt_social_share_hub_menu_link', 'sub_menu');
		// Module menu name parameters
		$module_name = 'Social Share Hub'; // Define the module name/title here
		ewpt::assign_modules_menu_link($menu_visibility_option, $module_name);
	}
);

// Callback function to render the Social Share Hub settings page
if (!function_exists('ewpt_social_share_hub_settings_page_rsmhr')) {
function ewpt_social_share_hub_settings_page_rsmhr() {
    // Include the module config file
     include(plugin_dir_path(__FILE__) . 'ewpt-social-share-hub-config.php');

	// Total Social Share Hub Buttons slot by User defined - OR, default to 5 
	$ssh_i = get_option('enable_total_share_buttons_counter', 5);

	// Array of custom post types
	$ewpt_post_types = get_post_types( array(
		'public'   => true,
		'_builtin' => false,
	), 'names' );

	// Sanitize and convert array to comma-separated string
	$ewpt_post_types_lists = ewpt::sanitize_post_types_lists( $ewpt_post_types );

	// Get the current stored post types list
	$current_post_types_lists = get_option( 'ewpt_share_buttons_custom_post_types_lists', '' );

	// Update option if new data is available
	if ( $current_post_types_lists !== $ewpt_post_types_lists ) {
		update_option( 'ewpt_share_buttons_custom_post_types_lists', $ewpt_post_types_lists );
	}

?>

    <div class="wrap">
	
		<?php
		// Include the module header file
		include(EWPT_PLUGIN_PATH . 'inc/ewpt-modules-header.php');
		?>

        <!-- Tab -->
        <h2 class="nav-tab-wrapper">
			<a href="#<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="nav-tab">Settings</a>
			
			<?php for ($i = 1; $i <= $ssh_i; $i++) : ?>
				<a href="#ssh-<?php echo intval($i); ?>" class="nav-tab<?php if (get_option("share_buttons_{$i}_slot", 0) == 1) { echo " ewpt-active-btn"; } ?>"><?php echo intval($i); ?></a>
			<?php endfor; ?>
			
            <a href="#about-module" class="nav-tab">About</a>
			<div class="nav-tab ewpt-save-button"><p class="submit"><input form="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p></div>
        </h2>

		<form id="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" name="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" method="post" action="options.php">
		
			<?php wp_nonce_field( sanitize_html_class(strtolower($EWPT_MODULE_VAR).'_nonce'), sanitize_html_class(strtolower($EWPT_MODULE_VAR).'_nonce') ); ?>
			<?php //settings_errors(); ?>
			<?php settings_fields(sanitize_html_class(strtolower(EWPT_SHORT_SLUG.'_'.$EWPT_MODULE_VAR.'_settings'))); ?>
			<?php do_settings_sections(sanitize_html_class(strtolower(EWPT_SHORT_SLUG.'-'.$EWPT_MODULE_SLUG))); ?>
			
			<div id="<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border"><?php echo esc_attr($EWPT_MODULE_NAME); ?> Settings</h3>
					
					<table class="form-table ewpt-form ewpt-form-border-bottom">
						<tr valign="top">
							<th scope="row">All Options</th>
							<td>
								<label>
									<input type="checkbox" name="ewpt_disable_all_social_share_hub_options" value="1" <?php checked(get_option('ewpt_disable_all_social_share_hub_options'), 1); ?> />
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
									<select name="ewpt_social_share_hub_menu_link">
										<option value="sub_menu" <?php selected(get_option("ewpt_social_share_hub_menu_link"), 'sub_menu'); ?>>Sub Menu</option>
										<option value="main_menu" <?php selected(get_option("ewpt_social_share_hub_menu_link"), 'main_menu'); ?>>Main Menu</option>
										<option value="hidden_menu" <?php selected(get_option("ewpt_social_share_hub_menu_link"), 'hidden_menu'); ?>>Hide Menu</option>
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
					
					<table class="form-table ewpt-form ewpt-no-bottom-border">
						
						<tr valign="top">
							<th scope="row">Total Social Share Hub Slots</th>
							<td>
								<input type="number" name="enable_total_share_buttons_counter" min="1" max="25" value="<?php echo esc_attr(get_option('enable_total_share_buttons_counter', 5)); ?>" />
							</td>
							<td>
								<div class='ewpt-info-blue'>
									Decreasing the Social Share Hub slot's does not clear saved data or alter the enabled status of Social Share Hub slots.
								</div>
							</td>
						</tr>
					
						<tr valign="top">
							<th scope="row">Enable custom post types</th>
							<td>
								<label>
									<input type="checkbox" name="enable_ewpt_share_buttons_custom_post_types" value="1" <?php checked(get_option('enable_ewpt_share_buttons_custom_post_types'), 1); ?> />
									Enable
								</label>
							</td>
							<td>
								<div class='ewpt-info-blue'>
									Deactivating will clear the checked status of all custom post types.
								</div>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row">Enable All Social Share Hub Shortcodes</th>
							<td>
								<label>
									<input type="checkbox" name="ewpt_enable_all_social_share_hub_shortcodes" value="1" <?php checked(get_option('ewpt_enable_all_social_share_hub_shortcodes'), 1); ?> />
									Enable
								</label>
							</td>
							<td>
								<div class='ewpt-info-blue'>
									Generate shortcodes for all social share buttons slots, but require separate shortcode activation for each slot.<br/>
									To display all social share buttons at once, use [ewpt_social_share_hub], or use [ewpt_social_share_hub slot=0].
								</div>
							</td>
						</tr>
						
					</table>
					
					<h3>Essential Tools</h3>
					<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
						
						<tr valign="top">
							<th scope="row">Are you facing EXCERPT issue?</th>
							<td>
								<div class='ewpt-info-blue'>
									Enable <a class="ewpt-button-link-text" title="Auto Excerpt" target="_blank" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-essential-tools#auto-excerpt">Auto Excerpt</a> in Essential Tools. Note: "Essential Tools" (module) must be enabled in <a class="ewpt-button-link-text" title="Modules Manager" target="_blank" href="<?php echo esc_url(EWPT_DASH_URL); ?>#modules-manager">Modules Manager</a><br/>
									This will make sure that all single posts, pages, and custom post types have their own excerpt from the main the_content()
								</div>
							</td>
						</tr>
						
					</table>
					
				</div>
			</div>
			
			<?php for ($i = 1; $i <= $ssh_i; $i++) : ?>
				<div id="ssh-<?php echo intval($i); ?>" class="tab-content">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border<?php if (get_option("share_buttons_{$i}_slot", 0) == 1) { echo " ewpt-active-h3"; } ?>">Social Share Hub: <?php echo intval($i); ?></h3>
						
						<table class="form-table ewpt-form ewpt-no-bottom-border">
							<tr valign="top">
								<th scope="row">Title</th>
								<td>
									<input type="text" class="size-6x" name="share_buttons_<?php echo intval($i); ?>_title" value="<?php echo esc_attr(get_option("share_buttons_{$i}_title", "Social Share Hub - {$i}")); ?>" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Status</th>
								<td>
									<label>
										<input type="checkbox" name="share_buttons_<?php echo intval($i); ?>_slot" value="1" <?php checked(get_option("share_buttons_{$i}_slot"), 1); ?> />
										Enable
									</label>
								</td>
							</tr>
						</table>
						
						<h3>Choose Share Buttons</h3>
						<?php
							// Dynamic loading of buttons
							$ssh_buttons_lists_array = glob(plugin_dir_path(__FILE__) . 'templates/ssh-design-1-color/*.png');
							$ssh_design_template = wp_kses_post(get_option("share_buttons_{$i}_design_template", 'ssh_design_1_color'));
							$design_type_parts = explode('_', $ssh_design_template);
							$ssh_design_type = end($design_type_parts);
							// Define the directory containing the button images based on the selected design template
							$button_images_dir = plugin_dir_url(__FILE__) . 'templates/' . str_replace('_', '-', $ssh_design_template) . '/';
							// Retrieve selected buttons from the get_option array
							$selected_buttons = (array) get_option("share_buttons_{$i}_selected_buttons");
						?>
						<div class="ewpt-row ewpt-form ewpt-no-bottom-border" style="padding: 10px 10px 10px 10px;">
							<div class="ewpt-column-1 ewpt-no-bottom-border <?php echo sanitize_html_class($ssh_design_type); ?>">
								<h3 class="ewpt-module-name ssh-module-name text-center">Selected Social Share Hub Buttons</h3>
								<div class="ewpt-card ssh-card sshDropText" id="share_buttons_<?php echo intval($i); ?>_selected_buttons">
									<?php
										// Loop through the selected buttons array and output them in the same order
										foreach ($selected_buttons as $button_name) {
											// Load site images
											$site_name = str_replace("ssh_{$i}_", '', basename($button_name));
											// Construct the image URL
											$image_url = $button_images_dir . str_replace('-', '_', $site_name) . '.png';

											$site_name = str_replace('.png', '', $site_name);
											$option_name = "ssh_{$i}_{$site_name}";
											// Check if there are any value in the $button_name
											if (!empty(basename($button_name))) {
											?>
												<div class="ssh-select-icon-options" data-option="<?php echo sanitize_html_class($option_name); ?>">
													<div class="ssh-icon-col">
														<div class="ssh-icon-img"><img class="ssh-select-icon-option" src="<?php echo esc_url($image_url); ?>"/></div>
														<div class="ssh-icon-name"><?php echo esc_attr(ucfirst(str_replace('_', ' ', $site_name))); ?></div>
													</div>
													<input type="hidden" name="share_buttons_<?php echo intval($i); ?>_selected_buttons[]" value="<?php echo sanitize_html_class($option_name); ?>" />
												</div>
											<?php
											}
										}
									?>
								</div>
							</div>
						</div>
						
						<div class="ewpt-form ewpt-no-bottom-border">
							<div class="ewpt-info-green ewpt-info-border ewpt-info-full text-center">
								&#8645; Drag and Drop icon. <kbd>Ctrl</kbd> (Windows/Linux) or <kbd>Option</kbd> (Mac) to select multiple icons.
							</div>
						</div>
						
						<div class="ewpt-row ewpt-form ewpt-no-bottom-border" style="padding: 10px 10px 10px 10px;">
							<div id="fieldChooser<?php echo intval($i); ?>" class="ewpt-column-1 <?php echo sanitize_html_class($ssh_design_type); ?>">
								<h3 class="ewpt-module-name ssh-module-name text-center">Available Social Share Hub Buttons</h3>
								<div class="ewpt-card ssh-card" id="share_buttons_<?php echo intval($i); ?>_all_buttons">
									<?php
									// Loop through the selected buttons array to check if the value isn't saved in DB
									foreach ($ssh_buttons_lists_array as $button_name) {
										// Load site images
										$site_name = str_replace("ssh_{$i}_", '', basename($button_name));
										// Construct the image URL
										$image_url = $button_images_dir . str_replace('-', '_', $site_name) . '';

										$site_name = str_replace('.png', '', $site_name);
										$option_name = "ssh_{$i}_{$site_name}";
										// Check if the button is not selected
										//$option_key = false;
										$option_key = in_array($option_name, $selected_buttons);
										if ($option_key === false && !empty(basename($button_name))) {
											?>
												<div class="ssh-select-icon-options" data-option="<?php echo sanitize_html_class($option_name); ?>">
													<div class="ssh-icon-col">
														<div class="ssh-icon-img"><img class="ssh-select-icon-option" src="<?php echo esc_url($image_url); ?>"/></div>
														<div class="ssh-icon-name"><?php echo esc_attr(ucfirst(str_replace('_', ' ', $site_name))); ?></div>
													</div>
												</div>
											<?php
										}
									}
									?>
								</div>
							</div>
						</div>

						<h3>Share Buttons Design</h3>
						<table class="form-table ewpt-form">
						
							<tr valign="top">
								<th scope="row">Buttons Design Template</th>
								<td>
									<label>
										<select name="share_buttons_<?php echo intval($i); ?>_design_template">
											<?php
											// Dynamic loading of buttons
											$ssh_templates_directory_array =  glob(plugin_dir_path(__FILE__) . 'templates/ssh-*', GLOB_ONLYDIR);
											$ssh_buttons_lists_array = glob(plugin_dir_path(__FILE__) . 'templates/ssh-design-1-color/*.png');
											
											// Output the dynamically loaded buttons
											foreach ($ssh_templates_directory_array as $ssh_template_directory) {
												$ssh_template_name = basename($ssh_template_directory, 'ssh-');
												$ssh_template_name = str_replace('ssh-', '', $ssh_template_name);
												$ssh_template_name = str_replace('-', '_', $ssh_template_name);
												$option_name = "ssh_{$ssh_template_name}";
												?>
												<option value="<?php echo sanitize_html_class($option_name); ?>" <?php selected(get_option("share_buttons_{$i}_design_template"), $option_name); ?>>
													<?php echo esc_attr(ucwords(str_replace('_', ' ', $ssh_template_name))); ?>
												</option>
												<?php
											}
											?>
										</select>
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Share buttons icons design sets.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Share Icons Size</th>
								<td>
									<label>
										<input type="number" min="12" max="128" name="share_buttons_<?php echo intval($i); ?>_icons_sizes" value="<?php echo esc_attr(get_option("share_buttons_{$i}_icons_sizes", '40')); ?>" />
										PX
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Recommended size: min: 12 to max: 128. Default: 32 (in pixels). Width and Height of the icons.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Share Icons Border Radius</th>
								<td>
									<label>
										<input type="number" min="0" max="96" name="share_buttons_<?php echo intval($i); ?>_icons_border_radius" value="<?php echo esc_attr(get_option("share_buttons_{$i}_icons_border_radius", '12')); ?>" />
										PX
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Recommended radius: min: 0 to max: 128. Default: 12 (in pixels). Shouldn't cross more than 50% of the "Share Icons Size".
									</div>
								</td>
							</tr>
							
						</table>
						
						<table class="form-table ewpt-form ewpt-no-bottom-border">
						
							<tr valign="top">
								<th scope="row">All CSS Styles</th>
								<td>
									<label>
										<input type="checkbox" name="share_buttons_<?php echo intval($i); ?>_css_style" value="1" <?php checked(get_option("share_buttons_{$i}_css_style"), 1); ?> />
										Enable 
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Below custom css style will add to the frontend design, if you enable this.
									</div>
								</td>
							</tr>
						
							<tr valign="top">
								<th scope="row">All Buttons Area Background</th>
								<td>
									<label>
										<input type="text" class="ewpt-color-field" data-alpha-enabled="true" name="share_buttons_<?php echo intval($i); ?>_background_color" value="<?php echo esc_attr(get_option("share_buttons_{$i}_background_color", 'rgba(211, 211, 211, 0.14)')); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Choose the buttons area background color.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">All Buttons Area Border Color</th>
								<td>
									<label>
										<input type="text" class="ewpt-color-field" data-alpha-enabled="true" name="share_buttons_<?php echo intval($i); ?>_border_color" value="<?php echo esc_attr(get_option("share_buttons_{$i}_border_color", 'rgba(211, 211, 211, 0.07)')); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Choose the buttons area border color.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">All Buttons Area Border Radius</th>
								<td>
									<label>
										<input type="number" min="0" max="64" name="share_buttons_<?php echo intval($i); ?>_border_radius" value="<?php echo esc_attr(get_option("share_buttons_{$i}_border_radius", '5')); ?>" />
										PX
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Recommended radius: min: 0 to max: 24. Default radius: 5 (in pixels)
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">All Buttons Area Padding</th>
								<td>
									<label>
										<input type="number" min="0" max="50" name="share_buttons_<?php echo intval($i); ?>_padding" value="<?php echo esc_attr(get_option("share_buttons_{$i}_padding", '5')); ?>" />
										PX
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Recommended padding: min: 0 to max: 50. Default padding: 5 (in pixels)
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">All Buttons Alignment</th>
								<td>
									<label>
										<select name="share_buttons_<?php echo intval($i); ?>_alignment">
											<option value="left" <?php selected(get_option("share_buttons_{$i}_alignment"), 'left'); ?>>Left</option>
											<option value="center" <?php selected(get_option("share_buttons_{$i}_alignment"), 'center'); ?>>Center</option>
											<option value="right" <?php selected(get_option("share_buttons_{$i}_alignment"), 'right'); ?>>Right</option>
										</select>
									</label>
								</td>
							</tr>
						</table>
						
						<h3>Placement</h3>
						<table class="form-table ewpt-form ewpt-no-bottom-border">
							<tr valign="top">
								<th scope="row">General Places</th>
								<td>
									<label>
										<input type="checkbox" name="share_buttons_<?php echo intval($i); ?>_place_singlepost" value="1" <?php checked(get_option("share_buttons_{$i}_place_singlepost"), 1); ?> />
										Posts
									</label>
								</td>
								<td>
									<label>
										<input type="checkbox" name="share_buttons_<?php echo intval($i); ?>_place_singlepage" value="1" <?php checked(get_option("share_buttons_{$i}_place_singlepage"), 1); ?> />
										Pages
									</label>
								</td>
							
							</tr>
							
							<?php if ( !empty($ewpt_post_types) && (get_option('enable_ewpt_share_buttons_custom_post_types', 0) == 1)) {  ?>
								<tr valign="top">
									<th scope="row">Custom Post Types</th>
								<?php foreach ($ewpt_post_types  as $post_type) { ?>
										<td>
											<label>
												<input type="checkbox" name="share_buttons_<?php echo intval($i); ?>_place_<?php echo sanitize_html_class($post_type); ?>" value="1" <?php checked(get_option("share_buttons_{$i}_place_{$post_type}"), 1); ?> />
												<?php echo sanitize_html_class($post_type); ?>
											</label>
										</td>
								<?php } ?>
								</tr>
							<?php } ?>
							
						</table>

						<h3>Insert (Hook)</h3>
						<table class="form-table ewpt-form ewpt-no-bottom-border">
							<tr valign="top">
								<th scope="row">Placement Hooks</th>
								<td>
									<select name="share_buttons_<?php echo intval($i); ?>_insert_hook">
										<option value="the_content" <?php selected(get_option("share_buttons_{$i}_insert_hook"), 'the_content'); ?>>Posts / Pages / CPT  - The Content</option>
										<option value="disable" <?php selected(get_option("share_buttons_{$i}_insert_hook"), 'disable'); ?>>Disable</option>
									</select>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										<strong>Posts / Pages / CPT  - The Content:</strong> Only in the single pages, single posts and custom post types content.<br/>
										<strong>Disable:</strong> Disable this social share buttons slot placement everywhere. Except, if you enabled the shortcode.
									</div>
								</td>
							</tr>
						</table>
						
						<h3>Position</h3>
						<table class="form-table ewpt-form <?php if (get_option("ewpt_enable_all_social_share_hub_shortcodes", 0) == 1) { echo "ewpt-no-bottom-border"; } else { echo "ewpt-border-radius-bottom-5px"; } ?>">
							<tr valign="top">
								<th scope="row">Button Position</th>
								<td>
									<label>
										<select name="share_buttons_<?php echo intval($i); ?>_placement_position">
											<option value="above_below_position" <?php selected(get_option("share_buttons_{$i}_placement_position"), 'above_below_position'); ?>>Above & Below Content</option>
											<option value="above_position" <?php selected(get_option("share_buttons_{$i}_placement_position"), 'above_position'); ?>>Above Content</option>
											<option value="below_position" <?php selected(get_option("share_buttons_{$i}_placement_position"), 'below_position'); ?>>Below Content</option>
										</select>
									</label>
								</td>
							</tr>
						
						</table>
						
						<?php if (get_option("ewpt_enable_all_social_share_hub_shortcodes", 0) == 1) { ?>
						<h3>Social Share Hub Shortcode</h3>
						<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
							
							<tr valign="top">
								<th scope="row">Enable Shortcode</th>
								<td>
									<label>
										<input type="checkbox" name="share_buttons_<?php echo intval($i); ?>_shortcode" value="1" <?php checked(get_option("share_buttons_{$i}_shortcode"), 1); ?> />
										Enable 
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										To use only the shortcode for this social share buttons, select "Disable" in "Insert (Hook)".
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">The Shortcode</th>
								<td>
									<div class='ewpt-info-blue'>
										<?php echo esc_attr("[ewpt_social_share_hub slot={$i}]"); ?>
									</div>
									<br/>
									<div class='ewpt-info-blue'>
										<?php
											$phpShort1 = "<?php echo do_shortcode( '";
											$phpShort2 = "[ewpt_social_share_hub slot={$i}]";
											$phpShort3 = "' ); ?>";
											echo  esc_attr($phpShort1.$phpShort2.$phpShort3);
										?>
									</div>
								</td>
							</tr>
							
						</table>
						<?php } ?>
						
					</div>
				</div>

			<?php endfor; ?>
				
			<?php
			// Include the module about file
			include(EWPT_PLUGIN_PATH . 'inc/ewpt-about-modules.php');
			?>
			
			<?php submit_button('Save Changes'); ?>
				
		</form>
			
    </div>
	
	<?php
    // Check if current page is the target page
    //if (isset($_GET['page']) && $_GET['page'] === 'ewpt-social-share-hub') {
		// Enqueue WordPress jQuery UI
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_style('wp-jquery-ui-dialog');
		
		// Enqueue plugin CSS and JS
		wp_enqueue_style('ssh-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '1.0.0');
		wp_enqueue_script('ssh-jquery-ui-script', plugin_dir_url(__FILE__) . 'assets/js/fieldChooser.js', array('jquery-ui-core', 'jquery-ui-sortable'), '1.0.6', true);
	//}
	?>
	
	<script id="ssh-jquery-fieldchooser">
	(function($) {
		$(document).ready(function () {
			// Initialize fieldChooser plugin
			<?php for ($i = 1; $i <= $ssh_i; $i++) : ?>
			
			var $sourceFields = $("#share_buttons_<?php echo intval($i); ?>_all_buttons");
			var $destinationFields = $("#share_buttons_<?php echo intval($i); ?>_selected_buttons");
			var $chooser = $("#fieldChooser<?php echo intval($i); ?>").fieldChooser($sourceFields, $destinationFields);

			// When a button is moved from source to destination
			$("#share_buttons_<?php echo intval($i); ?>_selected_buttons").on('DOMNodeInserted', function(event) {
				var $target = $(event.target);
				var optionName = $target.data('option');
				if (optionName) {
					var hiddenInput = '<input type="hidden" name="share_buttons_<?php echo intval($i); ?>_selected_buttons[]" value="' + optionName + '" />';
					$target.append(hiddenInput);
				}
			});

			// When a button is moved from destination to source
			$("#share_buttons_<?php echo intval($i); ?>_selected_buttons").on('DOMNodeRemoved', function(event) {
				var $target = $(event.target);
				$target.find('input[type="hidden"]').remove();
			});
			
			<?php endfor; ?>
			
			// Initialize color picker for elements with class 'ewpt-color-field'
			$(".ewpt-color-field").wpColorPicker();
		});
	})(jQuery);
	</script>

	<?php
	// Include the module footer file
	include(EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php');
	?>
	
    <?php
}

	add_action(
		'admin_enqueue_scripts',
		function () {
			// Check if current page is the target page
			if (isset($_GET['page']) && $_GET['page'] === 'ewpt-social-share-hub') {
				// Enqueue WordPress color picker style
				wp_enqueue_style( 'wp-color-picker' );
				
				// Enqueue custom color picker script
				$color_picker_alpha_script = EWPT_PLUGIN_URL . 'inc/wp-color-picker-alpha.js';
				wp_register_script( 'ssh-wp-color-picker-alpha', $color_picker_alpha_script, array( 'wp-color-picker' ), '3.0.3', true);
				wp_enqueue_script( 'ssh-wp-color-picker-alpha' );
			}
		}
	);
	
} // if (!function_exists('ewpt_social_share_hub_settings_page_rsmhr'))