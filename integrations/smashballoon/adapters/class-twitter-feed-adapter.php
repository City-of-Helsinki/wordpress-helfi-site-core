<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Twitter_Feed_Adapter extends Abstract_Social_Feed_Adapter
{
	protected function link_url( string $name, string $type ): string
	{
		if ( 'hashtags' === $type ) {
			$name = 'hashtag/' . $name;
		}

		return 'https://x.com/' . $name . '/';
	}

	protected function anchor_text( string $name, string $type ): string
	{
		if ( 'hashtags' === $type ) {
			return sprintf(
				_x( 'More posts about %1$s on X', '%1$s: hashtag', 'helsinki-site-core' ),
				'#' . $name
			);
		} else {
			return sprintf(
				_x( '%1$s on X', '%1$s: profile name', 'helsinki-site-core' ),
				$name
			);
		}
	}
}
