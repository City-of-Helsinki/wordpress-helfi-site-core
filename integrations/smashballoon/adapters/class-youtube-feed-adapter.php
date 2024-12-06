<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class YouTube_Feed_Adapter extends Abstract_Social_Feed_Adapter
{
	protected function link_url( string $index, string $username ): string
	{
		return 'https://www.youtube.com/channel/' . $username . '/';
	}

	protected function anchor_text( string $index, string $username ): string
	{
		return sprintf(
			_x( 'Follow %1$s on YouTube', '%1$s: profile name', 'helsinki-site-core' ),
			$username
		);
	}
}
