<?php

namespace Helsinki\WordPress\Site\Core\Admin\Notices;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_action( 'admin_menu', __NAMESPACE__ . '\\hide_wp_update_nag' );

	add_filter( 'admin_footer_text', '__return_empty_string', 11 );
	add_filter( 'update_footer', '__return_empty_string', 11 );
}

/**
  * Updates
  */
function hide_wp_update_nag(): void {
	remove_action( 'admin_notices', 'update_nag', 3 );
}
