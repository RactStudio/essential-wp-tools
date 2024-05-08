<?php
// essential-wp-tools/inc/ewpt-modules-header.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<script>
jQuery(document).ready(function($) {
    function showTab(tab_id) {
        // Hide all tabs and deactivate tab links
        $('.tab-content').hide();
        $('.nav-tab-wrapper a').removeClass('nav-tab-active');

        // Show the selected tab and activate its link
        $(tab_id).show();
        $('.nav-tab-wrapper a[href="' + tab_id + '"]').addClass('nav-tab-active');

        // Store the active tab in sessionStorage
        sessionStorage.setItem('ewptActiveTab<?php echo sanitize_html_class($EWPT_MODULE_TAB_VAR); ?>', tab_id);
    }

    // Select the active tab from sessionStorage or default to the Settings tab
    var activeTab = sessionStorage.getItem('ewptActiveTab<?php echo sanitize_html_class($EWPT_MODULE_TAB_VAR); ?>') || '#<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>';

    // Show the active tab on page load
    showTab(activeTab);

    // Check for a hash in the URL on page load
    var initialHash = window.location.hash;
    if (initialHash) {
        showTab(initialHash);
    }

    // Add click event listeners to tab links
    $('.nav-tab-wrapper a').on('click', function(event) {
        event.preventDefault();
        var tab_id = $(this).attr('href');
        showTab(tab_id);

        // Update the URL with the tab_id as the hash
        history.pushState(null, null, tab_id);
    });

    // Listen for hash changes in the URL
    $(window).on('hashchange', function() {
        var newHash = window.location.hash;
        showTab(newHash);
    });
});
</script>