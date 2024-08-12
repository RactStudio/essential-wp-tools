<?php
// enable-posts-sort-order.php

// Sort Frontend Posts by DESC / ASC and set orderby
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action( 'pre_get_posts', function ( $query ) {
	//Is Blog Home (posts)
	$home_status = get_option("et_posts_sort_home_status", 0);
	if( $home_status == 1 && $query->is_main_query() && ($query->is_home() || $query->is_front_page() ) ) {
		$home_orderby = get_option("enable_posts_sort_home_orderby", "date");
		$home_order = get_option("enable_posts_sort_home_order");
		$query->set( 'orderby', $home_orderby );
		$query->set( 'order', $home_order );
	}
	//Is Archive (all types including Custom Posts Types)
	$archive_status = get_option("et_posts_sort_archive_status", 0);
	if( $archive_status == 1 && $query->is_main_query() && $query->is_archive() && ( !$query->is_category() || !$query->is_tag() || !$query->is_search() || !$query->is_home() || !$query->is_front_page() ) ) {
		$archive_orderby = get_option("enable_posts_sort_archive_orderby", "date");
		$archive_order = get_option("enable_posts_sort_archive_order");
		$query->set( 'orderby', $archive_orderby );
		$query->set( 'order', $archive_order );
	}
	//Is Category
	$category_status = get_option("et_posts_sort_category_status", 0);
	if( $category_status == 1 && $query->is_main_query() && $query->is_category() ) {
		$category_orderby = get_option("enable_posts_sort_category_orderby", "date");
		$category_order = get_option("enable_posts_sort_category_order");
		$query->set( 'orderby', $category_orderby );
		$query->set( 'order', $category_order );
	}
	//Is Tag
	$tag_status = get_option("et_posts_sort_tag_status", 0);
	if( $tag_status == 1 && $query->is_main_query() && $query->is_tag() ) {
		$tag_orderby = get_option("enable_posts_sort_tag_orderby", "date");
		$tag_order = get_option("enable_posts_sort_tag_order");
		$query->set( 'orderby', $tag_orderby );
		$query->set( 'order', $tag_order );
	}
	//Is Search
	$search_status = get_option("et_posts_sort_search_status", 0);
	if( $search_status == 1 && $query->is_main_query() && $query->is_search() ) {
		$search_orderby = get_option("enable_posts_sort_search_orderby", "relevance");
		$search_order = get_option("enable_posts_sort_search_order");
		$query->set( 'orderby', $search_orderby );
		$query->set( 'order', $search_order );
	}
});