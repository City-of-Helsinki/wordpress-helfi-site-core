<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Custom_Facebook_Feed_Filter extends Abstract_Shortcode_Filter
{
	protected function social_feed_wrap_type(): string
	{
		return 'facebook';
	}

	protected function adapter_feed_callback(): string
	{
		return 'facebook_feed';
	}
}
