<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Social_Wall_Filter extends Abstract_Shortcode_Filter
{
	protected function social_feed_wrap_type(): string
	{
		return 'social-wall';
	}

	protected function adapter_feed_callback(): string
	{
		return 'composite_feed';
	}
}
