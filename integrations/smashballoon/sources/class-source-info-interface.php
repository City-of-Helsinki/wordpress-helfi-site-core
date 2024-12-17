<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Source_Info_Interface
{
	public function usernames(): array;
}
