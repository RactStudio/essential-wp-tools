<?php
// essential-wp-tools/modules/social-share-hub/ewpt-social-share-hub-functions.php

// Define namespace
namespace sshub;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class sshub {
	
    protected static $social_share_hub_buttons_url_array = NULL;
    protected static $social_share_hub_selected_buttons = NULL;
    protected static $social_share_hub_output_content = NULL;

    public static function social_share_hub_buttons_url_array() {
        if (is_null(self::$social_share_hub_buttons_url_array)) {
            self::$social_share_hub_buttons_url_array = array();
            global $post;
			
			if ( is_home() || is_front_page() || is_page() || is_archive() || is_search() ) {
				$ssh_current_name = is_home() || is_front_page() ? get_bloginfo( 'name' ) : rtrim( wp_title( '', false, 'right' ) );
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
				$ssh_current_url = esc_url($protocol . sanitize_text_field($_SERVER['HTTP_HOST']) . sanitize_text_field($_SERVER['REQUEST_URI']));
				$ssh_current_thumb = has_post_thumbnail() ? wp_get_attachment_url( get_post_thumbnail_id( get_the_ID(), '' ) ) : "";
			} elseif ( isset( $post ) ) {
				$ssh_current_name = html_entity_decode( wp_strip_all_tags( get_the_title( get_the_ID() ) ), ENT_QUOTES, 'UTF-8' );
				$ssh_current_url = esc_url(get_permalink( get_the_ID() ));
				$ssh_current_thumb = has_post_thumbnail() ? wp_get_attachment_url( get_post_thumbnail_id( get_the_ID(), '' ) ) : "";
			} else {
				$ssh_current_name = '';
				$ssh_current_url = '';
				$ssh_current_thumb = '';
			}
			
			self::$social_share_hub_buttons_url_array = array(
				'amazon'						=> "https://www.amazon.com/gp/wishlist/static-share?text={$ssh_current_name}&url={$ssh_current_url}",
				//'aol_email'						=> "https://mail.aol.com/webmail-std/en-us/suite?subject={$ssh_current_name}&body={$ssh_current_url}",
				'blogger'							=> "https://www.blogger.com/blog-this.g?u={$ssh_current_url}&n={$ssh_current_name}",
				'buffer'							=> "https://buffer.com/add?url={$ssh_current_url}&text={$ssh_current_name}",
				'copy_link'						=> "{$ssh_current_url}",
				//'digg'								=> "https://digg.com/submit?url={$ssh_current_url}",
				'diigo'								=> "https://www.diigo.com/post?url={$ssh_current_url}&title={$ssh_current_name}",
				//'douban'							=> "https://www.douban.com/share/service?href={$ssh_current_url}&name={$ssh_current_name}",
				'draugiem'						=> "https://www.draugiem.lv/say/ext/add.php?url={$ssh_current_url}&title={$ssh_current_name}",
				'email'								=> "mailto:?subject={$ssh_current_name}&body={$ssh_current_name} {$ssh_current_url}",
				'evernote'						=> "https://www.evernote.com/clip.action?url={$ssh_current_url}&title={$ssh_current_name}",
				'facebook'						=> "https://www.facebook.com/sharer/sharer.php?u={$ssh_current_url}",
				'fark'								=> "https://www.fark.com/farkit?u={$ssh_current_url}&h={$ssh_current_name}",
				'flipboard'						=> "https://share.flipboard.com/bookmarklet/popout?v=2&title={$ssh_current_name}&url={$ssh_current_url}",
				'folkd'								=> "http://www.folkd.com/submit/{$ssh_current_url}",
				'gmail'								=> "https://mail.google.com/mail/?view=cm&fs=1&to&su={$ssh_current_name}&body={$ssh_current_name}%20-%20{$ssh_current_url}",
				'google_translate'			=> "https://translate.google.com/translate?sl=auto&tl=en&u={$ssh_current_url}",
				'google_classroom'		=> "https://classroom.google.com/share?url={$ssh_current_url}&title={$ssh_current_name}",
				'hacker_news'				=> "https://news.ycombinator.com/submitlink?u={$ssh_current_url}&t={$ssh_current_name}",
				'hatena'							=> "https://b.hatena.ne.jp/add?mode=confirm&url={$ssh_current_url}",
				//'instagram'						=> "https://www.instagram.com/",
				'instapaper'					=> "https://www.instapaper.com/edit?url={$ssh_current_url}&title={$ssh_current_name}",
				'kindle'							=> "https://www.amazon.com/sendtokindle?url={$ssh_current_url}",
				'line'								=> "https://timeline.line.me/social-plugin/share?url={$ssh_current_url}&title={$ssh_current_name}",
				'linkedin'						=> "https://www.linkedin.com/sharing/share-offsite/?url={$ssh_current_url}",
				'livejournal'					=> "https://www.livejournal.com/update.bml?subject={$ssh_current_name}&event={$ssh_current_url}",
				'mail_ru'						=> "https://connect.mail.ru/share?url={$ssh_current_url}&title={$ssh_current_name}",
				//'mastodon'						=> "https://share.mastodon.social/?url={$ssh_current_url}",
				//'messenger'					=> "fb-messenger://share/?link=".urlencode($ssh_current_url),
				'mewe'							=> "https://mewe.com/share?url={$ssh_current_url}&title={$ssh_current_name}",
				'mix'								=> "https://mix.com/add?url={$ssh_current_url}&description={$ssh_current_name}",
				//'mixi'								=> "https://mixi.jp/simplepost/simplepost.mv?title={$ssh_current_name}&url={$ssh_current_url}",
				'myspace'						=> "https://myspace.com/post?u={$ssh_current_url}&t={$ssh_current_name}",
				//'ok'									=> "https://connect.ok.ru/dk?st.cmd=addShare&st.s=1&st._surl={$ssh_current_url}&title={$ssh_current_name}",
				'outlook'							=> "https://outlook.live.com/owa/?body={$ssh_current_url}&subject={$ssh_current_name}",
				'pinboard'						=> "https://pinboard.in/popup_login/?url={$ssh_current_url}&title={$ssh_current_name}",
				'pinterest'						=> "https://www.pinterest.com/pin/create/button/?url={$ssh_current_url}&media={$ssh_current_thumb}&description={$ssh_current_name}",
				'pocket'							=> "https://getpocket.com/edit?url={$ssh_current_url}",
				'print'								=> "javascript:window.print();",
				'printfriendly'				=> "https://www.printfriendly.com/print?url={$ssh_current_url}",
				'qzone'							=> "https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={$ssh_current_url}",
				'raindrop'						=> "https://raindrop.io/bookmarklet?url={$ssh_current_url}&title={$ssh_current_name}",
				'reddit'							=> "https://www.reddit.com/submit?url={$ssh_current_url}&title={$ssh_current_name}",
				'skype'							=> "https://web.skype.com/share?url={$ssh_current_url}",
				'slack'								=> "https://slack.com/intl/en-in/help/articles/204399343-Send-a-messhge-to-Slack#how-to-share-a-link",
				'slashdot'						=> "https://slashdot.org/bookmark.pl?url={$ssh_current_url}&title={$ssh_current_name}",
				'sms'								=> "sms:?&body={$ssh_current_name}%20-%20{$ssh_current_url}",
				//'snapchat'						=> "https://www.snapchat.com/add/{$ssh_current_url}",
				//'symbaloo'						=> "https://www.symbaloo.com/symbalooadd?url={$ssh_current_url}&title={$ssh_current_name}",
				'teams'							=> "https://teams.microsoft.com/share?&url={$ssh_current_url}&title={$ssh_current_name}",
				'telegram'						=> "https://telegram.me/share/url?url={$ssh_current_url}&text={$ssh_current_name}",
				'threema'						=> "https://threema.id/compose?text={$ssh_current_name}%20-%20{$ssh_current_url}",
				//'threads'							=> "https://threads.com/add-card?url={$ssh_current_url}&name={$ssh_current_name}",
				'trello'								=> "https://trello.com/add-card?url={$ssh_current_url}&name={$ssh_current_name}",
				'tumblr'							=> "https://www.tumblr.com/widgets/share/tool?canonicalUrl={$ssh_current_url}&title={$ssh_current_name}",
				'twitter'							=> "https://twitter.com/intent/tweet?url={$ssh_current_url}&text={$ssh_current_name}",
				'viber'								=> "viber://forward?text={$ssh_current_name} {$ssh_current_url}",
				//'vk'									=> "http://vk.com/share.php?url={$ssh_current_url}",
				//'wechat'							=> "https://web.wechat.com/",
				'weibo'							=> "http://service.weibo.com/share/share.php?url={$ssh_current_url}&title={$ssh_current_name}",
				'whatsapp'						=> "https://api.whatsapp.com/send?text={$ssh_current_name}%20-%20{$ssh_current_url}",
				'wordpress'					=> "https://wordpress.com/wp-admin/press-this.php?u={$ssh_current_url}&t={$ssh_current_name}",
				'x'									=> "https://x.com/share?url={$ssh_current_url}&text={$ssh_current_name}",
				'xing'								=> "https://www.xing.com/app/user?op=share&url={$ssh_current_url}",
				'yahoo_mail'					=> "https://compose.mail.yahoo.com/?to=&subject={$ssh_current_name}&body={$ssh_current_url}",
			);

        }
        return self::$social_share_hub_buttons_url_array;
    }
	
