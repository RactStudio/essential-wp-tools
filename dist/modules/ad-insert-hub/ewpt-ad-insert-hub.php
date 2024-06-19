<?php
// essential-wp-tools/modules/ad-insert-hub/ewpt-ad-insert-hub.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

// Register settings
add_action( 'init', function () {
	ewpt::register_setting_data('ewpt_ad_insert_hub_settings', 'ewpt_disable_all_ad_insert_hub_options', 'boolean');
	ewpt::register_setting_data('ewpt_ad_insert_hub_settings', 'ewpt_ad_insert_hub_menu_link', 'string');
	
	ewpt::register_setting_data('ewpt_ad_insert_hub_settings', 'enable_total_ads_counter', 'integer');
	ewpt::register_setting_data('ewpt_ad_insert_hub_settings', 'enable_ewpt_ads_custom_post_types', 'boolean');
	ewpt::register_setting_data('ewpt_ad_insert_hub_settings', 'ewpt_ads_custom_post_types_lists', 'string');
	ewpt::register_setting_data('ewpt_ad_insert_hub_settings', 'ewpt_enable_all_ads_shortcodes', 'boolean');
	
	// Main Ads Options / Settings Loop :-)
	// Get the minimum and maximum number to save from user input
	$total_ads_slots = intval(get_option('enable_total_ads_counter', 10));
	// Ensure between 10 and 40
	if ($total_ads_slots < 1) {
		$total_ads_slots = 1;
	} elseif ($total_ads_slots > 40) {
		$total_ads_slots = 40;
	}
	for ($i = 1; $i <= $total_ads_slots; $i++) {
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "enable_ads_{$i}_code", 'boolean');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_title", 'string');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_css_style", 'boolean');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_user_content", 'html_raw'); // Escaping and validating would break users ad code. 'html_raw'
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_place_singlepost", 'boolean');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_place_singlepage", 'boolean');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_place_homepage", 'boolean');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_place_categories", 'boolean');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_place_tag", 'boolean');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_place_archive", 'boolean');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_place_search", 'boolean');
		
		// Custom Post Types Conditions with options Register
		if ( (get_option('enable_ewpt_ads_custom_post_types', 0) == 1) && ! empty(get_option('ewpt_ads_custom_post_types_lists', ''))) { 
			$ewpt_post_types = explode (",", get_option('ewpt_ads_custom_post_types_lists', ''));
			foreach ($ewpt_post_types as $post_type) {
				ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_place_{$post_type}", 'boolean');
			}
		}
		
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_insert_hook", 'string');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_placement_position", 'string');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_p_user_number", 'integer');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_words_user_number", 'integer');
		ewpt::register_setting_data('ewpt_ad_insert_hub_settings', "ads_{$i}_shortcode", 'boolean');
	}
	
});

// Menu of the Module
add_action( 'admin_menu', function () {
	// Get the option for menu visibility
	$menu_visibility_option = get_option('ewpt_ad_insert_hub_menu_link', 'sub_menu');
	// Module menu name parameters
	$module_name = 'Ad Insert Hub'; // Define the module name/title here
	ewpt::assign_modules_menu_link($menu_visibility_option, $module_name);
});

