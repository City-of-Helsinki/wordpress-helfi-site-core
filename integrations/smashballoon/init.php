<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters\Social_Feeds_Adapter_Interface;

add_action( 'helsinki_site_core_init', __NAMESPACE__ . '\\init' );
function init(): void {
	$provider = create_shortcode_filter_provider(
		create_social_feeds_adapter()
	);

	foreach ( smash_balloon_shortcode_filters() as $tag => $filter ) {
		$provider->add_tag_filter( $tag, $filter );
	}

	if ( $provider->has_filters() ) {
		add_filter( 'do_shortcode_tag', array( $provider, 'provide_filtering' ), 10, 4 );
	}
}

function create_shortcode_filter_provider( Social_Feeds_Adapter_Interface $adapter ): Shortcode_Filter_Provider {
	$provider = new Shortcode_Filter_Provider( $adapter );

	return $provider;
}

function create_social_feeds_adapter(): Social_Feeds_Adapter_Interface {
	return new Adapters\Smash_Balloon_Feeds_Adapter();
}

function smash_balloon_shortcode_filters(): array {
	$filters = [];

	if ( class_exists( 'CustomFacebookFeed\Builder\CFF_Db' ) ) {
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

	// if ( class_exists( 'foo' ) ) {
	// 	$filters['youtube-feed'] = Shortcodes\YouTube_Feed_Filter::class;
	// }

	// if ( class_exists( 'foo' ) ) {
	// 	$filters['youtube-feed-search'] = Shortcodes\YouTube_Feed_Search_Filter::class;
	// }

	// if ( class_exists( 'foo' ) ) {
	// 	$filters['youtube-feed-single'] = Shortcodes\YouTube_Feed_Single_Filter::class;
	// }

	return $filters;
}
