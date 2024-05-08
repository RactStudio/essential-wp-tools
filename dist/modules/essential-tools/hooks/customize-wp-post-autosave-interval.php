<?php
// customize-wp-post-autosave-interval.php
/**
 * Customize WP Post Autosave Interval Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Get the custom autosave interval from settings
$custom_autosave_interval = intval(get_option('custom_autosave_interval', 5));

// Customize WP Post Autosave Interval
if (!defined('AUTOSAVE_INTERVAL')) {
	define('AUTOSAVE_INTERVAL', $custom_autosave_interval * MINUTE_IN_SECONDS);
}