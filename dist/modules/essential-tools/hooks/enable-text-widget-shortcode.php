<?php
// enable-text-widget-shortcode.php

// Check if Shortcode Execution in Default Text Widgets should be Enable
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enable Shortcode Execution in Default Text Widgets
add_filter( 'widget_text', 'do_shortcode' );