    public static function social_share_hub_selected_buttons($ssh_number) {
		$social_share_hub_selected_buttons = '';
		
		// Retrieve options outside the loop
		$ssh_icons_sizes = intval(get_option("share_buttons_{$ssh_number}_icons_sizes", '40'));
		$ssh_icons_border_radius = intval(get_option("share_buttons_{$ssh_number}_icons_border_radius", '12'));
		$ssh_design_template = wp_kses_post(get_option("share_buttons_{$ssh_number}_design_template", 'ssh_design_1_color'));
		$button_images_dir = plugin_dir_url(__FILE__) . 'templates/' . str_replace('_', '-', $ssh_design_template) . '/';
		$ssh_selected_buttons = (array)get_option("share_buttons_{$ssh_number}_selected_buttons");
		$button_html = array();

		// Retrieve the social share buttons URL array
		$social_share_hub_buttons_url_array = self::social_share_hub_buttons_url_array();
		
		// Loop through selected buttons and construct HTML
		foreach ($ssh_selected_buttons as $button_name) {
			$site_name = str_replace("ssh_{$ssh_number}_", '', $button_name);
			if (!empty($site_name) && isset($social_share_hub_buttons_url_array[strtolower($site_name)])) {
				$site_url = $social_share_hub_buttons_url_array[strtolower($site_name)];
				$image_url = $button_images_dir . str_replace('-', '_', $site_name) . '.png';
				$site_name = str_replace('_', ' ', $site_name);

				if ($site_name === 'print') {
					// Handle special case for print button
					$button_html[] = '<a id="ssh-icon-' . esc_attr(str_replace(' ', '-', $site_name)) . '" class="ssh-tooltip ssh-icon-' . esc_attr(str_replace(' ', '-', $site_name)) . '" rel="nofollow noopener" style="border-radius:' . $ssh_icons_border_radius . 'px;"><span class="tooltiptext" style="border-radius:'. $ssh_icons_border_radius .'px;">' . esc_attr(ucfirst($site_name)) . '</span><div style="border-radius:'. $ssh_icons_border_radius .'px;width:' . $ssh_icons_sizes .'px;height:' . $ssh_icons_sizes .'px;"></div><img style="border-radius:' . $ssh_icons_border_radius . 'px;width:' . $ssh_icons_sizes . 'px;height:' . $ssh_icons_sizes . 'px;" src="' . esc_url($image_url) . '" alt="' . esc_attr(ucfirst($site_name)) . '"></img></a>';
				} elseif ($site_name === 'copy link') {
					// Handle special case for copy link button
					$button_html[] = '<a data-url="' . $site_url . '" id="ssh-icon-' . esc_attr(str_replace(' ', '-', $site_name)) . '" class="ssh-tooltip ssh-icon-' . esc_attr(str_replace(' ', '-', $site_name)) . '" rel="nofollow noopener" style="border-radius:' . $ssh_icons_border_radius . 'px;"><span class="tooltiptext" style="border-radius:'. $ssh_icons_border_radius .'px;">' . esc_attr(ucfirst($site_name)) . '</span><div style="border-radius:'. $ssh_icons_border_radius .'px;width:' . $ssh_icons_sizes .'px;height:' . $ssh_icons_sizes .'px;"></div><img style="border-radius:' . $ssh_icons_border_radius . 'px;width:' . $ssh_icons_sizes . 'px;height:' . $ssh_icons_sizes . 'px;" src="' . esc_url($image_url) . '" alt="' . esc_attr(ucfirst($site_name)) . '"></img></a>';
				} else {
					// Handle regular buttons
					$button_html[] = '<a id="ssh-icon-' . esc_attr(str_replace(' ', '-', $site_name)) . '" class="ssh-tooltip ssh-icon-' . esc_attr(str_replace(' ', '-', $site_name)) . '" href="' . esc_url($site_url) . '" rel="nofollow noopener" style="border-radius:' . $ssh_icons_border_radius . 'px;" target="_blank"><span class="tooltiptext" style="border-radius:'. $ssh_icons_border_radius .'px;">' . esc_attr(ucfirst($site_name)) . '</span><div style="border-radius:'. $ssh_icons_border_radius .'px;width:' . $ssh_icons_sizes .'px;height:' . $ssh_icons_sizes .'px;"></div><img style="border-radius:' . $ssh_icons_border_radius . 'px;width:' . $ssh_icons_sizes . 'px;height:' . $ssh_icons_sizes . 'px;" src="' . esc_url($image_url) . '" alt="' . esc_attr(ucfirst($site_name)) . '"></img></a>';
				}
			}
		}
		
		// Convert the array of button HTML to a string
		$social_share_hub_selected_buttons = implode('', $button_html);
		
		return $social_share_hub_selected_buttons;
	}
	
