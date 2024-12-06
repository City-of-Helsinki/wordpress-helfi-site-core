<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters\Social_Feeds_Adapter_Interface;
use Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources\Source_Info_Factory_Interface;

add_action( 'helsinki_site_core_init', __NAMESPACE__ . '\\init' );
function init(): void {
	$provider = default_filters_provider();

	if ( $provider->has_filters() ) {
		add_filter( 'do_shortcode_tag', array( $provider, 'provide_filtering' ), 10, 4 );
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
	return new Sources\Smash_Balloon_Source_Info_Factory;
}

function smash_balloon_shortcode_filters(): array {
	$filters = [];

	if ( class_exists( 'CustomFacebookFeed\Builder\CFF_Feed_Saver' ) ) {
		$filters['custom-facebook-feed'] = Shortcodes\Custom_Facebook_Feed_Filter::class;
	}

	if ( class_exists( 'TwitterFeed\Builder\CTF_Db' ) ) {
		$filters['custom-twitter-feed'] = Shortcodes\Custom_Twitter_Feed_Filter::class;
		$filters['custom-twitter-feeds'] = Shortcodes\Custom_Twitter_Feeds_Filter::class;
	}

	if ( class_exists( 'SB\SocialWall\Admin\Feed_Saver' ) ) {
		$filters['social-wall'] = Shortcodes\Social_Wall_Filter::class;
	}

	if ( class_exists( 'InstagramFeed\Builder\SBI_Feed_Saver' ) ) {
		$filters['instagram-feed'] = Shortcodes\Instagram_Feed_Filter::class;
	}

	if ( class_exists( 'SmashBalloon\YouTubeFeed\Builder\SBY_Feed_Saver' ) ) {
		$filters['youtube-feed'] = Shortcodes\YouTube_Feed_Filter::class;
		$filters['youtube-feed-search'] = Shortcodes\YouTube_Feed_Search_Filter::class;
		$filters['youtube-feed-single'] = Shortcodes\YouTube_Feed_Single_Filter::class;
	}

	return $filters;
}
