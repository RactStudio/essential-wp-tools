<?php
// essential-wp-tools/modules/essential-tools/ewpt-essential-tools.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

use EWPT\Modules\EssentialTools\ethub as ethub;

// Register settings
add_action( 'init', function () {
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'ewpt_disable_all_essential_tools_options', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'ewpt_essential_tools_menu_link', 'string');
	
	// EWPT Essential Tools setting page Options
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_gutenberg_editor', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_widget_blocks', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_svg_files_upload', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'remove_wp_generator_tag', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_xml_rpc', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_wp_admin_bar', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'display_wp_admin_bar_except', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_automatic_updates_emails', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_wp_rest_api', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_wp_rest_api_frontend_backend', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'wp_rest_api_error_message_text', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_redirect_https_ssl', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_wp_comments', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_attachment_pages', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_replace_wp_howdy', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'replace_wp_howdy_message', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'remove_wp_welcome_panel', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_customize_wp_admin_footer_text', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'customize_wp_admin_footer_text', 'html_post');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'remove_admin_screen_options_tab', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_limit_wp_post_revisions_number', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'custom_post_rev_number', 'integer');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_wp_posts_min_words_count', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'custom_min_word_count', 'integer');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_wp_site_health', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_customize_oembed_dimensions', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'custom_oembed_width', 'integer');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'custom_oembed_height', 'integer');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_customize_autosave_interval', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'custom_autosave_interval', 'integer');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_automatic_trash_emptying', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_block_editor_directory_result', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_wp_duplicate_posts_pages', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_external_links_in_new_tab', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_wp_search', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_wp_editor_code_editing', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_frontend_copy_paste', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'remove_gutenberg_blocks_library_css', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'remove_pages_from_search_result', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'remove_posts_from_search_result', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'remove_attachments_from_search_result', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_auto_generated_image_sizes', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_selected_image_sizes', 'array');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_text_widget_shortcode', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_webp_files_upload', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_ico_files_upload', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_fonts_files_upload', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_big_image_threshold', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_gd_library_instead_image_magick', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_exclude_feed_categories', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'exclude_feed_categories', 'array');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_rss_feeds_posts_delay', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'rss_feeds_posts_delay_minutes', 'integer');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_rss_feeds_featured_image', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_rss_feeds_disabler', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_et_author_archives', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'disable_et_blog_posts_type', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'remove_query_strings_from_static_files', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'et_disable_jquery_migrate_script', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_affix_auto_excerpt', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'affix_auto_excerpt_words_count_length', 'integer');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_affix_auto_excerpt_read_more', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'affix_auto_excerpt_read_more_texts', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_affix_auto_excerpt_read_more_with_link', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'strip_auto_excerpt_content_shortcode_text', 'string');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sorting', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'et_posts_sort_home_status', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sort_home_orderby', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sort_home_order', 'string');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'et_posts_sort_archive_status', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sort_archive_orderby', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sort_archive_order', 'string');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'et_posts_sort_category_status', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sort_category_orderby', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sort_category_order', 'string');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'et_posts_sort_tag_status', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sort_tag_orderby', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sort_tag_order', 'string');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'et_posts_sort_search_status', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sort_search_orderby', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_posts_sort_search_order', 'string');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_affix_custom_search_slug', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'affix_custom_search_slug_text', 'string');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'redirect_empty_search_query', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_affix_custom_user_slug', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'affix_custom_user_slug_text', 'string');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_affix_custom_wp_login_logo_url', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'affix_custom_wp_login_page_logo_url_link', 'url');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_affix_custom_wp_login_page_logo', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'affix_custom_wp_login_page_logo_media', 'url');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_remove_frontend_scripts_version', 'boolean');
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_remove_frontend_styles_version', 'boolean');
	
	ewpt::register_setting_data('ewpt_essential_tools_settings', 'enable_remove_posts_list_menus_customizer', 'boolean');
	
});

// Menu of the Module
add_action( 'admin_menu', function () {
	// Get the option for menu visibility
	$menu_visibility_option = get_option('ewpt_essential_tools_menu_link', 'sub_menu');
	// Module menu name parameters
	$module_name = 'Essential Tools'; // Define the module name/title here
	ewpt::assign_modules_menu_link($menu_visibility_option, $module_name);
});

