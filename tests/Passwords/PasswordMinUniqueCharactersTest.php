
<?php

use PHPUnit\Framework\TestCase;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Min_Unique_Characters;

final class PasswordMinUniqueCharactersTest extends TestCase
{
    public function test_valid_password_with_enough_unique_chars(): void
    {
        $rule = new Password_Min_Unique_Characters(4);
        $this->expectNotToPerformAssertions();
        $rule->validate('abc1abc1');
    }

    public function test_invalid_password_with_insufficient_unique_chars(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $rule = new Password_Min_Unique_Characters(4);
        $rule->validate('aaa');
    }
}
