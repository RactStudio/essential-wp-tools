<?php
// essential-wp-tools/admin/ewpt-donate.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Menu of the Module
add_action(
	'admin_menu',
	function () {
		add_submenu_page(
			'essential-wp-tools',
			'Donate',
			'Donate',
			'manage_options',
			'ewpt-donate',
			'ewpt_donate_settings_page_rsmhr',
			999  // The position
		);
	}
);

// Callback function to render the settings page
if (!function_exists('ewpt_donate_settings_page_rsmhr')) {
function ewpt_donate_settings_page_rsmhr() {
	//Defined Variable Parameters
	$EWPT_MODULE_NAME = "Donate Us";
	$EWPT_MODULE_VAR = "donate_us";
	$EWPT_MODULE_SLUG = "donate-us";
	$EWPT_MODULE_TAB_VAR = "DonateUs";
	$EWPT_MODULE_TAB_DEFAULT = "donate-default";
	$EWPT_MODULE_READY = "Production";

?>
	
    <div class="wrap">
	
		<?php
		// Include the module header file
		include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-header.php';
		?>

		<div id="<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="tab-content">
			<div class="tab-pane">
				<h3>Donation Information</h3>
				
				<div class="ewpt-form ewpt-border-radius-bottom-5px">
					<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">

						<p>
						Assalamu Alaikum, (“peace be upon you”)<br/>
						Warm greetings from <strong><?php echo esc_attr(EWPT_DEV1_NAM); ?></strong> and <strong><?php echo esc_attr(EWPT_DEV2_NAM); ?></strong>.
						</p>

						<p>
						We are a dedicated team of developers, on a mission to enhance the WordPress experience. Our project, the "<strong>Essential WP Tools</strong>" plugin, is aimed at addressing the inherent limitations of WordPress by providing a comprehensive solution. We envision a WordPress environment where every feature is easily manageable through our plugin's options panel, exemplified by the "<strong>Essential Tools</strong>" module.
						</p>

						<p>
						"<strong>Essential WP Tools</strong>" stands out as a unique plugin, ensuring user-friendly customization of WordPress features. We are committed to offering a secure and high-performance solution, encompassing functionalities that are often scattered across various small to large plugins.
						</p>

						<p>
						Our future plans include creating a developer guide and a module repository, enabling developers worldwide to contribute and enhance the plugin's capabilities.
						</p>

						<p>
						Our vision is for every WordPress user to install "<strong>Essential WP Tools</strong>" right after WordPress setup, eliminating the need for multiple plugins. Users can tailor their website precisely to their requirements, thanks to our plugin's straightforward approach.
						</p>

						<p>
						<strong>However</strong>, embarking on such an ambitious project comes with its challenges. As a small team, we've invested significant resources, with the intention of making the main plugin and its core features entirely free and open source.
						</p>

						<p>
						To make this vision a reality, we kindly request your support. Your donation will contribute to the sustainability and growth of this project. We are planning to offer the main plugin and its core features for free to everyone, ensuring that it remains open source.
						</p>

						<p>
						<strong>Your donation</strong>, whether a one-time contribution or a monthly subscription on Patreon, will play a crucial role in ensuring the success of this project. We understand that resources are limited, but <strong>every bit helps</strong>.
						</p>

						<p>
						<strong>Please consider supporting</strong> us by visiting the donation link on <a class="ewpt-button-link-text ewpt-enlarge-1x" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL1); ?>">Patreon</a> or <a class="ewpt-button-link-text ewpt-enlarge-1x" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL2); ?>">Buy Me a Coffee</a>. Your generosity will make a significant impact, allowing us to continue improving and evolving the "<strong>Essential WP Tools</strong>" plugin.
						</p>

						<p>
						Thank you for considering and being a part of this journey.
						</p>

						<p>
						Best Regards,<br/>
						<strong><?php echo esc_attr(EWPT_DEV1_NAM); ?></strong> and <strong><?php echo esc_attr(EWPT_DEV2_NAM); ?></strong>
						</p>

						<p class=" ewpt-no-tab-target">
							<a title="Become a patron" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL1); ?>"><img width="110px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/patreon-btn.png" /></a>
							<a title="Buy me a coffee" target="_blank" href="<?php echo esc_url(EWPT_DONATE_URL2); ?>"><img width="110px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/bmac-btn.png" /></a>
							<a title="Hire us" target="_self" href="<?php echo esc_url(EWPT_HIREUS_URL); ?>"><img width="110px" src="<?php echo esc_url(EWPT_PLUGIN_URL); ?>admin/assets/img/hire-btn.png" /></a>
						</p>
						
					</div>
				</div>
				
			</div>
		</div>
		
    </div>
	
	<?php
	// Include the module footer file
	include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php';
	?>
	
    <?php
}

} // if (!function_exists('ewpt_donate_settings_page_rsmhr'))