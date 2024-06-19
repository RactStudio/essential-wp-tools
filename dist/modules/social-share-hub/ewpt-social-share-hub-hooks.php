<?php
// essential-wp-tools/modules/social-share-hub/ewpt-social-share-hub-hooks.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add Modules Action/Hooks files
$ewpt_disable_all_social_share_hub_options = get_option('ewpt_disable_all_social_share_hub_options');
if ($ewpt_disable_all_social_share_hub_options != 1 && !is_admin()) {
	
	// Array to keep track of included hook files
	$included_hook_files = array();
	
	// The hooks to display content based on user settings
	$hook_files = array(
		'the_content_hook.php',
	);
	
	foreach ($hook_files as $hook_file) {
		$file_path = plugin_dir_path(__FILE__) . 'hooks/' . $hook_file;
		if (file_exists($file_path) && !in_array($file_path, $included_hook_files)) {
			include_once($file_path);
			$included_hook_files[] = $file_path;
		}
	}
	
	if (get_option("ewpt_enable_all_social_share_hub_shortcodes", 0) == 1) {
		// Include the shortcode generator file
		include_once (plugin_dir_path(__FILE__) . 'ewpt-social-share-hub-shortcodes-generator.php');
	}
	
	//Frontend social share css style
	add_action( 'wp_head', function () { ?>
	<link rel="stylesheet" id="ewpt-ssh-style" href="<?php echo esc_url(plugin_dir_url(__FILE__). 'inc/ssh-style.css'); ?>" media="all">
	<?php
	});
	
	//Frontend social share css style
	add_action( 'wp_footer', function () { ?>
		<script>
		document.addEventListener("DOMContentLoaded", function() {
			var sshLinks = document.querySelectorAll(".ewpt-ssh a");
			sshLinks.forEach(function(link) {
				// Add tooltip
				var tooltip = document.createElement("div");
				tooltip.className = "ssh-tooltip";
				link.appendChild(tooltip);
				// Add link copy
				if (link.id === "ssh-icon-copy-link") {
				  link.addEventListener("click", function(event) {
					event.preventDefault();
					var copyDataUrl = link.getAttribute("data-url");
					navigator.clipboard.writeText(copyDataUrl);
					var tooltiptext = document.createElement("span");
					tooltiptext.className = "tooltiptext";
					tooltiptext.innerText = "Link copied";
					// Replace "Link copy" tooltip with "Link copied"
					var originalTooltip = link.querySelector(".tooltiptext");
					var originalTooltipText = originalTooltip.innerText;
					originalTooltip.innerText = tooltiptext.innerText;
					//recaplace old text after 1 seconds
					setTimeout(function() {
					  originalTooltip.innerText = originalTooltipText;
					  tooltip.removeChild(tooltiptext);
					}, 1000);
				  });
				}
				// Add print
				if (link.id === "ssh-icon-print") {
				  link.addEventListener("click", function(event) {
					event.preventDefault();
					window.print();
				  });
				}
			});
		});
		</script>
	<?php
	});

}