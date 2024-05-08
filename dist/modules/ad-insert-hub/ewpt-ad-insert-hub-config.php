<?php
// essential-wp-tools/modules/ad-insert-hub/ewpt-ad-insert-hub-config.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

//Defined Variable Parameters
$EWPT_MODULE_NAME = "Ad Insert Hub";
$EWPT_MODULE_DESC = "Manage ad placement on your website with our comprehensive module, compatible with Google Ads and other leading providers.";
$EWPT_MODULE_READY = "Production"; // eg: Production, Development
$EWPT_MODULE_VAR = "ad_insert_hub";
$EWPT_MODULE_SLUG = "ad-insert-hub";
$EWPT_MODULE_TAB_VAR = "AdInsertHub";
$EWPT_MODULE_TAB_DEFAULT = "default-settings";
$EWPT_MODULE_VERSION = "1.0.0";
$EWPT_MODULE_URL = "https://ewpt.ractstudio.com/module/".$EWPT_MODULE_SLUG."/";
$EWPT_MODULE_AUTHOR = "Mahamudul Hasan Rubel";
$EWPT_MODULE_AUTHOR_URL = "https://mhr.ractstudio.com/";
$EWPT_MODULE_DONATE = "https://www.patreon.com/RactStudio";

// Check module readiness
if ($EWPT_MODULE_READY == "Production") {
	$module_ready_class = "ewpt-info-green";
} elseif ($EWPT_MODULE_READY == "Development") {
	$module_ready_class = "ewpt-info-red";
} else {
	$module_ready_class = "ewpt-info-blue";
}