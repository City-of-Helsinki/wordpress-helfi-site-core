<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Polylang;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_init', __NAMESPACE__ . '\\init' );
function init(): void {
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\disable_users_script', 9999 );
}

function polylang_initialized(): bool {
	return did_action( 'pll_init' );
}

function disable_users_script(): void {
	if ( ! polylang_initialized() ) {
		return;
	}

	if ( ! apply_filters( 'helsinki_site_core_is_user_profile_view', false ) ) {
		return;
	}

	wp_dequeue_script( 'pll_user' );
}
