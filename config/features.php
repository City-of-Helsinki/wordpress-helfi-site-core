<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'admin' => array(
		'dashboard',
		'connectors',
		'notices',
		'toolbar',
	),
	'block-editor' => array(
		'reusable-blocks-menu',
		'view',
	),
	'cleanup' => array(
		'disable-emojis',
		'wp-head',
	),
	'login' => array(
		'view',
	),
	'plugins' => 'management',
	'search' => array(
		'meta',
	),
	'users' => array(
		'profile',
		'password' => array(
			'init'
		),
	),
);
