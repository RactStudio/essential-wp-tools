<?php
// essential-wp-tools/modules/system-info/ewpt-system-info-config.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

//Defined Variable Parameters
$EWPT_MODULE_NAME = "System Info";
$EWPT_MODULE_DESC = "Access PHP Info, WordPress Info, Database Info, and Developer Info etc.";
$EWPT_MODULE_READY = "Production"; // eg: Production, Development
$EWPT_MODULE_VAR = "system_info";
$EWPT_MODULE_SLUG = "system-info";
$EWPT_MODULE_TAB_VAR = "SystemInfo";
$EWPT_MODULE_TAB_DEFAULT = "default-settings";
$EWPT_MODULE_VERSION = "1.0.0";
$EWPT_MODULE_URL = "https://github.com/RactStudio/".$EWPT_MODULE_SLUG."/";
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