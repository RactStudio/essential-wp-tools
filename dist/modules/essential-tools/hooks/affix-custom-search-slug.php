<?php
// affix-custom-search-slug.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Initiate a change of the wordpress default search page slug to the new search page slug.
add_action( 'init', function () {
	global $wp_rewrite;
	//$search_base_slug = '%'.get_option('affix_custom_search_slug_text', 'query').'%';
	$wp_rewrite->search_base = sanitize_html_class('%'.get_option('affix_custom_search_slug_text', 'query').'%');
	$wp_rewrite->flush_rules();
});

// Redirect the Search from default s?={search_query} to new search base
add_action( 'template_redirect',  function () {
	if (is_search() && ! empty( $_GET['s'] ) && !empty(urlencode(get_query_var('s')))) {
		// Redirect URL 
		$redirect_url = home_url("/" . sanitize_html_class(get_option('affix_custom_search_slug_text', 'query')) . "/" . urlencode(get_query_var('s')) . "/");
		 wp_redirect($redirect_url, 301);
		exit();
	}
});