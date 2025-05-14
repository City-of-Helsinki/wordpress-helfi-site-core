<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password\Rules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Password_Digit implements Password_Rule_Interface
{
	public function hint(): string
	{
		return __( 'At least one digit, 0-9.', 'helsinki-site-core' );
	}

	public function validate( string $password ): void
	{
		if ( 1 !== preg_match( '/\d/', $password ) ) {
			throw new \InvalidArgumentException(
				__( 'The password does not contain any digits.', 'helsinki-site-core' )
			);
		}
	}
}
