<?php

namespace Helsinki\WordPress\Site\Core\Admin\Dashboard;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_action( 'admin_init', __NAMESPACE__ . '\\remove_welcome_panel' );
	add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\\remove_widgets', 9999 );
}


/**
  * Widgets
  */
function remove_welcome_panel(): void {
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
}

function remove_widgets(): void {
	global $wp_meta_boxes;

	// PHP
	remove_meta_box( 'dashboard_php_nag', 'dashboard', 'normal' );

	// Default
	$widgets = array(
		'dashboard_right_now' => true,
		'dashboard_activity' => true,
	);

	foreach ( array( 'normal', 'side' ) as $context ) {
		foreach ( $wp_meta_boxes['dashboard'][$context]['core'] as $name => $data ) {
			if ( ! isset( $widgets[$name] ) ) {
				unset( $wp_meta_boxes['dashboard'][$context]['core'][$name] );
			}
		}
	}
}
