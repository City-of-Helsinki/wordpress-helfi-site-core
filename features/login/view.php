<?php

namespace Helsinki\WordPress\Site\Core\Login\View;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_filter( 'login_headerurl', __NAMESPACE__ . '\\custom_login_headerurl' );
	add_filter( 'login_headertext', __NAMESPACE__ . '\\custom_login_headertext', 11 );
	add_filter( 'login_errors', __NAMESPACE__ . '\\generic_errors', 9999 );
	add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\custom_login_styles', 9999 );
}

/**
  * Errors
  */
function generic_errors(): string {
	return sprintf(
		'<strong>%s</strong> %s',
		esc_html_x( 'Login failed.', 'Login error', 'helsinki-site-core' ),
		esc_html_x( 'Please contact your site admin or developer if you continue having problems.', 'Login error', 'helsinki-site-core' ),
	);
}

/**
  * Header
  */
function custom_login_headerurl(): string {
	return home_url();
}

function custom_login_headertext( string $login_header_text ): string {
	return custom_logo_html() ?: get_bloginfo('name');
}

function custom_logo_html(): string {
	$logo_src = wp_get_attachment_image_src( get_theme_mod( 'custom_logo', 0 ) , 'full' );
	if ( ! is_array( $logo_src ) ) {
		return '';
	}

	return sprintf(
		'<img src="%s" alt="%s" width="%s" height="%s">',
		esc_url( $logo_src[0] ),
		esc_attr( get_bloginfo('name') ),
		esc_attr( $logo_src[1] ),
		esc_attr( $logo_src[2] )
	);
}

/**
  * Style
  */
function custom_login_styles(): void {
	$handle = apply_filters( 'helsinki_site_core_plugin_dirname', '' );
	$styles = apply_filters( 'helsinki_site_core_style_url', '' );

	wp_enqueue_style(
		$handle . '-login',
		$styles . 'login.css',
		[],
		apply_filters( 'helsinki_site_core_asset_version', false ),
		'all'
	);
}
