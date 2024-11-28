<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Custom_Facebook_Feed_Filter extends Abstract_Shortcode_Bypasser
{
	protected function social_feed_wrap_type(): string
	{
		return 'facebook';
	}

	protected function screen_reader_content( array $attributes ): string
	{
		$feed = $this->adapter->facebook_feed( $attributes );

		return $feed ? $feed->render_source() : '';
	}
}
