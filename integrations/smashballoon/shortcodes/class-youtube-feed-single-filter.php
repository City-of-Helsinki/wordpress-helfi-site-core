<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class YouTube_Feed_Single_Filter extends Abstract_Shortcode_Bypasser
{
	protected function social_feed_wrap_type(): string
	{
		return 'youtube';
	}

	protected function screen_reader_content( array $attributes ): string
	{
		return '';
	}
}
