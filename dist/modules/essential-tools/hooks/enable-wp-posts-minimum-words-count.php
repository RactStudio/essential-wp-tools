<?php
// enable-wp-posts-minimum-words-count.php

/**
 * Enable WP Posts Minimum Words Count Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enable WP Posts Minimum Words Count function
add_action( 'publish_post', function ($post_id, $post) {
	$min_word_count = intval(get_option('custom_min_word_count', 10));
	if ($min_word_count < 1) {
		$min_word_count = 1;
	} elseif ($min_word_count > 1000000) {
		$min_word_count = 1000000;
	}
	// Check if the post content word count is below the minimum
	if (str_word_count($post->post_content) < $min_word_count) {
		wp_die(
			sprintf(
				wp_kses_post('The post content is below the minimum word count. Your post needs to have at least %d words to be published.', 'essential-wp-tools'),
				absint($min_word_count)
			)
		);
	}
}, 9, 2 );