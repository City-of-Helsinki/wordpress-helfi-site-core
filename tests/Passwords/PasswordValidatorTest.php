
<?php

use PHPUnit\Framework\TestCase;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Password_Validator;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Min_Length;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Digit;

final class PasswordValidatorTest extends TestCase
{
    public function test_hints_returns_all_rule_hints(): void
    {
        $validator = new Password_Validator(
            new Password_Min_Length(5),
            new Password_Digit()
        );

        $hints = $validator->hints();
        $this->assertIsArray($hints);
        $this->assertCount(2, $hints);
    }

    public function test_validate_passes_with_valid_password(): void
    {
        $validator = new Password_Validator(
            new Password_Min_Length(5),
            new Password_Digit()
        );

        $this->expectNotToPerformAssertions();
        $validator->validate('abcde1');
    }

    public function test_validate_throws_exception_with_invalid_password(): void
    {
        $validator = new Password_Validator(
            new Password_Min_Length(10),
            new Password_Digit()
        );

        $this->expectException(Exception::class);
        $validator->validate('abc');
    }
}
