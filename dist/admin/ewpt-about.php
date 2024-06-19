<?php
// essential-wp-tools/admin/ewpt-about.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Menu of the Module
add_action( 'admin_menu', function () {
	add_submenu_page(
		'essential-wp-tools',
		'About',
		'About',
		'manage_options',
		'ewpt-about',
		'ewpt_about_settings_page',
		998  // The position
	);
});

// Callback function to render the settings page
if (!function_exists('ewpt_about_settings_page')) {
function ewpt_about_settings_page() {
	//Defined Variable Parameters
	$EWPT_MODULE_NAME = "About";
	$EWPT_MODULE_VAR = "about";
	$EWPT_MODULE_SLUG = "about";
	$EWPT_MODULE_TAB_VAR = "About";
	$EWPT_MODULE_TAB_DEFAULT = "about-guide";
	$EWPT_MODULE_READY = "Production";

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
				<a href="#<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="nav-tab">User Guide</a>
				<a href="#roadmap" class="nav-tab">Road Map</a>
				<a href="#services" class="nav-tab">Services</a>
				<a href="#donate" class="nav-tab">Donate</a>
			</h2>
			
			<div id="<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">User Guide</h3>
					
					<div class="ewpt-form ewpt-border-radius-bottom-5px">
						<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
						
							<p>Welcome to <?php echo esc_attr(EWPT_FULL_NAME); ?>, your all-in-one solution for enhancing and managing your WordPress site! This plugin comes packed with essential modules to improve your site's functionality. Here's a quick guide to help you get started:</p>
							
							<p><strong>Getting Started:</strong></p>
							Find the <?php echo esc_attr(EWPT_FULL_NAME); ?> menu "<strong><?php echo esc_attr(EWPT_SHORT_NAME); ?> Dashboard</strong>" in your WordPress admin sidebar.
							<br/>
							
							<p><strong>Enable/Disable Modules:</strong></p>
							Inside the <?php echo esc_attr(EWPT_FULL_NAME); ?> menu "<strong><?php echo esc_attr(EWPT_SHORT_NAME); ?> Dashboard</strong>", you'll find a list of modules already activated when you installed the plugin. Customize module activation by navigating to the "<strong>Installed Modules</strong>" tab.
							<br/><br/>
							Enable or disable specific modules according to your needs. Modified modules will be seamlessly integrated into the "<strong><?php echo esc_attr(EWPT_SHORT_NAME); ?> Dashboard</strong>" submenu in your WordPress menu bar.
							<br/>
							
							<p><strong>Customizing Modules:</strong></p>
							Each module has its own settings. Click on the module name in your WordPress menu bar to access its settings page. Customize the settings based on your preferences.
							<br/>
							
							<p><strong>Adding Modules to Admin Menu:</strong></p>
							Want quick access to specific modules? Integrate them into the main admin menu. Visit the specific module settings page and look for an option like "<strong>Add to main menu</strong>" Enable the checkbox and save changes for the effect.
							<br/>
							
							<p><strong>User-Friendly Design:</strong></p>
							<?php echo esc_attr(EWPT_FULL_NAME); ?> is designed with simplicity in mind. Easily navigate through modules and settings with a user-friendly interface.
							<br/>
							
							<p><strong>Save Changes:</strong></p>
							Don't forget to "<strong>Save Changes</strong>" after adjusting module settings.
							<br/>
							
							<p><strong>Enjoy <?php echo esc_attr(EWPT_FULL_NAME); ?>!</strong></p>
							Explore the various modules to enhance your WordPress experience. If you have any questions or need assistance, refer to the specefic module "<strong>About</strong>" tab, our <a class="ewpt-button-link-text ewpt-enlarge-1x" target="_blank" href="<?php echo esc_url(EWPT_DOCS_URL); ?>"><?php echo esc_attr(EWPT_SHORT_NAME); ?> Documentation</a>.
							<br/>
							
							<p><strong>Happy WordPressing!</strong></p>
							
						</div>
					</div>
					
				</div>
			</div>
						
			<div id="roadmap" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">What's Next?</h3>
					
					<div class="ewpt-form ewpt-border-radius-bottom-5px">
						<div class="ewpt-info-blue ewpt-info-border ewpt-info-full">
						
						<p>"<strong><?php echo esc_attr(EWPT_FULL_NAME); ?></strong>" stands out as a unique plugin, ensuring user-friendly customization of WordPress features. We are committed to offering a secure and high-performance solution, encompassing functionalities that are often scattered across various small to large plugins.</p>
						
						<p>We envision a WordPress environment where every feature is easily manageable through our plugin's options panel, exemplified by the "<strong>Essential Tools</strong>" module.</p>
						
						<p>Our future plans include creating a developer guide and a module repository / marketplace, enabling developers worldwide to contribute and enhance the plugin's capabilities.</p>
						
						<p>Our vision is for every WordPress user to install "<strong><?php echo esc_attr(EWPT_FULL_NAME); ?></strong>" right after WordPress setup, eliminating the need for multiple plugins. Users can tailor their website precisely to their requirements, thanks to our plugin's straightforward approach.</p>
						
						<p>Thank you for considering and being a part of this journey.</p>
						
						<p>
							Best Regards,<br/>
							<strong><?php echo esc_attr(EWPT_DEV1_NAM); ?></strong> and <strong><?php echo esc_attr(EWPT_DEV2_NAM); ?></strong>
						</p>
						
						</div>
					</div>
					
				</div>
			</div>
			
			<div id="services" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">Our Services</h3>
				
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
			
			<div id="donate" class="tab-content">
				<div class="tab-pane">
					<h3 class="ewpt-no-top-border">Donation Information</h3>
					
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
		
		<div id="ewpt-page-footer" class="ewpt-page-footer">
			
			<?php
			// Include the module footer file
			include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php';
			?>
						
		</div>
		
	</div>


    <?php
}

} // if (!function_exists('ewpt_about_settings_page'))