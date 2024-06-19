<?php
// redirect-https-ssl.php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Redirect HTTP to HTTPS if SSL is available
add_action( 'template_redirect', function () {
	// Check if SSL is available
	if (is_ssl()) {
		return; // SSL is already enabled, no need to redirect
	}
	
	// Check if the current environment supports SSL
	if (!wp_is_https_supported()) {
		return; // SSL is not supported, no need to redirect
	}
	
	// Construct the HTTPS URL
	$redirect_url = 'https://' . sanitize_text_field($_SERVER['HTTP_HOST']) . sanitize_text_field($_SERVER['REQUEST_URI']);

	// Redirect to HTTPS version of the current page
	wp_redirect(esc_url($redirect_url), 301);
	exit();
	
});