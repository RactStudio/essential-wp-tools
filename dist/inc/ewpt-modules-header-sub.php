<?php
// essential-wp-tools/inc/ewpt-modules-header-sub.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<?php settings_errors(); ?>

<?php if (esc_attr(ucwords($EWPT_MODULE_READY)) === "Development") {
	// Module Under Development message
?>
	<div class="notice ewpt-info-red is-dismissible">This module is in development, and its features may change, potentially resulting in data loss.</div>
<?php } ?>

<?php
	// All options disable message
	$module_options_status = 'ewpt_disable_all_'.sanitize_html_class(strtolower($EWPT_MODULE_VAR).'_options');
	if (get_option(esc_attr($module_options_status)) == 1) {
?>
	<div class="notice ewpt-info-red is-dismissible">The "<?php echo esc_attr($EWPT_MODULE_NAME); ?>'s" all options is currently disabled!</div>
<?php } ?>