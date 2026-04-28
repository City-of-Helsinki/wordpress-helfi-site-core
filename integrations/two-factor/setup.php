<?php

namespace Helsinki\WordPress\Site\Core\Integrations\TwoFactor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Two_Factor_Core;
use WP_User;

\add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\loaded' );
function loaded(): void {
	\add_filter( 'two_factor_providers', __NAMESPACE__ . '\\allowed_two_factor_providers' );
	\add_filter( 'show_user_profile', __NAMESPACE__ . '\\available_two_factor_providers', 0 );
	\add_filter( 'edit_user_profile', __NAMESPACE__ . '\\available_two_factor_providers', 0 );
	\add_action( 'user_register', __NAMESPACE__ . '\\setup_user_two_factor' );
	\add_action( 'init', __NAMESPACE__ . '\\check_user_two_factor_status' );
}

\add_action( 'helsinki_site_core_init', __NAMESPACE__ . '\\init' );
function init(): void {
	if ( \is_admin() ) {
		\remove_action( 'admin_menu', 'two_factor_add_settings_page' );
	}
}

function allowed_two_factor_providers( array $providers ): array {
	return array_intersect_key( $providers, array(
		two_factor_email_provider() => true,
	) );
}

function available_two_factor_providers(): void {
	if ( is_two_factor_active() ) {
		\add_filter( 'two_factor_providers_for_user', '__return_empty_array' );

		\remove_action( 'show_user_profile', array( Two_Factor_Core::class, 'user_two_factor_options' ) );
		\remove_action( 'edit_user_profile', array( Two_Factor_Core::class, 'user_two_factor_options' ) );

		\add_action( 'show_user_profile', __NAMESPACE__ . '\\profile_two_factor_options', 9 );
		\add_action( 'edit_user_profile', __NAMESPACE__ . '\\profile_two_factor_options', 9 );
	}
}

function profile_two_factor_options( WP_User $user ): void {
	$providers = Two_Factor_Core::get_providers();
	$email_provider = $providers[two_factor_email_provider()] ?? null;

	if ( $email_provider ) {
		printf(
			'<h2>%s</h2>
			<p><strong>%s</strong>: %s</p>',
			\esc_html( __( 'Two-Factor Authentication', 'helsinki-site-core' ) ),
			\esc_html( __( 'Allowed methods', 'helsinki-site-core' ) ),
			\esc_html( $email_provider->get_label() )
		);
	}
}

function setup_user_two_factor( int $user_id ): void {
	$user = \get_user_by( 'ID', $user_id );

	if (
		$user instanceof WP_User
		&& should_force_enable_two_factor( $user )
	) {
		enable_two_factor_provider( $user );
	}
}

function check_user_two_factor_status(): void {
	if ( should_force_enable_two_factor( \wp_get_current_user() ) ) {
		if ( enable_two_factor_provider( \wp_get_current_user() ) ) {
			force_user_to_reauthenticate();
		}
	}
}

function should_force_enable_two_factor( WP_User $user ): bool {
	$force = $user->exists()
		&& is_two_factor_active()
		&& ! has_two_factor_enabled( $user );

	return \apply_filters(
		'helsinki_site_core_force_enable_two_factor',
		$force,
		$user
	);
}

function force_user_to_reauthenticate(): void {
	\wp_logout();
	\auth_redirect();
}

function has_two_factor_enabled( WP_User $user ): bool {
	$provider = Two_Factor_Core::get_primary_provider_for_user( $user );

	return $provider && two_factor_email_provider() === $provider->get_key();
}

function enable_two_factor_provider( WP_User $user ): bool {
	return Two_Factor_Core::enable_provider_for_user( $user->ID, two_factor_email_provider() );
}

function two_factor_email_provider(): string {
	return 'Two_Factor_Email';
}

function is_two_factor_active(): bool {
	return class_exists( 'Two_Factor_Core' );
}
