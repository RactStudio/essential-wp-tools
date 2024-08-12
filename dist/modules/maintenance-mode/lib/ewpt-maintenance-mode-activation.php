<?php
// essential-wp-tools/modules/maintenance-mode/lib/ewpt-maintenance-mode-activation.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Execute once (first time) the main plugin (EWPT) activation (not this module activation)

update_option( 'maintenance_mode_logo_enable', 1 );
update_option( 'maintenance_mode_h1_text_enable', 1 );
update_option( 'maintenance_mode_paragraph_enable', 1 );

update_option( 'maintenance_mode_meta_title_enable', 1 );
update_option( 'maintenance_mode_meta_description_enable', 1 );