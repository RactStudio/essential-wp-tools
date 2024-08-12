<?php
// essential-wp-tools/modules/system-info/ewpt-system-info-actions.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

// Check if current page is the target page
if (isset($_GET['page']) && $_GET['page'] === 'ewpt-system-info') {
	
	// Enqueue EWPT Admin Assets
	ewpt::enqueue_ewpt_admin_assets();

}