<?php
// essential-wp-tools/admin/ewpt-hireus.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Menu of the Module
add_action(
	'admin_menu',
	function () {
		add_submenu_page(
			'essential-wp-tools',
			'Hire us',
			'Hire us',
			'manage_options',
			'ewpt-hireus',
			'ewpt_hireus_settings_page_rsmhr',
			998  // The position
		);
	}
);

// Callback function to render the settings page
if (!function_exists('ewpt_hireus_settings_page_rsmhr')) {
function ewpt_hireus_settings_page_rsmhr() {
	//Defined Variable Parameters
	$EWPT_MODULE_NAME = "Hire Us";
	$EWPT_MODULE_VAR = "hire_us";
	$EWPT_MODULE_SLUG = "hire-us";
	$EWPT_MODULE_TAB_VAR = "HireUs";
	$EWPT_MODULE_TAB_DEFAULT = "hireus-default";
	$EWPT_MODULE_READY = "Production";

?>
	
    <div class="wrap">
	
		<?php
		// Include the module header file
		include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-header.php';
		?>
	
		<div id="<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="tab-content">
			<div class="tab-pane">
				<h3>Our Services</h3>
			
				<div class="ewpt-row">
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="WordPress Development" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/wordpress-development/">
								WordPress Development
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="WHMCS Development" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/whmcs-development/">
								WHMCS Development
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="Bug Fix & Website Maintenance" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/bug-fix-website-maintenance/">
								Bug Fix & Site Maintenance
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="AI Articles with Images" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/ai-articles-with-images/">
								AI Articles with Images
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="Search Engine Optimization" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/search-engine-optimization/">
								Search Engine Optimization
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="Website Speed Optimization" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/website-speed-optimization/">
								Website Speed Optimization
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="Server Setup & Maintenance" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/server-setup-maintenance/">
								Server Setup & Maintenance
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="Web Software Setup & Maintenance" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/web-software-setup-maintenance/">
								Software Setup & Maintenance
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="IT Consultant Service" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/it-consultant-service/">
								IT Consultant Service
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="Web Data Mining (Scraping)" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/web-data-mining-scraping/">
								Web Data Mining (Scraping)
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="API Development & Implementation" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>service/api-development-implementation/">
								API Dev & Implementation
							</a>
						</div>
					</div>
					
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="Request A Quote" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>quote/">
								Request A Quote
							</a>
						</div>
					</div>
					
				</div>
				
				<h3 class="ewpt-no-top-border">Our Products</h3>
				<div class="ewpt-row">
				
					<div class="ewpt-column-3">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="King Hosting Cart" target="_blank" href="https://ractstudio.com/product/king-hosting-cart/">King Hosting Cart</a>
							<p>WHMCS Orderform Template</p>
						</div>
					</div>
					
					<div class="ewpt-column-3">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="Advanced Hosting Cart" target="_blank" href="https://ractstudio.com/product/advanced-hosting-cart/">Advanced Hosting Cart</a>
							<p>WHMCS Orderform Template</p>
						</div>
					</div>
					
					<div class="ewpt-column-3">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="Flip Hosting Cart" target="_blank" href="https://ractstudio.com/product/flip-hosting-cart/">Flip Hosting Cart</a>
							<p>WHMCS Orderform Template</p>
						</div>
					</div>
					
				</div>
				
				<h3 class="ewpt-no-top-border">Frequently Asked Questions</h3>
				<div class="ewpt-row ewpt-border-radius-bottom-5px">
				
					<div class="ewpt-column-2">
						<div class="ewpt-card">
							<h3 class="ewpt-module-name">Are these services affordable?</h3>
							<p>
								Yes, all our services are very affordable. As a small team, our cost of maintaining and providing services is lower than that of larger companies. 
								<a class="ewpt-button-link-text" title="Request A Quote" target="_blank" href="<?php echo esc_url(EWPT_SITE_URL); ?>quote/">Request A Quote</a> here.
							</p>
						</div>
					</div>
					
					<div class="ewpt-column-2">
						<div class="ewpt-card">
							<h3 class="ewpt-module-name">How can I pay for these services?</h3>
							<p>
								We offer limited payment options, including: 
								1. Direct Bank Transfer. 
								2. Payoneer.com. 
								3. Fiverr. 
								4. Binance.
							</p>
						</div>
					</div>
					
					<div class="ewpt-column-1">
						<div class="ewpt-card">
							<h3 class="ewpt-module-name">I have more questions, where I can find answers?</h3>
							<p>You can find answers to your questions by directly asking us. <a class="ewpt-button-link-text" target="_blank" title="Contact us" href="<?php echo esc_url(EWPT_SITE_URL); ?>contact/">Contact us here</a>, ractstudio@gmail.com, ractstudioteam@gmail.com with your question, and we'll get back to you within 2 business days at the latest.</p>
						</div>
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

} // if (!function_exists('ewpt_hireus_settings_page_rsmhr'))