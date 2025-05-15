
<?php

use PHPUnit\Framework\TestCase;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Min_Length;

final class PasswordMinLengthTest extends TestCase
{
    public function test_valid_password_above_min_length(): void
    {
        $rule = new Password_Min_Length(6);
        $this->expectNotToPerformAssertions();
        $rule->validate('123456');
    }

    public function test_invalid_password_below_min_length(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $rule = new Password_Min_Length(6);
        $rule->validate('123');
    }
}
