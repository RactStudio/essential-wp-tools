<?php
// essential-wp-tools/inc/ewpt-modules-header.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<link rel="stylesheet" href="<?php echo esc_url(EWPT_PLUGIN_URL); ?>inc/ewpt-admin-style.css" media="all">

<div class="ewpt-header-bg">
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
</div>