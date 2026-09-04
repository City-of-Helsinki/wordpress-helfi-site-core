<?php

namespace Helsinki\WordPress\Site\Core\Admin\Connectors;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
    if ( should_disable_connectors_page() ) {
        \add_action( 'admin_init', __NAMESPACE__ . '\\remove_connectors_page' );
        \add_action( 'admin_init', __NAMESPACE__ . '\\redirect_connectors_page' );
    }
}

function should_disable_connectors_page(): bool {
    if ( function_exists( 'wp_supports_ai' ) ) {
        return ! \wp_supports_ai();
    }

    return false;
}

function remove_connectors_page(): void {
    \remove_submenu_page( 'options-general.php', 'options-connectors.php' );
}

function redirect_connectors_page(): void {
	global $pagenow;

	if ( 'options-connectors.php' === $pagenow ) {
		\wp_redirect( \admin_url( '/' ), 301 );
		exit;
	}
}