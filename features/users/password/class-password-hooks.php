<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Exception;
use stdClass;
use WP_Error;
use WP_User;

class Password_Hooks
{
	public function __construct(
		private Password_Validator $validator,
		private Password_Message_Presenter $presenter,
		private Weak_Password_Disabler $weak_password,
	) {}

	/**
	 * Disable weak password checkbox.
	 *
	 * @return void
	 */
	public function disable_weak_password_checkbox(): void
	{
		$this->weak_password->hide_weak_password_checkbox();
		$this->weak_password->disable_weak_password_checkbox();
	}

	/**
	 * Get password requirement hints.
	 *
	 * @param string $hint The password hint text.
	 *
	 * @return string
	 */
	public function get_password_hints( string $hints ): string
	{
		return $this->presenter->hints_text( $this->validator->hints() );
	}

	/**
	 * Display password requirement hints.
	 *
	 * @return void
	 */
	public function display_password_hints(): void
	{
		echo $this->presenter->hints_list( $this->validator->hints() );
	}

	/**
	 * Validate the password reset request
	 *
	 * @param WP_Error         $errors WP Error object.
	 * @param WP_User|WP_Error $user   WP_User object if the login and reset key match. WP_Error object otherwise.
	 *
	 * @return void
	 */
	public function on_validate_password_reset( WP_Error $errors, mixed $user ): void
	{
		if ( ! $user instanceof WP_User ) {
			return;
		}

		$form_field = array_reduce(
			array( 'pass1', 'password_1' ),
			fn( $carry, $field ) => ! empty( $_POST[$field] ) ? $field : $carry,
			''
		);

		try {
			if ( $form_field ) {
				$this->validator->validate( \wp_unslash( $_POST[$form_field] ) );
			}
		} catch ( Exception $exception ) {
			\wp_die(
				$this->presenter->validation_errors( $exception ),
				sprintf(
					'%s | %s',
					\get_bloginfo( 'name' ),
					$this->presenter->invalid_password()
				)
			);
		}
	}

	/**
	 * Check if a new password is compliant with the password rules
	 *
	 * Applies to user passwords edited in:
	 * - /wp-login.php?action=resetpass
	 * - /wp-login.php?action=rp
	 *
	 * If password is compliant with the policy, user data will be updated and
	 * the "wp_set_password" hook will be fired.
	 *
	 * @param WP_User $user     The user.
	 * @param string  $new_pass New user password.
	 */
	public function on_password_reset( WP_User $user, string $new_pass ): void
	{
		try {
			$this->validator->validate( \wp_unslash( $new_pass ) );
		} catch ( Exception $exception ) {
			\wp_die(
				$this->presenter->validation_errors( $exception ),
				sprintf(
					'%s | %s',
					\get_bloginfo( 'name' ),
					$this->presenter->invalid_password()
				)
			);
		}
	}

	/**
	 * Check if new password is compliant with the password rules
	 *
	 * Applies to user passwords edited in:
	 * - /wp-admin/user-edit.php
	 * - /wp-admin/profile.php
	 *
	 * If password is compliant with the policy, user data will be updated and
	 * the "wp_update_user" hook will be fired.
	 *
	 * @param WP_Error $errors    WP_Error object (passed by reference).
	 * @param bool     $update    Whether this is a user update.
	 * @param stdClass $user_data User object (passed by reference).
	 *
	 * @return void
	 */
	public function on_user_profile_update( WP_Error &$errors, bool $update, stdClass &$user_data ): void
	{
		if ( isset( $user_data->user_pass ) ) {
			try {
				$this->validator->validate( \wp_unslash( $user_data->user_pass ) );
			} catch ( Exception $exception ) {
				$errors->add(
					'pass',
					$this->presenter->validation_errors( $exception ),
					[ 'form-field' => 'pass1' ],
				);
			}
		}
	}
}
