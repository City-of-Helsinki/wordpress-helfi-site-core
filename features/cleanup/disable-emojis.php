<?php

declare(strict_types=1);

namespace Helsinki\WordPress\Site\Core\Cleanup\DisableEmojis;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'helsinki_site_core_init', __NAMESPACE__ . '\\init' );
function init(): void {
    \add_action( 'admin_enqueue_scripts', function() {
        \remove_action( 'admin_enqueue_scripts', 'wp_enqueue_emoji_styles' );

        \remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        \remove_action( 'admin_print_styles', 'print_emoji_styles' );
    }, 0 );

    \remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles', 10 );

    \remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    \remove_action( 'wp_print_styles', 'print_emoji_styles' );

    \remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    \remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

    \remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

    \add_filter( 'tiny_mce_plugins', __NAMESPACE__ . '\\disable_tiny_mce_emojis' );
    \add_filter( 'wp_resource_hints', __NAMESPACE__ . '\\remove_emojis_dns_prefetch', 10, 2 );
}

function disable_tiny_mce_emojis( array $plugins ): array {
    return array_diff( $plugins, array( 'wpemoji' ) );
}

function remove_emojis_dns_prefetch( array $urls, string $relation_type ): array {
    if ( 'dns-prefetch' === $relation_type ) {
        $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
        
        foreach ( $urls as $key => $url) {
            if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
                unset( $urls[$key] );
            }
        }
    }

    return $urls;
}