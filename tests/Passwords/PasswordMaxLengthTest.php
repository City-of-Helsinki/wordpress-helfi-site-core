
<?php

use PHPUnit\Framework\TestCase;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Max_Length;

final class PasswordMaxLengthTest extends TestCase
{
    public function test_valid_password_under_max_length(): void
    {
        $rule = new Password_Max_Length(8);
        $this->expectNotToPerformAssertions();
        $rule->validate('12345678');
    }

    public function test_invalid_password_over_max_length(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $rule = new Password_Max_Length(8);
        $rule->validate('123456789');
    }
}
