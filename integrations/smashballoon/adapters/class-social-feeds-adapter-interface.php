<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Social_Feeds_Adapter_Interface
{
	public function composite_feed( array $attributes ): Social_Feed_Adapter_Interface;
	public function facebook_feed( array $attributes ): Social_Feed_Adapter_Interface;
	public function instagram_feed( array $attributes ): Social_Feed_Adapter_Interface;
	public function twitter_feed( array $attributes ): Social_Feed_Adapter_Interface;
	public function youtube_feed( array $attributes ): Social_Feed_Adapter_Interface;
}
