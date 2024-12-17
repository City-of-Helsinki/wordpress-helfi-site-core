<?php

namespace Helsinki\WordPress\Site\Core\Integrations\WordPressSeo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_filter( 'wpseo_title', __NAMESPACE__ . '\\provide_search_meta_title', 9999, 1 );
}

function provide_search_meta_title( string $title ): string {
	return is_search() ? apply_filters( 'helsinki_site_core_search_meta_title', $title ) : $title;
}
