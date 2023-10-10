<?php

namespace Helsinki\WordPress\Site\Core\BlockEditor\View;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\disable_editor_fullscreen_by_default' );
}

function disable_editor_fullscreen_by_default(): void {
	if (! is_admin()) {
		return;
	}

	wp_add_inline_script(
		'wp-blocks',
		"jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });"
	);
}