// Create the module settings page
if (!function_exists('ewpt_essential_tools_settings_page')) {
function ewpt_essential_tools_settings_page() {
    // Include the module config file
    include(plugin_dir_path(__FILE__) . 'ewpt-essential-tools-config.php');
	
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
				<a href="#general-tools" class="nav-tab">General</a>
				<a href="#posts-tools" class="nav-tab">Posts</a>
				<a href="#auto-excerpt" class="nav-tab">Excerpt</a>
				<a href="#posts-sort" class="nav-tab">Sort</a>
				<a href="#media-tools" class="nav-tab">Media</a>
				<a href="#archives-tools" class="nav-tab">Archives</a>
				<a href="#search-tools" class="nav-tab">Search</a>
				<a href="#users-tools" class="nav-tab">Users</a>
				<a href="#login-tools" class="nav-tab">Login</a>
				<a href="#rss-tools" class="nav-tab">RSS</a>
				<a href="#security-tools" class="nav-tab">Security</a>
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
						
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
							<tr valign="top">
								<th scope="row">All Options</th>
								<td>
									<label>
										<input type="checkbox" name="ewpt_disable_all_essential_tools_options" value="1" <?php checked(get_option('ewpt_disable_all_essential_tools_options', 0)) ?> />
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
										<select name="ewpt_essential_tools_menu_link">
											<option value="sub_menu" <?php selected(get_option("ewpt_essential_tools_menu_link"), 'sub_menu'); ?>>Sub Menu</option>
											<option value="main_menu" <?php selected(get_option("ewpt_essential_tools_menu_link"), 'main_menu'); ?>>Main Menu</option>
											<option value="hidden_menu" <?php selected(get_option("ewpt_essential_tools_menu_link"), 'hidden_menu'); ?>>Hide Menu</option>
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
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="general-tools" class="tab-content">
					<div class="tab-pane">
					
						<h3 class="ewpt-no-top-border">General Tools</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						
							<tr valign="top">
								<th scope="row">Disable Gutenberg Editor</th>
								<td>
									<label>
										<input type="checkbox" name="disable_gutenberg_editor" value="1" <?php checked(get_option('disable_gutenberg_editor', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Use Classic Editor
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Disable Widget Blocks</th>
								<td>
									<label>
										<input type="checkbox" name="disable_widget_blocks" value="1" <?php checked(get_option('disable_widget_blocks', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Use Classic Widgets
									</div>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">WP Admin Bar</th>
								<td>
									<label>
										<input type="checkbox" name="disable_wp_admin_bar" value="1" <?php checked(get_option('disable_wp_admin_bar', 0)) ?> />
										Disable
									</label>
									<label>
										<select name="display_wp_admin_bar_except">
											<option value="except_admin" <?php selected(get_option("display_wp_admin_bar_except"), 'except_admin'); ?>>Except Admin</option>
											<option value="except_admin_editor" <?php selected(get_option("display_wp_admin_bar_except"), 'except_admin_editor'); ?>>Except Admin, & Editor</option>
											<option value="except_admin_editor_author" <?php selected(get_option("display_wp_admin_bar_except"), 'except_admin_editor_author'); ?>>Except Admin, Editor, & Author</option>
											<option value="only_author" <?php selected(get_option("display_wp_admin_bar_except"), 'only_author'); ?>>Only Author</option>
											<option value="only_contributor" <?php selected(get_option("display_wp_admin_bar_except"), 'only_contributor'); ?>>Only Contributor</option>
											<option value="only_subscriber" <?php selected(get_option("display_wp_admin_bar_except"), 'only_subscriber'); ?>>Only Subscriber</option>
											<option value="all_logged_in_users" <?php selected(get_option("display_wp_admin_bar_except"), 'only_logged_in_users'); ?>>All Logged-in Users</option>
										</select>
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Hide the WP Admin Bar (frontend) for 'All Logged-in Users' or based on various users roles combination.
									</div>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">WordPress Comments</th>
								<td>
									<label>
										<input type="checkbox" name="disable_wp_comments" value="1" <?php checked(get_option('disable_wp_comments', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Remove comments for all post types, in the backend and the frontend.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">WP Site Health</th>
								<td>
									<label>
										<input type="checkbox" name="disable_wp_site_health" value="1" <?php checked(get_option('disable_wp_site_health', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Hide the WP Site Health menu and dashboard widget
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Gutenberg Block Library CSS</th>
								<td>
									<label>
										<input type="checkbox" name="remove_gutenberg_blocks_library_css" value="1" <?php checked(get_option('remove_gutenberg_blocks_library_css', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Prevents loading on the frontend
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Block Editor Directory Results</th>
								<td>
									<label>
										<input type="checkbox" name="disable_block_editor_directory_result" value="1" <?php checked(get_option('disable_block_editor_directory_result', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Prevent block directory results from being shown when searching for blocks in the editor
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Shortcode in Text Widgets</th>
								<td>
									<label>
										<input type="checkbox" name="enable_text_widget_shortcode" value="1" <?php checked(get_option('enable_text_widget_shortcode', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Enable Shortcode Execution in Default Text Widgets
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Admin Bar Howdy Message</th>
								<td>
									<label>
										<input type="checkbox" name="enable_replace_wp_howdy" value="1" <?php checked(get_option('enable_replace_wp_howdy', 0)) ?> />
										Enable
									
										<input type="text" name="replace_wp_howdy_message" value="<?php echo esc_attr(get_option('replace_wp_howdy_message', 'Hi, ')); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										New Howdy message for the wp admin bar
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">WP Dashboard Welcome Panel</th>
								<td>
									<label>
										<input type="checkbox" name="remove_wp_welcome_panel" value="1" <?php checked(get_option('remove_wp_welcome_panel', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Hide the WP Welcome Panel on the dashboard for all users
									</div>
								</td>
							</tr>
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">WP Admin Footer Text</th>
								<td>
									<label>
										<input type="checkbox" name="enable_customize_wp_admin_footer_text" value="1" <?php checked(get_option('enable_customize_wp_admin_footer_text', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<textarea name="customize_wp_admin_footer_text" rows="6" cols="45"><?php echo esc_textarea(get_option('customize_wp_admin_footer_text', '<span id="footer-thankyou">Thank you for creating with <a href="https://wordpress.org/">WordPress</a>.</span>')); ?></textarea>
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Add new wp admin footer text
									</div>
									<br/>
									<div class='ewpt-info-green'>
										Basic <strong>HTML</strong> Tags and Attributes are supported.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">'Screen Options' Tab</th>
								<td>
									<label>
										<input type="checkbox" name="remove_admin_screen_options_tab" value="1" <?php checked(get_option('remove_admin_screen_options_tab', 0)) ?> />
										Hide
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Remove the Screen Options menu at the top of wp admin pages.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Code Edit in Editor</th>
								<td>
									<label>
										<input type="checkbox" name="disable_wp_editor_code_editing" value="1" <?php checked(get_option('disable_wp_editor_code_editing', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Prevent non-admin users from using "Edit as HTML" or "Code editor" in the Gutenberg Editor
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Open External Links in New Tab</th>
								<td>
									<label>
										<input type="checkbox" name="enable_external_links_in_new_tab" value="1" <?php checked(get_option('enable_external_links_in_new_tab', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										This makes the manual link tab association obsolete. All links to another domain will open in a new tab.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Frontend Copy-Paste</th>
								<td>
									<label>
										<input type="checkbox" name="disable_frontend_copy_paste" value="1" <?php checked(get_option('disable_frontend_copy_paste', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Prevents right-click and copy events on the frontend
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Remove Posts Lists on Menus page and Customizer</th>
								<td>
									<label>
										<input type="checkbox" name="enable_remove_posts_list_menus_customizer" value="1" <?php checked(get_option('enable_remove_posts_list_menus_customizer', 0)) ?> />
										Remove
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Remove Posts List appearing on Appearance > Menus page and Customizer.
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="posts-tools" class="tab-content">
					<div class="tab-pane">
					
						<h3 class="ewpt-no-top-border">Post Types Tools</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						
							<tr valign="top">
								<th scope="row">Posts and Pages Duplication</th>
								<td>
									<label>
										<input type="checkbox" name="enable_wp_duplicate_posts_pages" value="1" <?php checked(get_option('enable_wp_duplicate_posts_pages', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Add the duplicate link to action list - for "post", "page" and custom post types
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Disable Blog Posts Type</th>
								<td>
									<label>
										<input type="checkbox" name="disable_et_blog_posts_type" value="1" <?php checked(get_option('disable_et_blog_posts_type', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Remove the menu links of blog posts type from the backend
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">WP Post Revisions</th>
								<?php
									$post_rev_number = intval(get_option('custom_post_rev_number', 20));
									if ($post_rev_number < 2) {
										$post_rev_number = 2;
									} elseif ($post_rev_number > 200) {
										$post_rev_number = 200;
									}
								?>
								<td>
									<label>
										<input type="checkbox" name="enable_limit_wp_post_revisions_number" value="1" <?php checked(get_option('enable_limit_wp_post_revisions_number', 0)) ?> />
										Enable
									</label>
									<label>
										<input type="number" name="custom_post_rev_number" value="<?php echo intval($post_rev_number); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										How many WP Post Revisions you would like to keep, min=2 and max=200, default=20
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">WP Posts Minimum Words</th>
								<?php
									$min_word_count = intval(get_option('custom_min_word_count', 10));
									if ($min_word_count < 1) {
										$min_word_count = 1;
									} elseif ($min_word_count > 1000000) {
										$min_word_count = 1000000;
									}
								?>
								<td>
									<label>
										<input type="checkbox" name="enable_wp_posts_min_words_count" value="1" <?php checked(get_option('enable_wp_posts_min_words_count', 0)) ?> />
										Enable
									</label>
									<label>
										<input type="number" name="custom_min_word_count" value="<?php echo intval($min_word_count); ?>" />
										Words
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Won't be able to publish wp post unless it is admin user, min=1 and max=1000000, default=10
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">WP Post Autosave Interval</th>
								<?php
									$autosave_interval = intval(get_option('custom_autosave_interval', 2));
									if ($autosave_interval < 1) {
										$autosave_interval = 1;
									} elseif ($autosave_interval > 300) {
										$autosave_interval = 300;
									}
								?>
								<td>
									<label>
										<input type="checkbox" name="enable_customize_autosave_interval" value="1" <?php checked(get_option('enable_customize_autosave_interval', 0)) ?> />
										Enable
									</label>
									<label>
										<input type="number" name="custom_autosave_interval" value="<?php echo intval($autosave_interval); ?>" />
										Minutes
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Set a custom WP Post Autosave Interval (in minutes), default= 2, min = 1, max = 300 minutes
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Automatic Trash Posts Emptying</th>
								<td>
									<label>
										<input type="checkbox" name="disable_automatic_trash_emptying" value="1" <?php checked(get_option('disable_automatic_trash_emptying', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Prevent automatic deletion of trashed posts after 30 days
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="auto-excerpt" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">Auto Excerpt</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">

							<tr valign="top">
								<th scope="row">Enable Auto Excerpt</th>
								<td>
									<label>
										<input type="checkbox" name="enable_affix_auto_excerpt" value="1" <?php checked(get_option('enable_affix_auto_excerpt', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Add automatic Excerpt to posts, pages and custom post types everywhere on the frontend.<br/>
										<strong>Note: If already have Excerpt texts, then will use that. Also, would execute below options.</strong>
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Excerpt Words Length</th>
								<?php
									$excerpt_words_count = intval(get_option('affix_auto_excerpt_words_count_length', 35));
									if ($excerpt_words_count < 0) {
										$excerpt_words_count = 0;
									} elseif ($excerpt_words_count > 1000) {
										$excerpt_words_count = 1000;
									}
								?>
								<td>
									<label>
										<input type="number" name="affix_auto_excerpt_words_count_length" value="<?php echo intval($excerpt_words_count); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Add custom excerpt words length, min=0 and max=1000, default=35
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Excerpt Read More </th>
								<td>
									<label>
										<input type="checkbox" name="enable_affix_auto_excerpt_read_more" value="1" <?php checked(get_option('enable_affix_auto_excerpt_read_more', 0)) ?> />
										Enable
									
										<input type="text" name="affix_auto_excerpt_read_more_texts" value="<?php echo esc_attr(get_option('affix_auto_excerpt_read_more_texts', 'Read More »')); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Add custom excerpt "Read More" text end of the excerpt content.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Read More Text with Link</th>
								<td>
									<label>
										<input type="checkbox" name="enable_affix_auto_excerpt_read_more_with_link" value="1" <?php checked(get_option('enable_affix_auto_excerpt_read_more_with_link', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Add a link on the Read More Text. (<strong>Note: "Excerpt Read More" option must be enabled</strong>)
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Strip Shortcode from Excerpt</th>
								<td>
									<label>
										<input type="checkbox" name="strip_auto_excerpt_content_shortcode_text" value="1" <?php checked(get_option('strip_auto_excerpt_content_shortcode_text', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Remove (strip) shortcode text (ex: [shortcode]) in the excerpt content.
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="posts-sort" class="tab-content">
					<div class="tab-pane">
					
						<h3 class="ewpt-no-top-border">Post Sort / Order</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						
							<tr valign="top">
								<th scope="row">Posts/Taxonomy/CPT Sort</th>
								<td>
									<label>
										<input type="checkbox" name="enable_posts_sorting" value="1" <?php checked(get_option( 'enable_posts_sorting', 0)); ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Must be enabled for below options to work for Posts / Taxonomy / CPT Sorting.
									</div>
								</td>
							</tr>
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Home / Blog Posts Sort</th>
								<td>
									<label>
										<input type="checkbox" name="et_posts_sort_home_status" value="1" <?php checked(get_option('et_posts_sort_home_status', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Set a custom Posts Sorting (orderby) and Order of the posts for home / blog.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="enable_posts_sort_home_orderby">
											<option value="modified" <?php selected(get_option("enable_posts_sort_home_orderby"), 'modified'); ?>>Modified Date</option>
											<option value="date" <?php selected(get_option("enable_posts_sort_home_orderby"), 'date'); ?>>Publish date</option>
											<option value="title" <?php selected(get_option("enable_posts_sort_home_orderby"), 'title'); ?>>Title</option>
											<option value="rand" <?php selected(get_option("enable_posts_sort_home_orderby"), 'rand'); ?>>Random</option>
										</select>
										Orderby
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<select name="enable_posts_sort_home_order">
											<option value="DESC" <?php selected(get_option("enable_posts_sort_home_order"), 'DESC'); ?>>DESC</option>
											<option value="ASC" <?php selected(get_option("enable_posts_sort_home_order"), 'ASC'); ?>>ASC</option>
											<option value="" <?php selected(get_option("enable_posts_sort_home_order"), ''); ?>>None</option>
										</select>
										Order
									</label>
								</td>
							</tr>
							
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Archive / CPT Posts Sort</th>
								<td>
									<label>
										<input type="checkbox" name="et_posts_sort_archive_status" value="1" <?php checked(get_option('et_posts_sort_archive_status', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Set a custom Posts Sorting (orderby) and Order of the posts for Archive / CPT.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="enable_posts_sort_archive_orderby">
											<option value="modified" <?php selected(get_option("enable_posts_sort_archive_orderby"), 'modified'); ?>>Modified Date</option>
											<option value="date" <?php selected(get_option("enable_posts_sort_archive_orderby"), 'date'); ?>>Publish date</option>
											<option value="title" <?php selected(get_option("enable_posts_sort_archive_orderby"), 'title'); ?>>Title</option>
											<option value="rand" <?php selected(get_option("enable_posts_sort_archive_orderby"), 'rand'); ?>>Random</option>
										</select>
										Orderby
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<select name="enable_posts_sort_archive_order">
											<option value="DESC" <?php selected(get_option("enable_posts_sort_archive_order"), 'DESC'); ?>>DESC</option>
											<option value="ASC" <?php selected(get_option("enable_posts_sort_archive_order"), 'ASC'); ?>>ASC</option>
											<option value="" <?php selected(get_option("enable_posts_sort_archive_order"), ''); ?>>None</option>
										</select>
										Order
									</label>
								</td>
							</tr>
							
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Category Archive Posts Sort</th>
								<td>
									<label>
										<input type="checkbox" name="et_posts_sort_category_status" value="1" <?php checked(get_option('et_posts_sort_category_status', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Set a custom Posts Sorting (orderby) and Order of the posts for Category Archive.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="enable_posts_sort_category_orderby">
											<option value="modified" <?php selected(get_option("enable_posts_sort_category_orderby"), 'modified'); ?>>Modified Date</option>
											<option value="date" <?php selected(get_option("enable_posts_sort_category_orderby"), 'date'); ?>>Publish date</option>
											<option value="title" <?php selected(get_option("enable_posts_sort_category_orderby"), 'title'); ?>>Title</option>
											<option value="rand" <?php selected(get_option("enable_posts_sort_category_orderby"), 'rand'); ?>>Random</option>
										</select>
										Orderby
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<select name="enable_posts_sort_category_order">
											<option value="DESC" <?php selected(get_option("enable_posts_sort_category_order"), 'DESC'); ?>>DESC</option>
											<option value="ASC" <?php selected(get_option("enable_posts_sort_category_order"), 'ASC'); ?>>ASC</option>
											<option value="" <?php selected(get_option("enable_posts_sort_category_order"), ''); ?>>None</option>
										</select>
										Order
									</label>
								</td>
							</tr>
							
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Tag Archive Posts Sort</th>
								<td>
									<label>
										<input type="checkbox" name="et_posts_sort_tag_status" value="1" <?php checked(get_option('et_posts_sort_tag_status', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Set a custom Posts Sorting (orderby) and Order of the posts for Tag Archive.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="enable_posts_sort_tag_orderby">
											<option value="modified" <?php selected(get_option("enable_posts_sort_tag_orderby"), 'modified'); ?>>Modified Date</option>
											<option value="date" <?php selected(get_option("enable_posts_sort_tag_orderby"), 'date'); ?>>Publish date</option>
											<option value="title" <?php selected(get_option("enable_posts_sort_tag_orderby"), 'title'); ?>>Title</option>
											<option value="rand" <?php selected(get_option("enable_posts_sort_tag_orderby"), 'rand'); ?>>Random</option>
										</select>
										Orderby
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<select name="enable_posts_sort_tag_order">
											<option value="DESC" <?php selected(get_option("enable_posts_sort_tag_order"), 'DESC'); ?>>DESC</option>
											<option value="ASC" <?php selected(get_option("enable_posts_sort_tag_order"), 'ASC'); ?>>ASC</option>
											<option value="" <?php selected(get_option("enable_posts_sort_tag_order"), ''); ?>>None</option>
										</select>
										Order
									</label>
								</td>
							</tr>
							
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Search Posts Sort</th>
								<td>
									<label>
										<input type="checkbox" name="et_posts_sort_search_status" value="1" <?php checked(get_option('et_posts_sort_search_status', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Set a custom Posts Sorting (orderby) and Order of the posts for Search.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="enable_posts_sort_search_orderby">
											<option value="relevance" <?php selected(get_option("enable_posts_sort_search_orderby"), 'relevance'); ?>>Relevance</option>
											<option value="modified" <?php selected(get_option("enable_posts_sort_search_orderby"), 'modified'); ?>>Modified Date</option>
											<option value="date" <?php selected(get_option("enable_posts_sort_search_orderby"), 'date'); ?>>Publish date</option>
											<option value="title" <?php selected(get_option("enable_posts_sort_search_orderby"), 'title'); ?>>Title</option>
											<option value="rand" <?php selected(get_option("enable_posts_sort_search_orderby"), 'rand'); ?>>Random</option>
										</select>
										Orderby
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<select name="enable_posts_sort_search_order">
											<option value="DESC" <?php selected(get_option("enable_posts_sort_search_order"), 'DESC'); ?>>DESC</option>
											<option value="ASC" <?php selected(get_option("enable_posts_sort_search_order"), 'ASC'); ?>>ASC</option>
											<option value="" <?php selected(get_option("enable_posts_sort_search_order"), ''); ?>>None</option>
										</select>
										Order
									</label>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="media-tools" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">Media Tools</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						
							<tr valign="top">
								<th scope="row">SVG Files Upload</th>
								<td>
									<label>
										<input type="checkbox" name="enable_svg_files_upload" value="1" <?php checked(get_option('enable_svg_files_upload', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Upload .svg files in wp media
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">WEBP Files Upload</th>
								<td>
									<label>
										<input type="checkbox" name="enable_webp_files_upload" value="1" <?php checked(get_option('enable_webp_files_upload', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Enable .webp media to be uploaded in the wp media
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">ICO Files Upload</th>
								<td>
									<label>
										<input type="checkbox" name="enable_ico_files_upload" value="1" <?php checked(get_option('enable_ico_files_upload', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Enable .ico media to be uploaded in the wp media
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Fonts Files Upload</th>
								<td>
									<label>
										<input type="checkbox" name="enable_fonts_files_upload" value="1" <?php checked(get_option('enable_fonts_files_upload', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Enable .ttf, .otf, .woff & .woff2 fonts to be uploaded in the wp media
									</div>
								</td>
							</tr>
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Custom oEmbed Dimensions</th>
								<td>
									<label>
										<input type="checkbox" name="enable_customize_oembed_dimensions" value="1" <?php checked(get_option('enable_customize_oembed_dimensions', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<?php
									$custom_oembed_width = intval(get_option('custom_oembed_width', 400));
									if ($custom_oembed_width < 0) {
										$custom_oembed_width = 0;
									} elseif ($custom_oembed_width > 8000) {
										$custom_oembed_width = 8000;
									}
									$custom_oembed_height = intval(get_option('custom_oembed_width', 280));
									if ($custom_oembed_height < 0) {
										$custom_oembed_height = 0;
									} elseif ($custom_oembed_height > 8000) {
										$custom_oembed_height = 8000;
									}
								?>
								<td>
									<label>
										<input type="number" name="custom_oembed_width" value="<?php echo esc_attr($custom_oembed_width); ?>" />
										Width
									</label>
									<label>
										<input type="number" name="custom_oembed_height" value="<?php echo esc_attr($custom_oembed_height); ?>" />
										Height
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
									Add new oEmbed media Width and Height, default - width:400, height:280
									</div>
								</td>
							</tr>
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">WP Generated Media Sizes</th>
								<td>
									<label>
										<input type="checkbox" name="disable_auto_generated_image_sizes" value="1" <?php checked(get_option('disable_auto_generated_image_sizes', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<?php
										$all_image_sizes = get_intermediate_image_sizes();
										$enable_selected_image_sizes = get_option('enable_selected_image_sizes', []);
										$enable_selected_image_sizes = ethub::sanitize_image_sizes($enable_selected_image_sizes);
										?>
										<select class="size-6x" name="enable_selected_image_sizes[]" multiple="multiple">
											<?php
											foreach ($all_image_sizes as $size) {
												?>
												<option value="<?php echo esc_attr($size); ?>" <?php selected(is_array($enable_selected_image_sizes) && in_array($size, $enable_selected_image_sizes), true); ?>><?php echo esc_attr($size); ?></option>
												<?php
											}
											?>
										</select>
									</label>
									<div class='ewpt-info-red'>
										EXPERIMENTAL
									</div>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Only selected image sizes will be generated, when image uploaded into WP media library.
									</div><br/>
									<div class='ewpt-info-blue'>
										Use <kbd>Ctrl</kbd> (Windows/Linux) or <kbd>Option</kbd> (Mac) to select multiple image sizes.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Large Image Threshold</th>
								<td>
									<label>
										<input type="checkbox" name="disable_big_image_threshold" value="1" <?php checked(get_option('disable_big_image_threshold', 0)) ?> />
										Enable
									</label>
									<div class='ewpt-info-red'>
										EXPERIMENTAL
									</div>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Should fix the big / large image errors in WordPress media upload
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">GD Library instead of ImageMagick</th>
								<td>
									<label>
										<input type="checkbox" name="enable_gd_library_instead_image_magick" value="1" <?php checked(get_option('enable_gd_library_instead_image_magick', 0)) ?> />
										Enable
									</label>
									<div class='ewpt-info-red'>
										EXPERIMENTAL
									</div>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Enable this when ImageMagick is not available, instead use GD Library
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="archives-tools" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">Archives / Taxonomy Tools</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">

							<tr valign="top">
								<th scope="row">Attachment / Attachments Pages</th>
								<td>
									<label>
										<input type="checkbox" name="disable_attachment_pages" value="1" <?php checked(get_option('disable_attachment_pages', 0)) ?> />
										Hide
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										On the frontend from all visitors
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="search-tools" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">Search Tools</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						
							<tr valign="top">
								<th scope="row">WordPress Frontend Search</th>
								<td>
									<label>
										<input type="checkbox" name="disable_wp_search" value="1" <?php checked(get_option('disable_wp_search', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Disable search on your WordPress frontend
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Custom Search Slug</th>
								<td>
									<label>
										<input type="checkbox" name="enable_affix_custom_search_slug" value="1" <?php checked(get_option('enable_affix_custom_search_slug', 0)) ?> />
										Enable
									
										<input type="text" name="affix_custom_search_slug_text" value="<?php echo esc_attr(get_option('affix_custom_search_slug_text', 'query')); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Add custom search slug for search archive including custom search pagination pages.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Redirect Empty Search Query</th>
								<td>
									<label>
										<input type="checkbox" name="redirect_empty_search_query" value="1" <?php checked(get_option('redirect_empty_search_query', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-red'>
										Redirect empty search query to the 'Custom Search Slug' and show a 404 page. Require 'Custom Search Slug' enabled.<br/>
										<strong>Note: May conflict with 'Auto Post Redirect' feature of various plugin. Example: Rank Math SEO -> Auto Post Redirect</strong>
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Remove WP Pages from Search</th>
								<td>
									<label>
										<input type="checkbox" name="remove_pages_from_search_result" value="1" <?php checked(get_option('remove_pages_from_search_result', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Prevents pages from showing up in search queries on the frontend
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Remove WP Posts from Search</th>
								<td>
									<label>
										<input type="checkbox" name="remove_posts_from_search_result" value="1" <?php checked(get_option('remove_posts_from_search_result', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Prevents posts from showing up in search queries on the frontend
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Remove WP Attachments from Search</th>
								<td>
									<label>
										<input type="checkbox" name="remove_attachments_from_search_result" value="1" <?php checked(get_option('remove_attachments_from_search_result', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Prevents attachments from showing up in search queries on the frontend
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="users-tools" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">Users Tools</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						
							<tr valign="top">
								<th scope="row">Disable Author Archives</th>
								<td>
									<label>
										<input type="checkbox" name="disable_et_author_archives" value="1" <?php checked(get_option('disable_et_author_archives', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										On the frontend
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Custom User Slug</th>
								<td>
									<label>
										<input type="checkbox" name="enable_affix_custom_user_slug" value="1" <?php checked(get_option('enable_affix_custom_user_slug', 0)) ?> />
										Enable
									
										<input type="text" name="affix_custom_user_slug_text" value="<?php echo esc_attr(get_option('affix_custom_user_slug_text', 'user')); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Add custom user slug for user frontend profile pages.
									</div>
								</td>
							</tr>
							
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="login-tools" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">Login Tools</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">WP Login Page Logo</th>
								<td>
									<label>
										<input type="checkbox" name="enable_affix_custom_wp_login_page_logo" value="1" <?php checked(get_option('enable_affix_custom_wp_login_page_logo', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="url" name="affix_custom_wp_login_page_logo_media" id="affix_custom_wp_login_page_logo_media" value="<?php echo esc_attr(get_option('affix_custom_wp_login_page_logo_media')); ?>" />
										<input type="button" id="upload_login_logo_button" class="button" value="Choose Logo" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Add custom wp login page logo (image).
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">WP Login Page Logo URL</th>
								<td>
									<label>
										<input type="checkbox" name="enable_affix_custom_wp_login_logo_url" value="1" <?php checked(get_option('enable_affix_custom_wp_login_logo_url', 0)) ?> />
										Enable
										<input type="url" name="affix_custom_wp_login_page_logo_url_link" value="<?php echo esc_attr(get_option('affix_custom_wp_login_page_logo_url_link')); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Add custom wp login page logo url (link).
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="rss-tools" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">RSS Feeds Tools</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						
							<tr valign="top">
								<th scope="row">RSS Feeds</th>
								<td>
									<label>
										<input type="checkbox" name="enable_rss_feeds_disabler" value="1" <?php checked(get_option( 'enable_rss_feeds_disabler', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Disable the RSS feeds in frontend
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Featured Image in RSS Feeds</th>
								<td>
									<label>
										<input type="checkbox" name="enable_rss_feeds_featured_image" value="1" <?php checked(get_option( 'enable_rss_feeds_featured_image', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Delay Posts in RSS Feeds</th>
								<?php
									$posts_delay_minutes = intval(get_option('rss_feeds_posts_delay_minutes', 10));
									if ($posts_delay_minutes < 1) {
										$posts_delay_minutes = 1;
									} elseif ($posts_delay_minutes > 10000) {
										$posts_delay_minutes = 10000;
									}
								?>
								<td>
									<label>
										<input type="checkbox" name="enable_rss_feeds_posts_delay" value="1" <?php checked(get_option( 'enable_rss_feeds_posts_delay', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="rss_feeds_posts_delay_minutes" value="<?php echo intval($posts_delay_minutes) ?>" />
										Minutes Delay
									</label>
									<div class='ewpt-info-red'>
										EXPERIMENTAL
									</div>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										WP Post will wait the provided minutes, before making itself visible in the RSS feed.
									</div>
								</td>
							</tr>
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">RSS Feeds based on Categories</th>
								<td>
									<label>
										<input type="checkbox" name="enable_exclude_feed_categories" value="1" <?php checked(get_option('enable_exclude_feed_categories', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<?php
										$exclude_feed_categories = get_option('exclude_feed_categories', []);
										$exclude_feed_categories = ethub::sanitize_excluded_categories($exclude_feed_categories);
										
										$all_categories = get_categories();

										if ( ! empty( $all_categories ) ) {
											?>
											<select class="size-6x" name="exclude_feed_categories[]" multiple="multiple">
												<?php
												foreach ( $all_categories as $category ) {
													?>
													<option value="<?php echo esc_attr( $category->term_id ); ?>" <?php selected( in_array( $category->term_id, $exclude_feed_categories ), true ); ?>><?php echo esc_attr( $category->name ); ?></option>
													<?php
												}
												?>
											</select>
											<?php
										}
										?>
									</label>
									<div class='ewpt-info-red'>
										EXPERIMENTAL
									</div>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Only selected categories posts will be visible in rss feeds.
									</div><br/>
									<div class='ewpt-info-blue'>
										Use <kbd>Ctrl</kbd> (Windows/Linux) or <kbd>Option</kbd> (Mac) to select multiple categories to exclude from feeds.
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<div id="security-tools" class="tab-content">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">Security Tools</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						
							<tr valign="top">
								<th scope="row">XML-RPC</th>
								<td>
									<label>
										<input type="checkbox" name="disable_xml_rpc" value="1" <?php checked(get_option('disable_xml_rpc', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Minimum WordPress 3.5+, Disable XML-RPC completely
									</div>
								</td>
							</tr>
							
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">WP REST-API</th>
								<td>
									<label>
										<input type="checkbox" name="disable_wp_rest_api" value="1" <?php checked(get_option('disable_wp_rest_api', 0)) ?> />
										Disable
									</label>
									<label>
										<select name="disable_wp_rest_api_frontend_backend">
											<option value="except_admin" <?php selected(get_option("disable_wp_rest_api_frontend_backend"), 'except_admin'); ?>>Except Admin</option>
											<option value="except_admin_editor" <?php selected(get_option("disable_wp_rest_api_frontend_backend"), 'except_admin_editor'); ?>>Except Admin, & Editor</option>
											<option value="except_admin_editor_author" <?php selected(get_option("disable_wp_rest_api_frontend_backend"), 'except_admin_editor_author'); ?>>Except Admin, Editor, & Author</option>
											<option value="only_author" <?php selected(get_option("disable_wp_rest_api_frontend_backend"), 'only_author'); ?>>Only Author</option>
											<option value="only_contributor" <?php selected(get_option("disable_wp_rest_api_frontend_backend"), 'only_contributor'); ?>>Only Contributor</option>
											<option value="only_subscriber" <?php selected(get_option("disable_wp_rest_api_frontend_backend"), 'only_subscriber'); ?>>Only Subscriber</option>
											<option value="only_logged_in_users" <?php selected(get_option("disable_wp_rest_api_frontend_backend"), 'only_logged_in_users'); ?>>Only Logged-in Users</option>
											<option value="only_non_logged_in_users" <?php selected(get_option("disable_wp_rest_api_frontend_backend"), 'only_non_logged_in_users'); ?>>Only Non Logged-in Users</option>
											<option value="all_users" <?php selected(get_option("disable_wp_rest_api_frontend_backend"), 'all_users'); ?>>All Users</option>
										</select>
									</label>
								</td>
								<td>
									<div class='ewpt-info-red'>
										Disable "REST API" for 'all visitors' (everyone) or based on various users roles combination.<br/>
										Recommended: 'Except Admin': Disable the REST API. Except, Admin role user'(s).<br/>
										<strong>Note: 'All Users' and 'Only Logged-in Users' option also disables AJAX and Cron REST API calls.<br/>
										This might cause issues for some themes and plugins.</strong>
									</div>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" name="wp_rest_api_error_message_text" value="<?php echo esc_attr(get_option('wp_rest_api_error_message_text', 'REST API has been disabled.')); ?>" />
										Error Message
									</label>
								</td>
								<td>
									<div class='ewpt-info-red'>
										Enter an error message for the disabled 'REST API' page visitors.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Redirect HTTP to HTTPS</th>
								<td>
									<label>
										<input type="checkbox" name="enable_redirect_https_ssl" value="1" <?php checked(get_option('enable_redirect_https_ssl', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-red'>
										Forcefully redirect all HTTP URL to HTTPS (SSL) URL on your WordPress website (everywhere).<br/>
										<strong>Note: Redirect happens only if your website (server) has SSL certificate properly installed.</strong>
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">jQuery Migrate Script</th>
								<td>
									<label>
										<input type="checkbox" name="et_disable_jquery_migrate_script" value="1" <?php checked(get_option('et_disable_jquery_migrate_script', 0)) ?> />
										Remove
									</label>
								</td>
								<td>
									<div class='ewpt-info-red'>
										Remove jQuery Migrate Script from the frontend. Might Cause jQuery issue for some theme and plugins (if checked).
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Static Files Query Strings</th>
								<td>
									<label>
										<input type="checkbox" name="remove_query_strings_from_static_files" value="1" <?php checked(get_option('remove_query_strings_from_static_files', 0)) ?> />
										Remove
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Remove query string from CSS & JS files and improve performance
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">WP Auto Updates Emails</th>
								<td>
									<label>
										<input type="checkbox" name="disable_automatic_updates_emails" value="1" <?php checked(get_option('disable_automatic_updates_emails', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Will not send wp admin email about automatic updates of core, plugins, and themes.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">WP Generator Tag</th>
								<td>
									<label>
										<input type="checkbox" name="remove_wp_generator_tag" value="1" <?php checked(get_option('remove_wp_generator_tag', 0)) ?> />
										Remove
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Remove WP Generator Tag from your site's frontend < head > meta
									</div>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">Frontend Script's Version</th>
								<td>
									<label>
										<input type="checkbox" name="enable_remove_frontend_scripts_version" value="1" <?php checked(get_option('enable_remove_frontend_scripts_version', 0)) ?> />
										Remove
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Remove WP Frontend Script's Version Number string
									</div>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">Frontend Style's Version</th>
								<td>
									<label>
										<input type="checkbox" name="enable_remove_frontend_styles_version" value="1" <?php checked(get_option('enable_remove_frontend_styles_version', 0)) ?> />
										Remove
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Remove WP Frontend Style's Version Number string
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
				// Include the module about file
				include(EWPT_PLUGIN_PATH . 'inc/ewpt-about-modules.php');
				?>
				
				<?php //submit_button('Save Changes'); ?>
					
			</form>
			
		</div>

		<div id="ewpt-page-footer" class="ewpt-page-footer">
				
			<script id="ethub-uploader-script">
			(function($) {
				// Logo Uploader Script
				$(document).ready(function () {
					var mediaUploader;

					$('#upload_login_logo_button').click(function (e) {
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
							$('#affix_custom_wp_login_page_logo_media').val(attachment.url);
						});

						mediaUploader.open();
					});
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
	include plugin_dir_path(__FILE__) . 'ewpt-essential-tools-actions.php';

} // if (!function_exists('ewpt_essential_tools_settings_page'))