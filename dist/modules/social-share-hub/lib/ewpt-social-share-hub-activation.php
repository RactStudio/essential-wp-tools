<?php
// essential-wp-tools/modules/social-share-hub/lib/ewpt-social-share-hub-activation.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Execute once (first time) the main plugin (EWPT) activation (not this module activation)

update_option( 'enable_ewpt_share_buttons_custom_post_types', 1 );
update_option( 'ewpt_enable_all_social_share_hub_shortcodes', 1 );