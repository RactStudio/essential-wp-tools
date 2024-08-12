<?php
// essential-wp-tools/modules/ad-insert-hub/ewpt-ad-insert-hub-actions.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

// Check if current page is the target page
if (isset($_GET['page']) && $_GET['page'] === 'ewpt-ad-insert-hub') {
	
	// Enqueue EWPT Admin Assets
	ewpt::enqueue_ewpt_admin_assets();

}