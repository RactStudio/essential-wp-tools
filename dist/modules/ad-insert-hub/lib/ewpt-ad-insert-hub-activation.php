<?php
// essential-wp-tools/modules/ad-insert-hub/lib/ewpt-ad-insert-hub-activation.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Execute once (first time) the main plugin (EWPT) activation (not this module activation)

update_option( 'enable_ewpt_ads_custom_post_types', 1 );
update_option( 'ewpt_enable_all_ads_shortcodes', 1 );