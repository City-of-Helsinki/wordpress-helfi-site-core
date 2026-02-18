<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Rule_Interface;

class Password_Rules_Factory
{
	public function digit(): Password_Rule_Interface
	{
		return $this->create_rule( __FUNCTION__ );
	}

	public function lowercase_character(): Password_Rule_Interface
	{
		return $this->create_rule( __FUNCTION__ );
	}

	public function max_length( int $length ): Password_Rule_Interface
	{
		return $this->create_rule( __FUNCTION__, $length );
	}

	public function max_repeating_characters( int $count ): Password_Rule_Interface
	{
		return $this->create_rule( __FUNCTION__, $count );
	}

	public function min_length( int $length ): Password_Rule_Interface
	{
		return $this->create_rule( __FUNCTION__, $length );
	}

	public function min_unique_characters( int $count ): Password_Rule_Interface
	{
		return $this->create_rule( __FUNCTION__, $count );
	}

	public function special_character(): Password_Rule_Interface
	{
		return $this->create_rule( __FUNCTION__ );
	}

	public function uppercase_character(): Password_Rule_Interface
	{
		return $this->create_rule( __FUNCTION__ );
	}

	private function create_rule( string $name, ...$args ): Password_Rule_Interface
	{
		$class_name = $this->to_fully_qualified_class_name( $name );

		return new $class_name( ...$args );
	}

	private function to_fully_qualified_class_name( string $name ): string
	{
		return sprintf(
			'%s\Rules\Password_%s',
			__NAMESPACE__,
			implode( '_', array_map( 'ucfirst', explode( '_', $name ) ) )
		);
	}
}
