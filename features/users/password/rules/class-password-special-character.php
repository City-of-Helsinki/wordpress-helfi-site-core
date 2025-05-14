<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password\Rules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Password_Special_Character implements Password_Rule_Interface
{
	public function hint(): string
	{
		return __( 'At least one special character, !@#$%^&*()-_\'[]{}<>~`+=,.;:/?|.', 'helsinki-site-core' );
	}

	public function validate( string $password ): void
	{
		if ( 1 !== preg_match( '/[!@#$%^&*()-_\'[\]{}<>~`+=,.;:\/?|]/', $password ) ) {
			throw new \InvalidArgumentException(
				__( 'The password does not contain a special character.', 'helsinki-site-core' )
			);
		}
	}
}
