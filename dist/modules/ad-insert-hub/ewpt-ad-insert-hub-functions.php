<?php
// essential-wp-tools/modules/ad-insert-hub/ewpt-ad-insert-hub-functions.php

// Define namespace
namespace adihub;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class adihub {
	
	protected static $ad_insert_hub_output_content = NULL;
	protected static $after_p_content = NULL;
	protected static $after_words_content = NULL;
	
	public static function ad_insert_hub_output_content($content, $ads_number) {
		$ad_insert_hub_output_content = wp_kses_post($content);
		
		// Sanitize content before processing
		$content = wp_kses_post($content);
		
		$ads_user_content = wp_kses_post(get_option("ads_{$ads_number}_user_content", ''));
		$ads_placement_position = get_option("ads_{$ads_number}_placement_position", '');
		$ads_p_user_number = intval(get_option("ads_{$ads_number}_p_user_number", ''));
		$ads_words_user_number = intval(get_option("ads_{$ads_number}_words_user_number", ''));
		$ads_css_style_status = get_option("ads_{$ads_number}_css_style", '');
		
		// Ads CSS Style
		if ($ads_css_style_status == 1) {
			$style_start = '<div style="margin:15px 0px; padding:5px; border:1px solid #D3D3D312; border-radius:5px; background-color:#D3D3D324; text-align:center;" class="ewpt-acode ewpt-acode-' . $ads_number . '">';
			$style_ends = "</div>";
		} else {
			$style_start = '';
			$style_ends = '';
		}
		$ads_user_content_with_style = $style_start . $ads_user_content . $style_ends;
		
		$content_paragraph_count = substr_count($content, '<p>');
		
		// Apply filter to the_content
		if ($ads_placement_position == 'above_position') {
			// Insert ads above the content
			$ad_insert_hub_output_content = $ads_user_content_with_style . $content;
		} elseif ($ads_placement_position == 'above_below_position') {
			// Insert ads below the content
			$ad_insert_hub_output_content = $ads_user_content_with_style . $content . $ads_user_content_with_style;
		} elseif ($ads_placement_position == 'below_position') {
			// Insert ads below the content
			$ad_insert_hub_output_content = $content . $ads_user_content_with_style;
		} elseif ($ads_placement_position == 'after_p_tag' && $content_paragraph_count >= $ads_p_user_number) {
			// Insert ads after specified number of <p> tags
			$ad_insert_hub_output_content = self::ad_insert_hub_after_p_tag($content, $ads_user_content_with_style, $ads_p_user_number);
		} elseif ($ads_placement_position == 'after_words_count' && str_word_count($content) >= $ads_words_user_number) {
			// Insert ads after specified number of words
			$ad_insert_hub_output_content = self::ad_insert_hub_after_words_count($content, $ads_user_content_with_style, $ads_words_user_number);
		}
	
		return $ad_insert_hub_output_content;
	}
	
	public static function ad_insert_hub_after_p_tag($content, $ads_user_content, $p_tag_number) {
		$after_p_content = '';
		
		// Sanitize content before processing
		$content = $content;
		$ads_user_content = $ads_user_content;
		$p_tag_number = $p_tag_number;
			
		$p_tags = preg_split('/<\/p>/', $content);
		$after_p_content = '';
		$count = 0;
		
		foreach ($p_tags as $index => $p_tag) {
			$count++;
			
			$after_p_content .= $p_tag . '</p>';
			
			if ($count == $p_tag_number && isset($p_tags[$index + 1])) {
				$after_p_content .= $ads_user_content;
			}
		}
		
		NULL === self::$after_p_content and self::$after_p_content = new self;
		//return self::$after_p_content;
		return $after_p_content;
	}
	
	public static function ad_insert_hub_after_words_count($content, $ads_user_content, $word_count) {
		$after_words_content = '';
		
		// Sanitize content before processing
		$content = $content;
		$ads_user_content = $ads_user_content;
		$word_count = $word_count;
			
		$words = preg_split('/\s+/', wp_strip_all_tags($content), -1, PREG_SPLIT_NO_EMPTY);
		
		if (is_array($words) && count($words) > $word_count) {
			$insert_position = array_keys($words)[$word_count];
			$content_parts = preg_split('/(<[^>]+>|\s+)/', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
			
			if (isset($content_parts[$insert_position * 2])) {
				$content_parts[$insert_position * 2] .= $ads_user_content;
				$after_words_content = implode('', $content_parts);
			}
		}
		
		NULL === self::$after_words_content and self::$after_words_content = new self;
		//return self::$after_words_content;
		return $after_words_content;
	}
	
}