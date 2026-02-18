<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Rule_Interface;
use Exception;

class Password_Validator
{
	private array $rules;

	public function __construct(
		Password_Rule_Interface ...$rules
	) {
		$this->rules = $rules;
	}

	public function hints(): array
	{
		return array_map(
			fn( Password_Rule_Interface $rule ) => $rule->hint(),
			$this->rules
		);
	}

	public function validate( string $password ): void
	{
		$invalid_rules = array_reduce(
			$this->rules,
			function( $carry, $rule ) use ( $password ) {
				try {
					$rule->validate( $password );

					return $carry;
				} catch ( Exception $invalid_rule ) {
					return new Exception(
						$invalid_rule->getMessage(),
						$invalid_rule->getCode(),
						$carry
					);
				}
			},
			null
		);

		if ( $invalid_rules ) {
			throw $invalid_rules;
		}
	}
}
