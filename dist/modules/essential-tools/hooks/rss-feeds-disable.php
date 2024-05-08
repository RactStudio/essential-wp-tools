<?php
// essential-wp-tools/modules/general-tools/rss-feeds-disable.php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Replace all feeds with the message.
// Function to disable RSS Feeds.

add_action(
	'init',
	function () {
		
		add_action(
			'do_feed_rdf',
			function () {
				wp_die(
					sprintf(
						esc_attr( 'No feed available!', 'essential-wp-tools' )
					)
				);
			},
			1
		);

		add_action(
			'do_feed_rss',
			function () {
				wp_die(
					sprintf(
						esc_attr( 'No feed available!', 'essential-wp-tools' )
					)
				);
			},
			1
		);

		add_action(
			'do_feed_rss2',
			function () {
				wp_die(
					sprintf(
						esc_attr( 'No feed available!', 'essential-wp-tools' )
					)
				);
			},
			1
		);

		add_action(
			'do_feed_atom',
			function () {
				wp_die(
					sprintf(
						esc_attr( 'No feed available!', 'essential-wp-tools' )
					)
				);
			},
			1
		);

		add_action(
			'do_feed_rss2_comments',
			function () {
				wp_die(
					sprintf(
						esc_attr( 'No feed available!', 'essential-wp-tools' )
					)
				);
			},
			1
		);

		add_action(
			'do_feed_atom_comments',
			function () {
				wp_die(
					sprintf(
						esc_attr( 'No feed available!', 'essential-wp-tools' )
					)
				);
			},
			1
		);
		
		// Remove feed links from the header.
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'feed_links', 2 );
		
	}
);