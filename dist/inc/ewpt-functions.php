<?php
// essential-wp-tools/inc/ewpt-functions.php

// Define namespace
namespace Essential\WP\Tools;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class ewpt {
	
    // Helper function to check nonce
    public static function check_nonce($nonce_key) {
        return isset($_POST[$nonce_key]) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST[$nonce_key])), $nonce_key);
    }

	// Method to sanitize callbacks and update settings data directly
	public static function update_settings_data($sanitized_data_array, $registered_settings) {
		foreach ($sanitized_data_array as $option_name => $value) {
			$type = isset($registered_settings[$option_name]['type']) ? $registered_settings[$option_name]['type'] : '';

			// Initialize the sanitized value
			$sanitized_value = $value;

			// Sanitize the value based on its type
			switch ($type) {
				case 'string':
				case 'sanitize_text_field':
					$sanitized_value = sanitize_text_field($value);
					break;
				case 'esc_html':
					$sanitized_value = esc_html($value);
					break;
				case 'html_post':
					$sanitized_value = wp_kses_post($value);
					break;
				case 'html_raw':
					$sanitized_value = ewpt::rsd_sanitize_html_raw_field($value);
					break;
				case 'int':
				case 'intval':
				case 'integer':
					$sanitized_value = intval($value);
					break;
				case 'float':
				case 'floatval':
				case 'double':
					$sanitized_value = floatval($value);
					break;
				case 'bool':
				case 'boolean':
					$sanitized_value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
					break;
				case 'array':
					$sanitized_value = is_array($value) ? $value : [];
					break;
				case 'color':
					if (preg_match('/^#[a-f0-9]{6}([a-f0-9]{2})?$/i', $value)) {
						$sanitized_value = sanitize_hex_color($value);
					} elseif (preg_match('/^hsla?\(\s*(-?\d+),\s*(-?\d+%?),\s*(-?\d+%?),\s*(0(\.\d+)?|1(\.0)?)\s*\)$/i', $value)) {
						$sanitized_value = $value;
					} elseif (preg_match('/^rgba?\((\s*\d+\s*,){2}\s*\d+(?:\.\d+)?(\s*,\s*\d+(?:\.\d+)?)?\)$/', $value)) {
						$sanitized_value = $value;
					} else {
						$sanitized_value = '';
					}
					break;
				case 'email':
					$sanitized_value = sanitize_email($value);
					break;
				case 'url':
					$sanitized_value = esc_url_raw($value);
					break;
				case 'file':
					$sanitized_value = ewpt::rsd_sanitize_file_field($value);
					break;
				case 'date':
					//$date = date_create_from_format('Y-m-d', $value);
					$date = date_create_from_format('Y-m-d', $value ?? '');
					$sanitized_value = ($date !== false) ? $date->format('Y-m-d') : '';
					break;
				case 'datetime':
					//$date = date_create_from_format('Y-m-d H:i:s', $value);
					$date = date_create_from_format('Y-m-d H:i:s', $value ?? '');
					$sanitized_value = ($date !== false) ? $date->format('Y-m-d H:i:s') : '';
					break;
				case 'dtzone':
					$timezone = get_option('timezone_string') ?: 'UTC';
					//$date = date_create_from_format('Y-m-d H:i:s', $value);
					$date = date_create_from_format('Y-m-d H:i:s', $value ?? '');
					if ($date !== false) {
						$date->setTimezone(new DateTimeZone($timezone));
						$sanitized_value = $date->format('Y-m-d H:i:s') . ' ' . $timezone;
					} else {
						$sanitized_value = '';
					}
					break;
				default:
					$sanitized_value = $value;
					break;
			}

			// Update the option with the sanitized value
			update_option($option_name, $sanitized_value);
			
		}
	}
	
	// Method to register settings with various data types and optional custom sanitize callbacks and invalid data messages
	protected static $rsd_args = NULL;
	public static function register_setting_data($option_group, $option_name, $type = '', $invalid_data_message = '') {
		// Initialize settings arguments array
		self::$rsd_args = array('type' => $type);

		// If a sanitize callback is provided, assign callbacks for common data types
		switch ($type) {
			case 'string':
			case 'sanitize_text_field':
				self::$rsd_args['sanitize_callback'] = 'sanitize_text_field';
				break;
			case 'esc_html':
				self::$rsd_args['sanitize_callback'] = 'esc_html';
				break;
			case 'html_post':
				self::$rsd_args['sanitize_callback'] = function($value) {
					return wp_kses_post($value);
				};
				break;
			case 'html_raw':
				self::$rsd_args['sanitize_callback'] = function($value) {
					// Might break some html!
					return ewpt::rsd_sanitize_html_raw_field($value);
				};
				break;
			case 'int':
			case 'intval':
			case 'integer':
				self::$rsd_args['sanitize_callback'] = 'intval';
				break;
			case 'float':
			case 'floatval':
			case 'double':
				self::$rsd_args['sanitize_callback'] = 'floatval';
				break;
			case 'bool':
			case 'boolean':
				self::$rsd_args['sanitize_callback'] = function ($value) {
					return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null ? filter_var($value, FILTER_VALIDATE_BOOLEAN) : false;
				};
				break;
			case 'array':
				self::$rsd_args['sanitize_callback'] = function ($value) {
					return is_array($value) ? $value : array();
				};
				break;
			case 'color':
				self::$rsd_args['sanitize_callback'] = function ($value) {
				   // Check if the value is a valid hexadecimal color with or without alpha
					if (preg_match('/^#[a-f0-9]{6}([a-f0-9]{2})?$/i', $value)) {
						// If it's a valid format, sanitize as hexadecimal
						return sanitize_hex_color($value);
					} elseif (preg_match('/^hsla?\(\s*(-?\d+),\s*(-?\d+%?),\s*(-?\d+%?),\s*(0(\.\d+)?|1(\.0)?)\s*\)$/i', $value)) {
						return $value; // Sanitize HSLA color, return as is
					} elseif (preg_match('/^rgba?\((\s*\d+\s*,){2}\s*\d+(?:\.\d+)?(\s*,\s*\d+(?:\.\d+)?)?\)$/', $value)) {
						return $value; // Sanitize RGBA and RGB colors, return as is
					} else {
						return ''; // Return empty string for invalid colors
					}
				};
				break;
			case 'email':
				self::$rsd_args['sanitize_callback'] = 'sanitize_email';
				break;
			case 'url':
				self::$rsd_args['sanitize_callback'] = 'esc_url_raw';
				break;
			case 'file':
				self::$rsd_args['sanitize_callback'] = array('ewpt', 'rsd_sanitize_file_field');
				break;
			case 'date':
				self::$rsd_args['sanitize_callback'] = function ($value) {
					// Check if the value is a valid date
					//$date = date_create_from_format('Y-m-d', $value);
					$date = date_create_from_format('Y-m-d', $value ?? '');
					if ($date !== false) {
						return $date->format('Y-m-d'); // Return formatted date
					} else {
						return ''; // Return empty string for invalid dates
					}
				};
				break;
			case 'datetime':
				self::$rsd_args['sanitize_callback'] = function ($value) {
					// Check if the value is a valid date and time
					//$date = date_create_from_format('Y-m-d H:i:s', $value);
					$date = date_create_from_format('Y-m-d H:i:s', $value ?? '');
					if ($date !== false) {
						return $date->format('Y-m-d H:i:s'); // Return formatted date and time
					} else {
						return ''; // Return empty string for invalid dates
					}
				};
				break;
			case 'dtzone':
				self::$rsd_args['sanitize_callback'] = function ($value) {
					// Get the WordPress timezone
					$timezone = get_option('timezone_string');
					if (empty($timezone)) {
						$timezone = 'UTC'; // Use UTC timezone if WordPress timezone is empty
					}
					// Check if the value is a valid date and time
					//$date = date_create_from_format('Y-m-d H:i:s', $value);
					$date = date_create_from_format('Y-m-d H:i:s', $value ?? '');
					if ($date !== false) {
						// Set the timezone after creating the DateTime object
						$date->setTimezone(new DateTimeZone($timezone));
						// Return formatted date and time with timezone
						return $date->format('Y-m-d H:i:s') . ' ' . $timezone;
					} else {
						return ''; // Return empty string for invalid dates
					}
				};
				break;
			default:
				// No specific sanitization callback for other types
				break;
		}
		
		// If an invalid data message is provided, add it to the settings arguments
		if (!empty($invalid_data_message)) {
			self::$rsd_args['invalid_data_message'] = $invalid_data_message;
		}

		// Register the WordPress setting with or without the invalid data message
		register_setting($option_group, $option_name, self::$rsd_args);
	}
	
	// Custom sanitize callback for html_raw field
	public static function rsd_sanitize_html_raw_field($value) {
		// Define allowed HTML tags and attributes
			$html_tags = array(
				'a' => array('href', 'target', 'rel', 'title'),
				'abbr' => array('title'),
				'address' => array(),
				'area' => array('shape', 'coords', 'href', 'alt', 'target', 'rel'),
				'article' => array(),
				'aside' => array(),
				'audio' => array('src', 'controls', 'autoplay', 'loop'),
				'b' => array(),
				'base' => array('href', 'target'),
				'bdi' => array(),
				'bdo' => array(),
				'blockquote' => array('cite'),
				'body' => array('onload', 'onunload'),
				'br' => array(),
				'button' => array('name', 'value', 'type', 'disabled', 'form', 'autofocus'),
				'canvas' => array('width', 'height'),
				'caption' => array(),
				'cite' => array(),
				'code' => array(),
				'col' => array('span'),
				'colgroup' => array('span'),
				'data' => array('value'),
				'datalist' => array(),
				'dd' => array(),
				'del' => array('cite', 'datetime'),
				'details' => array('open'),
				'dfn' => array(),
				'dialog' => array('open'),
				'div' => array('align'),
				'dl' => array(),
				'dt' => array(),
				'em' => array(),
				'embed' => array('src', 'type', 'width', 'height'),
				'fieldset' => array('disabled', 'form', 'name'),
				'figcaption' => array(),
				'figure' => array(),
				'footer' => array(),
				'form' => array('action', 'method', 'enctype', 'name', 'target', 'novalidate'),
				'h1' => array('align'),
				'h2' => array('align'),
				'h3' => array('align'),
				'h4' => array('align'),
				'h5' => array('align'),
				'h6' => array('align'),
				'head' => array(),
				'header' => array(),
				'hr' => array(),
				'html' => array('manifest'),
				'i' => array(),
				'iframe' => array('src', 'width', 'height', 'frameborder', 'allowfullscreen'),
				'img' => array('src', 'alt', 'title', 'width', 'height', 'ismap', 'usemap', 'style', 'data'),
				'input' => array('type', 'name', 'value', 'size', 'maxlength', 'readonly', 'disabled', 'checked', 'autofocus', 'required', 'form', 'placeholder', 'autocomplete'),
				'ins' => array('cite', 'datetime'),
				'kbd' => array(),
				'label' => array('for', 'form'),
				'legend' => array(),
				'li' => array('value'),
				'link' => array('rel', 'href', 'type', 'media'),
				'main' => array(),
				'map' => array('name'),
				'mark' => array(),
				'menu' => array('type', 'label'),
				'menuitem' => array('type'),
				'meta' => array('name', 'content', 'http-equiv', 'charset'),
				'meter' => array('value', 'min', 'max', 'low', 'high', 'optimum'),
				'nav' => array(),
				'noscript' => array(),
				'object' => array('data', 'type', 'width', 'height', 'name', 'usemap', 'form', 'classid', 'codebase', 'codetype', 'archive', 'declare', 'standby', 'align', 'border', 'hspace', 'vspace'),
				'ol' => array('reversed', 'start', 'type'),
				'optgroup' => array('disabled', 'label'),
				'option' => array('disabled', 'label', 'selected', 'value'),
				'output' => array('for', 'form', 'name'),
				'p' => array('align'),
				'param' => array('name', 'value'),
				'picture' => array(),
				'pre' => array('width', 'height'),
				'progress' => array('value', 'max'),
				'q' => array('cite'),
				'rp' => array(),
				'rt' => array(),
				'ruby' => array(),
				's' => array(),
				'samp' => array(),
				'script' => array('src', 'async', 'defer', 'type', 'charset'),
				'section' => array(),
				'select' => array('name', 'size', 'multiple', 'disabled', 'form', 'autofocus', 'required'),
				'small' => array(),
				'source' => array('src', 'type', 'media'),
				'span' => array('align'),
				'strong' => array(),
				'style' => array('type', 'media', 'scoped'),
				'sub' => array(),
				'summary' => array(),
				'sup' => array(),
				'svg' => array('width', 'height', 'xmlns'),
				'table' => array('border', 'cellpadding', 'cellspacing'),
				'tbody' => array('align', 'char', 'charoff', 'valign'),
				'td' => array('colspan', 'rowspan', 'headers', 'align', 'axis', 'abbr', 'scope', 'valign', 'nowrap', 'bgcolor', 'background', 'bordercolor', 'width', 'height', 'nowrap'),
				'textarea' => array('name', 'rows', 'cols', 'disabled', 'readonly', 'autofocus', 'required', 'placeholder', 'form'),
				'tfoot' => array('align', 'char', 'charoff', 'valign'),
				'th' => array('colspan', 'rowspan', 'headers', 'align', 'axis', 'abbr', 'scope', 'valign', 'nowrap', 'bgcolor', 'background', 'bordercolor', 'width', 'height', 'nowrap'),
				'thead' => array('align', 'char', 'charoff', 'valign'),
				'time' => array('datetime', 'pubdate'),
				'title' => array(),
				'tr' => array('align', 'char', 'charoff', 'valign', 'bgcolor', 'background', 'bordercolor', 'width', 'height', 'nowrap'),
				'track' => array('src', 'kind', 'srclang', 'label', 'default'),
				'u' => array(),
				'ul' => array('type'),
				'var' => array(),
				'video' => array('src', 'controls', 'autoplay', 'loop', 'preload', 'width', 'height', 'poster'),
				'wbr' => array(),
				'base' => array('href', 'target'),
				'meta' => array('name', 'content', 'http-equiv', 'charset'),
				'noscript' => array(),
				'script' => array('src', 'async', 'defer', 'type', 'charset'),
				'link' => array('rel', 'href', 'type', 'media'),
				'style' => array('type', 'media', 'scoped'),
			);
			
			// Global attributes applicable to multiple elements
			$global_attributes = array(
				'class', 'id', 'style', 'title', 'lang', 'dir', 'accesskey', 'contenteditable', 'hidden'
			);
			// Merge global attributes into each tag's attributes
			foreach ($html_tags as &$attributes) {
				$attributes = array_merge($attributes, $global_attributes);
			}
			
			// Flatten the multi-dimensional array
			$allowed_html = array();
			foreach ($html_tags as $tag => $attributes) {
				$allowed_html[$tag] = array();
				foreach ($attributes as $attribute) {
					$allowed_html[$tag][$attribute] = true;
				}
			}
			
		// Sanitize the input using wp_kses with the flattened allowed HTML tags and attributes
		$sanitized_value = wp_kses($value, $allowed_html);
		
		// Return the sanitized value
		return $sanitized_value;
	}
	
	// Custom sanitize callback for file fields
	public static function rsd_sanitize_file_field($file) {
		// Define allowed file types
		$allowed_types = array(
			'.zip', '.rar', '.png', '.jpeg', '.jpg', '.gif', '.svg', '.pdf', '.doc', '.docx', '.txt', '.ico', '.webp', '.ttf', '.otf', '.woff', '.woff2', '.ppt', '.xls', '.xlsx',
		);
		
		// Get the file extension
		$file_ext = pathinfo($file, PATHINFO_EXTENSION);
		
		// Check if the file extension is in the list of allowed types
		if (in_array(strtolower($file_ext), $allowed_types)) {
			return $file;
		} else {
			// If the file type is not allowed, return an empty string
			return ''; // Invalid file type, return empty string
		}
	}
	
	// Function to sanitize post type lists
	public static function sanitize_post_types_lists( $post_types ) {
		// Ensure $post_types is an array
		if ( is_array( $post_types ) ) {
			// Sanitize each element of the array
			foreach ( $post_types as &$type ) {
				$type = sanitize_key( $type ); // Sanitize as a key
			}
			// Return the sanitized array as a comma-separated string
			return implode( ',', $post_types );
		}
		// If $post_types is not an array, return an empty string
		return '';
	}
	
	// Assign menu for each module
	public static function assign_modules_menu_link($menu_visibility_option, $module_name) {
		// Get the option for menu visibility
		$menu_visibility_option = $menu_visibility_option;
		
		// Define common menu parameters
		$module_page_title =  ucfirst($module_name).' Settings';
		$menu_display_title = ucfirst($module_name); // Module display title
		$menu_slug = str_replace(' ', '-', strtolower($module_name)); //  Module name (lowercase) with hypen (-) after each word
		$menu_callback = str_replace('-', '_', $menu_slug); //  Mdule name (lowercase) with underscores (_) after each word
		$menu_capability = 'manage_options';
		$menu_icon = 'dashicons-admin-generic';
		
		// Determine which menu to add based on the option
		switch ($menu_visibility_option) {
			case 'main_menu':
				add_menu_page(
					$module_page_title,
					$menu_display_title, // Use the defined display title
					$menu_capability,
					'ewpt-'.$menu_slug,
					'ewpt_'.$menu_callback.'_settings_page',
					$menu_icon,
					3
				);
				break;
			case '': // If empty
			case 'sub_menu':
				add_submenu_page(
					'essential-wp-tools',
					$module_page_title,
					$menu_display_title, // Use the defined display title
					$menu_capability,
					'ewpt-'.$menu_slug,
					'ewpt_'.$menu_callback.'_settings_page',
				);
				break;
			case 'hidden_menu':
				add_submenu_page(
					null, // No parent page, hidden menu
					$module_page_title,
					$menu_display_title, // Use the defined display title
					$menu_capability,
					'ewpt-'.$menu_slug,
					'ewpt_'.$menu_callback.'_settings_page',
				);
				// Hook into the admin_title filter to change the title dynamically
				add_filter('admin_title', function($admin_title) use ($module_page_title, $menu_slug) {
					global $pagenow;
					// Check if the current page is the hidden settings page
					if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'ewpt-'.$menu_slug) {
						return $module_page_title . $admin_title;
					}
					return $admin_title;
				}, 10, 2);
				break;
		}
	}
	
	// Function to generate all active modules list
	public static function generate_all_active_modules($ewpt_active_modules) {
		// Check if the array is not empty
		if (!empty($ewpt_active_modules)) {
			// Loop through the active modules array
			foreach ($ewpt_active_modules as $module_name => $module_data) {
				// Validate the module before loading
				$folder_name = $module_data['folder_name'];
				$module_dir = $module_data['module_dir'];
				if (self::validate_module($module_dir, $folder_name)) {
				?>
					<div class="ewpt-column">
						<div class="ewpt-card text-center">
							<a  class="ewpt-module-name" title="<?php echo esc_attr($module_data['module_name'].' Settings'); ?>" href="<?php echo esc_attr(EWPT_DASH_SHORT_URL.'-'.$module_data['module_slug']); ?>"><?php echo esc_attr($module_data['module_name']); ?></a>
							<p><?php echo esc_attr($module_data['module_ready']); ?> v<?php echo esc_attr($module_data['module_version']); ?></p>
						</div>
					</div>
			<?php
				}
			}
		} else
		{ ?>
			<div class="ewpt-column-1">
				<div class="ewpt-card text-center">
					<p  class="ewpt-module-name">
						No active module found!
					</p>
					<p>
						Please, click <a  class="ewpt-button-link-text  ewpt-enlarge-1x" href="#modules-manager"><strong>Modules Manager</strong></a> to enable modules. <br/>
						Learn more at:<br/>
						<a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_THIS_ADMIN_URL); ?>/admin.php?page=ewpt-about#userguide"><strong>User Guide</strong></a>  <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_THIS_ADMIN_URL); ?>/admin.php?page=ewpt-about#about-new"><strong>What's New?</strong></a> <a class="ewpt-button-link-text" href="<?php echo esc_url(EWPT_THIS_ADMIN_URL); ?>/admin.php?page=ewpt-about#roadmap"><strong>Road map?</strong></a>
					</p>
				</div>
			</div>
	<?php
		}
	}

    // Function to get module-specific values
    public static function get_module_values($folder_name) {
        // Default MODULE values
        $EWPT_MODULE_NAME_DEFAULT = "Unknown";
        $EWPT_MODULE_DESC_DEFAULT = "null!";
        $EWPT_MODULE_READY_DEFAULT = "null";
        $EWPT_MODULE_SLUG_DEFAULT = esc_attr($folder_name);
        $EWPT_MODULE_VERSION_DEFAULT = "0.0.0";
        $EWPT_MODULE_URL_DEFAULT = esc_url(EWPT_SITE_URL)."modules/";
        $EWPT_MODULE_AUTHOR_DEFAULT = "null";
        $EWPT_MODULE_AUTHOR_URL_DEFAULT = esc_url(EWPT_DEV1_URL);

        // Validate the module before loading
        $module_dir = EWPT_MODULES_PATH . $folder_name . DIRECTORY_SEPARATOR;
        if (!self::validate_module($module_dir, $folder_name)) {
            return array(
                'module_dir'       => $module_dir,
                'folder_name'       => $folder_name,
                'module_name'       => $EWPT_MODULE_NAME_DEFAULT,
                'module_desc'       => 'Invalid module structure',
                'module_ready'      => $EWPT_MODULE_READY_DEFAULT,
                'module_slug'       => $EWPT_MODULE_SLUG_DEFAULT,
                'module_version'    => $EWPT_MODULE_VERSION_DEFAULT,
                'module_url'        => $EWPT_MODULE_URL_DEFAULT,
                'module_author'     => $EWPT_MODULE_AUTHOR_DEFAULT,
                'module_author_url' => $EWPT_MODULE_AUTHOR_URL_DEFAULT,
            );
        }

        // Include the module file to get its variables
        $module_file = $module_dir . '/ewpt-' . $folder_name . '-config.php';
        if (file_exists($module_file)) {
            include($module_file);
        }

        // Check if variables are defined in the module file, otherwise use defaults
        $EWPT_MODULE_NAME       = isset($EWPT_MODULE_NAME) ? $EWPT_MODULE_NAME : ucwords(str_replace('-', ' ', $folder_name));
        $EWPT_MODULE_DESC       = isset($EWPT_MODULE_DESC) ? $EWPT_MODULE_DESC : $EWPT_MODULE_DESC_DEFAULT;
        $EWPT_MODULE_READY      = isset($EWPT_MODULE_READY) ? $EWPT_MODULE_READY : $EWPT_MODULE_READY_DEFAULT;
        $EWPT_MODULE_SLUG       = isset($EWPT_MODULE_SLUG) ? $EWPT_MODULE_SLUG : $EWPT_MODULE_SLUG_DEFAULT;
        $EWPT_MODULE_VERSION    = isset($EWPT_MODULE_VERSION) ? $EWPT_MODULE_VERSION : $EWPT_MODULE_VERSION_DEFAULT;
        $EWPT_MODULE_URL        = isset($EWPT_MODULE_URL) ? $EWPT_MODULE_URL : $EWPT_MODULE_URL_DEFAULT;
        $EWPT_MODULE_AUTHOR     = isset($EWPT_MODULE_AUTHOR) ? $EWPT_MODULE_AUTHOR : $EWPT_MODULE_AUTHOR_DEFAULT;
        $EWPT_MODULE_AUTHOR_URL = isset($EWPT_MODULE_AUTHOR_URL) ? $EWPT_MODULE_AUTHOR_URL : $EWPT_MODULE_AUTHOR_URL_DEFAULT;

        return array(
            'module_dir'       => $module_dir,
            'folder_name'       => $folder_name,
            'module_name'       => $EWPT_MODULE_NAME,
            'module_desc'       => $EWPT_MODULE_DESC,
            'module_ready'      => $EWPT_MODULE_READY,
            'module_slug'       => $EWPT_MODULE_SLUG,
            'module_version'    => $EWPT_MODULE_VERSION,
            'module_url'        => $EWPT_MODULE_URL,
            'module_author'     => $EWPT_MODULE_AUTHOR,
            'module_author_url' => $EWPT_MODULE_AUTHOR_URL,
        );
    }

    // Function to generate table content for all modules
    public static function generate_modules_table() {
        $module_counter = 0;
        foreach (EWPT_MODULES_FOLDERS_ARRAY as $module_folder) {
            $folder_name = basename($module_folder);
            $option_name = "ewpt_enable_" . str_replace('-', '_', $folder_name);
			// Validate the module before loading
			$module_dir = EWPT_MODULES_PATH . $folder_name . DIRECTORY_SEPARATOR;
			if (self::validate_module($module_dir, $folder_name)) {
				$module_counter++;
				$module_values = self::get_module_values($folder_name);

				if ($module_values['module_ready'] == "Production") {
					$module_ready_class = "ewpt-info-green";
				} elseif ($module_values['module_ready'] == "Development") {
					$module_ready_class = "ewpt-info-red";
				} else {
					$module_ready_class = "ewpt-info-blue";
				}
			?>
				<tr valign="top">
					<td><?php echo esc_attr($module_counter); ?></td>
					<td>
						<a class="ewpt-module-name" target="_blank" href="<?php echo esc_url($module_values['module_url']); ?>"><?php echo esc_attr($module_values['module_name']); ?></a><br/>
						&#x1f5cd; v<?php echo esc_attr($module_values['module_version']); ?><br/>
						by <a title="Author: <?php echo esc_attr($module_values['module_author']); ?>" class="ewpt-module-author" target="_blank" href="<?php echo esc_url($module_values['module_author_url']); ?>"><?php echo esc_attr($module_values['module_author']); ?></a>
					</td>
					<td>
						<label>
							<input type="checkbox" name="<?php echo esc_attr($option_name); ?>" value="1" <?php checked(get_option($option_name, 0)); ?> />
							Enable
						</label>
						<?php if (get_option($option_name) == 1) { ?>
							<p>
								<a class="settingsModuleButton" title="<?php echo esc_attr($module_values['module_name'] . ' Settings'); ?>" href="<?php echo esc_attr(EWPT_DASH_SHORT_URL . '-' . $module_values['module_slug']); ?>">
									<icon>&#9881;</icon> 
									<text>Settings</text>
								</a>
							</p>
						<?php } else { ?>
							<p>
								<a class="deleteModuleButton" title="<?php echo esc_attr('Delete ' . $module_values['module_name']); ?>" module="<?php echo esc_attr($module_values['module_slug']); ?>">
									<icon>&#x1f5d1;</icon> 
									<text>Delete</text>
								</a>
							</p>
						<?php } ?>
					</td>
					<td>
						<div class='<?php echo sanitize_html_class($module_ready_class); ?>'>
							<?php echo esc_attr($module_values['module_ready']); ?>
						</div>
					</td>
					<td class="admin-module-desc">
						<div class='ewpt-info-blue'>
							<?php echo esc_attr($module_values['module_desc']); ?>
						</div>
					</td>
				</tr>
			<?php
			}
		}
    }

	// Helper function to validate the module structure
	public static function validate_module($module_dir, $module_name) {
		$required_files = array(
			"ewpt-{$module_name}.php",
			"ewpt-{$module_name}-config.php",
			"ewpt-{$module_name}-functions.php",
			"ewpt-{$module_name}-hooks.php"
		);

		foreach ($required_files as $required_file) {
			if (!file_exists($module_dir . DIRECTORY_SEPARATOR . $required_file)) {
				return false;
			}
		}

		return true;
	}

	// Helper function to handle file unzip using WordPress Filesystem API
	public static function handle_file_unzip($file_path) {
		global $wp_filesystem;

		// Initialize the WordPress filesystem
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			// Check if WP_ADMIN_DIR is defined
			if (defined('WP_ADMIN_DIR')) {
				require_once ABSPATH . WP_ADMIN_DIR . '/includes/file.php';
			} else {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
		}
		WP_Filesystem();

		$unzip_dir = EWPT_MODULES_PATH . DIRECTORY_SEPARATOR . 'temp_unzip';
		 // Delete temp_unzip directory if exist.
		if (is_dir($unzip_dir)) {
			self::delete_module_dir($unzip_dir);
		}
		// Create new temp_unzip directory.
		wp_mkdir_p($unzip_dir);

		// Set permissions for the unzip directory
		if (!$wp_filesystem->chmod($unzip_dir, 0755)) {
			self::delete_module_dir($unzip_dir);
			wp_send_json_error(array('message' => '<strong>Failed to set permissions on the unzip directory.</strong>'));
			exit;
		}

		// Use unzip_file() for unzipping the file
		$unzip_result = unzip_file($file_path, $unzip_dir);
		
		// Check if the module zip file exists and delete
		if ( ! $wp_filesystem->exists($file_path) ) {
			error_log('EWPT: Module zip file does not exist: ' . $file_path);
		} else {
			// Try to delete the uploaded module zip file
			if ( ! $wp_filesystem->delete($file_path) ) {
				error_log('EWPT: Failed to delete module zip file: ' . $file_path);
			} else {
				error_log('EWPT: Module zip file deleted successfully: ' . $file_path);
			}
		}


		if (is_wp_error($unzip_result)) {
			return $unzip_result;
		}

		// Set permissions for the files inside the unzip directory
		$file_list = scandir($unzip_dir);
		foreach ($file_list as $file) {
			$file_path = $unzip_dir . DIRECTORY_SEPARATOR . $file;
			if (is_file($file_path)) {
				if (!$wp_filesystem->chmod($file_path, 0644)) {
					self::delete_module_dir($unzip_dir);
					wp_send_json_error(array('message' => '<strong>Failed to set permissions on the files inside the unzip directory.</strong>'));
					exit;
				}
			}
		}

		$module_folder = scandir($unzip_dir);
		$module_folder = array_diff($module_folder, array('..', '.'));

		if (count($module_folder) !== 1 || !is_dir($unzip_dir . DIRECTORY_SEPARATOR . reset($module_folder))) {
			self::delete_module_dir($unzip_dir);
			wp_send_json_error(array('message' => '<strong>Module directory does not exist or multiple directories found.</strong>'));
			exit;
		}

		return array('module_name' => reset($module_folder), 'unzip_dir' => $unzip_dir);
	}

	// Helper function to delete a directory recursively
	public static function delete_module_dir($dir) {
		global $wp_filesystem;

		// Initialize the WordPress filesystem
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			// Check if WP_ADMIN_DIR is defined
			if (defined('WP_ADMIN_DIR')) {
				require_once ABSPATH . WP_ADMIN_DIR . '/includes/file.php';
			} else {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
		}
		WP_Filesystem();

		if ( ! $wp_filesystem->exists( $dir ) ) {
			return true;
		}

		if ( ! $wp_filesystem->is_dir( $dir ) ) {
			return $wp_filesystem->delete( $dir );
		}

		$file_list = $wp_filesystem->dirlist( $dir );
		foreach ( $file_list as $item => $itemdata ) {
			if ( ! self::delete_module_dir( trailingslashit( $dir ) . $item ) ) {
				return false;
			}
		}

		return $wp_filesystem->rmdir( $dir );
	}

}