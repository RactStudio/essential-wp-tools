<?php
// disable-automatic-updates-emails.php

// Check if Automatic Updates should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Disable auto-update emails.
add_filter( 'auto_core_update_send_email', '__return_false' );

// Disable auto-update emails for plugins.
add_filter( 'auto_plugin_update_send_email', '__return_false' );

// Disable auto-update emails for themes.
add_filter( 'auto_theme_update_send_email', '__return_false' );