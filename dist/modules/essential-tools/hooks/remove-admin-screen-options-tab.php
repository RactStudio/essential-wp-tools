<?php
// remove-admin-screen-options-tab.php

// Check if  WP Attachment Pages should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Hide admin 'Screen Options' tab
add_filter('screen_options_show_screen', '__return_false');