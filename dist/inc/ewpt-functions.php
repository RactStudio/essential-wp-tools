<?php
// essential-wp-tools/inc/ewpt-functions.php

// Define namespace
namespace ewpt;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class ewpt {
	
	
	protected static $rsd_args = NULL;
	
	
	// Method to register settings with various data types and optional custom sanitize callbacks and invalid data messages
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
					return filter_var($value, FILTER_VALIDATE_BOOLEAN);
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
					$date = date_create_from_format('Y-m-d', $value);
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
					$date = date_create_from_format('Y-m-d H:i:s', $value);
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
					$date = date_create_from_format('Y-m-d H:i:s', $value);
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
					'ewpt_'.$menu_callback.'_settings_page_rsmhr',
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
					'ewpt_'.$menu_callback.'_settings_page_rsmhr',
				);
				break;
			case 'hidden_menu':
				add_submenu_page(
					null, // No parent page, hidden menu
					$module_page_title,
					$menu_display_title, // Use the defined display title
					$menu_capability,
					'ewpt-'.$menu_slug,
					'ewpt_'.$menu_callback.'_settings_page_rsmhr',
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
			foreach ($ewpt_active_modules as $module_name => $module_data)
			{ ?>
				<div class="ewpt-column">
					<div class="ewpt-card text-center">
						<a  class="ewpt-module-name" title="<?php echo esc_attr($module_data['module_name'].' Settings'); ?>" href="<?php echo esc_attr(EWPT_DASH_SHORT_URL.'-'.$module_data['module_slug']); ?>"><?php echo esc_attr($module_data['module_name']); ?></a>
						<p><?php echo esc_attr($module_data['module_ready']); ?> v<?php echo esc_attr($module_data['module_version']); ?></p>
					</div>
				</div>
		<?php
			}
		} else
		{ ?>
			<div class="ewpt-column-1">
				<div class="ewpt-card text-center">
					<p  class="ewpt-module-name">
						No active module found!
					</p>
					<p>
						Please, click "<a href="#modules-manager"><strong>Modules Manager</strong></a>" to enable modules. Learn more at "<a href="#user-guide"><strong>User Guide</strong></a>" and "<a href="#whats-next"><strong>What's Next?</strong></a>".	
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
		$EWPT_MODULE_SLUG_DEFAULT = "null";
		$EWPT_MODULE_VERSION_DEFAULT = "0.0.0";
		$EWPT_MODULE_URL_DEFAULT = esc_url(EWPT_SITE_URL)."modules/";
		$EWPT_MODULE_AUTHOR_DEFAULT = "null";
		$EWPT_MODULE_AUTHOR_URL_DEFAULT = esc_url(EWPT_DEV1_URL);
		$module_name = ucwords(str_replace('-', ' ', $folder_name));
		// Include the module file to get its variables
		$module_file = EWPT_MODULES_PATH . $folder_name . '/ewpt-' . $folder_name . '-config.php';
		if (file_exists($module_file)) {
			include($module_file);
		}
		// Check if variables are defined in the module file, otherwise use defaults
		$EWPT_MODULE_NAME			= isset($EWPT_MODULE_NAME) ? $EWPT_MODULE_NAME : $module_name;
		$EWPT_MODULE_DESC				= isset($EWPT_MODULE_DESC) ? $EWPT_MODULE_DESC : $EWPT_MODULE_DESC_DEFAULT;
		$EWPT_MODULE_READY			= isset($EWPT_MODULE_READY) ? $EWPT_MODULE_READY : $EWPT_MODULE_READY_DEFAULT;
		$EWPT_MODULE_SLUG			= isset($EWPT_MODULE_SLUG) ? $EWPT_MODULE_SLUG : $EWPT_MODULE_SLUG_DEFAULT;
		$EWPT_MODULE_VERSION		= isset($EWPT_MODULE_VERSION) ? $EWPT_MODULE_VERSION : $EWPT_MODULE_VERSION_DEFAULT;
		$EWPT_MODULE_URL				= isset($EWPT_MODULE_URL) ? $EWPT_MODULE_URL : $EWPT_MODULE_URL_DEFAULT;
		$EWPT_MODULE_AUTHOR		= isset($EWPT_MODULE_AUTHOR) ? $EWPT_MODULE_AUTHOR : $EWPT_MODULE_AUTHOR_DEFAULT;
		$EWPT_MODULE_AUTHOR_URL	= isset($EWPT_MODULE_AUTHOR_URL) ? $EWPT_MODULE_AUTHOR_URL : $EWPT_MODULE_AUTHOR_URL_DEFAULT;
		
		return array(
			'module_name'			=> $EWPT_MODULE_NAME,
			'module_desc'				=> $EWPT_MODULE_DESC,
			'module_ready'			=> $EWPT_MODULE_READY,
			'module_slug'				=> $EWPT_MODULE_SLUG,
			'module_version'		=> $EWPT_MODULE_VERSION,
			'module_url'				=> $EWPT_MODULE_URL,
			'module_author'			=> $EWPT_MODULE_AUTHOR,
			'module_author_url'	=> $EWPT_MODULE_AUTHOR_URL,
		);
	}
	
	
	// Function to generate table content for all modules
	public static function generate_modules_table() {
		$module_counter = 0;
		foreach (EWPT_MODULES_FOLDERS_ARRAY as $module_folder) {
			$module_counter++;
			$folder_name = basename($module_folder);
			$option_name = "ewpt_disable_" . str_replace('-', '_', $folder_name);
			$module_values = ewpt::get_module_values($folder_name);
			
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
				<a  class="ewpt-module-name" target="_blank" href="<?php echo esc_url($module_values['module_url']); ?>"><?php echo esc_attr($module_values['module_name']); ?></a> v<?php echo esc_attr($module_values['module_version']); ?><br/>
				@<a title="Author: <?php echo esc_attr($module_values['module_author']); ?>"  class="ewpt-module-author" target="_blank" href="<?php echo esc_url($module_values['module_author_url']); ?>"><?php echo esc_attr($module_values['module_author']); ?></a>
			</td>
			<td>
				<label>
					<input type="checkbox" name="<?php echo esc_attr($option_name); ?>" value="1" <?php checked(get_option($option_name), 1); ?> />
					Enable
				</label>
				<?php
					// Check if the option is set to enable the module (1 means enabled)
					if (get_option($option_name) == 1) { ?>
				<p class='text-center'>
					<a title="<?php echo esc_attr($module_values['module_name'].' Settings'); ?>" href="<?php echo esc_attr(EWPT_DASH_SHORT_URL.'-'.$module_values['module_slug']); ?>">Settings</a>
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