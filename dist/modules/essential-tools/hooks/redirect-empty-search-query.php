<?php
// redirect-empty-search-query.php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Redirect the empty Search from default s?={search_query} to new search base and dispaly as 404 page
add_action( 'template_redirect', function () {
	if ( is_search() && empty( $_GET['s'] ) && empty( urlencode( get_query_var( 's' ) ) ) ) {
		// Redirect URL 
		$redirect_url = home_url("/" . sanitize_html_class(get_option('affix_custom_search_slug_text', 'search')) . "/");
		 wp_redirect($redirect_url);
		exit();
	}
});