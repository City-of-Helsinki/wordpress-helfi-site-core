
<?php

use PHPUnit\Framework\TestCase;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Digit;

final class PasswordDigitTest extends TestCase
{
    public function test_valid_password_with_digit(): void
    {
        $rule = new Password_Digit();
        $this->expectNotToPerformAssertions();
        $rule->validate('passw0rd');
    }

    public function test_invalid_password_without_digit(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $rule = new Password_Digit();
        $rule->validate('password');
    }

    public function test_hint(): void
    {
        $rule = new Password_Digit();
        $this->assertIsString($rule->hint());
        $this->assertStringContainsString('digit', strtolower($rule->hint()));
    }
}
