
<?php

use PHPUnit\Framework\TestCase;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Special_Character;

final class PasswordSpecialCharacterTest extends TestCase
{
    public function test_valid_password_with_special_char(): void
    {
        $rule = new Password_Special_Character();
        $this->expectNotToPerformAssertions();
        $rule->validate('test@123');
    }

    public function test_invalid_password_without_special_char(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $rule = new Password_Special_Character();
        $rule->validate('test123');
    }
}
