<?php
// essential-wp-tools/modules/system-info/ewpt-system-info.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

use EWPT\Modules\SystemInfo\sysinfo as sysinfo;

// Register settings
add_action( 'init', function () {
	ewpt::register_setting_data('ewpt_system_info_settings', 'ewpt_system_info_menu_link', 'string');
	ewpt::register_setting_data('ewpt_system_info_settings', 'enable_ewpt_system_php_info', 'boolean');
	
	ewpt::register_setting_data('ewpt_system_info_settings', 'ewpt_system_info_wp_api_connected_datetime', 'datetime');
	ewpt::register_setting_data('ewpt_system_info_settings', 'ewpt_system_info_wp_api_connected_data_array', 'array');
	
	ewpt::register_setting_data('ewpt_system_info_settings', 'enable_system_info_wordpress_api_update', 'boolean');
	ewpt::register_setting_data('ewpt_system_info_settings', 'custom_system_info_wordpress_api_update_interval', 'integer');
	
});

// Menu of the Module
add_action( 'admin_menu', function () {
	// Get the option for menu visibility
	$menu_visibility_option = get_option('ewpt_system_info_menu_link', 'sub_menu');
	// Module menu name parameters
	$module_name = 'System Info'; // Define the module name/title here
	ewpt::assign_modules_menu_link($menu_visibility_option, $module_name);
});

