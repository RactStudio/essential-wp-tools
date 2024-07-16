<?php
// disable-widget-blocks.php

// Check if Widget Blocks should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Disable Widget Blocks (use Classic Widgets)
add_filter( 'use_widgets_block_editor', '__return_false' );