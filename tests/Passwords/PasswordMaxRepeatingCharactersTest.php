
<?php

use PHPUnit\Framework\TestCase;
use Helsinki\WordPress\Site\Core\Features\Users\Password\Rules\Password_Max_Repeating_Characters;

final class PasswordMaxRepeatingCharactersTest extends TestCase
{
    public function test_valid_password_with_few_repeats(): void
    {
        $rule = new Password_Max_Repeating_Characters(2);
        $this->expectNotToPerformAssertions();
        $rule->validate('aabbcc');
    }

    public function test_invalid_password_with_too_many_repeats(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $rule = new Password_Max_Repeating_Characters(2);
        $rule->validate('aaabbb');
    }
}
