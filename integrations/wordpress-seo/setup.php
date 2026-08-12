<?php

namespace Helsinki\WordPress\Site\Core\Integrations\WordPressSeo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @since 5.3.0
 */
function is_yoast_seo_active(): bool {
	return (bool) \did_action( 'wpseo_loaded' );
}

/**
 * Disable AI features
 * Inspired by https://wordpress.org/plugins/disable-ai/
 *
 * @since 5.3.0
 */
\add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\disable_ai' );
function disable_ai(): void {
	if ( is_yoast_seo_active() ) {
		\add_filter( 'option_wpseo', __NAMESPACE__ . '\\disable_ai_generator', 10, 1 );
		\add_filter( 'get_user_metadata', __NAMESPACE__ . '\\revoke_ai_consent', 10, 5 );
		\add_filter( 'wpseo_introductions', __NAMESPACE__ . '\\hide_ai_upsell_modals', 15, 1 );
		\add_action( 'admin_print_styles', __NAMESPACE__ . '\\hide_ai_user_preferences' );
		\add_action( 'admin_bar_menu', __NAMESPACE__ . '\\remove_admin_bar_menu_items', 999 );
		\add_action( 'admin_menu', __NAMESPACE__ . '\\remove_admin_sidebar_menu_items', 10 );

		\add_filter( 'wpseo_title', __NAMESPACE__ . '\\provide_search_meta_title', 9999, 1 );
	}
}


function disable_ai_generator( $options ) {
	$options['enable_ai_generator'] = false;

	return $options;
}

function revoke_ai_consent( $value, $object_id, $meta_key, $single, $meta_type ) {
	return ( 'user' === $meta_type && '_yoast_wpseo_ai_consent' === $meta_key )
		? false
		: $value;
}

function hide_ai_user_preferences(): void {
	$screen = \get_current_screen();

	if ( $screen && 'profile' === $screen?->id ) {
		echo "<style>.yoast.yoast-settings:has( #ai-generator-consent ) {display: none;}</style>";
	}
}

function hide_ai_upsell_modals( array $introductions ): array {
	return array_filter(
		$introductions,
		function( $obj ) {
			return false === strpos( $obj->get_id(), 'ai-' );
		}
	);
}

function remove_admin_bar_menu_items( \WP_Admin_Bar $wp_admin_bar ): void {
	$wp_admin_bar->remove_menu( 'wpseo_brand_insights' );
	$wp_admin_bar->remove_menu( 'wpseo_brand_insights_premium' );

	// Older Yoast 26.3 menu location
	$wp_admin_bar->remove_menu( 'wpseo-brand-insights' );
	$wp_admin_bar->remove_menu( 'wpseo-brand-insights-premium' );
}

function remove_admin_sidebar_menu_items(): void {
	\remove_submenu_page( 'wpseo_dashboard', 'wpseo_brand_insights_premium' );
	\remove_submenu_page( 'wpseo_dashboard', 'wpseo_brand_insights' );
}

/**
 * Search meta title filtering
 *
 * @since 2.0.0
 */
function provide_search_meta_title( string $title ): string {
	return \is_search()
		? \apply_filters( 'helsinki_site_core_search_meta_title', $title )
		: $title;
}
