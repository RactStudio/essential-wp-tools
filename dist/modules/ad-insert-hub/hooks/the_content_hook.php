<?php
// essential-wp-tools/modules/ad-insert-hub/hooks/the_content_hook.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use EWPT\Modules\AdIInsertHub\adihub as adihub;

// Get the minimum and maximum number to save from user input
// Total Ads slot by User defined - OR, default to 10 
$ewpt_ads_i = intval(get_option('enable_total_ads_counter', 10));
// Ensure between 10 and 40
if ($ewpt_ads_i < 1) {
	$ewpt_ads_i = 1;
} elseif ($ewpt_ads_i > 40) {
	$ewpt_ads_i = 40;
}

for ($i = 1; $i <= $ewpt_ads_i; $i++) {
	$enable_ads_code = get_option("enable_ads_{$i}_code");
	$condition_insert_placement = get_option("ads_{$i}_insert_hook", '');
	
	if ( $enable_ads_code == 1 && $condition_insert_placement == 'the_content' ) {
		
		add_filter( 'the_content', function ($content) use ($i) {
			// Check if it's single post types or single pages, if not, do not add the ads code
			if ( is_home() || is_front_page() || is_archive() || is_search() || is_attachment() || !in_the_loop() ) {
				return $content;
			}
			
			// Check where ads placement is allowed
			$ads_place_singlepost = get_option("ads_{$i}_place_singlepost");
			$ads_place_singlepage = get_option("ads_{$i}_place_singlepage");
			// Check if it's a custom post type
			$current_post_type = get_post_type();
			$current_post_type = $current_post_type ?? 'adihub'; // Set a default fake post type if null
			$post_type_checkbox = "ads_{$i}_place_{$current_post_type}";
			$ads_place_current_post_type = get_option($post_type_checkbox);
			// Ensure that get_post_type() returns an array before accessing its elements
			$current_post_type = is_array($current_post_type) ? $current_post_type[0] : $current_post_type;
			// Check if the post type matches and the specific post type checkbox is checked
			if (
				( (is_single() || is_singular($current_post_type)) && ($current_post_type == 'post') && ($ads_place_singlepost == 1) && post_type_exists('post')) ||
				( (is_page() || is_singular($current_post_type)) && ($current_post_type == 'page') && ($ads_place_singlepage == 1) && post_type_exists('page')) ||
				( is_singular($current_post_type) && ($ads_place_current_post_type == 1) && post_type_exists($current_post_type))
			) {
				// Apply insertion logic to the current post or page or CPT
				return adihub::ad_insert_hub_output_content($content, $i);
			}
			
			return $content;
		});
	}
}