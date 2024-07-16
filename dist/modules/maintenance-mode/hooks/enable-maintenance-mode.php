<?php
// essential-wp-tools/module/maintenance-mode/hooks/enable-maintenance-mode.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

if (!function_exists('ewpt_maintenance_mode_status_enable')) {
	// Function to render the maintenance mode page
	function ewpt_maintenance_mode_status_enable() {
		// Styles and Scripts
		$styles_url = plugin_dir_url(__FILE__) . '../assets/css/styles.css';
		//$scripts_url = plugin_dir_url(__FILE__) . '../assets/js/scripts.js';
		
		//Global Styles
		$global_background = get_option('maintenance_mode_global_background', 'rgb(250, 250, 250)');
		$global_color = get_option('maintenance_mode_global_color', 'rgb(0, 0, 0)');
		$global_margin = get_option('maintenance_mode_global_margin', 0);
		$global_padding = get_option('maintenance_mode_global_padding', 50);
		$global_align = get_option('maintenance_mode_global_align', 'center');
		$global_font = get_option('maintenance_mode_global_font', '"open sans", sans-serif, Helvetica Neue');
		$global_size = get_option('maintenance_mode_global_size', 16);
		
		// Options Variables String
		$page_title_enabled = get_option('maintenance_mode_meta_title_enable', 0);
		$page_title = get_option('maintenance_mode_meta_title', 'Under Maintenance!');
		
		$page_description_enabled = get_option('maintenance_mode_meta_description_enable', 0);
		$page_description = get_option('maintenance_mode_meta_description', 'We are currently undergoing maintenance to improve your experience. Please check back soon for updates.');
		
		$logo_enabled = get_option('maintenance_mode_logo_enable', 0);
		$logo_img_url = get_option('maintenance_mode_logo_media_link', '');
		$logo_width = get_option('maintenance_mode_logo_media_width', 192);
		$logo_height = get_option('maintenance_mode_logo_media_height', 0);
		$logo_align = get_option('maintenance_mode_logo_media_align', 'center');
		
		$logo_link_enabled = get_option('maintenance_mode_logo_url_enable', 0);
		$logo_link = get_option('maintenance_mode_logo_url', '');
		
		$background_color_enabled = get_option('maintenance_mode_background_color_enable', 0);
		$background_color = get_option('maintenance_mode_background_color');
		
		$page_padding_enabled = get_option('maintenance_mode_page_padding_enable', 0);
		$page_padding = get_option('maintenance_mode_page_padding', 0);
		
		$h1_enabled = get_option('maintenance_mode_h1_text_enable', 0);
		$h1_align = get_option('maintenance_mode_h1_text_align', 'center');
		$h1_color = get_option('maintenance_mode_h1_text_color', 'rgb(0, 0, 0)');
		$h1_size = get_option('maintenance_mode_h1_text_size', '32');
		$h1_text = get_option('maintenance_mode_h1_text', "We'll be back soon!");
		
		$paragraph_enabled = get_option('maintenance_mode_paragraph_enable', 0);
		$paragraph_align = get_option('maintenance_mode_paragraph_text_align', 'center');
		$paragraph_color = get_option('maintenance_mode_paragraph_text_color', 'rgb(0, 0, 0)');
		$paragraph_size = get_option('maintenance_mode_paragraph_text_size', '16');
		$paragraph_text = get_option('maintenance_mode_paragraph_text', "<p>We're performing some maintenance at the moment. We’ll be back up shortly!</p><p>— <strong>The Team</strong></p>");
		
		// Advanced Mode
		$advanced_enable = get_option('ewpt_enable_maintenance_mode_advanced_enable', 0);
		//HTML text (assign string)
		$html_placement = 'above_everything';
		$html_text = '';
		//Style and Script (assign string)
		$style_script_placement = 'head_below';
		$style_script_text = '';
		if (empty($advanced_enable) || $advanced_enable == 0) {
			//HTML text
			$html_enabled = get_option('maintenance_mode_html_enable', 0);
			if ($html_enabled) {
				$html_placement = get_option('maintenance_mode_html_placement', '');
				$html_text = get_option('maintenance_mode_html_text', '');
			}
			//Style and Script
			$style_script_enabled = get_option('maintenance_mode_styles_scripts_enable', 0);
			if ($style_script_enabled) {
				$style_script_placement = get_option('maintenance_mode_styles_scripts_placement', '');
				$style_script_text = get_option('maintenance_mode_styles_scripts_text', '');
			}
		}
		
		// Current Page URL
		if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1)) {
			// HTTPS is enabled
			$protocol = 'https://';
		} elseif (isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] === '443')) {
			// If HTTPS is not explicitly set but the server port is 443, it's likely HTTPS
			$protocol = 'https://';
		} else {
			// Otherwise, assume HTTP
			$protocol = 'http://';
		}
        // Construct the Current Page URL
		$mmhub_current_url = $protocol . sanitize_text_field($_SERVER['HTTP_HOST']) . sanitize_text_field($_SERVER['REQUEST_URI']);
		
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Content-Type: text/html; charset=utf-8');
		header('Retry-After: 3600');
		
		?>
