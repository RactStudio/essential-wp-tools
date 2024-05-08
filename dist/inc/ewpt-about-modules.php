<?php
// essential-wp-tools/inc/ewpt-about-modules.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div id="about-module" class="tab-content">
	<div class="tab-pane">
		<h3 class="ewpt-no-top-border">About <?php echo esc_attr($EWPT_MODULE_NAME); ?></h3>
		
		<table class="form-table ewpt-form ewpt-no-bottom-border">
			<tr valign="top">
				<th scope="row">Module:</th>
				<td>
					<div class='ewpt-info-blue'>
						<a class="ewpt-module-info" target="_blank" href="<?php echo esc_url($EWPT_MODULE_URL); ?>"><?php echo esc_attr($EWPT_MODULE_NAME); ?></a> v<?php echo esc_attr($EWPT_MODULE_VERSION); ?>
					</div>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"></th>
				<td>
					<div class='ewpt-info-blue'>
						<?php echo wp_kses_post($EWPT_MODULE_DESC); ?>
					</div>
				</td>
			</tr>
		
			<tr valign="top">
				<th scope="row">Status:</th>
				<td>
					<div class='<?php echo sanitize_html_class($module_ready_class); ?>'>
						<?php echo esc_attr($EWPT_MODULE_READY); ?>
					</div>
				</td>
			</tr>
		
			<tr valign="top">
				<th scope="row">Author:</th>
				<td>
					<div class='ewpt-info-blue'>
						<a class="ewpt-module-info" target="_blank" href="<?php echo esc_url($EWPT_MODULE_AUTHOR_URL); ?>"><?php echo esc_attr($EWPT_MODULE_AUTHOR); ?></a>
					</div>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Donate <?php echo esc_attr($EWPT_MODULE_NAME); ?>:</th>
				<td>
					<div class='ewpt-info-blue'>
						<?php echo esc_attr($EWPT_MODULE_DONATE); ?>
					</div>
				</td>
			</tr>
			
		</table>
		
		<h3>Donate <?php echo esc_attr(EWPT_FULL_NAME); ?></h3>
		
		<div class="ewpt-form ewpt-border-radius-bottom-5px">
			<div class="ewpt-info-blue ewpt-info-border ewpt-info-full ewpt-no-tab-target">
				We are offering the main plugin and its core features free of cost to everyone.
				<br/>
				Consider a one-time contribution or a monthly subscription, every bit helps.
				<br/><br/>
				
				<strong>Please consider supporting</strong> us by visiting the donation link below.
				<br/>
				Learn more on the <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-donate">Donation Page</a>
				<br/><br/>
				
				Best Regards,<br/>
				<strong><?php echo esc_attr(EWPT_DEV1_NAM); ?></strong> and <strong><?php echo esc_attr(EWPT_DEV2_NAM); ?></strong>
				<br/><br/>
				
				<a title="Become a patron" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL1); ?>"><img width="96px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/patreon-btn.png" /></a>
				<a title="Buy me a coffee" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL2); ?>"><img width="96px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/bmac-btn.png" /></a>
				<a title="Hire us" target="_self" href="<?php echo esc_url(EWPT_HIREUS_URL); ?>"><img width="96px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/hire-btn.png" /></a>
			</div>
		</div>
		
	</div>
</div>