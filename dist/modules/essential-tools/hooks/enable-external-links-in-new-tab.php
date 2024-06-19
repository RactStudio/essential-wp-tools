<?php
// enable-external-links-in-new-tab.php
/**
 * Enable External Links in New Tab Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue the JavaScript code in the footer
add_action( 'wp_footer', function () {
	?>
	<script type="text/javascript">
		//<![CDATA[
		document.addEventListener('DOMContentLoaded', function() {
			var links = document.querySelectorAll('a');
			links.forEach(function(link) {
				// Check if the link is external
				if (link.hostname && link.hostname !== window.location.hostname) {
					// Set target="_blank" for external links
					link.setAttribute('target', '_blank');
					link.setAttribute('rel', 'noopener noreferrer');
				}
			});
		});
		//]]>
	</script>
	<?php
}, 9999 ); // Use a high priority to ensure it's one of the last scripts
