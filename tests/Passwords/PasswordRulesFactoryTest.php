
<?php

use PHPUnit\Framework\TestCase;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Password_Rules_Factory;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Rule_Interface;

final class PasswordRulesFactoryTest extends TestCase
{
    protected Password_Rules_Factory $factory;

    protected function setUp(): void
    {
        $this->factory = new Password_Rules_Factory();
    }

    public function test_digit_returns_rule_interface(): void
    {
        $this->assertInstanceOf(Password_Rule_Interface::class, $this->factory->digit());
    }

    public function test_lowercase_character_returns_rule_interface(): void
    {
        $this->assertInstanceOf(Password_Rule_Interface::class, $this->factory->lowercase_character());
    }

    public function test_max_length_returns_rule_interface(): void
    {
        $this->assertInstanceOf(Password_Rule_Interface::class, $this->factory->max_length(10));
    }

    public function test_min_length_returns_rule_interface(): void
    {
        $this->assertInstanceOf(Password_Rule_Interface::class, $this->factory->min_length(5));
    }

    public function test_special_character_returns_rule_interface(): void
    {
        $this->assertInstanceOf(Password_Rule_Interface::class, $this->factory->special_character());
    }

    public function test_uppercase_character_returns_rule_interface(): void
    {
        $this->assertInstanceOf(Password_Rule_Interface::class, $this->factory->uppercase_character());
    }
}
