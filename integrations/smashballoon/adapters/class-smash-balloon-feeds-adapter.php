<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CustomFacebookFeed\Builder\CFF_Db;
use SB\SocialWall\Admin\Feed_Saver;

class Smash_Balloon_Feeds_Adapter implements Social_Feeds_Adapter_Interface
{
	public function composite_feed( array $attributes ): ?Social_Feed_Adapter_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		$feed_saver = $feed_id ? new Feed_Saver( $feed_id ) : null;
		if ( ! $feed_saver ) {
			return null;
		}

		$adapters = array();
		foreach ( $feed_saver->get_feed_plugins() as $type => $config ) {
			$feed_adapter = $this->from_string( $type, $config->id );

			if ( $feed_adapter ) {
				$adapters[] = $feed_adapter;
			}
		}

		return $adapters ? new Composite_Feed_Adapter( ...$adapters ) : null;
	}

	public function facebook_feed( array $attributes ): ?Social_Feed_Adapter_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		$source = $feed_id ? CFF_Db::get_feed_source_info( $feed_id ) : null;
		if ( empty( $source['id'] ) ) {
			return null;
		}

		return new Facebook_Feed_Adapter( $source['id'], $source['name'] );
	}

	public function instagram_feed( array $attributes ): ?Social_Feed_Adapter_Interface
	{
		return null;
	}

	public function twitter_feed( array $attributes ): ?Social_Feed_Adapter_Interface
	{
		return null;
	}

	public function youtube_feed( array $attributes ): ?Social_Feed_Adapter_Interface
	{
		return null;
	}

	protected function from_string( string $type, int $feed_id ): ?Social_Feed_Adapter_Interface
	{
		$feed_adapter = "{$type}_feed";

		return method_exists( $this, $feed_adapter )
			? $this->$feed_adapter( array( 'feed' => $feed_id ) )
			: null;
	}

	protected function feed_id( array $attributes ): int
	{
		return ! empty( $attributes['feed'] ) ? absint( $attributes['feed'] ) : 0;
	}
}
