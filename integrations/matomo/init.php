<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init', 11 );
function init(): void {
	\add_action( 'admin_init', __NAMESPACE__ . '\\register_matomo_settings' );
	\add_action( 'admin_menu', __NAMESPACE__ . '\\register_menu_page' );

	\add_action( 'update_option_' . settings_group_name(), __NAMESPACE__ . '\\handle_settings_updated', 10, 3 );

	\add_action( 'helsinki_site_core_matomo_admin_page', __NAMESPACE__ . '\\menu_page_layout', 1 );
	\add_action( 'helsinki_site_core_matomo_admin_page_content', __NAMESPACE__ . '\\menu_page_title', 10 );
	\add_action( 'helsinki_site_core_matomo_admin_page_content', __NAMESPACE__ . '\\settings_form', 10 );
}