<!DOCTYPE html>
<html lang="en-US" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<!-- Meta -->
	<title><?php echo $page_title_enabled ? wp_kses_post($page_title) : 'Under Maintenance'; ?></title>
	<meta name="description" content="<?php echo $page_description_enabled ? wp_kses_post($page_description) : 'We are currently undergoing maintenance to improve your experience. Please check back soon for updates.'; ?>"/>
	<meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large"/>
	<link rel="canonical" href="<?php echo esc_url($mmhub_current_url); ?>" />
	<!-- Styles and Scripts -->
	<link rel='stylesheet' id='ewpt-mmhub-styles' href='<?php echo esc_url($styles_url); ?>' media='all' />
	<style>
		:root {
			background-color: <?php echo $global_background ? esc_attr($global_background) : 'rgb(250,250,250)'; ?>;
			color: <?php echo $global_color ? esc_attr($global_color) : 'rgb(0, 0, 0)'; ?>;
			margin: <?php echo $global_margin ? esc_attr($global_margin) : '35'; ?>px;
			padding: <?php echo $global_padding ? esc_attr($global_padding) : '5'; ?>px;
			text-align: <?php echo $global_align ? esc_attr($global_align) : 'center'; ?>;
			font-family: <?php echo $global_font ? wp_kses_post($global_font) : '"open sans", sans-serif, Helvetica Neue'; ?>;
			font-size: <?php echo $global_size ? esc_attr($global_size) : '16'; ?>px;
		}
		div.h1-text h1 {
			margin: <?php echo $h1_size ? esc_attr($h1_size) : '32'; ?>px 0 <?php echo $h1_size ? esc_attr($h1_size) : '32'; ?>px 0;
			font-size: <?php echo $h1_size ? esc_attr($h1_size) : '32'; ?>px;
			text-align: <?php echo $h1_enabled ? esc_attr($h1_align) : 'center'; ?>;
			color: <?php echo $h1_enabled ? esc_attr($h1_color) : '#000'; ?>;
		}
		div.paragraph-text {
			margin: 30px 0 30px 0;
			font-size: <?php echo $paragraph_size ? esc_attr($paragraph_size) : '16'; ?>px;
			text-align: <?php echo $paragraph_enabled ? esc_attr($paragraph_align) : 'center'; ?>;
			color: <?php echo $paragraph_enabled ? esc_attr($paragraph_color) : '#000'; ?>;
		}
		div.logo {
			margin: 0 0 30px 0;
			text-align: <?php echo $logo_enabled ? esc_attr($logo_align) : 'center'; ?>;
		}
		div.logo img {
			width: <?php if ($logo_width && $logo_enabled) { echo esc_attr($logo_width).'px'; } elseif (empty($logo_width) && $logo_enabled) {echo 'auto';}?>;
			height: <?php if ($logo_height && $logo_enabled) { echo esc_attr($logo_height).'px'; } elseif (empty($logo_height) && $logo_enabled) {echo 'auto';}?>;
		}
	</style>
	
	<?php
	/**
	<script src="<?php echo esc_url($scripts_url); ?>" id="ewpt-mmhub-scripts"></script>
	**/
	?>
	
	<?php
	// Style & Script Text
	if ($style_script_placement === 'head_below') {
		echo ewpt::rsd_sanitize_html_raw_field($style_script_text); 
	}
	?>
	
