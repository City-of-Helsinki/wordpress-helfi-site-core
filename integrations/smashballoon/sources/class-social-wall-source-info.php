<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Social_Wall_Source_Info implements Source_Info_Interface
{
	protected array $usernames;

	public function __construct( array $data )
	{
		$this->usernames = array();

		foreach ( $data as $type => $config ) {
			$this->usernames[$type] = (int) $config->id;
		}
	}

	public function usernames(): array
	{
		return $this->usernames;
	}
}
