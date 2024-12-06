<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources\Source_Info_Factory_Interface;

class Smash_Balloon_Feeds_Adapter implements Social_Feeds_Adapter_Interface
{
	protected Source_Info_Factory_Interface $sources;

	public function __construct( Source_Info_Factory_Interface $sources )
	{
		$this->sources = $sources;
	}

	public function composite_feed( array $attributes ): Social_Feed_Adapter_Interface
	{
		$sources = $this->sources->social_wall_feeds( $attributes );

		$adapters = array();
		foreach ( $sources->usernames() as $type => $id ) {
			$adapters[] = $this->from_string( $type, $id );
		}

		return new Composite_Feed_Adapter( ...$adapters );
	}

	public function facebook_feed( array $attributes ): Social_Feed_Adapter_Interface
	{
		return new Facebook_Feed_Adapter( $this->sources->facebook_source_info( $attributes ) );
	}

	public function instagram_feed( array $attributes ): Social_Feed_Adapter_Interface
	{
		return new Instagram_Feed_Adapter( $this->sources->instagram_source_info( $attributes ) );
	}

	public function twitter_feed( array $attributes ): Social_Feed_Adapter_Interface
	{
		return new Twitter_Feed_Adapter( $this->sources->twitter_source_info( $attributes ) );
	}

	public function youtube_feed( array $attributes ): Social_Feed_Adapter_Interface
	{
		return new YouTube_Feed_Adapter( $this->sources->youtube_source_info( $attributes ) );
	}

	protected function from_string( string $type, int $feed_id ): Social_Feed_Adapter_Interface
	{
		return call_user_func( array( $this, "{$type}_feed" ), array( 'feed' => $feed_id ) );
	}
}
