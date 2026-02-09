<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password\Rules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Password_Rule_Interface
{
	public function hint(): string;
	public function validate( string $password ): void;
}
