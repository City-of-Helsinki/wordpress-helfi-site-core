<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Facebook_Feed_Adapter extends Abstract_Social_Feed_Adapter
{
	protected function link_url( string $page_id, string $username ): string
	{
		return 'https://www.facebook.com/' . $page_id . '/';
	}

	protected function anchor_text( string $page_id, string $username ): string
	{
		return sprintf(
			_x( 'Follow %1$s on Facebook', '%1$s: profile name', 'helsinki-site-core' ),
			$username
		);
	}
}
