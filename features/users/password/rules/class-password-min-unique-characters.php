<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password\Rules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Password_Min_Unique_Characters implements Password_Rule_Interface
{
	public function __construct(
		private int $count
	) {}

	public function hint(): string
	{
		return sprintf(
			__( 'At least %d unique characters.', 'helsinki-site-core' ),
			$this->count
		);
	}

	public function validate( string $password ): void
	{
		if ( count( array_unique( str_split( $password ) ) ) < $this->count ) {
			throw new \InvalidArgumentException(
				sprintf(
					__( 'The password contains less than %d unique characters.', 'helsinki-site-core' ),
					$this->count
				)
			);
		}
	}
}
