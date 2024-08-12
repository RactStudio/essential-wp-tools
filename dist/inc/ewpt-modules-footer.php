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

    // Commonly used selectors
    var $form = $('#<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form');
    var $allSubmitButtons = $('#ewpt-page-body input[type="submit"].ewpt-save-btn');
    var $saveModal = $('#saveModal');
    var $ewptMask = $('#ewpt-mask');
	var retryLimit = 3; // Set the number of retry attempts to Fetch API POST and GET requests
	var retryBackoff = 4000; // 4 seconds

	// Function to handle Fetch API with retry logic
	function fetchWithRetry(url, options, retryLimit, retryBackoff) {
		return new Promise((resolve, reject) => {
			const attemptFetch = (retryCount) => {
				fetch(url, options)
					.then(response => {
						if (!response.ok) {
							if (retryCount > 0) {
								setTimeout(() => {
									attemptFetch(retryCount - 1);
								}, retryBackoff);
							} else {
								reject(new Error('Network response was not ok.'));
							}
						} else {
							resolve(response);
						}
					})
					.catch(error => {
						if (retryCount > 0) {
							setTimeout(() => {
								attemptFetch(retryCount - 1);
							}, retryBackoff);
						} else {
							reject(error);
						}
					});
			};

			attemptFetch(retryLimit);
		});
	}

	// Function to handle form submission via Fetch API with retry logic
	function handleFormSubmission($form, $submitButton, $allSubmitButtons, retryLimit, retryBackoff) {
		$allSubmitButtons.prop('disabled', true).val('Please wait .. ..');
		var successMessage = "<strong>Settings saved successfully!</strong>";
		var errorsMessage = "<strong>Failed to save settings.</strong><br/>Please try again.";
		var networkErrorMessage = "<strong>Network error.</strong><br/>Please check your connection and try again.";
		var nonce = $('#<?php echo esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce'); ?>').val();
		
		// Start the skeleton loader
		skeleton_loader_init();
		
		// Show the mask
		//$ewptMask.show();
		
		// Prepare form data
		var formData = new FormData($form[0]);
		formData.append('action', 'ewpt_form_submit');
		formData.append('<?php echo esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce'); ?>', nonce);
		
		// Fetch options
		var fetchOptions = {
			method: 'POST',
			body: formData,
			cache: 'no-cache',
			headers: {
				'X-Requested-With': 'XMLHttpRequest' // Ensure the request is recognized as AJAX
			}
		};

		fetchWithRetry('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', fetchOptions, retryLimit, retryBackoff)
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					reloadPageContent($allSubmitButtons, successMessage, retryLimit, retryBackoff);
				} else {
					//skeleton_loader_remove(); // Stop skeleton loader
					showModal('saveModal', data.data.message || errorsMessage, false);
				}
			})
			.catch(error => {
				//skeleton_loader_remove(); // Stop skeleton loader
				showModal('saveModal', networkErrorMessage, false);
			})
			.finally(() => {
				//skeleton_loader_remove(); // Stop skeleton loader
				$allSubmitButtons.prop('disabled', false).val('Save Changes');
				//$ewptMask.hide();
			});
	}

	// Function to reload the page content
	function reloadPageContent($allSubmitButtons, successMessage, retryLimit, retryBackoff) {
		skeleton_loader_init(); // Start the skeleton loader before reloading content

		fetchWithRetry(window.location.href, {
			method: 'GET',
			cache: 'no-cache'
		}, retryLimit, retryBackoff)
		.then(response => response.text())
		.then(data => {
			var newContent = $(data);

			// Replace the id="ewpt-page-main" content with the new content
			$('#ewpt-page-main').html(newContent.find('#ewpt-page-main').html());

			// Admin sidebar EWPT Main menu update
			$('#toplevel_page_<?php echo esc_attr(EWPT_FULL_SLUG); ?>').html(newContent.find('#toplevel_page_<?php echo esc_attr(EWPT_FULL_SLUG); ?>').html());

			// Re-enable all submit buttons after reloading the content
			$allSubmitButtons.prop('disabled', false).val('Save Changes');

			// Reinitialize any necessary scripts for the new content
			reinitializeScripts();
			
			// Show success modal after content is loaded
			showModal('saveModal', successMessage, true);
		})
		.catch(error => {
			var reloadErrorMessage = "<strong>Failed to reload the page content.</strong><br/>Reload the page and try again.";
			showModal('saveModal', reloadErrorMessage, false);
		});
	}

	// Function to initialize the skeleton loader
	function skeleton_loader_init() {
		var $pageMain = $('#ewpt-page-main');
		// Initialize the skeleton loader
		$pageMain.scheletrone({
			//backgroundColor: '#fefefe',
			//backgroundOpacity: 0.2,
			//backgroundImage: true,
			//replaceImageWith: 'bg-image',
			//skeletonImage: 'linear-gradient(90deg, #e0e0e0 25%, #f8f8f8 50%, #e0e0e0 75%)',
			//elementTypes: ['div', 'span', 'th', 'td', 'input', 'select', 'textarea', 'button', 'h2', 'h3', 'h4', 'p', 'label'],
			//excludeElements: '.exclude-skeleton-loader',
			//maskText: false,
			//skelParentText: false,
			incache: false
		});
		$pageMain.scheletrone(); // Start skeleton loader
	}

	// Function to remove the skeleton loader forcefully
	function skeleton_loader_remove() {
		var $pageMain = $('#ewpt-page-main');
		// Stop skeleton loader
		$pageMain.scheletrone('stopLoader');
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

    // Handle form submission via AJAX for both buttons
    $form.submit(function(e) {
        e.preventDefault();
        var $submitButton = $(document.activeElement); // Get the button that triggered the submit event
        $saveModal.removeClass('success errors'); // remove dynamic classes
		handleFormSubmission($form, $submitButton, $allSubmitButtons);
    });
	
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
        }, 4000); // Hide the modal after 4 seconds
    }

    // Close modal on clicking the close button or cancel button
    $(document).on('click', '.close, .cancel', function() {
        $(this).closest('.modal').fadeOut();
    });
	
});
</script>