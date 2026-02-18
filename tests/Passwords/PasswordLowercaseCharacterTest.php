
<?php

use PHPUnit\Framework\TestCase;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Lowercase_Character;

final class PasswordLowercaseCharacterTest extends TestCase
{
    public function test_valid_password_with_lowercase(): void
    {
        $rule = new Password_Lowercase_Character();
        $this->expectNotToPerformAssertions();
        $rule->validate('abcDEF123');
    }

    public function test_invalid_password_without_lowercase(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $rule = new Password_Lowercase_Character();
        $rule->validate('ABC123');
    }
}
