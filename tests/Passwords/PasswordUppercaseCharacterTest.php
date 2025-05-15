
<?php

use PHPUnit\Framework\TestCase;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Uppercase_Character;

final class PasswordUppercaseCharacterTest extends TestCase
{
    public function test_valid_password_with_uppercase(): void
    {
        $rule = new Password_Uppercase_Character();
        $this->expectNotToPerformAssertions();
        $rule->validate('abcABC123');
    }

    public function test_invalid_password_without_uppercase(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $rule = new Password_Uppercase_Character();
        $rule->validate('abc123');
    }
}
