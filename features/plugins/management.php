<?php

namespace Helsinki\WordPress\Site\Core\Features\Plugins\Management;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	if ( is_plugin_management_disabled() ) {
		\add_filter(
			'plugin_action_links',
			__NAMESPACE__ . '\\disable_plugin_actions',
			PHP_INT_MAX
		);

		\add_filter(
			'network_admin_plugin_action_links',
			__NAMESPACE__ . '\\disable_plugin_actions',
			PHP_INT_MAX
		);

		\add_filter(
			'bulk_actions-plugins',
			__NAMESPACE__ . '\\disable_plugin_bulk_actions',
			PHP_INT_MAX
		);
	}
}

function is_plugin_management_disabled(): bool {
	$allowed = defined( 'HELSINKI_PLUGIN_MANAGEMENT_ALLOWED' )
		? HELSINKI_PLUGIN_MANAGEMENT_ALLOWED
		: false;

	return (bool) \apply_filters(
		'helsinki_site_core_plugin_management_disabled',
		! $allowed
	);
}

function disable_plugin_actions( array $actions ): array {
	$disallowed = (array) \apply_filters(
		'helsinki_site_core_disallowed_plugin_actions',
		array(
			'deactivate' => '',
			'activate' => '',
			'network_active' => '',
			'network_only' => '',
		)
	);

	return array_diff_key( $actions, $disallowed );
}

function disable_plugin_bulk_actions( array $actions ): array {
	$disallowed = (array) \apply_filters(
		'helsinki_site_core_disallowed_plugin_bulk_actions',
		array(
			'activate-selected' => '',
			'deactivate-selected' => '',
		)
	);

	return array_diff_key( $actions, $disallowed );
}
