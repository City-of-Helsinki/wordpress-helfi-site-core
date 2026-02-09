<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password\Rules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Password_Min_Length implements Password_Rule_Interface
{
	public function __construct(
		private int $length
	) {}

	public function hint(): string
	{
		return sprintf(
			__( 'At least %d characters long.', 'helsinki-site-core' ),
			$this->length
		);
	}

	public function validate( string $password ): void
	{
		if ( strlen( $password ) < $this->length ) {
			throw new \InvalidArgumentException(
				sprintf(
					__( 'The password is less than %d characters long.', 'helsinki-site-core' ),
					$this->length
				)
			);
		}
	}
}
