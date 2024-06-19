<?php
// affix-custom-user-slug.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Initiate a change of the wordpress default author page slug to the new author page slug.
add_action( 'init', function () {
	global $wp_rewrite;
	// Update author base slug
	$author_base_slug = get_option('affix_custom_user_slug_text', 'user');
	$wp_rewrite->author_base = sanitize_html_class($author_base_slug);
	$wp_rewrite->flush_rules();
});

// Modify the default author slug to a custom user slug
add_filter( 'author_rewrite_rules', function ($author_rewrite_rules) {
	$new_author_base_slug = get_option('affix_custom_user_slug_text', 'user');
	$new_author_base_slug = sanitize_html_class($new_author_base_slug);

	// Generate new author rewrite rules
	$new_author_rewrite_rules = array();

	foreach ($author_rewrite_rules as $regex => $rule) {
		$new_regex = str_replace('author/', $new_author_base_slug . '/', $regex);
		$new_author_rewrite_rules[$new_regex] = $rule;
	}

	return $new_author_rewrite_rules;
});

// Flush rewrite rules to ensure the new rules are recognized
add_action('init', 'flush_rewrite_rules');