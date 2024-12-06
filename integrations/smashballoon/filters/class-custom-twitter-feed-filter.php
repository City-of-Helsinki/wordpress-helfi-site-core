<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Filters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Custom_Twitter_Feed_Filter extends Abstract_Shortcode_Filter
{
	protected function social_feed_wrap_type(): string
	{
		return 'twitter';
	}

	protected function adapter_feed_callback(): string
	{
		return 'twitter_feed';
	}
}