</head>
<body>
	
	<?php
	// Style & Script Text
	if ($style_script_placement === 'body_above') {
		echo ewpt::rsd_sanitize_html_raw_field($style_script_text); 
	}
	?>
	
	<?php
	// HTML Text
	if ($html_placement === 'above_everything') {
		echo ewpt::rsd_sanitize_html_raw_field($html_text);
	}
	?>
	
	<?php if ($logo_img_url && $logo_enabled) : ?>
		<div class="logo">
			<?php if ($logo_link && $logo_link_enabled) : ?>
				<a href="<?php echo esc_url($logo_link); ?>" target="_blank">
			<?php endif; ?>
				<img src="<?php echo esc_url($logo_img_url); ?>" alt="logo">
			<?php if ($logo_link && $logo_link_enabled) : ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
	<?php
	// HTML Text
	if ($html_placement === 'below_logo') {
		echo ewpt::rsd_sanitize_html_raw_field($html_text);
	}
	?>
	
	<?php if ($h1_enabled) : ?>
	<div class="h1-text">
		<h1>
			<?php echo wp_kses_post($h1_text); ?>
		</h1>
	</div>
	<?php endif; ?>
	
	<?php
	// HTML Text
	if ($html_placement === 'below_h1_text') {
		echo ewpt::rsd_sanitize_html_raw_field($html_text);
	}
	?>
	
	<?php if ($paragraph_enabled) : ?>
	<div class="paragraph-text">
			<?php echo wp_kses_post($paragraph_text); ?>
	</div>
	<?php endif; ?>

	<?php
	// HTML Text
	if ($html_placement === 'below_paragraph_text') {
		echo ewpt::rsd_sanitize_html_raw_field($html_text);
	}
	?>

	<?php
	// Style & Script Text
	if ($style_script_placement === 'body_below') {
		echo ewpt::rsd_sanitize_html_raw_field($style_script_text); 
	}
	?>
	
</body>
<footer>

	<?php
	// HTML Text
	if ($html_placement === 'below_eveything') {
		echo ewpt::rsd_sanitize_html_raw_field($html_text);
	}
	?>
	
	<?php
	// Style & Script Text
	if ($style_script_placement === 'footer_below') {
		echo ewpt::rsd_sanitize_html_raw_field($style_script_text); 
	}
	?>
	
</footer>
</html>
		<?php
		die();
	}
	
    // Retrieve the option value to determine where to enable "Maintenance Mode"
    $condition_value = get_option('display_wp_maintenance_mode_except', 'except_admin');

    switch ($condition_value) {
        case 'except_admin':
            if (!current_user_can('administrator')) {
                add_action('wp', 'ewpt_maintenance_mode_status_enable', 1); // Except Admin
            }
            break;
        case 'except_admin_editor':
            if (!current_user_can('administrator') && !current_user_can('editor')) {
                add_action('wp', 'ewpt_maintenance_mode_status_enable', 1); // Except Admin, & Editor
            }
            break;
        case 'except_admin_editor_author':
            if (!current_user_can('administrator') && !current_user_can('editor') && !current_user_can('author')) {
                add_action('wp', 'ewpt_maintenance_mode_status_enable', 1); // Except Admin, Editor, & Author
            }
            break;
        case 'only_author':
            if (current_user_can('author')) {
                add_action('wp', 'ewpt_maintenance_mode_status_enable', 1); // Only Author
            }
            break;
        case 'only_contributor':
            if (current_user_can('contributor')) {
                add_action('wp', 'ewpt_maintenance_mode_status_enable', 1); // Only Contributor
            }
            break;
        case 'only_subscriber':
            if (current_user_can('subscriber')) {
                add_action('wp', 'ewpt_maintenance_mode_status_enable', 1); // Only Subscriber
            }
            break;
        case 'only_logged_in_users':
            if (is_user_logged_in()) {
                add_action('wp', 'ewpt_maintenance_mode_status_enable', 1); // Only Logged-in Users
            }
            break;
        case 'only_non_logged_in_users':
            if (!is_user_logged_in()) {
                add_action('wp', 'ewpt_maintenance_mode_status_enable', 1); // Only Non Logged-in Users
            }
            break;
        case 'all_users':
            add_action('wp', 'ewpt_maintenance_mode_status_enable', 1); // All Users
            break;
        default:
            // Default case, do nothing
            break;
    }
	
} // if (!function_exists('ewpt_maintenance_mode_status_enable'))