<?php

namespace Helsinki\WordPress\Site\Admin\Toolbar;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_action( 'wp_before_admin_bar_render', __NAMESPACE__ . '\\remove_links' );
}

/**
  * Links
  */
function remove_links(): void {
	global $wp_admin_bar;

	$remove_items = [
		'wp-logo',
		'about',
		'wporg',
		'documentation',
		'support-forums',
		'feedback',
		'updates',
		'comments',
		// 'customize',
		// 'view-site',
		'search',
	];

	foreach ( $remove_items as $item ) {
		$wp_admin_bar->remove_menu( $item );
	}
}