	public static function social_share_hub_output_content($content, $ssh_number) {
		$social_share_hub_output_content = wp_kses_post($content);
		
		// Sanitize content before processing
		$content = wp_kses_post($content);
		
		$ssh_design_type = get_option("share_buttons_{$ssh_number}_design_template", 'ssh_design_1_color');
		$design_type_parts = explode('_', $ssh_design_type);
		$ssh_design_type = wp_kses(end($design_type_parts), array());
		$ssh_design_template = sshub::social_share_hub_selected_buttons($ssh_number);
		$ssh_placement_position = get_option("share_buttons_{$ssh_number}_placement_position", 'above_below_position');
		$ssh_css_style_status = get_option("share_buttons_{$ssh_number}_css_style");
		
		// CSS Style
		if ($ssh_css_style_status == 1) {
			$ssh_padding = get_option("share_buttons_{$ssh_number}_padding");
			if (!empty($ssh_padding)) {
				$ssh_padding = 'padding:'.$ssh_padding.'px '.$ssh_padding.'px '.round($ssh_padding/3).'px '.$ssh_padding.'px ;';
			} else {
				$ssh_padding = '';
			}
			$ssh_text_align = get_option("share_buttons_{$ssh_number}_alignment");
			if (!empty($ssh_text_align)) {
				$ssh_text_align = 'text-align:'.$ssh_text_align.';';
			} else {
				$ssh_text_align = '';
			}
			$ssh_background_color = get_option("share_buttons_{$ssh_number}_background_color");
			if (!empty($ssh_background_color)) {
				$ssh_background_color = 'background-color:'.sshub::ssh_rgba_to_hex($ssh_background_color).';';
			} else {
				$ssh_background_color = '';
			}
			$ssh_border_color = get_option("share_buttons_{$ssh_number}_border_color");
			if (!empty($ssh_border_color)) {
				$ssh_border_color = 'border:1px solid:'.sshub::ssh_rgba_to_hex($ssh_border_color).';';
			} else {
				$ssh_border_color = '';
			}
			$ssh_border_radius = intval(get_option("share_buttons_{$ssh_number}_border_radius"));
			if (!empty($ssh_border_radius)) {
				$ssh_border_radius = 'border-radius:'.$ssh_border_radius.'px;';
			} else {
				$ssh_border_radius = '';
			}
			$ssh_css_style = $ssh_padding.$ssh_border_color.$ssh_border_radius.$ssh_background_color.$ssh_text_align;
		} else {
			$ssh_css_style = '';
		}
		$ssh_design_template_with_style = '<div style="' . $ssh_css_style . '" class="ewpt-ssh ' . $ssh_design_type . ' ewpt-ssh-' . $ssh_number . '">'. $ssh_design_template . '</div>';
		
		// Apply filter to the_content
		if ($ssh_placement_position == 'above_position') {
			// Insert above the content
			$social_share_hub_output_content = $ssh_design_template_with_style . $content;
		} elseif ($ssh_placement_position == 'above_below_position') {
			// Insert below and above the content
			$social_share_hub_output_content = $ssh_design_template_with_style . $content . $ssh_design_template_with_style;
		} elseif ($ssh_placement_position == 'below_position') {
			// Insert below the content
			$social_share_hub_output_content = $content . $ssh_design_template_with_style;
		}
		
		return $social_share_hub_output_content;
	}
		
	public static function ssh_rgba_to_hex($rgba) {
		// Define the regex pattern to match RGBA values
		$pattern = "/\\((\\d{1,3}),\\s*(\\d{1,3}),\\s*(\\d{1,3}),?\\s*([01]?\\.\\d+)?\\)/";

		// Match RGBA values using regex
		preg_match($pattern, $rgba, $matches);

		// Check if rgba format matches
		if (!empty($matches)) {
			// Extract RGBA components from regex matches
			$red = $matches[1];
			$green = $matches[2];
			$blue = $matches[3];
			$alpha = isset($matches[4]) ? $matches[4] * 255 : 255; // If alpha is not provided, default to 1 (255 in hex)

			// Convert RGBA to hexadecimal format with or without alpha channel
			if ($alpha < 255) {
				// With alpha channel
				$hex = sprintf("#%02X%02X%02X%02X", $red, $green, $blue, $alpha);
			} else {
				// Without alpha channel
				$hex = sprintf("#%02X%02X%02X", $red, $green, $blue);
			}

			// Return the converted hexadecimal color
			return $hex;
		} else {
			// If rgba format does not match, return the input value as is
			return $rgba;
		}
	}

	
}