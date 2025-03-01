<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Configuration
  */
function menu_page_required_capability(): string {
	return 'manage_options';
}

function menu_page_slug(): string {
	return 'helsinki-site-core-matomo';
}

function menu_page_url(): string {
	return \add_query_arg( array(
			'page' => menu_page_slug(),
		), \admin_url( 'options-general.php' )
	);
}

/**
  * Register
  */
function register_menu_page(): string {
	$prefix = \add_submenu_page(
		'options-general.php',
		__( 'Helsinki Matomo', 'helsinki-site-core' ),
		__( 'Helsinki Matomo', 'helsinki-site-core' ),
		menu_page_required_capability(),
		menu_page_slug(),
		__NAMESPACE__ . '\\render_menu_page',
		85
	);

	return $prefix ?: '';
}

/**
  * Render
  */
function render_menu_page(): void {
	\do_action( 'helsinki_site_core_matomo_admin_page' );
}

/**
  * Templates & parts
  */
function menu_page_layout(): void {
	require_once \apply_filters(
		'helsinki_site_core_path_to_php_file',
		array( 'integrations', 'matomo', 'templates', 'layout' )
	);
}

function menu_page_title(): void {
	printf( '<h1>%s</h1>', \esc_html( get_admin_page_title() ) );
}
