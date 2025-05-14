<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	$hooks = create_default_hooks();

	// Disable weak password checkbox
	\add_action( 'login_init', array( $hooks, 'disable_weak_password_checkbox' ) );
	\add_action( 'admin_head', array( $hooks, 'disable_weak_password_checkbox' ) );

	// Display password requirement hints.
	\add_filter( 'password_hint', array( $hooks, 'get_password_hints' ) );
	\add_action( 'show_user_profile', array( $hooks, 'display_password_hints' ) );
	\add_action( 'edit_user_profile', array( $hooks, 'display_password_hints' ) );

	// Validate the password reset request.
	\add_action( 'validate_password_reset', array( $hooks, 'on_validate_password_reset' ), 1, 2 );

	// Check if a new password is compliant with the password rules.
	\add_action( 'password_reset', array( $hooks, 'on_password_reset' ), 1, 2 );

	// Check if a new password is compliant with the password rules.
	\add_action( 'user_profile_update_errors', array( $hooks, 'on_user_profile_update' ), 1, 3 );
}

function create_default_hooks(): Password_Hooks {
	$rules = create_password_rules_factory();

	return create_password_hooks(
		create_password_validator(
			array(
				$rules->lowercase_character(),
				$rules->uppercase_character(),
				$rules->digit(),
				$rules->special_character(),
				$rules->min_length( 12 ),
				$rules->min_unique_characters( 8 ),
				$rules->max_length( 255 ),
				$rules->max_repeating_characters( 2 ),
			)
		),
		create_password_message_presenter(),
		weak_password_disabler()
	);
}

function create_password_hooks(
	Password_Validator $validator,
	Password_Message_Presenter $presenter,
	Weak_Password_Disabler $weak_password
	): Password_Hooks {
	return new Password_Hooks( $validator, $presenter, $weak_password );
}

function create_password_validator( array $rules ): Password_Validator {
	return new Password_Validator( ...$rules );
}

function create_password_message_presenter(): Password_Message_Presenter {
	return new Password_Message_Presenter();
}

function create_password_rules_factory(): Password_Rules_Factory {
	return new Password_Rules_Factory();
}

function weak_password_disabler(): Weak_Password_Disabler {
	return new Weak_Password_Disabler();
}
