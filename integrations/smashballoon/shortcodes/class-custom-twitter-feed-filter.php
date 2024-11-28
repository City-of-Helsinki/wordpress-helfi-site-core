<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Custom_Twitter_Feed_Filter extends Abstract_Shortcode_Bypasser
{
	protected function social_feed_wrap_type(): string
	{
		return 'twitter';
	}

	protected function screen_reader_content( array $attributes ): string
	{
		return '';
	}
}
