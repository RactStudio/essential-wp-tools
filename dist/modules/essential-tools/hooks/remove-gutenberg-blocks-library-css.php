<?php
// remove-gutenberg-blocks-library-css.php

// Check if WordPress Gutenberg Block Library CSS should be removed
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Remove Gutenberg Block Library CSS from loading on the frontend
add_action( 'wp_print_styles', function (){
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
}, 100 );
