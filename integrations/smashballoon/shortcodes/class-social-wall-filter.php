<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Social_Wall_Filter extends Abstract_Shortcode_Bypasser
{
	protected function social_feed_wrap_type(): string
	{
		return 'social-wall';
	}

	protected function screen_reader_content( array $attributes ): string
	{
		$feed = $this->adapter->composite_feed( $attributes );

		return $feed ? $feed->render_source() : '';
	}
}
