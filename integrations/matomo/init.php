<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'plugins_loaded', __NAMESPACE__ . '\\setup', 5 );
function setup(): void {
	\add_filter( 'cmplz_integrations', __NAMESPACE__ . '\\provide_cmplz_integration' );
	\add_filter( 'cmplz_integration_path', __NAMESPACE__ . '\\provide_cmplz_integration_path', 10, 2 );
}

\add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init', 11 );
function init(): void {
	\add_action( 'admin_init', __NAMESPACE__ . '\\register_matomo_settings' );
	\add_action( 'admin_menu', __NAMESPACE__ . '\\register_menu_page' );

	\add_action( 'wp_head', __NAMESPACE__ . '\\provide_tracking_script' );

	\add_action( 'update_option_' . settings_group_name(), __NAMESPACE__ . '\\handle_settings_updated', 10, 3 );

	\add_action( 'helsinki_site_core_matomo_admin_page', __NAMESPACE__ . '\\menu_page_layout', 1 );
	\add_action( 'helsinki_site_core_matomo_admin_page_content', __NAMESPACE__ . '\\menu_page_title', 10 );
	\add_action( 'helsinki_site_core_matomo_admin_page_content', __NAMESPACE__ . '\\settings_form', 10 );
}

function cmplz_integration_name(): string {
	return 'helsinki_matomo';
}

function provide_cmplz_integration( array $integrations ): array {
	$integrations[cmplz_integration_name()] = array(
		'constant_or_function' => __NAMESPACE__ . '\\cmplz_integration_name',
		'label'                => __( 'Helsinki Matomo', 'helsinki-site-core' ),
		'firstparty_marketing' => false,
	);

	return $integrations;
}

function provide_cmplz_integration_path( string $path, string $integration ): string {
	if ( cmplz_integration_name() === $integration ) {
		return \apply_filters(
			'helsinki_site_core_path_to_php_file',
			array( 'integrations', 'matomo', 'complianz' )
		);
	}

	return $path;
}
