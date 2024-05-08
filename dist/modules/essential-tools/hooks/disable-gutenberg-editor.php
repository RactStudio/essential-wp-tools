<?php
// disable-gutenberg-editor.php

// Check if Gutenberg should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Disable Gutenberg Editor
add_filter('use_block_editor_for_post', '__return_false', 10);