<?php
// essential-wp-tools/modules/essential-tools/ewpt-essential-tools-config.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

//Defined Variable Parameters
$EWPT_MODULE_NAME = "Essential Tools";
$EWPT_MODULE_DESC = "Effortlessly switch between and customize a variety of features and technical components on your WordPress site.";
$EWPT_MODULE_READY = "Production"; // eg: Production, Development
$EWPT_MODULE_VAR = "essential_tools";
$EWPT_MODULE_SLUG = "essential-tools";
$EWPT_MODULE_TAB_VAR = "EssentialTools";
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