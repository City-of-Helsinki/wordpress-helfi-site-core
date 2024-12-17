<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Smash_Balloon_Source_Info_Factory implements Source_Info_Factory_Interface
{
	protected Source_Info_Interface $no_info;
	protected bool $facebook_source;
	protected bool $instagram_source;
	protected bool $social_wall_source;
	protected bool $twitter_source;
	protected bool $youtube_source;

	public function __construct( array $config )
	{
		$this->no_info = new No_Source_Info();
		$this->facebook_source = ! empty( $config['facebook'] );
		$this->instagram_source = ! empty( $config['instagram'] );
		$this->social_wall_source = ! empty( $config['social_wall'] );
		$this->twitter_source = ! empty( $config['twitter'] );
		$this->youtube_source = ! empty( $config['youtube'] );
	}

	public function social_wall_feeds( array $attributes ): Source_Info_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		if ( ! $feed_id || ! $this->social_wall_source ) {
			return $this->no_source_info();
		}

		return new Social_Wall_Source_Info(
			(new \SB\SocialWall\Admin\Feed_Saver( $feed_id ))->get_feed_plugins()
		);
	}

	public function facebook_source_info( array $attributes ): Source_Info_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		if ( ! $feed_id || ! $this->facebook_source ) {
			return $this->no_source_info();
		}

		return new Facebook_Source_Info(
			(new \CustomFacebookFeed\Builder\CFF_Feed_Saver( $feed_id ))->get_feed_settings()
		);
	}

	public function instagram_source_info( array $attributes ): Source_Info_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		if ( ! $feed_id || ! $this->instagram_source ) {
			return $this->no_source_info();
		}

		return new Instagram_Source_Info(
			(new \InstagramFeed\Builder\SBI_Feed_Saver( $feed_id ))->get_feed_settings()
		);
	}

	public function twitter_source_info( array $attributes ): Source_Info_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		if ( ! $feed_id || ! $this->twitter_source ) {
			return $this->no_source_info();
		}

		return new Twitter_Source_Info(
			(new \TwitterFeed\Builder\CTF_Feed_Saver( $feed_id ))->get_feed_settings()
		);
	}

	public function youtube_source_info( array $attributes ): Source_Info_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		if ( ! $feed_id || ! $this->youtube_source ) {
			return $this->no_source_info();
		}

		return new YouTube_Source_Info(
			(new \SmashBalloon\YouTubeFeed\Builder\SBY_Feed_Saver( $feed_id ))->get_feed_settings()
		);
	}

	protected function feed_id( array $attributes ): int
	{
		return ! empty( $attributes['feed'] ) ? absint( $attributes['feed'] ) : 0;
	}

	protected function no_source_info(): Source_Info_Interface
	{
		return $this->no_info;
	}
}
