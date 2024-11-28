<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CustomFacebookFeed\Builder\CFF_Db;
use TwitterFeed\Builder\CTF_Db;
use InstagramFeed\Builder\SBI_Feed_Saver;
use SB\SocialWall\Admin\Feed_Saver;

class Smash_Balloon_Feeds_Adapter implements Social_Feeds_Adapter_Interface
{
	public function composite_feed( array $attributes ): ?Social_Feed_Adapter_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		$adapters = array();
		foreach ( $this->social_wall_feeds( $feed_id ) as $type => $config ) {
			$feed_adapter = $this->from_string( $type, $config->id );

			if ( $feed_adapter ) {
				$adapters[] = $feed_adapter;
			}
		}

		return $adapters ? new Composite_Feed_Adapter( ...$adapters ) : null;
	}

	protected function social_wall_feeds( int $feed_id ): array
	{
		return ( $feed_id && class_exists( Feed_Saver::class ) )
			? (new Feed_Saver( $feed_id ))->get_feed_plugins()
			: array();
	}

	public function facebook_feed( array $attributes ): ?Social_Feed_Adapter_Interface
	{
		$source = $this->facebook_source_info( $this->feed_id( $attributes ) );

		return ! empty( $source['id'] )
			? new Facebook_Feed_Adapter( $source['id'], $source['name'] )
			: null;
	}

	protected function facebook_source_info( int $feed_id ): array
	{
		return ( $feed_id && class_exists( CFF_Db::class ) )
			? CFF_Db::get_feed_source_info( $feed_id )
			: array();
	}

	public function instagram_feed( array $attributes ): ?Social_Feed_Adapter_Interface
	{
		$source = $this->instagram_source_info( $this->feed_id( $attributes ) );

		return ! empty( $source['username'] )
			? new Instagram_Feed_Adapter( $source['username'] )
			: null;
	}

	protected function instagram_source_info( int $feed_id ): array
	{
		if ( $feed_id && class_exists( SBI_Feed_Saver::class ) ) {
			$settings = (new SBI_Feed_Saver( $feed_id ))->get_feed_settings();

			return is_array( $settings ) ? $settings : array();
		} else {
			return array();
		}
	}

	public function twitter_feed( array $attributes ): ?Social_Feed_Adapter_Interface
	{
		$source = $this->twitter_source_info( $this->feed_id( $attributes ) );

		return ! empty( $source['name'] )
			? new Twitter_Feed_Adapter( $source['name'] )
			: null;
	}

	protected function twitter_source_info( int $feed_id ): array
	{
		return ( $feed_id && class_exists( CTF_Db::class ) )
			? CTF_Db::get_feed_source_info( $feed_id )
			: array();
	}

	public function youtube_feed( array $attributes ): ?Social_Feed_Adapter_Interface
	{
		return null;
	}

	protected function youtube_source_info( int $feed_id ): array
	{
		return array();
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
