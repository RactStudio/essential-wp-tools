<?php
// essential-wp-tools/admin/ewpt-admin-settings.php

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
		
		ewpt::register_setting_data('essential_wp_tools_settings', 'ewpt_first_activated_datetime', 'dtzone');
		
		foreach (EWPT_MODULES_FOLDERS_ARRAY as $module_folder) {
			$folder_name = basename($module_folder);
			$option_name = 'ewpt_disable_' . str_replace('-', '_', $folder_name);
			ewpt::register_setting_data('essential_wp_tools_settings', $option_name, 'boolean');
		}
	}
);

// Add menu items
add_action(
	'admin_menu',
	function ($icon_data_in_base64) {
		$icon_data_in_base64 = wp_remote_retrieve_body(wp_remote_get(EWPT_PLUGIN_URL.'admin/assets/img/ewpt-icon.svg'));
		add_menu_page(
			'Essential WP Tools',
			'EWPT Dashboard',
			'manage_options',
			'essential-wp-tools',
			'ewpt_essential_wp_tools_settings_page_rsmhr',
			"data:image/svg+xml;base64,".$icon_data_in_base64, // the icon
			2  // The position
		);
	}
);

// Create the admin settings page
if (!function_exists('ewpt_essential_wp_tools_settings_page_rsmhr')) {
function ewpt_essential_wp_tools_settings_page_rsmhr() {
	//Defined Parameters
	$EWPT_MODULE_TAB_VAR = "EWPT";
	$EWPT_MODULE_TAB_DEFAULT = "ewpt-dashboard";
	
	// Array to store all active module details
	$ewpt_active_modules = array();
	
	// Loop through each module folder
	foreach (EWPT_MODULES_FOLDERS_ARRAY as $module_folder) {
		// Get the folder name without path
		$folder_name = basename($module_folder);
		
		// Define the option name based on the folder name
		$option_name = 'ewpt_disable_' . str_replace('-', '_', $folder_name);
		
		// Check if the option is set to enable the module (1 means enabled)
		if (get_option($option_name) == 1) {
			// Module is active, include its main file
			$main_file = $module_folder . "/ewpt-{$folder_name}.php";
			if (file_exists($main_file)) {
				require_once $main_file;
				
				// Retrieve module-specific values
				$module_values = ewpt::get_module_values($folder_name);

				// Store the configuration details in the $ewpt_active_modules array
				$ewpt_active_modules[$folder_name] = $module_values;
			}
		}
	}
	
?>
	
	<div class="wrap">
		
		<link rel="stylesheet" href="<?php echo esc_url(EWPT_PLUGIN_URL); ?>inc/ewpt-admin-style.css" media="all">
		
		<h1 class="ewpt-header-bg">
			<div class="ewpt-row ewpt-header">
				<div class="ewpt-column-2 ewpt-brand">
					<p class="ewpt-title">
						<a target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>">
							<?php echo esc_attr(EWPT_FULL_NAME); ?>
						</a>
						<span class="ewpt-version">
							v<?php echo esc_attr(EWPT_VERSION_NO); ?>
						</span>
					</p>
					<p class="ewpt-dev">
						Powered by - <a title="<?php echo esc_attr(EWPT_DEV1_NAM); ?>" target="_blank" href="<?php echo esc_url(EWPT_DEV1_URL); ?>"><?php echo esc_attr(EWPT_DEV1_NAM); ?></a> & <a title="<?php echo esc_attr(EWPT_DEV2_NAM); ?>" target="_blank" href="<?php echo esc_url(EWPT_DEV2_URL); ?>"><?php echo esc_attr(EWPT_DEV2_SHORT); ?></a>
					</p>
				</div>
				<div class="ewpt-column-2 ewpt-donate">
					<a title="Become a patron" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL1); ?>"><img src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/patreon-btn.png" /></a>
					<a title="Buy me a coffee" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL2); ?>"><img src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/bmac-btn.png" /></a>
					<a title="Hire us" target="_self" href="<?php echo esc_url(EWPT_HIREUS_URL); ?>"><img src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/hire-btn.png" /></a>
				</div>
			</div>
		</h1>
		
		<?php
		/**
			// Verify nonce
			if ( isset( $_POST[sanitize_html_class(strtolower(EWPT_FULL_VAR).'_nonce')] ) || wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST[sanitize_html_class(strtolower(EWPT_FULL_VAR).'_nonce')] ) ) , sanitize_html_class(strtolower(EWPT_FULL_VAR).'_nonce') ) ) {
				// Save changes message
				if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
					echo '<div class="notice notice-success settings-error is-dismissible"><p>'.sanitize_html_class(EWPT_SHORT_NAME).' settings saved successfully!</p></div>';
				}
			}
		**/
		?>
		
		<?php settings_errors(); ?>
		
		<!-- Tab -->
		<h2 class="nav-tab-wrapper">
			<a href="#<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="nav-tab">Dashboard</a>
			<a href="#modules-manager" class="nav-tab">Modules Manager <?php echo '('.intval(EWPT_MODULES_FOLDERS_COUNT).')'; ?></a>
			<a href="#upcoming-modules" class="nav-tab">Upcoming Modules (24)</a>
			<a href="#user-guide" class="nav-tab">User Guide</a>
			<a href="#whats-next" class="nav-tab">What's Next</a>
			<a href="#about-ewpt" class="nav-tab">About</a>
			<div class="nav-tab ewpt-save-button"><p class="submit"><input form="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p></div>
		</h2>
		
		<form id="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" name="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" method="post" action="options.php">
			
			<?php wp_nonce_field( sanitize_html_class(strtolower(EWPT_FULL_VAR).'_nonce'), sanitize_html_class(strtolower(EWPT_FULL_VAR).'_nonce') ); ?>
			<?php //settings_errors(); ?>
			<?php settings_fields(sanitize_html_class(strtolower(EWPT_FULL_VAR).'_settings')); ?>
			<?php do_settings_sections(sanitize_html_class(strtolower(EWPT_FULL_SLUG))); ?>
			
			<div id="<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">EWPT Dashboard (active modules)</h3>
					
					<div class="ewpt-row">
						<?php
							// Call the function and pass the $ewpt_active_modules array as an argument
							ewpt::generate_all_active_modules($ewpt_active_modules);
						?>
					</div>
					
					<h3 class="ewpt-no-top-border">Donate <?php echo esc_attr(EWPT_FULL_NAME); ?>: Pretty please!</h3>
					<div class="ewpt-form ewpt-border-radius-bottom-5px ewpt-no-tab-target">
						<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
							We are offering the main plugin and its core features free of cost to everyone.
							<br/>
							Consider a one-time contribution or a monthly subscription, every bit helps.
							<br/><br/>
							
							<strong>Please consider supporting</strong> us by visiting the donation link below.
							<br/>
							Learn more on the <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-donate">Donation Page</a>
							<br/><br/>
							
							Best Regards,<br/>
							<strong><?php echo esc_attr(EWPT_DEV1_NAM); ?></strong> and <strong><?php echo esc_attr(EWPT_DEV2_NAM); ?></strong>
							<br/><br/>
							
							<a title="Become a patron" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL1); ?>"><img width="96px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/patreon-btn.png" /></a>
							<a title="Buy me a coffee" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL2); ?>"><img width="96px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/bmac-btn.png" /></a>
							<a title="Hire us" target="_self" href="<?php echo esc_url(EWPT_HIREUS_URL); ?>"><img width="96px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/hire-btn.png" /></a>
						</div>
					</div>
					
				</div>
			</div>
			
			<div id="modules-manager" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">Modules Manager <?php echo '('.intval(EWPT_MODULES_FOLDERS_COUNT).')'; ?></h3>
					
					<div class="ewpt-form">
						<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
								More essential modules are coming soon. Explore <a class="ewpt-button-link-text" title="Upcoming Modules" href="<?php echo esc_url(EWPT_DASH_URL); ?>#upcoming-modules">Upcoming Modules</a><br/>
								+ Explore all available modules on <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url(EWPT_MODULES_REPO_URL); ?>">Modules</a> repository.<br/>
								+ Please contribute and learn more on the <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-donate">Donation Page</a><br/>
								+ Now, accepting new Features, <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url(EWPT_FEATURE_REQ); ?>">Request Here</a>
						</div>
					</div>
					
					<table class="wp-list-table widefat striped ewpt-no-top-border ewpt-border-radius-bottom-5px">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Module Name</th>
								<th scope="col">Action</th>
								<th scope="col">Status</th>
								<th scope="col" class="admin-module-desc">Description</th>
							</tr>
						</thead>
						<tbody>
							<?php ewpt::generate_modules_table(); ?>
						</tbody>
					</table>
					
				</div>
			</div>
			
			<div id="upcoming-modules" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">Upcoming Modules (24)</h3>
					
					<div class="ewpt-form">
						<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
								Production ready modules will be available on <a class="ewpt-button-link-text" title="Modules Manager" href="<?php echo esc_url(EWPT_DASH_URL); ?>#modules-manager">Modules Manager</a><br/>
								+ Explore all upcoming modules on <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url(EWPT_UPCOMING_MODULES_URL); ?>">Upcoming</a> repository.<br/>
								+ Please contribute and learn more on the <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-donate">Donation Page</a><br/>
								+ Now, accepting new Features, <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url(EWPT_FEATURE_REQ); ?>">Request Here</a>
						</div>
					</div>
					
					<table class="wp-list-table widefat striped ewpt-no-top-border ewpt-border-radius-bottom-5px">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Module Name</th>
								<th scope="col">Action</th>
								<th scope="col">Status</th>
								<th scope="col" class="admin-module-desc">Description</th>
							</tr>
						</thead>
						<tbody>
						
							<tr valign="top">
								<td>1</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/ai-article-writer/">
										AI Article Writer
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
										- OpenAI GPT-3, GPT-4, and DALL-E-3 Image Integration (confirmed)<br/>
										- No Third-Party Involvement except OpenAI API (confirmed)<br/>
										- Keyword-Based Article Generation (confirmed)<br/>
										- Automatic Publishing of AI-Generated Articles (confirmed)<br/>
										- Unique Prompt Selection for Each Article (confirmed)<br/>
										- + Many More Features...
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>2</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/speed-master-tools/">
										Speed Master Tools
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
											- JavaScript Tinified (confirmed)<br/>
											- CSS Tinified (confirmed)<br/>
											- HTML Tinified (confirmed)<br/>
											- Image Compress (not sure yet)<br/>
											- Delete Transition (not sure yet)<br/>
											- Database Optimization (not sure yet)<br/>
											- + Many more features...
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>3</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/inline-posts-linker/">
										Inline Posts Linker
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
											- Inline Related Posts (article) Link (confirmed)<br/>
											- Related Posts  Below Posts (confirmed)<br/>
											- Support Custom Post Types (confirmed)<br/>
											- + Many more features...
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>4</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/auto-translate-hub/">
										Auto Translate Hub
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
										- Automatic Frontend Translation with Google (confirmed)<br/>
										- Google Translation API required (Free version acceptable) (confirmed)<br/>
										- Language Selector for Users with cookie memory (confirmed)<br/>
										- Language Choice for Admin from Backend (confirmed)<br/>
										- Shortcode and PHP code for Frontend Integration (confirmed)<br/>
										- + Many More Features...
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>5</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/announcements-hub/">
										Announcements Hub
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
										Announce various information to Backend and / or Frontend users.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>6</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/forms-manager/">
										Forms Manager
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
										Easily manage your all sorts of forms.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>7</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/cookie-notices-tools/">
										Cookie Notices Tools
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
										Implement Cookie Notice, GDPR Compliance, Consent Banner, and Basic Privacy Notices.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>8</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/ecommerce-tools/">
										Ecommerce Tools
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
										Effortlessly manage features in various Ecommerce plugins, e.g., WooCommerce etc.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>9</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/perfect-seo-tools/">
										Perfect SEO Tools
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
										Enhance your site with essential to advanced SEO features to optimize your site.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>10</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/smart-cache-hub/">
										Smart Cache Hub
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
										Optimize your site like a PRO. Caching everything on your site and serve as static files.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>11</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/xml-sitemaps-tools/">
										XML Sitemaps Tools
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
									<div class='ewpt-info-blue'>
										Create multiple types of SEO-friendly XML Sitemaps. Add custom links, Add/Remove Post Types, and Taxonomy.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<td>12</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/visitor-insights-hub/">
										Visitor Insights Hub
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>13</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/chatbots-manager/">
										Chatbots Manager
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>14</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/social-media-hub/">
										Social Media Hub
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>15</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/social-register-login/">
										Social Register / Login
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>16</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/popups-manager/">
										Popups Manager
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>17</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/search-engine-index/">
										Search Engine Index
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>18</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/duplicate-remover-tools/">
										Duplicate Remover Tools
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>19</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/redirections-manager/">
										Redirections Manager
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>20</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/404-monitor-hub/">
										404 Monitor Hub
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>21</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/site-backups-manager/">
										Site Backups Manager
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>22</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/image-galleries-hub/">
										Image Galleries Hub
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>23</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/support-hub/">
										Support Hub
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>24</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/users-management-tools/">
										Users Management Tools
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>25</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/code-snippets-hub/">
										Code Snippets Hub
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
							<tr valign="top">
								<td>26</td>
								<td class="ewpt-module-name">
									<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>upcoming/search-manager/">
										Search Manager
									</a>
								</td>
								<td>
									<label>
										<input type="checkbox" name="" value="" disabled />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upcoming
									</div>
								</td>
								<td class="admin-module-desc">
								</td>
							</tr>
							
						</tbody>
					</table>
					
				</div>
			</div>
			
			<div id="user-guide" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">User Guide</h3>
					
					<div class="ewpt-form ewpt-border-radius-bottom-5px">
						<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
						
							<p>Welcome to <?php echo esc_attr(EWPT_FULL_NAME); ?>, your all-in-one solution for enhancing and managing your WordPress site! This plugin comes packed with essential modules to improve your site's functionality. Here's a quick guide to help you get started:</p>
							
							<p><strong>Getting Started:</strong></p>
							Find the <?php echo esc_attr(EWPT_FULL_NAME); ?> menu "<strong><?php echo esc_attr(EWPT_SHORT_NAME); ?> Dashboard</strong>" in your WordPress admin sidebar.
							<br/>
							
							<p><strong>Enable/Disable Modules:</strong></p>
							Inside the <?php echo esc_attr(EWPT_FULL_NAME); ?> menu "<strong><?php echo esc_attr(EWPT_SHORT_NAME); ?> Dashboard</strong>", you'll find a list of modules already activated when you installed the plugin. Customize module activation by navigating to the "<strong>Modules Manager</strong>" tab.
							<br/><br/>
							Enable or disable specific modules according to your needs. Modified modules will be seamlessly integrated into the "<strong><?php echo esc_attr(EWPT_SHORT_NAME); ?> Dashboard</strong>" submenu in your WordPress menu bar.
							<br/>
							
							<p><strong>Customizing Modules:</strong></p>
							Each module has its own settings. Click on the module name in your WordPress menu bar to access its settings page. Customize the settings based on your preferences.
							<br/>
							
							<p><strong>Adding Modules to Admin Menu:</strong></p>
							Want quick access to specific modules? Integrate them into the main admin menu. Visit the specific module settings page and look for an option like "<strong>Add to main menu</strong>" Enable the checkbox and save changes for the effect.
							<br/>
							
							<p><strong>User-Friendly Design:</strong></p>
							<?php echo esc_attr(EWPT_FULL_NAME); ?> is designed with simplicity in mind. Easily navigate through modules and settings with a user-friendly interface.
							<br/>
							
							<p><strong>Save Changes:</strong></p>
							Don't forget to "<strong>Save Changes</strong>" after adjusting module settings.
							<br/>
							
							<p><strong>Enjoy <?php echo esc_attr(EWPT_FULL_NAME); ?>!</strong></p>
							Explore the various modules to enhance your WordPress experience. If you have any questions or need assistance, refer to the specefic module "<strong>About</strong>" tab, our <a class="ewpt-button-link-text ewpt-enlarge-1x" target="_blank" href="<?php echo esc_url(EWPT_DOCS_URL); ?>"><?php echo esc_attr(EWPT_SHORT_NAME); ?> Documentation</a>.
							<br/>
							
							<p><strong>Happy WordPressing!</strong></p>
							
						</div>
					</div>
					
				</div>
			</div>
						
			<div id="whats-next" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">What's Next?</h3>
					
					<div class="ewpt-form ewpt-border-radius-bottom-5px">
						<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
						
						<p>"<strong><?php echo esc_attr(EWPT_FULL_NAME); ?></strong>" stands out as a unique plugin, ensuring user-friendly customization of WordPress features. We are committed to offering a secure and high-performance solution, encompassing functionalities that are often scattered across various small to large plugins.</p>
						
						<p>We envision a WordPress environment where every feature is easily manageable through our plugin's options panel, exemplified by the "<strong>Essential Tools</strong>" module.</p>
						
						<p>Our future plans include creating a developer guide and a module repository / marketplace, enabling developers worldwide to contribute and enhance the plugin's capabilities. As well as, user will be able to upload local modules from our modules manager.</p>
						
						<p>Our vision is for every WordPress user to install "<strong><?php echo esc_attr(EWPT_FULL_NAME); ?></strong>" right after WordPress setup, eliminating the need for multiple plugins. Users can tailor their website precisely to their requirements, thanks to our plugin's straightforward approach.</p>
						
						<p>Thank you for considering and being a part of this journey.</p>
						
						<p>
							Best Regards,<br/>
							<strong><?php echo esc_attr(EWPT_DEV1_NAM); ?></strong> and <strong><?php echo esc_attr(EWPT_DEV2_NAM); ?></strong>
						</p>
						
						</div>
					</div>
					
				</div>
			</div>
			
			<div id="about-ewpt" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">About <?php echo esc_attr(EWPT_FULL_NAME); ?></h3>
					
					<table class="form-table ewpt-form ewpt-no-bottom-border">
						<tr valign="top">
							<th scope="row">Name:</th>
							<td>
								<div class='ewpt-info-blue'>
									<a class="ewpt-module-info" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>"><?php echo esc_attr(EWPT_FULL_NAME); ?></a> v<?php echo esc_attr(EWPT_VERSION_NO); ?>
								</div>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row"></th>
							<td>
								<div class='ewpt-info-blue'>
									<?php echo esc_attr(EWPT_PLUGIN_DESC); ?>
								</div>
							</td>
						</tr>
					
						<tr valign="top">
							<th scope="row">Author:</th>
							<td>
								<div class='ewpt-info-blue'>
									<a class="ewpt-module-info" target="_blank" href="<?php echo esc_url(EWPT_DEV1_URL); ?>"><?php echo esc_attr(EWPT_DEV1_NAM); ?></a>,<br/>
									<a class="ewpt-module-info" target="_blank" href="<?php echo esc_url(EWPT_DEV2_URL); ?>"><?php echo esc_attr(EWPT_DEV2_NAM); ?></a>
								</div>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row">WordPress.org:</th>
							<td>
								<div class='ewpt-info-blue'>
									<?php echo esc_url(EWPT_PLUGIN_WP_URL); ?>
								</div>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row">Patreon:</th>
							<td>
								<div class='ewpt-info-blue'>
									<?php echo esc_url(EWPT_DONATE_URL1); ?>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Buy me a coffee:</th>
							<td>
								<div class='ewpt-info-blue'>
									<?php echo esc_url(EWPT_DONATE_URL2); ?>
								</div>
							</td>
						</tr>
						
					</table>
					
					<h3>Donate <?php echo esc_attr(EWPT_FULL_NAME); ?></h3>
					
					<div class="ewpt-form ewpt-border-radius-bottom-5px ewpt-no-tab-target">
						<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
							We are offering the main plugin and its core features free of cost to everyone.
							<br/>
							Consider a one-time contribution or a monthly subscription, every bit helps.
							<br/><br/>
							
							<strong>Please consider supporting</strong> us by visiting the donation link below.
							<br/>
							Learn more on the <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-donate">Donation Page</a>
							<br/><br/>
							
							Best Regards,<br/>
							<strong><?php echo esc_attr(EWPT_DEV1_NAM); ?></strong> and <strong><?php echo esc_attr(EWPT_DEV2_NAM); ?></strong>
							<br/><br/>
							
							<a title="Become a patron" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL1); ?>"><img width="96px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/patreon-btn.png" /></a>
							<a title="Buy me a coffee" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL2); ?>"><img width="96px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/bmac-btn.png" /></a>
							<a title="Hire us" target="_self" href="<?php echo esc_url(EWPT_HIREUS_URL); ?>"><img width="96px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/hire-btn.png" /></a>
						</div>
					</div>
					
				</div>
			</div>
			
			<?php submit_button('Save Changes'); ?>
				
		</form>
		
	</div>

	<?php
	// Include the module footer file
	include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php';
	?>
	
	<?php
}

// Include the admin hooks file
include_once (plugin_dir_path(__FILE__) . 'ewpt-admin-hooks.php');

} // if (!function_exists('essential_wp_tools_settings_page_rsmhr'))