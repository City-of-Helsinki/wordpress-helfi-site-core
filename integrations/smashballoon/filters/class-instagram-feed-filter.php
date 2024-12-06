<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Filters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Instagram_Feed_Filter extends Abstract_Shortcode_Filter
{
	protected function social_feed_wrap_type(): string
	{
		return 'instagram';
	}

	protected function adapter_feed_callback(): string
	{
		return 'instagram_feed';
	}
}
