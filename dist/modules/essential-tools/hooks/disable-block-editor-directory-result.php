<?php
// disable-block-editor-directory-result.php

// Check if WordPress Block Editor Directory Result should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Prevent block directory results from being shown when searching for blocks in the editor.
remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');