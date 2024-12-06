<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters\Social_Feeds_Adapter_Interface;
use Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources\Source_Info_Factory_Interface;

add_action( 'helsinki_site_core_init', __NAMESPACE__ . '\\init' );
function init(): void {
	setup_feed_type_status_filters();

	$provider = default_filters_provider();

	if ( $provider->has_filters() ) {
		add_filter( 'do_shortcode_tag', array( $provider, 'provide_filtering' ), 10, 4 );
	}
}

function setup_feed_type_status_filters(): void {
	if ( class_exists( 'CustomFacebookFeed\Builder\CFF_Feed_Saver' ) ) {
		add_filter( 'helsinki_site_core_is_smash_balloon_facebook_active', '__return_true' );
	}

	if ( class_exists( 'InstagramFeed\Builder\SBI_Feed_Saver' ) ) {
		add_filter( 'helsinki_site_core_is_smash_balloon_instagram_active', '__return_true' );
	}

	if ( class_exists( 'SB\SocialWall\Admin\Feed_Saver' ) ) {
		add_filter( 'helsinki_site_core_is_smash_balloon_social_wall_active', '__return_true' );
	}

	if ( class_exists( 'TwitterFeed\Builder\CTF_Feed_Saver' ) ) {
		add_filter( 'helsinki_site_core_is_smash_balloon_twitter_active', '__return_true' );
	}

	if ( class_exists( 'SmashBalloon\YouTubeFeed\Builder\SBY_Feed_Saver' ) ) {
		add_filter( 'helsinki_site_core_is_smash_balloon_youtube_active', '__return_true' );
	}
}

function default_filters_provider(): Shortcode_Filter_Provider {
	$provider = create_shortcode_filter_provider(
		create_social_feeds_adapter(
			create_source_info_factory()
		)
	);

	foreach ( smash_balloon_shortcode_filters() as $tag => $filter ) {
		$provider->add_tag_filter( $tag, $filter );
	}

	return $provider;
}

function create_shortcode_filter_provider( Social_Feeds_Adapter_Interface $adapter ): Shortcode_Filter_Provider {
	$provider = new Shortcode_Filter_Provider( $adapter );

	return $provider;
}

function create_social_feeds_adapter( Source_Info_Factory_Interface $sources ): Social_Feeds_Adapter_Interface {
	return new Adapters\Smash_Balloon_Feeds_Adapter( $sources );
}

function create_source_info_factory(): Source_Info_Factory_Interface {
	return new Sources\Smash_Balloon_Source_Info_Factory( array(
		'facebook' => apply_filters( 'helsinki_site_core_is_smash_balloon_facebook_active', false ),
		'instagram' => apply_filters( 'helsinki_site_core_is_smash_balloon_instagram_active', false ),
		'social_wall' => apply_filters( 'helsinki_site_core_is_smash_balloon_social_wall_active', false ),
		'twitter' => apply_filters( 'helsinki_site_core_is_smash_balloon_twitter_active', false ),
		'youtube' => apply_filters( 'helsinki_site_core_is_smash_balloon_youtube_active', false ),
	) );
}

function smash_balloon_shortcode_filters(): array {
	$filters = [];

	if ( apply_filters( 'helsinki_site_core_is_smash_balloon_facebook_active', false ) ) {
		$filters['custom-facebook-feed'] = Filters\Custom_Facebook_Feed_Filter::class;
	}

	if ( apply_filters( 'helsinki_site_core_is_smash_balloon_instagram_active', false ) ) {
		$filters['instagram-feed'] = Filters\Instagram_Feed_Filter::class;
	}

	if ( apply_filters( 'helsinki_site_core_is_smash_balloon_social_wall_active', false ) ) {
		$filters['social-wall'] = Filters\Social_Wall_Filter::class;
	}

	if ( apply_filters( 'helsinki_site_core_is_smash_balloon_twitter_active', false ) ) {
		$filters['custom-twitter-feed'] = Filters\Custom_Twitter_Feed_Filter::class;
		$filters['custom-twitter-feeds'] = Filters\Custom_Twitter_Feeds_Filter::class;
	}

	if ( apply_filters( 'helsinki_site_core_is_smash_balloon_youtube_active', false ) ) {
		$filters['youtube-feed'] = Filters\YouTube_Feed_Filter::class;
		$filters['youtube-feed-search'] = Filters\YouTube_Feed_Search_Filter::class;
		$filters['youtube-feed-single'] = Filters\YouTube_Feed_Single_Filter::class;
	}

	return $filters;
}
