<?php

namespace Helsinki\WordPress\Site\Core\Integrations\TwoFactor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Two_Factor_Core;
use WP_User;

\add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	\add_filter( 'two_factor_providers', __NAMESPACE__ . '\\allowed_two_factor_providers' );
	\add_filter( 'show_user_profile', __NAMESPACE__ . '\\available_two_factor_providers', 0 );
	\add_action( 'init', __NAMESPACE__ . '\\check_user_two_factor_status' );
}

function allowed_two_factor_providers( array $providers ): array {
	return array_intersect_key( $providers, array(
		two_factor_email_provider() => true,
	) );
}

function available_two_factor_providers(): void {
	\add_filter( 'two_factor_providers_for_user', '__return_empty_array' );
}

function check_user_two_factor_status(): void {
	if ( should_force_enable_two_factor( \wp_get_current_user() ) ) {
		if ( enable_two_factor_provider( \wp_get_current_user() ) ) {
			force_user_to_reauthenticate();
		}
	}
}

function should_force_enable_two_factor( WP_User $user ): bool {
	return \is_user_logged_in()
		&& is_two_factor_active()
		&& ! has_two_factor_enabled( $user );
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
