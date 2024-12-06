<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Instagram_Feed_Adapter extends Abstract_Social_Feed_Adapter
{
	protected function link_url( string $index, string $username ): string
	{
		return 'https://www.instagram.com/' . $username . '/';
	}

	protected function anchor_text( string $index, string $username ): string
	{
		return sprintf(
			_x( 'Follow %1$s on Instagram', '%1$s: profile name', 'helsinki-site-core' ),
			$username
		);
	}
}
