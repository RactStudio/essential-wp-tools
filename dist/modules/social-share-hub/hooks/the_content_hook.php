<?php
// essential-wp-tools/modules/social-share-hub/hooks/the_content_hook.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// importing the 'ewpt' class
// essential-wp-tools/modules/social-share-hub/ewpt-social-share-hub-functions.php
use sshub\sshub as sshub;

$ewpt_ssh_i = get_option('enable_total_share_buttons_counter', 5);

for ($i = 1; $i <= $ewpt_ssh_i; $i++) {
    $enable_ssh_code = get_option("share_buttons_{$i}_slot");
    $condition_insert_placement = get_option("share_buttons_{$i}_insert_hook");
	
    if ($enable_ssh_code == 1 && $condition_insert_placement == 'the_content') {
		
        add_filter(
			'the_content',
			function ($content) use ($i) {
				// Check if it's single post types or single pages, if not, do not add the buttons
				if ( is_home() || is_front_page() || is_archive() || is_search() || is_attachment() || !in_the_loop() ) {
					return $content;
				}

				// Check where placement is allowed
				$ssh_place_singlepost = get_option("share_buttons_{$i}_place_singlepost");
				$ssh_place_singlepage = get_option("share_buttons_{$i}_place_singlepage");
				// Check if it's a custom post type
				$current_post_type = get_post_type();
				$current_post_type = $current_post_type ?? 'ewptssh'; // Set a default fake post type if null
				$post_type_checkbox = "share_buttons_{$i}_place_{$current_post_type}";
				$ssh_place_current_post_type = get_option($post_type_checkbox);
				// Ensure that get_post_type() returns an array before accessing its elements
				$current_post_type = is_array($current_post_type) ? $current_post_type[0] : $current_post_type;
				// Check if the post type matches and the specific post type checkbox is checked
				if (
					( (is_single() || is_singular($current_post_type)) && ($current_post_type == 'post') && ($ssh_place_singlepost == 1) && post_type_exists('post')) ||
					( (is_page() || is_singular($current_post_type)) && ($current_post_type == 'page') && ($ssh_place_singlepage == 1) && post_type_exists('page')) ||
					( is_singular($current_post_type) && ($ssh_place_current_post_type == 1) && post_type_exists($current_post_type))
				) {
					// Apply insertion logic to the current post or page or CPT
					return sshub::social_share_hub_output_content($content, $i);
				}
				
				return $content;
			}
		);
    }
}