<?php
// remove-wp-welcome-panel.php

// Check if WP Welcome Panel should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Hide the Welcome Panel on the WordPress dashboard for all users.
add_action( 'admin_init', function () {
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
});