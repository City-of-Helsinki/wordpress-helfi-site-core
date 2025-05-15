<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password\Rules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Password_Uppercase_Character implements Password_Rule_Interface
{
	public function hint(): string
	{
		return __( 'At least one uppercase character, A-Z.', 'helsinki-site-core' );
	}

	public function validate( string $password ): void
	{
		if ( 1 !== preg_match( '/[A-Z]/', $password ) ) {
			throw new \InvalidArgumentException(
				__( 'The password does not contain an uppercase character.', 'helsinki-site-core' )
			);
		}
	}
}
