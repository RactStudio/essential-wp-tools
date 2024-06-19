<?php
// essential-wp-tools/modules/essential-tools/ewpt-essential-tools-hooks.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add Modules Action/Hooks files
$ewpt_disable_all_essential_tools_options = get_option("ewpt_disable_all_essential_tools_options", 0);
if ($ewpt_disable_all_essential_tools_options != 1) {
	
	$disable_gutenberg_editor = get_option('disable_gutenberg_editor', 0);
	if ($disable_gutenberg_editor == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-gutenberg-editor.php');
	}
	
	$disable_widget_blocks = get_option('disable_widget_blocks', 0);
	if ($disable_widget_blocks == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-widget-blocks.php');
	}
	
	$enable_svg_files_upload = get_option('enable_svg_files_upload', 0);
	if ($enable_svg_files_upload == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-svg-files-upload.php');
	}
	
	$remove_wp_generator_tag = get_option('remove_wp_generator_tag', 0);
	if ($remove_wp_generator_tag == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-wp-generator-tag.php');
	}
	
	$disable_xml_rpc = get_option('disable_xml_rpc', 0);
	if ($disable_xml_rpc == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-xml-rpc.php');
	}
	
	$disable_wp_admin_bar = get_option('disable_wp_admin_bar', 0);
	if ($disable_wp_admin_bar == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-wp-admin-bar.php');
	}
	
	$disable_automatic_updates_emails = get_option('disable_automatic_updates_emails', 0);
	if ($disable_automatic_updates_emails == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-automatic-updates-emails.php');
	}
	
	$disable_wp_rest_api = get_option('disable_wp_rest_api', 0);
	if ($disable_wp_rest_api == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-wp-rest-api.php');
	}
	
	$disable_wp_comments = get_option('disable_wp_comments', 0);
	if ($disable_wp_comments == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-wp-comments.php');
	}
	
	$disable_attachment_pages = get_option('disable_attachment_pages', 0);
	if ($disable_attachment_pages == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-attachment-pages.php');
	}
	
	$enable_replace_wp_howdy = get_option('enable_replace_wp_howdy', 0);
	if ($enable_replace_wp_howdy == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/customize-replace-wp-howdy.php');
	}
	
	$remove_wp_welcome_panel = get_option('remove_wp_welcome_panel', 0);
	if ($remove_wp_welcome_panel == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-wp-welcome-panel.php');
	}
	
	$enable_customize_wp_admin_footer_text = get_option('enable_customize_wp_admin_footer_text', 0);
	if ($enable_customize_wp_admin_footer_text == 1 && is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/customize-wp-admin-footer-text.php');
	}
	
	$remove_admin_screen_options_tab = get_option('remove_admin_screen_options_tab', 0);
	if ($remove_admin_screen_options_tab == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-admin-screen-options-tab.php');
	}
	
	$enable_limit_wp_post_revisions_number = get_option('enable_limit_wp_post_revisions_number', 0);
	if ($enable_limit_wp_post_revisions_number == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-limit-wp-post-revisions-number.php');
	}
	
	$enable_wp_posts_min_words_count = get_option('enable_wp_posts_min_words_count', 0);
	if ($enable_wp_posts_min_words_count == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-wp-posts-minimum-words-count.php');
	}
	
	$disable_wp_site_health = get_option('disable_wp_site_health', 0);
	if ($disable_wp_site_health == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-wp-site-health.php');
	}
	
	$enable_customize_oembed_dimensions = get_option('enable_customize_oembed_dimensions', 0);
	if ($enable_customize_oembed_dimensions == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/customize-oembed-width-height.php');
	}
	
	$enable_customize_autosave_interval = get_option('enable_customize_autosave_interval', 0);
	if ($enable_customize_autosave_interval == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/customize-wp-post-autosave-interval.php');
	}
	
	$disable_automatic_trash_emptying = get_option('disable_automatic_trash_emptying', 0);
	if ($disable_automatic_trash_emptying == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-automatic-trash-emptying.php');
	}
	
	$disable_block_editor_directory_result = get_option('disable_block_editor_directory_result', 0);
	if ($disable_block_editor_directory_result == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-block-editor-directory-result.php');
	}
	
	$enable_wp_duplicate_posts_pages = get_option('enable_wp_duplicate_posts_pages', 0);
	if ($enable_wp_duplicate_posts_pages == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-wp-duplicate-posts-pages.php');
	}
	
	$enable_external_links_in_new_tab = get_option('enable_external_links_in_new_tab', 0);
	if ($enable_external_links_in_new_tab == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-external-links-in-new-tab.php');
	}
	
	$disable_wp_search = get_option('disable_wp_search', 0);
	if ($disable_wp_search == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-wp-search.php');
	}
	
	$disable_wp_editor_code_editing = get_option('disable_wp_editor_code_editing', 0);
	if ($disable_wp_editor_code_editing == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-wp-editor-code-editing.php');
	}
	
	$disable_frontend_copy_paste = get_option('disable_frontend_copy_paste', 0);
	if ($disable_frontend_copy_paste == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-frontend-copy-paste.php');
	}
	
	$remove_gutenberg_blocks_library_css = get_option('remove_gutenberg_blocks_library_css', 0);
	if ($remove_gutenberg_blocks_library_css == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-gutenberg-blocks-library-css.php');
	}
	
	$remove_pages_from_search_result = get_option('remove_pages_from_search_result', 0);
	if ($remove_pages_from_search_result == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-pages-from-search-result.php');
	}
	
	$remove_posts_from_search_result = get_option('remove_posts_from_search_result', 0);
	if ($remove_posts_from_search_result == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-posts-from-search-result.php');
	}
	
	$remove_attachments_from_search_result = get_option('remove_attachments_from_search_result', 0);
	if ($remove_attachments_from_search_result == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-attachments-from-search-result.php');
	}
	
	$disable_auto_generated_image_sizes = get_option('disable_auto_generated_image_sizes', 0);
	if ($disable_auto_generated_image_sizes == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-auto-generated-images-sizes.php');
	}
	
	$enable_text_widget_shortcode = get_option('enable_text_widget_shortcode', 0);
	if ($enable_text_widget_shortcode == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-text-widget-shortcode.php');
	}
	
	$enable_webp_files_upload = get_option('enable_webp_files_upload', 0);
	if ($enable_webp_files_upload == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-webp-files-upload.php');
	}
	
	$enable_ico_files_upload = get_option('enable_ico_files_upload', 0);
	if ($enable_ico_files_upload == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-ico-files-upload.php');
	}
	
	$enable_fonts_files_upload = get_option('enable_fonts_files_upload', 0);
	if ($enable_fonts_files_upload == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-fonts-files-upload.php');
	}
	
	$disable_big_image_threshold = get_option('disable_big_image_threshold', 0);
	if ($disable_big_image_threshold == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-big-image-threshold.php');
	}
	
	$enable_gd_library_instead_image_magick = get_option('enable_gd_library_instead_image_magick', 0);
	if ($enable_gd_library_instead_image_magick == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-gd-library-instead-image-magick.php');
	}
	
	$enable_exclude_feed_categories = get_option('enable_exclude_feed_categories', 0);
	if ($enable_exclude_feed_categories == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/rss-feeds-remove-categories.php');
	}
	$enable_rss_feeds_featured_image = get_option('enable_rss_feeds_featured_image', 0);
	if ($enable_rss_feeds_featured_image == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/rss-feeds-featured-image.php');
	}
	$enable_rss_feeds_disabler = get_option('enable_rss_feeds_disabler', 0);
	if ($enable_rss_feeds_disabler == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/rss-feeds-disable.php');
	}
	
	$disable_et_author_archives = get_option('disable_et_author_archives', 0);
	if ($disable_et_author_archives == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-author-archives.php');
	}
	
	$disable_et_blog_posts_type = get_option('disable_et_blog_posts_type', 0);
	if ($disable_et_blog_posts_type == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-blog-posts-type.php');
	}
	
	$remove_query_strings_from_static_files = get_option('remove_query_strings_from_static_files', 0);
	if ($remove_query_strings_from_static_files == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-query-strings-from-static-files.php');
	}
	
	$et_disable_jquery_migrate_script = get_option('et_disable_jquery_migrate_script', 0);
	if ($et_disable_jquery_migrate_script == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/disable-jquery-migrate-script.php');
	}
	
	$enable_affix_auto_excerpt = get_option('enable_affix_auto_excerpt', 0);
	if ($enable_affix_auto_excerpt == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/affix-auto-excerpt.php');
	}
	
	$enable_posts_sorting = get_option('enable_posts_sorting', 0);
	if ($enable_posts_sorting == 1 && !is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/enable-posts-sort-order.php');
	}
	
	$enable_affix_custom_search_slug = get_option('enable_affix_custom_search_slug', 0);
	if ($enable_affix_custom_search_slug == 1 && ! is_admin() ) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/affix-custom-search-slug.php');
	}
	
	$redirect_empty_search_query = get_option('redirect_empty_search_query', 0);
	if ($redirect_empty_search_query == 1 && ! is_admin()) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/redirect-empty-search-query.php');
	}
	
	$enable_affix_custom_user_slug = get_option('enable_affix_custom_user_slug', 0);
	if ($enable_affix_custom_user_slug == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/affix-custom-user-slug.php');
	}
	
	$enable_affix_custom_wp_login_logo_url = get_option('enable_affix_custom_wp_login_logo_url', 0);
	if ($enable_affix_custom_wp_login_logo_url == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/affix-custom-wp-login-logo-url.php');
	}
	
	$enable_affix_custom_wp_login_page_logo = get_option('enable_affix_custom_wp_login_page_logo', 0);
	if ($enable_affix_custom_wp_login_page_logo == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/affix-custom-wp-login-page-logo.php');
	}
	
	$enable_remove_frontend_scripts_version = get_option('enable_remove_frontend_scripts_version', 0);
	if ($enable_remove_frontend_scripts_version == 1 && ! is_admin() ) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-frontend-scripts-version.php');
	}
	
	$enable_remove_frontend_styles_version = get_option('enable_remove_frontend_styles_version', 0);
	if ($enable_remove_frontend_styles_version == 1 && ! is_admin() ) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-frontend-styles-version.php');
	}
	
	$enable_remove_posts_list_menus_customizer = get_option('enable_remove_posts_list_menus_customizer', 0);
	if ($enable_remove_posts_list_menus_customizer == 1 && is_admin() ) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/remove-posts-list-menus-customizer.php');
	}
	
	$enable_https_ssl_redirect = get_option('enable_redirect_https_ssl', 0);
	if ($enable_https_ssl_redirect == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/redirect-https-ssl.php');
	}
	
	
}