<?php
// disable-frontend-copy-paste.php
/**
 * Disable Frontend Copy Paste Module
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue the JavaScript code in the footer
add_action(
	'wp_footer',
    function () {
        ?>
        <script type="text/javascript">
            //<![CDATA[
			document.addEventListener("contextmenu", (evt) => {
			  evt.preventDefault();
			}, false);
			document.addEventListener("copy", (evt) => {
			  evt.clipboardData.setData("text/plain", "Content protected by Essential WP Tools");
			  evt.preventDefault();
			}, false);
            //]]>
        </script>
        <?php
    },
    9999
); // Use a high priority to ensure it's one of the last scripts