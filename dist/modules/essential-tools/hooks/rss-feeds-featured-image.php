<?php
// essential-wp-tools/modules/general-tools/rss-feeds-featured-image.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add the post thumbnail, if available, before the content in feeds.

add_filter(
	'the_excerpt_rss',
	function ( $content ) {
		global $post;
		if ( has_post_thumbnail( $post->ID ) ) {
			$content = '<p>' . get_the_post_thumbnail( $post->ID ) . '</p>' . $content;
		}
		return $content;
	}
);

add_filter(
	'the_content_feed',
	function ( $content ) {
		global $post;
		if ( has_post_thumbnail( $post->ID ) ) {
			$content = '<p>' . get_the_post_thumbnail( $post->ID ) . '</p>' . $content;
		}
		return $content;
	}
);