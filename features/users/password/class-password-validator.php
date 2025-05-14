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
		$rules_to_check = count( $this->rules );

		$invalid_rules = null;

		for ( $i=0; $i < $rules_to_check; $i++ ) {
			try {
				$this->rules[$i]->validate( $password );
			} catch ( Exception $invalid_rule ) {
				$invalid_rules = new Exception(
					$invalid_rule->getMessage(),
					$invalid_rule->getCode(),
					$invalid_rules
				);
			}
		}

		if ( $invalid_rules ) {
			throw $invalid_rules;
		}
	}
}
