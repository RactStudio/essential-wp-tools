<?php
// enable-wp-posts-minimum-words-count.php

/**
 * Enable WP Posts Minimum Words Count Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enable WP Posts Minimum Words Count function
add_action(
	'publish_post',
    function ($post_id, $post) {
		// Get the custom minimum number of words from settings
		$custom_min_word_count = intval(get_option('custom_min_word_count', 100));
        // Check if the post content word count is below the minimum
        if (str_word_count($post->post_content) < $custom_min_word_count) {
            wp_die(
                sprintf(
                    wp_kses_post('The post content is below the minimum word count. Your post needs to have at least %d words to be published.', 'essential-wp-tools'),
                    absint($custom_min_word_count)
                )
            );
        }
    },
	9,
	2
);