<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CustomFacebookFeed\Builder\CFF_Feed_Saver;
use TwitterFeed\Builder\CTF_Feed_Saver;
use InstagramFeed\Builder\SBI_Feed_Saver;
use SB\SocialWall\Admin\Feed_Saver;
use SmashBalloon\YouTubeFeed\Builder\SBY_Feed_Saver;

class Smash_Balloon_Source_Info_Factory implements Source_Info_Factory_Interface
{
	protected Source_Info_Interface $no_info;
	protected bool $facebook_source;
	protected bool $instagram_source;
	protected bool $social_wall_source;
	protected bool $twitter_source;
	protected bool $youtube_source;

	public function __construct()
	{
		$this->no_info = new No_Source_Info();
		$this->facebook_source = class_exists( CFF_Feed_Saver::class );
		$this->instagram_source = class_exists( SBI_Feed_Saver::class );
		$this->social_wall_source = class_exists( Feed_Saver::class );
		$this->twitter_source = class_exists( CTF_Feed_Saver::class );
		$this->youtube_source = class_exists( SBY_Feed_Saver::class );
	}

	public function social_wall_feeds( array $attributes ): Source_Info_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		if ( ! $feed_id || ! $this->social_wall_source ) {
			return $this->no_source_info();
		}

		return new Social_Wall_Source_Info(
			(new Feed_Saver( $feed_id ))->get_feed_plugins()
		);
	}

	public function facebook_source_info( array $attributes ): Source_Info_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		if ( ! $feed_id || ! $this->facebook_source ) {
			return $this->no_source_info();
		}

		return new Facebook_Source_Info(
			(new CFF_Feed_Saver( $feed_id ))->get_feed_settings()
		);
	}

	public function instagram_source_info( array $attributes ): Source_Info_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		if ( ! $feed_id || ! $this->instagram_source ) {
			return $this->no_source_info();
		}

		return new Instagram_Source_Info(
			(new SBI_Feed_Saver( $feed_id ))->get_feed_settings()
		);
	}

	public function twitter_source_info( array $attributes ): Source_Info_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		if ( ! $feed_id || ! $this->twitter_source ) {
			return $this->no_source_info();
		}

		return new Twitter_Source_Info(
			(new CTF_Feed_Saver( $feed_id ))->get_feed_settings()
		);
	}

	public function youtube_source_info( array $attributes ): Source_Info_Interface
	{
		$feed_id = $this->feed_id( $attributes );

		if ( ! $feed_id || ! $this->youtube_source ) {
			return $this->no_source_info();
		}

		return new YouTube_Source_Info(
			(new SBY_Feed_Saver( $feed_id ))->get_feed_settings()
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
