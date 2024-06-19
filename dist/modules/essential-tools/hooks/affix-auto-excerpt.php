<?php
// affix-auto-excerpt.php

/**
 * Add automatic Excerpt to posts, pages and custom post types everywhere on the frontend
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add automatic Excerpt
add_filter( 'get_the_excerpt', function ($excerpt, $post) {
	$excerpt_length = intval(get_option('affix_auto_excerpt_words_count_length', 35));
	if ($excerpt_length < 0) {
		$excerpt_length = 0;
	} elseif ($excerpt_length > 1000) {
		$excerpt_length = 1000;
	}
	$excerpt_more_enable = get_option('enable_affix_auto_excerpt_read_more', 0); // Check if "Read More" is enabled
	$excerpt_more_text = get_option('affix_auto_excerpt_read_more_texts', 'Read More »'); // Get custom "Read More" text from user setting
	$excerpt_more_link_enable = get_option('enable_affix_auto_excerpt_read_more_with_link', 1); // Check if "Read More" link is enabled
	$excerpt_strip_shortcode = get_option('strip_auto_excerpt_content_shortcode_text', 0); // Check if "Read More" link is enabled

	$excerpt_more = $excerpt_more_enable ? '... ' . ($excerpt_more_link_enable ? '<a href="' . get_permalink($post->ID) . '">' . $excerpt_more_text . '</a>' : $excerpt_more_text) : ''; // Add ellipsis and 'Read More' permalink text when trimmed, based on user settings

	if (has_excerpt($post)) {
		if ($excerpt_strip_shortcode == 1) {
			$excerpt = wp_trim_words(strip_shortcodes($excerpt, $excerpt_length, $excerpt_more));
		} else {
			$excerpt = wp_trim_words($excerpt, $excerpt_length, $excerpt_more);
		}
	} else {
		$content = $post->post_content;
		if ($excerpt_strip_shortcode == 1) {
			$excerpt = wp_trim_words(strip_shortcodes($content, $excerpt_length, $excerpt_more));
		} else {
			$excerpt = wp_trim_words($content, $excerpt_length, $excerpt_more);
		}
	}
	return $excerpt;
}, 10, 2 );