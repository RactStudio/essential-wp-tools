<?php
// essential-wp-tools/modules/maintenance-mode/ewpt-maintenance-mode-config.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

//Defined Variable Parameters
$EWPT_MODULE_NAME = "Maintenance Mode";
$EWPT_MODULE_DESC = "Maintenance Mode across your site, tailored to different user roles. Customize the maintenance page with our feature-rich customizer.";
$EWPT_MODULE_READY = "Production"; // eg: Production, Development
$EWPT_MODULE_VAR = "maintenance_mode";
$EWPT_MODULE_SLUG = "maintenance-mode";
$EWPT_MODULE_TAB_VAR = "MaintenanceMode";
$EWPT_MODULE_TAB_DEFAULT = "default-settings";
$EWPT_MODULE_VERSION = "1.0.0";
$EWPT_MODULE_URL = "https://ewpt.ractstudio.com/module/".$EWPT_MODULE_SLUG."/";
$EWPT_MODULE_AUTHOR = "RactStudio";
$EWPT_MODULE_AUTHOR_URL = "https://ractstudio.com/";
$EWPT_MODULE_DONATE = "https://www.patreon.com/RactStudio";

// Check module readiness
if ($EWPT_MODULE_READY == "Production") {
	$module_ready_class = "ewpt-info-green";
} elseif ($EWPT_MODULE_READY == "Development") {
	$module_ready_class = "ewpt-info-red";
} else {
	$module_ready_class = "ewpt-info-blue";
}