// Callback function to render the Ad Insert Hub settings page
if (!function_exists('ewpt_ad_insert_hub_settings_page')) {
function ewpt_ad_insert_hub_settings_page() {
	// Include the module config file
	include(plugin_dir_path(__FILE__) . 'ewpt-ad-insert-hub-config.php');
	 
	// Get the minimum and maximum number to save from user input
	// Total Ads slot by User defined - OR, default to 10 
	$ewpt_ads_i = intval(get_option('enable_total_ads_counter', 10));
	// Ensure between 10 and 40
	if ($ewpt_ads_i < 1) {
		$ewpt_ads_i = 1;
	} elseif ($ewpt_ads_i > 40) {
		$ewpt_ads_i = 40;
	}
	
	// Array of custom post types
	$ewpt_post_types = get_post_types( array(
		'public'   => true,
		'_builtin' => false,
	), 'names' );
	
	// Sanitize and convert array to comma-separated string
	$ewpt_post_types_lists = ewpt::sanitize_post_types_lists( $ewpt_post_types );
	
	// Get the current stored post types list
	$current_post_types_lists = get_option( 'ewpt_ads_custom_post_types_lists', '' );
	
	// Update option if new data is available
	if ( $current_post_types_lists !== $ewpt_post_types_lists ) {
		update_option( 'ewpt_ads_custom_post_types_lists', $ewpt_post_types_lists );
	}
	
?>

	<div id="ewpt-page-header" class="ewpt-page-header">
	
		<?php
		// Include the module header file
		include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-header.php';
		?>
		
	</div>
	
	<div id="ewpt-page-main" class="wrap ewpt-page-main">

		<div id="ewpt-page-body" class="ewpt-page-body">
			
			<h1>
			
				<!-- Show Mask -->
				<div id="ewpt-mask"></div>
				
				<?php
				// Include the module header file
				include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-header-sub.php';
				?>
				
			</h1>
	
			<!-- Tab -->
			<h2 class="nav-tab-wrapper">
				<a href="#<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="nav-tab">Settings</a>
				
				<?php for ($i = 1; $i <= $ewpt_ads_i; $i++) : ?>
					<a href="#ewpt-ads-<?php echo intval($i); ?>" class="nav-tab<?php if (get_option("enable_ads_{$i}_code", 0) == 1) { echo " ewpt-active-btn"; } ?>"><?php echo intval($i); ?></a>
				<?php endfor; ?>
				
				<a href="#about-module" class="nav-tab">About</a>
				<div class="nav-tab ewpt-save-button"><p class="submit"><input form="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p></div>
			</h2>
			
			<form id="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" name="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" method="post" action="options.php">
			
				<?php wp_nonce_field( esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce'), esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce') ); ?>
				<?php //settings_errors(); ?>
				<?php settings_fields(esc_attr(strtolower(EWPT_SHORT_SLUG.'_'.$EWPT_MODULE_VAR.'_settings'))); ?>
				<?php //do_settings_sections(esc_attr(strtolower(EWPT_SHORT_SLUG.'_'.$EWPT_MODULE_VAR.'_settings'))); ?>
				<?php //do_settings_sections(esc_attr(strtolower(EWPT_SHORT_SLUG.'-'.$EWPT_MODULE_SLUG))); ?>
				
				<div id="<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="tab-content">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border"><?php echo esc_attr($EWPT_MODULE_NAME); ?> Settings</h3>
						
						<table class="form-table ewpt-form ewpt-form-border-bottom">
							<tr valign="top">
								<th scope="row">All Options</th>
								<td>
									<label>
										<input type="checkbox" name="ewpt_disable_all_ad_insert_hub_options" value="1" <?php checked(get_option('ewpt_disable_all_ad_insert_hub_options', 0)); ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-red'>
										Disable all options action and won't load hooks files, unchecked means all actions are active.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Menu Link</th>
								<td>
										<select name="ewpt_ad_insert_hub_menu_link">
											<option value="sub_menu" <?php selected(get_option("ewpt_ad_insert_hub_menu_link"), 'sub_menu'); ?>>Sub Menu</option>
											<option value="main_menu" <?php selected(get_option("ewpt_ad_insert_hub_menu_link"), 'main_menu'); ?>>Main Menu</option>
											<option value="hidden_menu" <?php selected(get_option("ewpt_ad_insert_hub_menu_link"), 'hidden_menu'); ?>>Hide Menu</option>
										</select>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										'Sub Menu': Add this module settings page link inside 'EWPT Dashboard' menu.<br/>
										'Main Menu': Add this module settings page link as main menu link (standalone).<br/>
										'Hide menu': Hide this settings page link. Link only available on 'EWPT Dashboard' page.
									</div>
								</td>
							</tr>
						</table>
						
						<table class="form-table ewpt-form ewpt-no-bottom-border">
							<tr valign="top">
								<th scope="row">Total Ads Slots</th>
								<?php
									// Get the minimum and maximum number to save from user input
									$total_ads_counter = intval(get_option('enable_total_ads_counter', 10));
									// Ensure between 10 and 40
									if ($total_ads_counter < 1) {
										$total_ads_counter = 1;
									} elseif ($total_ads_counter > 40) {
										$total_ads_counter = 40;
									}
								?>
								<td>
									<input type="number" name="enable_total_ads_counter" value="<?php echo intval($total_ads_counter); ?>" />
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Decreasing the ad slot's does not clear saved data.<br/>
										<strong>Note: Default: 10, Minimum: 1, and Maximum: 40.</strong>
									</div>
								</td>
							</tr>
						
							<tr valign="top">
								<th scope="row">Enable custom post types</th>
								<td>
									<label>
										<input type="checkbox" name="enable_ewpt_ads_custom_post_types" value="1" <?php checked(get_option('enable_ewpt_ads_custom_post_types', 1)); ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Deactivating will clear the checked status of all custom post types.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">All Ads Shortcodes</th>
								<td>
									<label>
										<input type="checkbox" name="ewpt_enable_all_ads_shortcodes" value="1" <?php checked(get_option('ewpt_enable_all_ads_shortcodes', 1)); ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Generate shortcodes for all ad slots, but require separate shortcode activation for each slot.<br/>
										To display all ads at once, use [ewpt_ad_insert_hub], or use [ewpt_ad_insert_hub slot=0].
									</div>
								</td>
							</tr>
							
						</table>
						
						<h3>Essential Tools</h3>
						<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
							
							<tr valign="top">
								<th scope="row">Are you facing EXCERPT issue?</th>
								<td>
									<div class='ewpt-info-blue'>
										Enable <a class="ewpt-button-link-text" title="Auto Excerpt" target="_blank" href="<?php echo esc_url(EWPT_DASH_SHORT_URL); ?>-essential-tools#auto-excerpt">Auto Excerpt</a> in Essential Tools. "<strong>Essential Tools</strong>" (module) must be enabled in <a class="ewpt-button-link-text" title="Modules Manager" target="_blank" href="<?php echo esc_url(EWPT_DASH_URL); ?>#modules-manager">Modules Manager</a><br/>
										This will make sure that all single posts, pages, and custom post types have their own excerpt from the main the_content()
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
						<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
					</div>
					
				</div>
				
				<?php for ($i = 1; $i <= $ewpt_ads_i; $i++) : ?>
					<div id="ewpt-ads-<?php echo intval($i); ?>" class="tab-content">
						<div class="tab-pane">
							<h3 class="ewpt-no-top-border<?php if (get_option("enable_ads_{$i}_code", 0) == 1) { echo " ewpt-active-h3"; } ?>">Ad Slot: <?php echo intval($i); ?></h3>
							
							<table class="form-table ewpt-form ewpt-no-bottom-border">
								<tr valign="top">
									<th scope="row">Title</th>
									<td>
										<input type="text" class="size-6x" name="ads_<?php echo intval($i); ?>_title" value="<?php echo esc_attr(get_option("ads_{$i}_title", "Ad Slot - {$i}")); ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">Status</th>
									<td>
										<label>
											<input type="checkbox" name="enable_ads_<?php echo intval($i); ?>_code" value="1" <?php checked(get_option("enable_ads_{$i}_code", 0)); ?> />
											Enable
										</label>
									</td>
								</tr>
							</table>

							<h3>Ad Code</h3>
							<table class="form-table ewpt-form ewpt-no-bottom-border">
								<tr valign="top">
									<td>
										<?php
										$ads_user_content = get_option("ads_{$i}_user_content");
										if (!empty($ads_user_content)) :
											?>
											<textarea name="ads_<?php echo intval($i); ?>_user_content" class="ewpt-code-field" rows="12" cols="80"><?php echo esc_html($ads_user_content); ?></textarea>
										<?php else : ?>
											<textarea name="ads_<?php echo intval($i); ?>_user_content" class="ewpt-code-field" rows="12" cols="80"></textarea>
										<?php endif; ?>
									</td>
									<td>
										<div class='ewpt-info-blue'>
											Please ensure valid HTML code.
										</div>
										<br/>
										<div class="ewpt-info-green">
											All <strong>HTML</strong> Tags and Attributes are supported.
										</div>
										<br/>
										<div class="ewpt-info-red">
											Bad <strong>HTML</strong> Tags and Attributes would break the page.
										</div>
									</td>
								</tr>
							</table>
							
							<table class="form-table ewpt-form ewpt-no-bottom-border">
								<tr valign="top">
									<th scope="row">Enable CSS Style</th>
									<td>
										<label>
											<input type="checkbox" name="ads_<?php echo intval($i); ?>_css_style" value="1" <?php checked(get_option("ads_{$i}_css_style", 1)); ?> />
											Enable 
										</label>
									</td>
									<td>
										<div class='ewpt-info-blue'>
											Predefined css style to make sure the ads code placement is perfect.
										</div>
									</td>
								</tr>
							</table>

							<h3>Placement</h3>
							<table class="form-table ewpt-form ewpt-no-bottom-border">
								<tr valign="top">
									<th scope="row">
										<h4>General Places</h4>
									</th>
									<td>
										<label>
											<input type="checkbox" name="ads_<?php echo intval($i); ?>_place_singlepost" value="1" <?php checked(get_option("ads_{$i}_place_singlepost", 1)); ?> />
											Posts
										</label>
									</td>
									<td>
										<label>
											<input type="checkbox" name="ads_<?php echo intval($i); ?>_place_singlepage" value="1" <?php checked(get_option("ads_{$i}_place_singlepage", 1)); ?> />
											Pages
										</label>
									</td>
								</tr>
								<?php if ( !empty($ewpt_post_types) && (get_option('enable_ewpt_ads_custom_post_types', 0) == 1)) {  ?>
									<tr valign="top">
										<th scope="row">
											<h4>Custom Post Types</h4>
										</th>
									<?php foreach ($ewpt_post_types  as $post_type) { ?>
											<td>
												<label>
													<input type="checkbox" name="ads_<?php echo intval($i); ?>_place_<?php echo sanitize_html_class($post_type); ?>" value="1" <?php checked(get_option("ads_{$i}_place_{$post_type}", 0)); ?> />
													<?php echo sanitize_html_class($post_type); ?>
												</label>
											</td>
									<?php } ?>
									</tr>
								<?php } ?>
							</table>
							
							<div class="ewpt-form">
								<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
									<strong>More coming soon:</strong> in the meantime use shortcode to place ads anywhere you want.<br/>
								</div>
							</div>
								
							<h3>Insert (Hook/HTML)</h3>
							<table class="form-table ewpt-form ewpt-no-bottom-border">
							
								<tr valign="top">
									<th scope="row">Placement Hooks</th>
									<td>
										<select name="ads_<?php echo intval($i); ?>_insert_hook">
											<option value="the_content" <?php selected(get_option("ads_{$i}_insert_hook"), 'the_content'); ?>>Posts / Pages / CPT - The Content</option>
											<option value="disable" <?php selected(get_option("ads_{$i}_insert_hook"), 'disable'); ?>>Disable</option>
										</select>
									</td>
									<td>
										<div class='ewpt-info-blue'>
											<strong>The Content:</strong> only works in the single page, single posts and custom post types content.<br/>
											<strong>Disable:</strong> Disable this ads insert slot placement everywhere. Except, if you enabled the shortcode.<br/>
											<strong>More coming soon:</strong> in the meantime use shortcode to place ads anywhere you want.
										</div>
									</td>
								</tr>
								
							</table>
							
							<h3>Position</h3>
							<table class="form-table ewpt-form <?php if (get_option("ewpt_enable_all_ads_shortcodes", 0) == 1) { echo "ewpt-no-bottom-border"; } else { echo "ewpt-border-radius-bottom-5px"; } ?>">
								
								<tr valign="top">
									<th scope="row">Ad Position</th>
									<td>
										<label>
											<select name="ads_<?php echo intval($i); ?>_placement_position">
												<option value="above_below_position" <?php selected(get_option("ads_{$i}_placement_position"), 'above_below_position'); ?>>Above & Below Content</option>
												<option value="above_position" <?php selected(get_option("ads_{$i}_placement_position"), 'above_position'); ?>>Above Content</option>
												<option value="below_position" <?php selected(get_option("ads_{$i}_placement_position"), 'below_position'); ?>>Below Content</option>
												<option value="after_p_tag" <?php selected(get_option("ads_{$i}_placement_position"), 'after_p_tag'); ?>>After P Tag</option>
												<option value="after_words_count" <?php selected(get_option("ads_{$i}_placement_position"), 'after_words_count'); ?>>After Words Count</option>
											</select>
										</label>
									</td>
								</tr>
							
								<tr valign="top" id="ads_<?php echo intval($i); ?>_pUserNumber">
									<th scope="row">Below - HTML "P" Tags</th>
									<td> 
										<label>
											<input type="number" name="ads_<?php echo intval($i); ?>_p_user_number" value="<?php echo esc_attr(get_option("ads_{$i}_p_user_number", '')); ?>" />
										</label>
									</td>
								</tr>
								
								<tr valign="top" id="ads_<?php echo intval($i); ?>_wordsUserNumber">
									<th scope="row">Below - Words Count</th>
									<td>
										<label>
											<input type="number" name="ads_<?php echo intval($i); ?>_words_user_number" value="<?php echo esc_attr(get_option("ads_{$i}_words_user_number", '')); ?>" />
										</label>
									</td>
								</tr>
								
							</table>
							
							<?php if (get_option("ewpt_enable_all_ads_shortcodes", 0) == 1) { ?>
							<h3>Ad Shortcode</h3>
							<table class="form-table ewpt-form ewpt-border-radius-bottom-5px">
								
								<tr valign="top">
									<th scope="row">Enable Shortcode</th>
									<td>
										<label>
											<input type="checkbox" name="ads_<?php echo intval($i); ?>_shortcode" value="1" <?php checked(get_option("ads_{$i}_shortcode", 1)); ?> />
											Enable 
										</label>
									</td>
									<td>
										<div class='ewpt-info-blue'>
											To use only the shortcode for this ad, select "Disable" in "Insert (Hook)".
										</div>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">The Shortcode</th>
									<td>
										<div class='ewpt-info-blue'>
											<?php echo esc_attr("[ewpt_ad_insert_hub slot={$i}]"); ?>
										</div>
										<br/>
										<div class='ewpt-info-blue'>
											<?php
												$phpShort1 = "<?php echo do_shortcode( '";
												$phpShort2 = "[ewpt_ad_insert_hub slot={$i}]";
												$phpShort3 = "' ); ?>";
												echo  esc_attr($phpShort1.$phpShort2.$phpShort3);
											?>
										</div>
									</td>
								</tr>
								
							</table>
							<?php } ?>
							
						</div>
						
						<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
							<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
						</div>
						
					</div>
					
				<?php endfor; ?>
					
				<?php
				// Include the module about file
				include(EWPT_PLUGIN_PATH . 'inc/ewpt-about-modules.php');
				?>
				
				<?php //submit_button('Save Changes'); ?>
					
			</form>
				
		</div>
		
		<div id="ewpt-page-footer" class="ewpt-page-footer">
			
			<?php
			// Include the module footer file
			include(EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php');
			?>
			
			<script>
				jQuery(document).ready(function ($) {
					// Function to show/hide P Tag and Words Count based on Placement Type and Insert Hook
					function toggleOptions(adSlot) {
						var insertHook = $('select[name="ads_' + adSlot + '_insert_hook"]').val();
						var placementType = $('select[name="ads_' + adSlot + '_placement_position"]').val();

						// Show/hide P Tag and Words Count based on Insert Hook and Placement Type
						if (insertHook === 'the_content') {
							$('#ads_' + adSlot + '_p_tag_placement, #ads_' + adSlot + '_words_placement').show();

							if (placementType === 'after_p_tag') {
								$('#ads_' + adSlot + '_wordsUserNumber').hide();
								$('#ads_' + adSlot + '_pUserNumber').show();
							} else if (placementType === 'after_words_count') {
								$('#ads_' + adSlot + '_pUserNumber').hide();
								$('#ads_' + adSlot + '_wordsUserNumber').show();
							} else {
								// Hide both P Tag and Words Count for other Placement Types
								$('#ads_' + adSlot + '_pUserNumber, #ads_' + adSlot + '_wordsUserNumber').hide();
							}
						} else {
							// Hide both P Tag and Words Count for other Insert Hooks
							$('#ads_' + adSlot + '_pUserNumber, #ads_' + adSlot + '_wordsUserNumber, #ads_' + adSlot + '_p_tag_placement, #ads_' + adSlot + '_words_placement').hide();
						}
					}

					// Initial call to set the visibility based on the default Insert Hook and Placement Type
					// An array or list of ad slots, loop through them
					<?php for ($i = 1; $i <= $ewpt_ads_i; $i++) : ?>
						toggleOptions(<?php echo intval($i); ?>);

						// Event handler for Insert Hook and Placement Type change
						$('select[name="ads_<?php echo intval($i); ?>_insert_hook"], select[name="ads_<?php echo intval($i); ?>_placement_position"]').change(function () {
							toggleOptions(<?php echo intval($i); ?>);
						});
					<?php endfor; ?>
					
				});
			</script>
						
		</div>
		
	</div>


	<?php
}

	// Include the actions (mostly ajax call)
	include plugin_dir_path(__FILE__) . 'ewpt-ad-insert-hub-actions.php';

} // if (!function_exists('ewpt_ad_insert_hub_settings_page'))