// Function to render the PHP Info settings page
if (!function_exists('ewpt_system_info_settings_page')) {
function ewpt_system_info_settings_page() {
    // Include the module config file
 	include(plugin_dir_path(__FILE__) . 'ewpt-system-info-config.php');
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
				<a href="#wordpress-info" class="nav-tab">WordPress</a>
				<a href="#media-info" class="nav-tab">Media</a>
				<a href="#directories-info" class="nav-tab">Directories</a>
				<a href="#themes-info" class="nav-tab">Themes</a>
				<a href="#plugins-info" class="nav-tab">Plugins</a>
				<a href="#server-info" class="nav-tab">Server</a>
				<a href="#database-info" class="nav-tab">Database</a>
				<a href="#wordpress-constants-info" class="nav-tab">WP Constants</a>
				<a href="#filesystem-permissions-info" class="nav-tab">Files Permissions</a>
				<a href="#php-info" class="nav-tab">PHP Info</a>
				<a href="#about-module" class="nav-tab">About</a>
				<div class="nav-tab ewpt-save-button"><p class="submit"><input form="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p></div>
			</h2>
			
			<form id="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" name="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" method="post" action="options.php">
			
				<?php wp_nonce_field( esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce'), esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce') ); ?>
				<?php //settings_errors(); ?>
				<?php settings_fields(esc_attr(strtolower(EWPT_SHORT_SLUG.'_'.$EWPT_MODULE_VAR.'_settings'))); ?>
				<?php //do_settings_sections(esc_attr(strtolower(EWPT_SHORT_SLUG.'_'.$EWPT_MODULE_VAR.'_settings'))); ?>
				<?php //do_settings_sections(esc_attr(strtolower(EWPT_SHORT_SLUG.'-'.$EWPT_MODULE_SLUG))); ?>
				
				<div id="<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border"><?php echo esc_attr($EWPT_MODULE_NAME); ?>  Settings</h3>
						
						<table class="form-table ewpt-form">
							<tr valign="top">
								<th scope="row">Menu Link</th>
								<td>
										<select name="ewpt_system_info_menu_link">
											<option value="sub_menu" <?php selected(get_option("ewpt_system_info_menu_link"), 'sub_menu'); ?>>Sub Menu</option>
											<option value="main_menu" <?php selected(get_option("ewpt_system_info_menu_link"), 'main_menu'); ?>>Main Menu</option>
											<option value="hidden_menu" <?php selected(get_option("ewpt_system_info_menu_link"), 'hidden_menu'); ?>>Hide Menu</option>
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
							<!-- WordPress API Update Interval -->
							<?php
								// Get the minimum and maximum number to save from user input
								$wp_api_interval = intval(get_option('custom_system_info_wordpress_api_update_interval', 5));
								// Ensure between 10 and 60
								if ($wp_api_interval < 1) {
									$wp_api_interval = 1;
								} elseif ($wp_api_interval > 60) {
									$wp_api_interval = 60;
								}
							?>
							<tr valign="top">
								<th scope="row">WP.org API Update Interval</th>
								<td>
									<label>
										<input type="checkbox" name="enable_system_info_wordpress_api_update" value="1" <?php checked(get_option('enable_system_info_wordpress_api_update', 0)) ?> />
										Enable
									</label>
									<label>
										<input type="number" name="custom_system_info_wordpress_api_update_interval" value="<?php echo intval($wp_api_interval); ?>" />
										Minutes
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Enter a WordPress API Update Interval time in minutes. Default 5 minutes.<br/>
										<strong>Note: Updates only upon page load, if the previous update time is outdated.</strong>
									</div>
								</td>
							</tr>
							<!-- Enable PHP Info -->
							<tr valign="top">
								<th scope="row">Enable PHP Info</th>
								<td>
									<label>
										<input type="checkbox" name="enable_ewpt_system_php_info" value="1" <?php checked(get_option('enable_ewpt_system_php_info'), 1); ?> />
										Enable PHP Info
									</label>
								</td>
							</tr>
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="wordpress-info" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">WordPress Info</h3>
						
						<?php
						// Get WordPress version data
						$wordpress_version_data = sysinfo::get_wp_api_version_data();
						
						// Get dynamic system (WordPress) information
						$ewpt_system_wordpress_info = array(
							'This WordPress Version' => sysinfo::get_wp_version(),
							'Site Language' => get_locale(),
							'User Language' => get_user_locale(),
							'Timezone' => get_option('timezone_string', '+00:00'),
							'Home URL' => home_url(),
							'Site URL' => site_url(),
							'Permalink structure' => get_option('permalink_structure', 'Default'),
							'Is this site using HTTPS?' => is_ssl() ? 'Yes' : 'No',
							'Is this a multisite?' => is_multisite() ? 'Yes' : 'No',
							'Can anyone register on this site?' => get_option('users_can_register') ? 'Yes' : 'No',
							'Is this site discouraging search engines?' => get_option('blog_public') ? 'No' : 'Yes',
							'Default comment status' => get_option('default_comment_status', 'closed'),
							'Environment type' => sysinfo::get_environment_type(),
							'User count' => count_users()['total_users'],
						);
						
						// Check if Wordpress API  Update Interval
						$wp_api_status = get_option('enable_system_info_wordpress_api_update', 0);
						// Get the minimum and maximum number to save from user input
						$wp_api_intval = intval(get_option('custom_system_info_wordpress_api_update_interval', 5));
						// Ensure between 10 and 60
						if ($wp_api_intval < 1) {
							$wp_api_intval = 1;
						} elseif ($wp_api_intval > 60) {
							$wp_api_intval = 60;
						}
						// Wordpress API  Update Interval value
						if ($wp_api_status && ($wp_api_intval <= 1)) {
							$wp_api_interval = ' (updates every 1 minute)';
						} elseif ($wp_api_status && ($wp_api_intval >= 2)) {
							$wp_api_interval = ' (updates every '. $wp_api_intval .' minutes)';
						} else {
							$wp_api_interval = '';
						}
						// Merge the arrays
						$ewpt_system_wp_info = array_merge(
							array('Latest WordPress Version' => $wordpress_version_data['current_version']. $wp_api_interval),
							$ewpt_system_wordpress_info,
							array(
								'Download Full' => $wordpress_version_data['download_full'],
								'Download No Content' => $wordpress_version_data['download_no_content'],
								'Is WordPress.org reachable?' => $wordpress_version_data['wordpress_reachable']. $wp_api_interval,
							)
						);
						?>
						
						<!-- Display dynamic system (WordPress) information in a table -->
						<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
							<?php foreach ($ewpt_system_wp_info as $label => $value) : ?>
								<tr valign="top">
									<th scope="row"><?php echo esc_attr($label); ?></th>
									<td><?php echo esc_attr($value); ?></td>
								</tr>
							<?php endforeach; ?>
							<tr valign="top">
								<th scope="row">Last data updated at:</th>
								<td><?php echo esc_attr(get_option('ewpt_system_info_wp_api_connected_datetime')); ?></td>
							</tr>
						</table>
						
					</div>
				</div>
				
				<div id="media-info" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Media Handling</h3>

						<?php
						// Get media handling information
						$gd_info = function_exists('gd_info') ? gd_info() : array();
						$gd_file_formats = isset($gd_info['File Formats']) ? implode(', ', $gd_info['File Formats']) : 'Not available';

						$media_info = array(
							'Active editor' => wp_image_editor_supports(array('GD')) ? 'WP_Image_Editor_GD' : 'Not available',
							'ImageMagick version number' => 'Not available',
							'ImageMagick version string' => 'Not available',
							'Imagick version' => class_exists('Imagick') ? Imagick::getVersion()['versionNumber'] : 'Not available',
							'File uploads' => get_option('upload_files') ? 'Enabled' : 'Disabled',
							'Max size of post data allowed' => ini_get('post_max_size'),
							'Max size of an uploaded file' => ini_get('upload_max_filesize'),
							'Max effective file size' => wp_max_upload_size(),
							'Max number of files allowed' => defined('MAX_FILES_UPLOAD') ? MAX_FILES_UPLOAD : 'Not available',
							'GD version' => isset($gd_info['GD Version']) ? $gd_info['GD Version'] : 'Not available',
							'GD supported file formats' => $gd_file_formats,
							'Ghostscript version' => 'Not available',
						);
						?>

						<!-- Display media handling information in a table -->
						<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
							<?php foreach ($media_info as $label => $value) : ?>
								<tr valign="top">
									<th scope="row"><?php echo esc_attr($label); ?></th>
									<td><?php echo esc_attr($value); ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>

				<div id="directories-info" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Directories Info</h3>
						<?php
						// Get directories and sizes information
						$ewpt_directory_sizes = array(
							'WordPress directory location' => ABSPATH,
							'Uploads directory location' => wp_upload_dir()['basedir'],
							'Themes directory location' => get_theme_root(),
							'Plugins directory location' => WP_PLUGIN_DIR,
							'EWPT modules location' => EWPT_MODULES_PATH,
						);
						?>
						
						<!-- Display directories and sizes information in a table -->
						<table class="form-table ewpt-form ewpt-border-radius-bottom-5px" id="directories-info-table">
							<?php foreach ($ewpt_directory_sizes as $label => $value) : ?>
								<tr valign="top">
									<th scope="row"><?php echo esc_attr($label); ?></th>
									<td><?php echo esc_attr($value); ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
						
					</div>
				</div>

				<div id="themes-info" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Active Theme Info</h3>

						<?php
						// Get active theme information
						$active_theme = wp_get_theme();

						$active_theme_info = array(
							'Name' => $active_theme->get('Name'),
							'Version' => $active_theme->get('Version'),
							'Author' => $active_theme->get('Author'),
							'Author website' => $active_theme->get('AuthorURI'),
							'Parent theme' => $active_theme->get('Template') ? $active_theme->parent()->get('Name') : 'None',
							'Theme Link' => is_array($active_theme->get('ThemeURI')) ? implode(', ', $active_theme->get('ThemeURI')) : $active_theme->get('ThemeURI'),
							'Theme directory location' => $active_theme->get_stylesheet_directory(),
							'Auto-updates' => $active_theme->get('Auto-updates'),
						);
						?>

						<!-- Display active theme information in a table -->
						<table class="form-table ewpt-form">
							<?php foreach ($active_theme_info as $label => $value) : ?>
								<tr valign="top">
									<th scope="row"><?php echo esc_attr($label); ?></th>
									<td><?php echo esc_attr($value); ?></td>
								</tr>
							<?php endforeach; ?>
						</table>

						<h3 class="ewpt-no-top-border">Inactive Theme Info</h3>
						<?php
						// Get information about all themes
						$all_themes = wp_get_themes();

						// Check if there are inactive themes
						$inactive_themes = array_filter($all_themes, function ($theme) use ($active_theme) {
							return $theme->get('Name') !== $active_theme->get('Name');
						});

						if (!empty($inactive_themes)) {
							foreach ($inactive_themes as $inactive_theme) {
								$inactive_theme_info = array(
									'Name' => $inactive_theme->get('Name'),
									'Version' => $inactive_theme->get('Version'),
									'Author' => $inactive_theme->get('Author'),
									'Author website' => $inactive_theme->get('AuthorURI'),
									'Parent theme' => $inactive_theme->get('Template') ? $inactive_theme->parent()->get('Name') : 'None',
									'Theme Link' => is_array($inactive_theme->get('ThemeURI')) ? implode(', ', $inactive_theme->get('ThemeURI')) : $inactive_theme->get('ThemeURI'),
									'Theme directory location' => $inactive_theme->get_stylesheet_directory(),
									'Auto-updates' => $inactive_theme->get('Auto-updates'),
								);
								?>
								<!-- Display inactive theme information in a separate table -->
								<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
									<?php foreach ($inactive_theme_info as $label => $value) : ?>
										<tr valign="top">
											<th scope="row"><?php echo esc_attr($label); ?></th>
											<td><?php echo esc_attr($value); ?></td>
										</tr>
									<?php endforeach; ?>
								</table>
								<?php
							}
						} else {
						?>
						<!-- Display no inactive plugin information in a table -->
						<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
								<tr valign="top">
									<th scope="row">No inactive theme found!</th>
									<td>Good for security!</td>
								</tr>
						</table>
						<?php
						}
						?>

					</div>
				</div>

				<div id="plugins-info" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Active Plugin Info</h3>

						<?php
						// Get active plugin information
						$active_plugins = get_option('active_plugins');
						$active_plugin_info = array();

						foreach ($active_plugins as $plugin) {
							$plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
							$active_plugin_info[] = array(
								'Name' => $plugin_data['Name'],
								'Version' => $plugin_data['Version'],
								'Author' => wp_strip_all_tags($plugin_data['Author']),
								'Plugin directory location' => WP_PLUGIN_DIR . '/' . dirname($plugin),
							);
						}
						?>

						<!-- Display active plugin information in a table -->
						<?php foreach ($active_plugin_info as $plugin_info) : ?>
							<table class="form-table ewpt-form">
								<?php foreach ($plugin_info as $label => $value) : ?>
									<tr valign="top">
										<th scope="row"><?php echo esc_attr($label); ?></th>
										<td><?php echo esc_attr($value); ?></td>
									</tr>
								<?php endforeach; ?>
							</table>
						<?php endforeach; ?>

						<h3 class="ewpt-no-top-border">Inactive Plugin Info</h3>
						<?php
						// Get information about all inactive plugins
						$all_plugins = get_plugins();
						$inactive_plugins = array_diff_key($all_plugins, array_flip($active_plugins));

						// Check if there are inactive plugins
						if (!empty($inactive_plugins)) {
							foreach ($inactive_plugins as $plugin_file => $plugin_data) {
								$inactive_plugin_info = array(
									'Name' => $plugin_data['Name'],
									'Version' => $plugin_data['Version'],
									'Author' => wp_strip_all_tags($plugin_data['Author']),
									'Plugin directory location' => WP_PLUGIN_DIR . '/' . dirname($plugin_file),
								);
								?>
								<!-- Display inactive plugin information in a table -->
								<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
									<?php foreach ($inactive_plugin_info as $label => $value) : ?>
										<tr valign="top">
											<th scope="row"><?php echo esc_attr($label); ?></th>
											<td><?php echo esc_attr($value); ?></td>
										</tr>
									<?php endforeach; ?>
								</table>
								
								<?php
							}
						} else {
						?>
							<!-- Display no inactive plugin information in a table -->
							<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
									<tr valign="top">
										<th scope="row">No inactive plugin found!</th>
										<td>Good for security!</td>
									</tr>
							</table>
						<?php
						}
						?>

					</div>
				</div>

				<div id="server-info" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Server Info</h3>

						<?php
						// Function to check if a PHP extension is loaded
						function is_extension_loaded($extension) {
							return extension_loaded($extension) ? 'Yes' : 'No';
						}

						// Function to check if a value is set
						function check_value($value) {
							return isset($value) ? $value : 'N/A';
						}

						// Get server information
						$server_info = array(
							'Server architecture' => php_uname('s') . ' ' . php_uname('r') . ' ' . php_uname('m'),
							'Web server' => esc_html(sanitize_text_field($_SERVER['SERVER_SOFTWARE'])),
							'PHP version' => PHP_VERSION,
							'PHP SAPI' => php_sapi_name(),
							'PHP max input variables' => ini_get('max_input_vars'),
							'PHP time limit' => ini_get('max_execution_time'),
							'PHP memory limit' => ini_get('memory_limit'),
							'Max input time' => ini_get('max_input_time'),
							'Upload max filesize' => ini_get('upload_max_filesize'),
							'PHP post max size' => ini_get('post_max_size'),
							'cURL version' => check_value(curl_version()['version'] . ' ' . curl_version()['ssl_version']),
							//'Is SUHOSIN installed?' => is_extension_loaded('suhosin') ? 'Yes' : 'No',
							'Is the Imagick library available?' => class_exists('Imagick') ? 'Yes' : 'No',
							'Is the GD Library available?' => extension_loaded('gd') ? 'Yes' : 'No',
							'Are pretty permalinks supported?' => get_option('permalink_structure') ? 'Yes' : 'No',
							'.htaccess rules' => check_value(file_exists('.htaccess') ? read_file_content('.htaccess') : ''),
							'Current time' => current_time('c'),
							'Current UTC time' => current_time('l, d-M-y H:i:s e', true),
							'Current Server time' => gmdate('c'),
						);
						?>

						<!-- Display server information in a table -->
						<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
							<?php foreach ($server_info as $label => $value) : ?>
								<tr valign="top">
									<th scope="row"><?php echo esc_attr($label); ?></th>
									<td><?php echo esc_attr($value); ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>

				<div id="database-info" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Database</h3>

						<?php
						// Get available database extensions
						$database_extensions = array();

						if (extension_loaded('mysqli')) {
							$database_extensions[] = 'mysqli';
						}

						if (extension_loaded('pdo_mysql')) {
							$database_extensions[] = 'pdo_mysql';
						}

						if (empty($database_extensions)) {
							$database_extensions[] = 'Not available';
						}

						// Determine the active database extension
						$active_database_extension = in_array('mysqli', $database_extensions) ? 'mysqli' : (in_array('pdo_mysql', $database_extensions) ? 'pdo_mysql' : 'Not available');

						// Get other database information
						global $wpdb;

						$database_info = array(
							'Available Extensions' => implode(', ', $database_extensions),
							'Active Extension' => $active_database_extension,
							'Server version' => method_exists($wpdb, 'db_version') ? $wpdb->db_version() : 'Not available',
							'Database username' => defined('DB_USER') ? DB_USER : 'Not available',
							'Database host' => defined('DB_HOST') ? DB_HOST : 'Not available',
							'Database name' => defined('DB_NAME') ? DB_NAME : 'Not available',
							'Table prefix' => isset($wpdb->prefix) ? $wpdb->prefix : 'Not available',
							'Database charset' => defined('DB_CHARSET') ? DB_CHARSET : 'Not available',
							'Database collation' => defined('DB_COLLATE') ? DB_COLLATE : 'Not available',
							'Max allowed packet size' => 'Not available',
							'Max connections number' => 'Not available',
						);
						?>

						<!-- Display database information in a table -->
						<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
							<?php foreach ($database_info as $label => $value) : ?>
								<tr valign="top">
									<th scope="row"><?php echo esc_attr($label); ?></th>
									<td><?php echo esc_attr($value); ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>

				<div id="wordpress-constants-info" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">WordPress Constants</h3>

						<?php
						// Define the WordPress constants you want to display
						$wordpress_constants = array(
							'ABSPATH' => ABSPATH,
							'WP_HOME' => defined('WP_HOME') ? WP_HOME : 'Undefined',
							'WP_SITEURL' => defined('WP_SITEURL') ? WP_SITEURL : 'Undefined',
							'WP_CONTENT_DIR' => defined('WP_CONTENT_DIR') ? WP_CONTENT_DIR : 'Undefined',
							'WP_PLUGIN_DIR' => defined('WP_PLUGIN_DIR') ? WP_PLUGIN_DIR : 'Undefined',
							'WP_MEMORY_LIMIT' => defined('WP_MEMORY_LIMIT') ? WP_MEMORY_LIMIT : 'Undefined',
							'WP_MAX_MEMORY_LIMIT' => defined('WP_MAX_MEMORY_LIMIT') ? WP_MAX_MEMORY_LIMIT : 'Undefined',
							'WP_DEBUG' => defined('WP_DEBUG') ? (WP_DEBUG ? 'Enabled' : 'Disabled') : 'Undefined',
							'WP_DEBUG_DISPLAY' => defined('WP_DEBUG_DISPLAY') ? (WP_DEBUG_DISPLAY ? 'Enabled' : 'Disabled') : 'Undefined',
							'WP_DEBUG_LOG' => defined('WP_DEBUG_LOG') ? (WP_DEBUG_LOG ? 'Enabled' : 'Disabled') : 'Undefined',
							'SCRIPT_DEBUG' => defined('SCRIPT_DEBUG') ? (SCRIPT_DEBUG ? 'Enabled' : 'Disabled') : 'Undefined',
							'WP_CACHE' => defined('WP_CACHE') ? (WP_CACHE ? 'Enabled' : 'Disabled') : 'Undefined',
							'CONCATENATE_SCRIPTS' => defined('CONCATENATE_SCRIPTS') ? CONCATENATE_SCRIPTS : 'Undefined',
							'COMPRESS_SCRIPTS' => defined('COMPRESS_SCRIPTS') ? COMPRESS_SCRIPTS : 'Undefined',
							'COMPRESS_CSS' => defined('COMPRESS_CSS') ? COMPRESS_CSS : 'Undefined',
							'WP_ENVIRONMENT_TYPE' => defined('WP_ENVIRONMENT_TYPE') ? WP_ENVIRONMENT_TYPE : 'Undefined',
							'WP_DEVELOPMENT_MODE' => defined('WP_DEVELOPMENT_MODE') ? (WP_DEVELOPMENT_MODE ? 'Enabled' : 'Disabled') : 'Undefined',
							'DB_CHARSET' => defined('DB_CHARSET') ? DB_CHARSET : 'Undefined',
							'DB_COLLATE' => defined('DB_COLLATE') ? DB_COLLATE : 'Undefined',
						);
						?>

						<!-- Display WordPress Constants in a table -->
						<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
							<?php foreach ($wordpress_constants as $label => $value) : ?>
								<tr valign="top">
									<th scope="row"><?php echo esc_attr($label); ?></th>
									<td><?php echo esc_attr($value); ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>

				<div id="filesystem-permissions-info" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Filesystem Permissions</h3>

						<?php
						// Define the directories to check permissions
						$directories = array(
							'Main WordPress directory' => ABSPATH,
							'wp-content directory' => WP_CONTENT_DIR,
							'uploads directory' => wp_upload_dir()['basedir'],
							'plugins directory' => WP_PLUGIN_DIR,
							'themes directory' => get_theme_root(),
							'EWPT modules path' => EWPT_MODULES_PATH,
						);

							// Check and display filesystem permissions
							$filesystem_permissions = array();
							foreach ($directories as $label => $directory) {
								if (function_exists('WP_Filesystem') && WP_Filesystem()) {
									global $wp_filesystem;
									$writable = $wp_filesystem->is_writable($directory) ? 'Writable' : 'Not Writable';
								} else {
									// If WP_Filesystem is not available, fallback to is_writable
									//$writable = is_writable($directory) ? 'Writable' : 'Not Writable';
									$writable = 'Unknown';
								}
								$filesystem_permissions[$label] = $writable;
							}
						?>

						<!-- Display Filesystem Permissions in a table -->
						<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
							<?php foreach ($filesystem_permissions as $label => $value) : ?>
								<tr valign="top">
									<th scope="row"><?php echo esc_attr($label); ?></th>
									<td><?php echo esc_attr($value); ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>

				<div id="php-info" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">PHP Server Info</h3>
						
						<div class="ewpt-form ewpt-border-radius-bottom-5px">
							
							<?php if (get_option('enable_ewpt_system_php_info', 0)) : ?>
								<iframe id="php-info-frame" class="ewpt-border-radius-bottom-5px" style="width: 100%; height: 800px; border: none;"></iframe>
								<script>
									jQuery(document).ready(function($) {
										$('#php-info-frame').attr('src', '<?php echo esc_url(admin_url('admin-ajax.php?action=php_info')); ?>');
									});
								</script>
							<?php else : ?>
								<p>PHP Info is disabled. Enable it, in the settings.</p>
							<?php endif; ?>
								
						</div>
						
					</div>
				</div>
					
				<?php
				// Include the module about file
				include(EWPT_PLUGIN_PATH . 'inc/ewpt-about-modules.php');
				?>
				
				<?php //submit_button('Save Changes'); ?>
					
			</form>
				
		</div>

		<div id="ewpt-page-footer" class="ewpt-page-footer">
		
			<?php
			// Include the module footer file
			include(EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php');
			?>
			
		</div>
	 
	</div>
	
	
    <?php
	
}

	// AJAX handler for PHP Info
	add_action( 'wp_ajax_php_info', function () {
		ob_start();
		phpinfo();
		$php_info_content = ob_get_clean();
		
		//$php_info_content = ewpt::rsd_sanitize_html_raw_field($php_info_content);
		// Modify the output to include correct data:image scheme for the logo
		//$output = str_replace('src="image/png;base64,', 'src="data:image/png;base64,', $php_info_content);
		
		echo ewpt::rsd_sanitize_html_raw_field($php_info_content);
		
		wp_die();
	}, 0 );
	
	// Include the actions (mostly ajax call)
	include plugin_dir_path(__FILE__) . 'ewpt-system-info-actions.php';

} // if (!function_exists('ewpt_system_info_settings_page'))