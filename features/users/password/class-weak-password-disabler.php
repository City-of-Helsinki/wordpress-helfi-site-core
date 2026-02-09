<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Weak_Password_Disabler
{
	public function hide_weak_password_checkbox(): void
	{
		echo '<style>.pw-weak{display:none!important}</style>';
	}

	public function disable_weak_password_checkbox(): void
	{
		echo '<script>(el => {if (el) {el.disabled = true;}})(document.querySelector(\'[name="pw_weak"]\'));</script>';
	}
}
