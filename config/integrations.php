<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'cache-enabler' => 'clear-cache',
	'limit-login-attempts-reloaded' => 'data-cleaner',
	'matomo' => array(
		'menu-page',
		'settings-fields',
		'settings',
		'tracking-code',
		'init',
	),
	'polylang' => 'users',
	'redirection' => 'default-options',
	'smashballoon' => 'init',
	'wordpress-seo' => 'meta',
);
