<?php
// essential-wp-tools/modules/ad-insert-hub/ewpt-ad-insert-hub-shortcodes-generator.php

namespace adihub;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_shortcode(
	'ewpt_ad_insert_hub',
	function ($atts) {
		// Extract shortcode attributes
		$atts = shortcode_atts(
			array(
				'slot' => 0, // Default to show all ad slots
			),
			$atts,
			'ewpt_ad_insert_hub'
		);

		// Retrieve all options outside the loop
		$total_ads_slots = get_option('enable_total_ads_counter', 10);
		$html = ''; // Initialize an empty string to accumulate HTML

		// Initialize an array to store HTML snippets
		$html_snippets = array();

		for ($i = 1; $i <= $total_ads_slots; $i++) {
			// Check if the ad slot is enabled in user settings
			$ads_number = $i;
			$ads_code = get_option("enable_ads_{$ads_number}_code");
			$ads_shortcode = get_option("ads_{$ads_number}_shortcode");
			
			if ($ads_code == 1 && $ads_shortcode == 1) {
				// Check if the current ad slot matches the specified 'slot' attribute
				if ($atts['slot'] == 0 || $atts['slot'] == $ads_number) {
					$ads_user_content = wp_kses_post(get_option("ads_{$ads_number}_user_content"));
					$ads_css_style_status = get_option("ads_{$ads_number}_css_style");
					
					// Ads CSS Style
					$style_start = '';
					$style_ends = '';
					if ($ads_css_style_status == 1) {
						$style_start = '<div style="margin:15px 0px; padding:5px; border:1px solid #D3D3D312; border-radius:5px; background-color:#D3D3D324; text-align:center;" class="ewpt-acode ewpt-acode-' . $ads_number . '">';
						$style_ends = "</div>";
					}
					
					// Generate HTML snippet for the ad slot
					$html_snippets[] = $style_start . $ads_user_content . $style_ends;
					
					// If 'slot' attribute is specified, exit the loop after processing that slot
					if ($atts['slot'] > 0) {
						break;
					}
				}
			}
		}
		
		// Join HTML snippets
		$html = implode('', $html_snippets);
		
		return $html; // Return accumulated HTML for the specified ad slot(s)
	}
);