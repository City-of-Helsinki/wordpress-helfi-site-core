<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password\Rules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Password_Max_Repeating_Characters implements Password_Rule_Interface
{
	public function __construct(
		private int $count
	) {}

	public function hint(): string
	{
		return sprintf(
			__( 'At most %d consecutive repeating characters. E.g. "%s" is not allowed.', 'helsinki-site-core' ),
			$this->count,
			str_repeat( 'a', $this->count + 1 )
		);
	}

	public function validate( string $password ): void
	{
		preg_match_all( '/(.)\1+/', $password, $matches );

		foreach ( $matches[0] as $match ) {
			if ( strlen( $match ) > $this->count ) {
				throw new \InvalidArgumentException(
					sprintf(
						__( 'The password contains more than %d consecutive repeating characters.', 'helsinki-site-core' ),
						$this->count
					)
				);
			}
		}
	}
}
