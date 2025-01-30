<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class No_Source_Info implements Source_Info_Interface
{
	public function usernames(): array
	{
		return array();
	}
}
