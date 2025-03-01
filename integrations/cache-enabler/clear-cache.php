<?php

namespace Helsinki\WordPress\Site\Core\Integrations\CacheEnabler;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init', 11 );
function init(): void {
	if ( is_cache_enabler_active() ) {
		\add_action( 'helsinki_site_core_cache_clear', __NAMESPACE__ . '\\provide_clear_site_cache' );
	}
}

function is_cache_enabler_active(): bool {
	return defined( 'CACHE_ENABLER_FILE' ) && CACHE_ENABLER_FILE;
}

function provide_clear_site_cache( $site = null ): void {
	do_action( 'cache_enabler_clear_site_cache', $site );
}
