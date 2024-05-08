<?php
// essential-wp-tools/modules/social-share-hub/ewpt-social-share-hub-config.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

//Defined Variable Parameters
$EWPT_MODULE_NAME = "Social Share Hub";
$EWPT_MODULE_DESC = "Integrate social share hub (buttons) into posts, pages, and custom post types with customization options.";
$EWPT_MODULE_READY = "Production"; // eg: Production, Development
$EWPT_MODULE_VAR = "social_share_hub";
$EWPT_MODULE_SLUG = "social-share-hub";
$EWPT_MODULE_TAB_VAR = "SocialShareHub";
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
