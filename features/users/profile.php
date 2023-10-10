<?php

namespace Helsinki\WordPress\Site\Core\Users\Profile;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	// Providers
	add_filter( 'helsinki_site_core_is_user_profile_view', __NAMESPACE__ . '\\is_user_profile_view' );

	// Contact methods
	add_filter( 'user_contactmethods', '__return_empty_array', 9999 );

	// User details
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_user_assests', 9999 );

	add_filter( 'pre_user_description', '__return_empty_string', 9999 );
	add_filter( 'pre_user_url', '__return_empty_string', 9999 );

	// Avatar
	add_filter( 'user_profile_picture_description', '__return_empty_string', 9999 );
	add_filter( 'avatar_defaults', '__return_empty_array', 9999 );
	add_filter( 'pre_get_avatar', '__return_empty_string', 9999 );
	add_filter( 'option_show_avatars', '__return_false', 9999 );
}

/**
  * Assets
  */
function enqueue_user_assests(): void {
	if ( ! apply_filters( 'helsinki_site_core_is_user_profile_view', false ) ) {
		return;
	}

	$handle = apply_filters( 'helsinki_site_core_plugin_dirname', '' );
	$scripts = apply_filters( 'helsinki_site_core_script_url', '' );

	wp_enqueue_script(
		$handle . '-user',
		$scripts . 'user.js',
		[],
		apply_filters( 'helsinki_site_core_asset_version', false ),
		'all'
	);
}

/**
  * Conditionals
  */
function is_user_profile_view(): bool {
	$screen = get_current_screen();

	return ! empty( $screen )
		? in_array( $screen->base, ['profile', 'user-edit', 'user'] )
		: false;
}
