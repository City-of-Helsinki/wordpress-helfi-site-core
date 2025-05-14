<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password\Rules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Password_Lowercase_Character implements Password_Rule_Interface
{
	public function hint(): string
	{
		return __( 'At least one lowercase character, a-z.', 'helsinki-site-core' );
	}

	public function validate( string $password ): void
	{
		if ( 1 !== preg_match( '/[a-z]/', $password ) ) {
			throw new \InvalidArgumentException(
				__( 'The password does not contain a lowercase character.', 'helsinki-site-core' )
			);
		}
	}
}
