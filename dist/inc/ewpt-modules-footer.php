<?php
// essential-wp-tools/inc/ewpt-modules-footer.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<!-- Modals -->
<div id="saveModal" class="ewpt modal">
	<div class="modal-content">
		<span class="close">&times;</span>
		<header>
			<h2>Message</h2>
		</header>
		<div>
			<p id="save-message"></p>
		</div>
		<footer>
			<button class="close button">Close</button>
		</footer>
	</div>
</div>

<script>
jQuery(document).ready(function($) {
    function showTab(tab_id) {
        // Hide all main tab contents and deactivate main tab links
        $('.tab-content').hide();
        $('.nav-tab-wrapper a').removeClass('nav-tab-active');

        // Show the selected main tab and activate its link
        $(tab_id).show();
        $('.nav-tab-wrapper a[href="' + tab_id + '"]').addClass('nav-tab-active');

        // Store the active main tab in sessionStorage
        sessionStorage.setItem('ewptActiveTab<?php echo sanitize_html_class($EWPT_MODULE_TAB_VAR); ?>', tab_id);
    }

    // Select the active main tab from sessionStorage or default to the Settings tab
    var activeTab = sessionStorage.getItem('ewptActiveTab<?php echo sanitize_html_class($EWPT_MODULE_TAB_VAR); ?>') || '#<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>';

    // Show the active main tab on page load
    showTab(activeTab);

    // Check for a hash in the URL on page load for the main tab
    var initialHash = window.location.hash;
    if (initialHash) {
        showTab(initialHash);
    }

    // Add click event listeners to main tab links
    $('.nav-tab-wrapper a.main-tab').on('click', function(event) {
        event.preventDefault();
        var tab_id = $(this).attr('href');
        showTab(tab_id);

        // Update the URL with the tab_id as the hash for the main tab
        history.pushState(null, null, tab_id);
    });

    // Listen for hash changes in the URL for the main tab
    $(window).on('hashchange', function() {
        var newHash = window.location.hash;
        showTab(newHash);
    });

    // Nested Tab Functionality
    function showNestedTab(nested_tab_id) {
        // Hide all nested tab content and deactivate nested tab links
        $('.nested-tab-content').hide();
        $('.nested-tab').removeClass('nav-tab-active');

        // Show the selected nested tab and activate its link
        $(nested_tab_id).show();
        $('.nested-tab[href="' + nested_tab_id + '"]').addClass('nav-tab-active');
    }

    // Always show the first nested tab by default
    showNestedTab('#nested-tab-1');

    // Add click event listeners to nested tab links
    $('.nested-tab').on('click', function(event) {
        event.preventDefault();
        var nested_tab_id = $(this).attr('href');
        showNestedTab(nested_tab_id);
    });
	

    // Cache commonly used selectors
    var $form = $('#<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form');
    var $allSubmitButtons = $('#ewpt-page-body input[type="submit"].ewpt-save-btn');
    var $saveModal = $('#saveModal');
    var $ewptMask = $('#ewpt-mask');
    var ajaxRetryLimit = 3; // Set the number of retry attempts for AJAX requests

    // Function to set checkbox values based on their checked state
    function setCheckboxValues() {
        $('input[type="checkbox"]').each(function() {
            var checkbox = $(this);
            checkbox.val(checkbox.is(':checked') ? '1' : '0');
            // Add or update a hidden input to ensure unchecked checkboxes are included in the form submission
            if (!checkbox.next('input[type="hidden"]').length) {
                $('<input>').attr({
                    type: 'hidden',
                    name: checkbox.attr('name'),
                    value: checkbox.val()
                }).insertAfter(checkbox);
            } else {
                checkbox.next('input[type="hidden"]').val(checkbox.val());
            }
        });
    }

    // Call the function on page load
    setCheckboxValues();

    // Debounce function to limit the rate at which a function can fire
    function debounce(func, delay) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, delay);
        };
    }

    // Listen for changes on checkboxes with debounce
    $(document).on('change', 'input[type="checkbox"]', debounce(function() {
        var checkbox = $(this);
        checkbox.val(checkbox.is(':checked') ? '1' : '0');
        checkbox.next('input[type="hidden"]').val(checkbox.val());
    }, 300)); // 300ms debounce time

    // Function to show modals with dynamic messages
    function showModal(modalId, message, isSuccess) {
        var $modal = $('#' + modalId);
        $modal.find('p').html(message);
        if (isSuccess) {
            $modal.removeClass('errors').addClass('success');
        } else {
            $modal.removeClass('success').addClass('errors');
        }
        $modal.fadeIn();
        setTimeout(function() {
            $modal.fadeOut();
        }, 6000); // Hide the modal after 6 seconds
    }

    // Function to handle form submission via AJAX with retry logic
    function handleFormSubmission($form, $submitButton, $allSubmitButtons, retryCount = 0) {
        $allSubmitButtons.prop('disabled', true).val('Please wait .. ..');
        var successMessage = "<strong>Settings saved successfully!</strong>";
        var errorsMessage = "<strong>Failed to save settings.</strong><br/>Please try again.";
        var networkErrorMessage = "<strong>Network error.</strong><br/>Please check your connection and try again.";
        var timeoutMessage = "<strong>Request timed out.</strong><br/>Please try again.";
        var nonce = $('#<?php echo esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce'); ?>').val();

        // Show the mask
        $ewptMask.show();

        var jqxhr = $.ajax({
            type: 'POST',
            url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
            data: $form.serialize() + '&action=ewpt_form_submit&<?php echo esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce'); ?>=' + nonce,
            cache: false, // Disable caching for this request
            timeout: 60000, // Set timeout to 60 seconds
            success: function(response) {
                if (response.success) {
                    reloadPageContent(successMessage);
                } else {
                    showModal('saveModal', response.data.message || errorsMessage, false);
                    $allSubmitButtons.prop('disabled', false).val('Save Changes');
					$ewptMask.hide();
                }
            },
            error: function(xhr, status, error) {
                if (status === 'timeout') {
                    showModal('saveModal', timeoutMessage, false);
                } else if (status === 'error' || status === 'abort') {
                    if (retryCount < ajaxRetryLimit) {
                        handleFormSubmission($form, $submitButton, $allSubmitButtons, retryCount + 1);
                        return;
                    } else {
                        showModal('saveModal', networkErrorMessage, false);
                    }
                } else {
                    showModal('saveModal', errorsMessage, false);
                }
                $allSubmitButtons.prop('disabled', false).val('Save Changes');
                $ewptMask.hide();
            }
        });
    }

    // Function to reload the page content
    function reloadPageContent(successMessage) {
        $.ajax({
            type: 'GET',
            url: window.location.href, // Request the current page
            cache: false, // Disable caching for this request
            success: function(data) {
                // Replace the id="ewpt-page-main" content with the new content
                var newFormMain = $(data).find('#ewpt-page-main').html();
                $('#ewpt-page-main').html(newFormMain);
                
				// Admin sidebar EWPT Main menu update
				var newEWPTmenuBar = $(data).find('#toplevel_page_<?php echo esc_attr(EWPT_FULL_SLUG); ?>').html();
				$('#toplevel_page_<?php echo esc_attr(EWPT_FULL_SLUG); ?>').html(newEWPTmenuBar);
                
                // Re-enable all submit buttons after reloading the content
                $('#ewpt-page-body input[type="submit"].ewpt-save-btn').prop('disabled', false).val('Save Changes');

                // Reinitialize any necessary scripts for the new content
                reinitializeScripts();

                // Show success modal after content is loaded
                showModal('saveModal', successMessage, true);

				// Hide the mask
			   $ewptMask.hide();
            },
            error: function(xhr, status, error) {
                var reloadErrorMessage = "<strong>Failed to reload the page content.</strong><br/>Reload the page and try again.";
                showModal('saveModal', reloadErrorMessage, false);
                $('#ewpt-page-body input[type="submit"].ewpt-save-btn').prop('disabled', false).val('Save Changes');
                $ewptMask.hide();
            }
        });
    }
	
	// Function to reinitialize any necessary scripts after content reload
	function reinitializeScripts() {
		// Reinitialize the dismissible notices
		reinitializeDismissibleNotices();
		// Ensure checkbox values are set correctly after reloading content
		setCheckboxValues();
		// Trigger the window load event to ensure all scripts are properly reinitialized
		$(window).trigger('load');
	}

	// Function to reinitialize dismissible notices
	function reinitializeDismissibleNotices() {
		$('#ewpt-page-main .notice.is-dismissible').each(function() {
			var $this = $(this);
			var $button = $('<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>');
			$button.on('click.wp-dismiss-notice', function(event) {
				event.preventDefault();
				$this.fadeTo(100, 0, function() {
					$this.slideUp(100, function() {
						$this.remove();
					});
				});
			});
			$this.append($button);
		});
	}
	
    // Handle form submission via AJAX for both buttons
    $form.submit(function(e) {
        e.preventDefault();
        var $submitButton = $(document.activeElement); // Get the button that triggered the submit event
        $saveModal.removeClass('success errors'); // remove dynamic classes
        handleFormSubmission($form, $submitButton, $allSubmitButtons);
    });

    // Close modal on clicking the close button or cancel button
    $(document).on('click', '.close, .cancel', function() {
        $(this).closest('.modal').fadeOut();
    });
	
});
</script>
