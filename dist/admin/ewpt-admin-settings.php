<?php
// essential-wp-tools/admin/ewpt-admin-settings.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

// Register settings
add_action( 'init', function () {
	ewpt::register_setting_data('essential_wp_tools_settings', 'ewpt_first_activated_datetime', 'dtzone');
	foreach (EWPT_MODULES_FOLDERS_ARRAY as $module_folder) {
		$folder_name = basename($module_folder);
		$option_name = 'ewpt_enable_' . str_replace('-', '_', $folder_name);
		ewpt::register_setting_data('essential_wp_tools_settings', $option_name, 'boolean');
	}
});

// Add menu items
add_action( 'admin_menu', function ($icon_data_in_base64) {
	$icon_data_in_base64 = wp_remote_retrieve_body(wp_remote_get(EWPT_PLUGIN_URL.'admin/assets/img/ewpt-icon.svg'));
	add_menu_page(
		'Essential WP Tools',
		'EWPT Dashboard',
		'manage_options',
		'essential-wp-tools',
		'ewpt_essential_wp_tools_settings_page',
		"data:image/svg+xml;base64,".$icon_data_in_base64, // the icon
		2  // The position
	);
});

// Create the admin settings page
if (!function_exists('ewpt_essential_wp_tools_settings_page')) {
function ewpt_essential_wp_tools_settings_page() {
	//Defined Parameters
	$EWPT_MODULE_TAB_VAR = "EWPT";
	$EWPT_MODULE_TAB_DEFAULT = "ewpt-dashboard";
	global $EWPT_MODULES_FOLDERS_COUNT;
	
	// Array to store all active module details
	$ewpt_active_modules = array();
	
	// Loop through each module folder
	foreach (EWPT_MODULES_FOLDERS_ARRAY as $module_folder) {
		// Get the folder name without path
		$folder_name = basename($module_folder);
		
		// Define the option name based on the folder name
		$option_name = 'ewpt_enable_' . str_replace('-', '_', $folder_name);
		
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

	<div id="ewpt-page-header" class="ewpt-page-header">
			
		<link rel="stylesheet" href="<?php echo esc_url(EWPT_PLUGIN_URL); ?>inc/ewpt-admin-style.css" media="all">
			
		<div class="ewpt-header-bg">
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
		</div>
		
		<?php settings_errors(); ?>
		
	</div>
		
	<div id="ewpt-page-main" class="wrap ewpt-page-main">

		<div id="ewpt-page-body" class="ewpt-page-body">
			
			<!-- Show Mask -->
			<h1>
				<div id="ewpt-mask"></div>
			</h1>
	
			<!-- Tab -->
			<h2 class="nav-tab-wrapper">
				<a href="#<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="nav-tab">Dashboard</a>
				<a href="#modules-manager" class="nav-tab">Installed Modules <?php echo '('.intval($EWPT_MODULES_FOLDERS_COUNT).')'; ?></a>
				<a href="#modules-repository" class="nav-tab">Download Modules</a>
				<a href="#modules-uploader" class="nav-tab">Modules Uploader</a>
				<a href="#upcoming-modules" class="nav-tab">Upcoming Modules (26)</a>
				<a href="#about-ewpt" class="nav-tab">About</a>
				<div class="nav-tab ewpt-save-button"><p class="submit"><input form="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p></div>
			</h2>
			
			<form id="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" name="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" method="post" action="options.php">
				
				<?php wp_nonce_field( esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce'), esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce') ); ?>
				<?php //settings_errors(); ?>
				<?php settings_fields(esc_attr(strtolower(EWPT_FULL_VAR).'_settings')); ?>
				<?php //do_settings_sections(esc_attr(strtolower(EWPT_FULL_VAR).'_settings')); ?>
				<?php //do_settings_sections(esc_attr(strtolower(EWPT_FULL_SLUG))); ?>
				
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
								Learn more on the <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-about#donate">Donation Page</a>
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
						<h3 class="ewpt-no-top-border">Installed Modules <?php echo '('.intval($EWPT_MODULES_FOLDERS_COUNT).')'; ?></h3>
						
						<div class="ewpt-form">
							<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
									More essential modules are available on <a class="ewpt-button-link-text" title="Download Modules" href="<?php echo esc_url(EWPT_DASH_URL); ?>#modules-repository">Download Modules</a><br/>
									+ Explore all available modules on <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url(EWPT_MODULES_REPO_URL); ?>">Modules</a> repository.<br/>
									+ Please contribute and learn more on the <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-about#donate">Donation Page</a><br/>
									+ Now, accepting new Features, <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url(EWPT_FEATURE_REQ); ?>">Request Here</a><br/>
									+ Please, rate EWPT on WordPress <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url('https://wordpress.org/support/plugin/essential-wp-tools/reviews/?filter=5'); ?>">Rate 5 Star</a>
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
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="upcoming-modules" class="tab-content">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Upcoming Modules (26)</h3>
						
						<div class="ewpt-form">
							<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
									Production ready modules will be available on <a class="ewpt-button-link-text" title="Download Modules" href="<?php echo esc_url(EWPT_DASH_URL); ?>#modules-repository">Download Modules</a><br/>
									+ Explore all upcoming modules on <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url(EWPT_UPCOMING_MODULES_URL); ?>">Upcoming</a> repository.<br/>
									+ Please contribute and learn more on the <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-about#donate">Donation Page</a><br/>
									+ Now, accepting new Features, <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url(EWPT_FEATURE_REQ); ?>">Request Here</a><br/>
									+ Please, rate EWPT on WordPress <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url('https://wordpress.org/support/plugin/essential-wp-tools/reviews/?filter=5'); ?>">Rate 5 Star</a>
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
								<th scope="row">GitHub Repository:</th>
								<td>
									<div class='ewpt-info-blue'>
										<?php echo esc_url(EWPT_GITHUB_REPO_URL); ?>
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
								Learn more on the <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-about#donate">Donation Page</a>
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
				
			</form>
		
			<div id="modules-repository" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">Download Modules</h3>
					
					<div class="ewpt-form">
						<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
								Download available EWPT modules and upload via <a class="ewpt-button-link-text" title="Modules Uploader" href="<?php echo esc_url(EWPT_DASH_URL); ?>#modules-uploader">Modules Uploader</a><br/>
								+ Very soon we will add one click module install and search via API.<br/>
								+ Please contribute and learn more on the <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-about#donate">Donation Page</a><br/>
								+ Now, accepting new Features, <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url(EWPT_FEATURE_REQ); ?>">Request Here</a><br/>
								+ Please, rate EWPT on WordPress <a class="ewpt-button-link-text" target="_blank" href="<?php echo esc_url('https://wordpress.org/support/plugin/essential-wp-tools/reviews/?filter=5'); ?>">Rate 5 Star</a>
						</div>
					</div>
					
					<table class="wp-list-table widefat striped ewpt-no-top-border ewpt-border-radius-bottom-5px">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Module Name</th>
								<th scope="col">Download</th>
								<th scope="col">Status</th>
								<th scope="col" class="admin-module-desc">Description</th>
							</tr>
						</thead>
						<tbody>
							<tr valign="top">
								<td>1</td>
								<td>
									<a class="ewpt-module-name" target="_blank" href="https://ewpt.ractstudio.com/module/ad-insert-hub/">Ad Insert Hub</a><br>
									&#x1f5cd; v1.0.0<br>
									by <a title="Author: Mahamudul Hasan Rubel" class="ewpt-module-author" target="_blank" href="https://mhr.ractstudio.com/">Mahamudul Hasan Rubel</a>
								</td>
								<td>
									<a class="ewpt-button-link-text ewpt-enlarge-1x" title="Download from GitHub" href="<?php echo esc_url(EWPT_GITHUB_MODOULE_DOWNLOAD . 'ad-insert-hub.zip'); ?>" download="ad-insert-hub.zip">&#x1F4C1; Download</a>
								</td>
								<td>
									<div class="ewpt-info-green"> Production </div>
								</td>
								<td class="admin-module-desc">
									<div class="ewpt-info-blue"> Manage ad placement on your website with our comprehensive module, compatible with Google Ads and other leading providers. </div>
								</td>
							</tr>
							<tr valign="top">
								<td>2</td>
								<td>
									<a class="ewpt-module-name" target="_blank" href="https://ewpt.ractstudio.com/module/email-manager-hub/">Email Manager Hub</a><br/>
									&#x1f5cd; v1.0.0 <br>
									by <a title="Author: Mahamudul Hasan Rubel" class="ewpt-module-author" target="_blank" href="https://mhr.ractstudio.com/">Mahamudul Hasan Rubel</a>
								</td>
								<td>
									<a class="ewpt-button-link-text ewpt-enlarge-1x" title="Download from GitHub" href="<?php echo esc_url(EWPT_GITHUB_MODOULE_DOWNLOAD . 'email-manager-hub.zip'); ?>" download="email-manager-hub.zip">&#x1F4C1; Download</a>
								</td>
								<td>
									<div class="ewpt-info-red"> Development </div>
								</td>
								<td class="admin-module-desc">
									<div class="ewpt-info-blue"> Manage your WordPress site's email sender's name and email address, and in future we will add stunning HTML template-based emails. </div>
								</td>
							</tr>
							<tr valign="top">
								<td>3</td>
								<td>
									<a class="ewpt-module-name" target="_blank" href="https://ewpt.ractstudio.com/module/essential-tools/">Essential Tools</a><br>
									&#x1f5cd; v1.0.0<br> 
									by <a title="Author: RactStudio" class="ewpt-module-author" target="_blank" href="https://ractstudio.com/">RactStudio</a>
								</td>
								<td>
									<a class="ewpt-button-link-text ewpt-enlarge-1x" title="Download from GitHub" href="<?php echo esc_url(EWPT_GITHUB_MODOULE_DOWNLOAD . 'essential-tools.zip'); ?>" download="essential-tools.zip">&#x1F4C1; Download</a>
								</td>
								<td>
									<div class="ewpt-info-green"> Production </div>
								</td>
								<td class="admin-module-desc">
									<div class="ewpt-info-blue"> Effortlessly switch between and customize a variety of features and technical components on your WordPress site. </div>
								</td>
							</tr>
							<tr valign="top">
								<td>4</td>
								<td>
									<a class="ewpt-module-name" target="_blank" href="https://ewpt.ractstudio.com/module/maintenance-mode/">Maintenance Mode</a><br/>
									&#x1f5cd; v1.0.0<br>
									by <a title="Author: RactStudio" class="ewpt-module-author" target="_blank" href="https://ractstudio.com/">RactStudio</a>
								</td>
								<td>
									<a class="ewpt-button-link-text ewpt-enlarge-1x" title="Download from GitHub" href="<?php echo esc_url(EWPT_GITHUB_MODOULE_DOWNLOAD . 'maintenance-mode.zip'); ?>" download="maintenance-mode.zip">&#x1F4C1; Download</a>
								</td>
								<td>
									<div class="ewpt-info-green"> Production </div>
								</td>
								<td class="admin-module-desc">
									<div class="ewpt-info-blue"> Maintenance Mode across your site, tailored to different user roles. Customize the maintenance page with our feature-rich customizer. </div>
								</td>
							</tr>
							<tr valign="top">
								<td>5</td>
								<td>
									<a class="ewpt-module-name" target="_blank" href="https://ewpt.ractstudio.com/module/sample-module/">Sample Module</a><br>
									&#x1f5cd; v0.1.0<br>
									by <a title="Author: RactStudio" class="ewpt-module-author" target="_blank" href="https://ractstudio.com/">RactStudio</a>
								</td>
								<td>
									<a class="ewpt-button-link-text ewpt-enlarge-1x" title="Download from GitHub" href="<?php echo esc_url(EWPT_GITHUB_MODOULE_DOWNLOAD . 'sample-module.zip'); ?>" download="sample-module.zip">&#x1F4C1; Download</a>
								</td>
								<td>
									<div class="ewpt-info-red"> Development </div>
								</td>
								<td class="admin-module-desc">
									<div class="ewpt-info-blue"> This is a sample module for developers to build module for EWPT. </div>
								</td>
							</tr>
							<tr valign="top">
								<td>6</td>
								<td>
									<a class="ewpt-module-name" target="_blank" href="https://ewpt.ractstudio.com/module/social-share-hub/">Social Share Hub</a><br>
									&#x1f5cd; v1.0.0<br>
									by <a title="Author: Mahamudul Hasan Rubel" class="ewpt-module-author" target="_blank" href="https://mhr.ractstudio.com/">Mahamudul Hasan Rubel</a>
								</td>
								<td>
									<a class="ewpt-button-link-text ewpt-enlarge-1x" title="Download from GitHub" href="<?php echo esc_url(EWPT_GITHUB_MODOULE_DOWNLOAD . 'social-share-hub.zip'); ?>" download="social-share-hub.zip">&#x1F4C1; Download</a>
								</td>
								<td>
									<div class="ewpt-info-green"> Production </div>
								</td>
								<td class="admin-module-desc">
									<div class="ewpt-info-blue"> Integrate social share hub (buttons) into posts, pages, and custom post types with customization options. </div>
								</td>
							</tr>
							<tr valign="top">
								<td>7</td>
								<td>
									<a class="ewpt-module-name" target="_blank" href="https://ewpt.ractstudio.com/module/system-info/">System Info</a><br>
									&#x1f5cd; v1.0.0<br>
									by <a title="Author: RactStudio" class="ewpt-module-author" target="_blank" href="https://ractstudio.com/">RactStudio</a>
								</td>
								<td>
									<a class="ewpt-button-link-text ewpt-enlarge-1x" title="Download from GitHub" href="<?php echo esc_url(EWPT_GITHUB_MODOULE_DOWNLOAD . 'system-info.zip'); ?>" download="system-info.zip">&#x1F4C1; Download</a>
								</td>
								<td>
									<div class="ewpt-info-green"> Production </div>
								</td>
								<td class="admin-module-desc">
									<div class="ewpt-info-blue"> Access PHP Info, WordPress Info, Database Info, and Developer Info etc. </div>
								</td>
							</tr>
						</tbody>
					</table>
										
				</div>
				
			</div>
			
			<div id="modules-uploader" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">Modules Uploader</h3>
					
							<div class="ewpt-row ewpt-border-radius-bottom-5px">
							
								<div class="ewpt-column-1">
									
									<form id="ewpt-upload-form" enctype="multipart/form-data" style="text-align: center;">
										<?php wp_nonce_field('ewpt_upload_nonce', 'ewpt_upload_nonce'); ?>
										<input type="file" id="ewpt-module-file" class="button" name="ewpt_module_file" accept=".zip" />
										<input type="submit" class="button" value="Upload Module" />
									</form>
									<div id="ewpt-upload-result"></div>
									
									<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
											Explore all installed EWPT modules on your site at <a class="ewpt-button-link-text" title="Installed Modules" href="<?php echo esc_url(EWPT_DASH_URL); ?>#modules-manager">Installed Modules</a><br/>
											+ Please, don't leave the page until module upload is completed.<br/>
											+ Please, upload only one .zip EWPT module at once.<br/>
											+ Please, do not upload WordPress based plugin.
									</div>
								
								</div>
								
							</div>
					
				</div>
				
			</div>
			
		</div>
		
		<div id="ewpt-page-footer" class="ewpt-page-footer">
			
			<!-- Activate Module Modal -->
			<div id="activateModuleModal" class="ewpt modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<header>
						<h2>Activate the module!</h2>
					</header>
					<div>
						<p id="confirm-message">
							Module uploaded successfully.<br />
							Do you want to activate it?
						</p>
					</div>
					<footer>
						<button id="activateModuleConfirm" class="ok button">Yes, Activate Module</button>
						<button id="activateModuleCancel" class="cancel button">Cancel</button>
					</footer>
				</div>
			</div>
			
			<!-- Merge Module Modals -->
			<div id="mergeModuleModal" class="ewpt modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<header>
						<h2>Module already exist!</h2>
					</header>
					<div>
						<p id="confirm-message">
							Module with the same name already exists!<br />
							Are you sure you want to merge the existing module?
						</p>
					</div>
					<footer>
						<button id="confirmMergeModule" class="ok button">Yes, Merge Module</button>
						<button id="cancelMergeModule" class="cancel button">Cancel</button>
					</footer>
				</div>
			</div>

			<!-- Delete Confirmation Modal -->
			<div id="deleteModuleModal" class="ewpt modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<header>
						<h2>Confirmation</h2>
					</header>
					<div>
						<p id="confirm-delete-message">
							Are you sure you want to delete this module?<br/>
							Module: <strong id="confirm-delete-module-name"></strong>
						</p>
					</div>
					<footer>
						<button id="confirmDeleteModule" class="ok button">Yes, Delete Module</button>
						<button id="cancelDeleteModule" class="cancel button">Cancel</button>
					</footer>
				</div>
			</div>

			<script>
			jQuery(document).ready(function($) {
				var saveModal = $('#saveModal');
				var ewptMask = $('#ewpt-mask');
				var moduleFile, uploadedModuleName;
				var ajaxRetryLimit = 3;

				// Function to show modals with dynamic messages
				function showModal(modalId, message, isSuccess) {
					var $modal = $('#' + modalId);
					$modal.find('p').html(message);
					if (isSuccess) {
						$modal.removeClass('errors').addClass('success');
					} else {
						$modal.removeClass('success').addClass('errors');
					}
					$modal.fadeIn();
					setTimeout(function() {
						$modal.fadeOut();
					}, 6000);
				}

				// Retry function for AJAX
				function retryAjax(options, retries) {
					$.ajax(options).fail(function(xhr, status, error) {
						if (retries > 1) {
							retryAjax(options, retries - 1);
						} else {
							var errorMessage = '<strong>An error occurred while processing the request. Please try again later.</strong>';
							if (status === 'timeout') {
								errorMessage = '<strong>The request timed out. Please check your network connection and try again.</strong>';
							} else if (status === 'error') {
								errorMessage = '<strong>There was a problem processing the request. Please try again later.</strong>';
							} else if (status === 'abort') {
								errorMessage = '<strong>The request was aborted. Please try again later.</strong>';
							}
							showModal('saveModal', errorMessage, false);
							ewptMask.hide();
						}
					});
				}

				// Handle form submission for upload
				$('#ewpt-upload-form').on('submit', function(e) {
					e.preventDefault();

					var fileInput = $('#ewpt-module-file')[0];
					if (!fileInput.files.length) {
						showModal('saveModal', '<strong>Please select a .ZIP module.</strong>', false);
						return;
					}

					moduleFile = fileInput.files[0];

					var formData = new FormData();
					formData.append('ewpt_module_file', moduleFile);
					formData.append('action', 'ewpt_upload_module');
					formData.append('ewpt_upload_nonce', $('#ewpt_upload_nonce').val());

					ewptMask.show();

					retryAjax({
						type: 'POST',
						url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
						data: formData,
						processData: false,
						contentType: false,
						cache: false,
						timeout: 300000, // Set timeout to 300 seconds
						success: function(response) {
							if (response.success) {
								uploadedModuleName = response.data.module_name;
								if (response.data.merge_option) {
									if (!response.data.module_active) {
										$('#mergeModuleModal').show();
									} else {
										showModal('saveModal', '<strong>Module uploaded successfully and is already active.</strong>', 'success');
									}
								} else {
									$('#activateModuleModal').show();
								}
							} else {
								showModal('saveModal', response.data.message, false);
							}
							ewptMask.hide();
						},
						error: function() {
							showModal('saveModal', '<strong>Error during file upload.</strong>', false);
							ewptMask.hide();
						}
					}, ajaxRetryLimit);
				});

				// Confirm merge module
				$('#confirmMergeModule').on('click', function() {
					var formData = new FormData();
					formData.append('action', 'ewpt_merge_module');
					formData.append('module_name', uploadedModuleName);
					formData.append('ewpt_upload_nonce', $('#ewpt_upload_nonce').val());
					formData.append('ewpt_module_file', moduleFile);

					ewptMask.show();

					$('#mergeModuleModal').hide();

					retryAjax({
						url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
						type: 'POST',
						data: formData,
						processData: false,
						contentType: false,
						success: function(response) {
							if (response.success) {
								$('#activateModuleModal').show();
								ewptMask.hide();
							} else {
								reloadPageContent(response.data.message, false);
							}
						}
					}, ajaxRetryLimit);
				});

				// Close modal on cancel merge
				$('#cancelMergeModule').on('click', function() {
					ewptMask.show();
					$('#mergeModuleModal').hide();
					reloadPageContent('', '');
				});

				// Confirm activation of module
				$('#activateModuleConfirm').on('click', function() {
					var formData = new FormData();
					formData.append('action', 'ewpt_activate_module');
					formData.append('module_name', uploadedModuleName);
					formData.append('ewpt_upload_nonce', $('#ewpt_upload_nonce').val());

					ewptMask.show();

					$('#activateModuleModal').hide();

					retryAjax({
						url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
						type: 'POST',
						data: formData,
						processData: false,
						contentType: false,
						success: function(response) {
							if (response.success) {
								reloadPageContent(response.data.message, 'success');
							} else {
								reloadPageContent(response.data.message, false);
							}
						}
					}, ajaxRetryLimit);
				});

				// Close modal on cancel activation
				$('#activateModuleCancel').on('click', function() {
					ewptMask.show();
					$('#activateModuleModal').hide();
					reloadPageContent('<strong>Module uploaded and unzipped successfully.</strong>', 'success');
				});

				// Capitalize each word and replace hyphens with spaces
				function formatModuleName(moduleName) {
					return moduleName
						.replace(/-/g, ' ') // Replace hyphens with spaces
						.replace(/\b\w/g, function(char) {
							return char.toUpperCase(); // Capitalize the first letter of each word
						});
				}

				// Show delete confirmation modal for all delete buttons using event delegation
				$(document).on('click', 'a.deleteModuleButton', function(event) {
					event.preventDefault();
					moduleNameToDelete = $(this).attr('module'); // Set module name to delete here
					if (moduleNameToDelete) {
						var formattedModuleName = formatModuleName(moduleNameToDelete);
						$('#confirm-delete-module-name').html(formattedModuleName);
						$('#deleteModuleModal').show();
					}
				});

				// Confirm module deletion
				$('#confirmDeleteModule').on('click', function() {
					var formData = new FormData();
					formData.append('action', 'ewpt_delete_module');
					formData.append('module_name', moduleNameToDelete); // Use moduleNameToDelete here
					formData.append('<?php echo esc_attr(strtolower(EWPT_SHORT_SLUG) . '_nonce'); ?>', $('#<?php echo esc_attr(strtolower(EWPT_SHORT_SLUG) . '_nonce'); ?>').val());

					ewptMask.show(); // Show the mask

					//Hide confirmation Modal
					$('#deleteModuleModal').hide();

					retryAjax({
						url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
						type: 'POST',
						data: formData,
						processData: false,
						contentType: false,
						cache: false,
						timeout: 60000, // Set timeout to 60 seconds
						success: function(response) {
							if (response.success) {
								reloadPageContent(response.data.message, 'success');
							} else {
								reloadPageContent(response.data.message, false);
							}
						}
					}, ajaxRetryLimit); // Use the ajaxRetryLimit variable
				});

				// Close modal on cancel delete
				$('#cancelDeleteModule').on('click', function() {
					$('#deleteModuleModal').hide();
				});

				// Close modal event
				$('.close').on('click', function() {
					$(this).closest('.modal').hide();
				});

				// Function to reload the page content
				function reloadPageContent(successMessage, modalClass) {
					retryAjax({
						type: 'GET',
						url: window.location.href,
						cache: false,
						timeout: 60000, // Set timeout to 60 seconds
						success: function(data) {
							var newFormMain = $(data).find('#ewpt-page-main').html();
							$('#ewpt-page-main').html(newFormMain);

							var newEWPTmenuBar = $(data).find('#toplevel_page_<?php echo esc_attr(EWPT_FULL_SLUG); ?>').html();
							$('#toplevel_page_<?php echo esc_attr(EWPT_FULL_SLUG); ?>').html(newEWPTmenuBar);

							reinitializeScripts();

							if (successMessage && successMessage.length > 0) {
								showModal('saveModal', successMessage, modalClass === 'success');
							}
							
							// Hide the mask
							ewptMask.hide();
						},
						error: function(xhr, status, error) {
							showModal('saveModal', "<strong>Failed to reload the page content.</strong><br/>Reload the page and try again.", false);
							ewptMask.hide();
						}
					}, ajaxRetryLimit);
				}

				function reinitializeScripts() {
					// Reinitialize the dismissible notices
					reinitializeDismissibleNotices();
					// Trigger the window load event to ensure all scripts are properly reinitialized
					$(window).trigger('load');
				}

				function reinitializeDismissibleNotices() {
					$('#ewpt-page-main .notice.is-dismissible').each(function() {
						var $this = $(this);
						var $button = $('<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>');
						$button.on('click.wp-dismiss-notice', function(event) {
							event.preventDefault();
							$this.fadeTo(100, 0, function() {
								$this.slideUp(100, function() {
									$this.remove();
								});
							});
						});
						$this.append($button);
					});
				}
				
			});
			</script>

			<?php
			// Include the module footer file
			include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php';
			?>
			
		</div>
		
	</div>

	<?php
}

	// AJAX actions for handling module upload, merge, activation, and deletion
	add_action('wp_ajax_ewpt_upload_module', function () {
		if (!ewpt::check_nonce('ewpt_upload_nonce')) {
			wp_send_json_error(array('message' => '<strong>Security (nonce) verification failed!</strong><br/>Reload the page and try again.'));
			exit;
		}
		
		global $wp_filesystem;

		// Initialize the WordPress filesystem
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			// Check if WP_ADMIN_DIR is defined
			if (defined('WP_ADMIN_DIR')) {
				require_once ABSPATH . WP_ADMIN_DIR . '/includes/file.php';
			} else {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
		}

		WP_Filesystem();

		// Check if WP_Filesystem is initialized
		if (!is_object($wp_filesystem) || !method_exists($wp_filesystem, 'move')) {
			error_log('EWPT: WP_Filesystem initialization failed.');
			wp_send_json_error(array('message' => '<strong>Filesystem initialization failed.</strong>'));
			exit;
		}

		if (!empty($_FILES['ewpt_module_file']) && $_FILES['ewpt_module_file']['error'] == UPLOAD_ERR_OK) {
			$uploaded_file = $_FILES['ewpt_module_file'];
			$upload_file_path = EWPT_MODULES_PATH . DIRECTORY_SEPARATOR . basename($uploaded_file['name']);

			// Ensure the destination directory exists
			if (!$wp_filesystem->is_dir(EWPT_MODULES_PATH)) {
				if (!$wp_filesystem->mkdir(EWPT_MODULES_PATH, 0755)) {
					error_log('EWPT: Failed to create module directory: ' . EWPT_MODULES_PATH);
					wp_send_json_error(array('message' => '<strong>Failed to create module directory.</strong>'));
					exit;
				}
			}

			// Check permissions of tmp_name and destination directory
			if (!$wp_filesystem->is_writable($uploaded_file['tmp_name'])) {
				error_log('EWPT: Uploaded file is not writable: ' . $uploaded_file['tmp_name']);
				wp_send_json_error(array('message' => '<strong>Uploaded file is not writable.</strong>'));
				exit;
			}

			if (!$wp_filesystem->is_writable(EWPT_MODULES_PATH)) {
				error_log('EWPT: Destination directory is not writable: ' . EWPT_MODULES_PATH);
				wp_send_json_error(array('message' => '<strong>Destination directory is not writable.</strong>'));
				exit;
			}

			if ($wp_filesystem->move($uploaded_file['tmp_name'], $upload_file_path)) {
				//error_log('EWPT: File moved successfully to ' . $upload_file_path);
				$unzip_result = ewpt::handle_file_unzip($upload_file_path);
				$wp_filesystem->delete($upload_file_path);

				if (is_wp_error($unzip_result)) {
					error_log('EWPT: Upload error: ' . $unzip_result->get_error_message());
					wp_send_json_error(array('message' => '<strong>Failed to unzip the module: ' . $unzip_result->get_error_message() . '</strong>'));
				} else {
					$module_name = $unzip_result['module_name'];
					$module_dir = EWPT_MODULES_PATH . DIRECTORY_SEPARATOR . $module_name;

					if ($wp_filesystem->is_dir($module_dir)) {
						ewpt::delete_module_dir($unzip_result['unzip_dir']);
						wp_send_json_success(array(
							'message' => "A module with the same name already exists.",
							'module_name' => $module_name,
							'merge_option' => true,
							'module_active' => false, // Assuming it's not active; update as needed
						));
					} else {
						$wp_filesystem->move($unzip_result['unzip_dir'] . DIRECTORY_SEPARATOR . $module_name, $module_dir);
						ewpt::delete_module_dir($unzip_result['unzip_dir']);

						if (ewpt::validate_module($module_dir, $module_name)) {
							wp_send_json_success(array(
								'message' => "Module uploaded and unzipped successfully.",
								'module_name' => $module_name,
								'merge_option' => false,
								'module_active' => false, // Assuming it's not active; update as needed
							));
						} else {
							ewpt::delete_module_dir($module_dir);
							wp_send_json_error(array('message' => '<strong>Required files are missing or invalid module structure.</strong>'));
						}
					}
				}
			} else {
				error_log('EWPT: Upload failed: Unable to move uploaded file.');
				wp_send_json_error(array('message' => '<strong>Failed to upload file.</strong>'));
			}
		} else {
			error_log('EWPT: Upload error: No file uploaded or upload error. Error code: ' . $_FILES['ewpt_module_file']['error']);
			wp_send_json_error(array('message' => '<strong>No file uploaded or upload error.</strong>'));
		}
	});

	add_action('wp_ajax_ewpt_merge_module', function () {
		if (!ewpt::check_nonce('ewpt_upload_nonce')) {
			wp_send_json_error(array('message' => '<strong>Security (nonce) verification failed!</strong><br/>Reload the page and try again.'));
			exit;
		}

		global $wp_filesystem;

		// Initialize the WordPress filesystem
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			// Check if WP_ADMIN_DIR is defined
			if (defined('WP_ADMIN_DIR')) {
				require_once ABSPATH . WP_ADMIN_DIR . '/includes/file.php';
			} else {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
		}

		WP_Filesystem();

		// Check if WP_Filesystem is initialized
		if (!is_object($wp_filesystem) || !method_exists($wp_filesystem, 'move')) {
			error_log('EWPT: WP_Filesystem initialization failed.');
			wp_send_json_error(array('message' => '<strong>Filesystem initialization failed.</strong>'));
			exit;
		}

		$module_name = isset($_POST['module_name']) ? sanitize_text_field($_POST['module_name']) : null;

		if (!empty($_FILES['ewpt_module_file']) && $_FILES['ewpt_module_file']['error'] == UPLOAD_ERR_OK) {
			$uploaded_file = $_FILES['ewpt_module_file'];
			$upload_file_path = EWPT_MODULES_PATH . DIRECTORY_SEPARATOR . basename($uploaded_file['name']);

			// Ensure the destination directory exists
			if (!$wp_filesystem->is_dir(EWPT_MODULES_PATH)) {
				if (!$wp_filesystem->mkdir(EWPT_MODULES_PATH, 0755)) {
					error_log('EWPT: Failed to create module directory: ' . EWPT_MODULES_PATH);
					wp_send_json_error(array('message' => '<strong>Failed to create module directory.</strong>'));
					exit;
				}
			}

			// Check permissions of tmp_name and destination directory
			if (!$wp_filesystem->is_writable($uploaded_file['tmp_name'])) {
				error_log('EWPT: Uploaded file is not writable: ' . $uploaded_file['tmp_name']);
				wp_send_json_error(array('message' => '<strong>Uploaded file is not writable.</strong>'));
				exit;
			}

			if (!$wp_filesystem->is_writable(EWPT_MODULES_PATH)) {
				error_log('EWPT: Destination directory is not writable: ' . EWPT_MODULES_PATH);
				wp_send_json_error(array('message' => '<strong>Destination directory is not writable.</strong>'));
				exit;
			}

			if ($wp_filesystem->move($uploaded_file['tmp_name'], $upload_file_path)) {
				//error_log('File moved successfully to ' . $upload_file_path);
				$module_dir = EWPT_MODULES_PATH . DIRECTORY_SEPARATOR . $module_name;

				// Delete existing module directory (with previous user customization).
				if ($wp_filesystem->is_dir($module_dir)) {
					ewpt::delete_module_dir($module_dir);
				}

				$unzip_result = ewpt::handle_file_unzip($upload_file_path);
				$wp_filesystem->delete($upload_file_path);

				if (is_wp_error($unzip_result)) {
					error_log('EWPT: Upload error: ' . $unzip_result->get_error_message());
					wp_send_json_error(array('message' => '<strong>Failed to unzip the module: ' . $unzip_result->get_error_message() . '</strong>'));
				} else {
					$module_name = $unzip_result['module_name'];
					$module_dir = EWPT_MODULES_PATH . DIRECTORY_SEPARATOR . $module_name;

					$wp_filesystem->move($unzip_result['unzip_dir'] . DIRECTORY_SEPARATOR . $module_name, $module_dir);
					ewpt::delete_module_dir($unzip_result['unzip_dir']);

					if (ewpt::validate_module($module_dir, $module_name)) {
						wp_send_json_success(array(
							'message' => "<strong>Module uploaded and unzipped successfully.</strong>",
							'module_name' => $module_name,
						));
					} else {
						ewpt::delete_module_dir($module_dir);
						wp_send_json_error(array('message' => '<strong>Required files are missing or invalid module structure.</strong>'));
					}
				}
			} else {
				error_log('EWPT: Upload failed: Unable to move uploaded file.');
				wp_send_json_error(array('message' => '<strong>Failed to upload file.</strong>'));
			}
		} else {
			error_log('EWPT: Upload error: No file uploaded or upload error. Error code: ' . $_FILES['ewpt_module_file']['error']);
			wp_send_json_error(array('message' => '<strong>No file uploaded or upload error.</strong>'));
		}
	});

	add_action('wp_ajax_ewpt_activate_module', function () {
		if (!ewpt::check_nonce('ewpt_upload_nonce')) {
			wp_send_json_error(array('message' => '<strong>Security (nonce) verification failed!</strong><br/>Reload the page and try again.'));
			exit;
		}

		$module_name = isset($_POST['module_name']) ? sanitize_text_field($_POST['module_name']) : null;

		if ($module_name) {
			$option_name = 'ewpt_enable_' . str_replace('-', '_', $module_name);
			$module_status = get_option($option_name, false);

			if (empty($module_status)) {
				if (update_option($option_name, true)) {
					wp_send_json_success(array('message' => '<strong>Module activated successfully.</strong>'));
				} else {
					wp_send_json_error(array('message' => '<strong>Failed to activate module.</strong>'));
				}
			} else {
				wp_send_json_success(array('message' => '<strong>Module is already active.</strong>'));
			}
		} else {
			wp_send_json_error(array('message' => '<strong>Invalid module name.</strong>'));
		}
	});

	add_action('wp_ajax_ewpt_delete_module', function () {
		if (!ewpt::check_nonce(esc_attr(strtolower(EWPT_SHORT_SLUG) . '_nonce'))) {
			wp_send_json_error(array('message' => '<strong>Security (nonce) verification failed!</strong><br/>Reload the page and try again.'));
			exit;
		}
		
		global $wp_filesystem;

		// Initialize the WordPress filesystem
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			// Check if WP_ADMIN_DIR is defined
			if (defined('WP_ADMIN_DIR')) {
				require_once ABSPATH . WP_ADMIN_DIR . '/includes/file.php';
			} else {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
		}
		
		WP_Filesystem();

		$module_name = isset($_POST['module_name']) ? sanitize_text_field($_POST['module_name']) : null;

		if ($module_name) {
			$module_dir = EWPT_MODULES_PATH . $module_name . DIRECTORY_SEPARATOR;

			if (strpos(realpath($module_dir), realpath(EWPT_MODULES_PATH)) !== 0) {
				wp_send_json_error(array('message' => '<strong>Invalid module directory.</strong>'));
				return;
			}

			if (!$wp_filesystem->chmod($module_dir, 0777)) {
				wp_send_json_error(array('message' => '<strong>Failed to set permissions on the module directory.</strong>'));
				return;
			}

			if ($wp_filesystem->is_dir($module_dir)) {
				if (ewpt::delete_module_dir($module_dir)) {
					wp_send_json_success(array('message' => '<strong>Module deleted successfully.</strong>'));
				} else {
					wp_send_json_error(array('message' => '<strong>Failed to delete the module.</strong>'));
				}
			} else {
				wp_send_json_error(array('message' => '<strong>Module doesn\'t exist with this name: ' . $module_name . '</strong>'));
			}
		} else {
			wp_send_json_error(array('message' => '<strong>No module name provided.</strong>'));
		}
		exit;
	});

	// Include the admin hooks file
	include plugin_dir_path(__FILE__) . 'ewpt-admin-hooks.php';

} // if (!function_exists('ewpt_essential_wp_tools_settings_page'))