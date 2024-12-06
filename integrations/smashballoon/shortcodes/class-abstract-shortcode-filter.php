<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters\Social_Feeds_Adapter_Interface;

abstract class Abstract_Shortcode_Filter implements Shortcode_Filter_Interface
{
	protected Social_Feeds_Adapter_Interface $adapter;

	public function __construct( Social_Feeds_Adapter_Interface $adapter )
	{
		$this->adapter = $adapter;
	}

	public function filter_output( string $output, array $attributes ): string
	{
		return sprintf(
			'<div class="%1$s">
				<div class="helsinki-social-feed" aria-hidden="true">%2$s</div>
				<div class="screen-reader-text--temp" style="background: red;">%3$s</div>
			</div>',
			esc_attr( implode( ' ', $this->social_feed_wrap_classes() ) ),
			$output,
			$this->screen_reader_content( $attributes )
		);
	}

	protected function social_feed_wrap_classes(): array
	{
		$classes = array( 'helsinki-social-feed-wrap' );

		if ( $this->social_feed_wrap_type() ) {
			$classes[] = 'helsinki-social-feed-wrap--' . $this->social_feed_wrap_type();
		}

		return $classes;
	}

	protected function screen_reader_content( array $attributes ): string
	{
		$feed = call_user_func( array( $this->adapter, $this->adapter_feed_callback() ), $attributes );

		return $feed ? $feed->render_source() : '';
	}

	abstract protected function social_feed_wrap_type(): string;

	abstract protected function adapter_feed_callback(): string;
}
