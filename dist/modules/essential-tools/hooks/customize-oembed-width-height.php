<?php
// customize-oembed-width-height.php

/**
 * Customize oEmbed Width and Height Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Customize oEmbed Width and Height function
add_filter(
	'embed_defaults',
	function ($sizes) {
		// Get the custom width and height from settings
		$custom_oembed_width = intval(get_option('custom_oembed_width', 400));
		$custom_oembed_height = intval(get_option('custom_oembed_height', 280));
		
		return array(
			'width' => $custom_oembed_width,
			'height' => $custom_oembed_height,
		);
	}
);