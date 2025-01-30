<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Facebook_Source_Info extends Abstract_Source_Info
{
	protected function is_valid_source( $source, $key ): bool
	{
		return ! empty( $source['account_id'] ) && ! empty( $source['username'] );
	}

	protected function add_username( $source, $key ): void
	{
		$this->usernames[$source['account_id']] = $source['username'];
	}
}
