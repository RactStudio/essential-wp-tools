<?php
// essential-wp-tools/inc/ewpt-modules-header.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<link rel="stylesheet" href="<?php echo esc_url(EWPT_PLUGIN_URL); ?>inc/ewpt-admin-style.css" media="all">

<h1 class="ewpt-header-bg">
	<div class="ewpt-row ewpt-header">
		<div class="ewpt-column-2 ewpt-brand">
			<p class="ewpt-title">
				<a href="<?php echo esc_url(EWPT_DASH_URL); ?>"><?php echo esc_attr(EWPT_SHORT_NAME); ?></a>
				 / 
				<a href=""><?php echo esc_attr($EWPT_MODULE_NAME); ?></a>
			</p>
			<p class="ewpt-dev">
				Powered by - <a title="<?php echo esc_attr(EWPT_DEV1_NAM); ?>" target="_blank" href="<?php echo esc_url(EWPT_DEV1_URL); ?>"><?php echo esc_attr(EWPT_DEV1_NAM); ?></a> & <a title="<?php echo esc_attr(EWPT_DEV2_NAM); ?>" target="_blank" href="<?php echo esc_url(EWPT_DEV2_URL); ?>"><?php echo esc_attr(EWPT_DEV2_SHORT); ?></a>
			</p>
		</div>
		<div class="ewpt-column-2 ewpt-donate">
			<a title="Become a patron" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL1); ?>"><img src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/patreon-btn.png" /></a>
			<a title="Buy me a coffee" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL2); ?>"><img src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/bmac-btn.png" /></a>
			<a title="Hire us" target="_self" href="<?php echo esc_url(EWPT_HIREUS_URL); ?>"><img src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/hire-btn.png" /></a>
		</div>
	</div>
</h1>

<?php
/**
    // Verify nonce
	if ( isset( $_POST[sanitize_html_class(strtolower($EWPT_MODULE_VAR).'_nonce')] ) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST[sanitize_html_class(strtolower($EWPT_MODULE_VAR).'_nonce')] ) ) , sanitize_html_class(strtolower($EWPT_MODULE_VAR).'_nonce') ) ) {
		// Save changes message
		if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
			echo '<div class="notice notice-success settings-error is-dismissible"><p>'.sanitize_html_class(EWPT_SHORT_NAME).' settings saved successfully!</p></div>';
		}
	}
**/
?>

<?php settings_errors(); ?>

<?php if (sanitize_html_class(ucwords($EWPT_MODULE_READY)) === "Development") {
	// Module Under Development message
?>
	<div class="notice ewpt-info-red is-dismissible">This module is in development, and its features may change, potentially resulting in data loss.</div>
<?php } ?>

<?php
// All options disable options name
$module_options_status = 'ewpt_disable_all_'.sanitize_html_class(strtolower($EWPT_MODULE_VAR).'_options');
if (get_option(sanitize_html_class($module_options_status)) == 1) {
?>
	<div class="notice ewpt-info-red is-dismissible">The "<?php echo esc_attr($EWPT_MODULE_NAME); ?>'s" all options is currently disabled!</div>
<?php } ?>