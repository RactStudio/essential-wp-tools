<?php
// remove-wp-generator-tag.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Remove WordPress Generator Tag
add_filter('the_generator', '__return_empty_string');
remove_action('wp_head', 'wp_generator');