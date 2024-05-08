<?php
// essential-wp-tools/modules/social-share-hub/ewpt-social-share-hub-shortcodes-generator.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// importing the 'ewpt' class
// essential-wp-tools/modules/social-share-hub/ewpt-social-share-hub-functions.php
use sshub\sshub as sshub;


add_shortcode(
	'ewpt_social_share_hub',
	function ($atts) {
		
		// Extract shortcode attributes
		$atts = shortcode_atts(
			array(
				'slot' => 0, // Default to show all share buttons slots
			),
			$atts,
			'ewpt_social_share_hub'
		);

		$ssh_design_template_with_style = ''; // Initialize an empty string to accumulate HTML

		// Retrieve total slots once outside the loop
		$total_ssh_slots = get_option('enable_total_share_buttons_counter', 10);

		// Retrieve options outside the loop once
		$options = array();
		for ($i = 1; $i <= $total_ssh_slots; $i++) {
			$options[$i] = array(
				'enable_ssh_code' => get_option("share_buttons_{$i}_slot"),
				'enable_ssh_shortcode' => get_option("share_buttons_{$i}_shortcode"),
				'ssh_design_type' => get_option("share_buttons_{$i}_design_template"),
				'ssh_design_template' => sshub::social_share_hub_selected_buttons($i),
				'ssh_css_style_status' => get_option("share_buttons_{$i}_css_style"),
				'ssh_padding' => get_option("share_buttons_{$i}_padding"),
				'ssh_text_align' => get_option("share_buttons_{$i}_alignment"),
				'ssh_background_color' => get_option("share_buttons_{$i}_background_color"),
				'ssh_border_color' => get_option("share_buttons_{$i}_border_color"),
				'ssh_border_radius' => intval(get_option("share_buttons_{$i}_border_radius")),
			);
		}

		// Loop through the slots
		for ($i = 1; $i <= $total_ssh_slots; $i++) {
			$ssh_number = $i;
			$option = $options[$ssh_number];

			// Check if the share buttons slot is enabled in user settings
			if ($option['enable_ssh_code'] == 1 && $option['enable_ssh_shortcode'] == 1) {
				// Check if the current share buttons slot matches the specified 'slot' attribute
				if ($atts['slot'] == 0 || $atts['slot'] == $ssh_number) {
					// CSS Style
					$ssh_css_style = '';
					if ($option['ssh_css_style_status'] == 1) {
						$ssh_css_style .= !empty($option['ssh_padding']) ? 'padding:' . $option['ssh_padding'].'px ' . $option['ssh_padding'].'px ' . round($option['ssh_padding']/3).'px ' . $option['ssh_padding'].'px;' : '';
						$ssh_css_style .= !empty($option['ssh_text_align']) ? 'text-align:' . $option['ssh_text_align'] . ';' : '';
						$ssh_css_style .= !empty($option['ssh_background_color']) ? 'background-color:' . sshub::ssh_rgba_to_hex($option['ssh_background_color']) . ';' : '';
						$ssh_css_style .= !empty($option['ssh_border_color']) ? 'border:1px solid ' . sshub::ssh_rgba_to_hex($option['ssh_border_color']) . ';' : '';
						$ssh_css_style .= !empty($option['ssh_border_radius']) ? 'border-radius:' . $option['ssh_border_radius'] . 'px;' : '';
					}
					
					// Create the design type class (color)
					$design_type_parts = explode('_', $option['ssh_design_type']);
					$ssh_design_type = wp_kses(end($design_type_parts), array());
					
					// Generate HTML with CSS style
					$ssh_design_template_with_style = '<div style="' . $ssh_css_style . '" class="ewpt-ssh ' . $ssh_design_type . ' ewpt-ssh-' . $ssh_number . '">' . $option['ssh_design_template'] . '</div>';

					// If 'slot' attribute is specified, exit the loop after processing that slot
					if ($atts['slot'] > 0) {
						return $ssh_design_template_with_style;
					}

					// Accumulate HTML for all share buttons slots
					$ssh_design_template_with_style .= $ssh_design_template_with_style;
				}
			}
		}
		
		return $ssh_design_template_with_style; // Return accumulated HTML for the specified share buttons slot(s)
	}
);