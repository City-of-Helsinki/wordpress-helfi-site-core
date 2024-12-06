<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters\Social_Feeds_Adapter_Interface;
use Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Shortcodes\Shortcode_Filter_Interface;

class Shortcode_Filter_Provider
{
	protected Social_Feeds_Adapter_Interface $adapter;
	protected array $tags;
	protected array $filters;

	public function __construct( Social_Feeds_Adapter_Interface $adapter )
	{
		$this->adapter = $adapter;
		$this->tags = array();
		$this->filters = array();
	}

	public function add_tag_filter( string $tag, string $handler ): void
	{
		if ( ! $this->has_filter( $tag ) ) {
			$this->tags[$tag] = $handler;
		}
	}

	public function provide_filtering( string $output, string $tag, array $attributes, array $matches ): string
	{
		return $this->has_filter( $tag )
			? $this->filter_output( $output, $tag, $attributes )
			: $output;
	}

	public function has_filters(): bool
	{
		return ! empty( $this->tags );
	}

	protected function has_filter( string $tag ): bool
	{
		return ! empty( $this->tags[$tag] );
	}

	protected function filter_output( string $output, string $tag, array $attributes ): string
	{
		$filter = $this->create_filter( $tag );

		return $filter->filter_output( $output, $attributes );
	}

	protected function create_filter( string $tag ): Shortcode_Filter_Interface
	{
		if ( $this->in_filters( $tag ) ) {
			return $this->from_filters( $tag );
		}

		$class = $this->filter_class( $tag );
		$filter = new $class( $this->adapter );

		$this->to_filters( $tag, $filter );

		return $filter;
	}

	protected function filter_class( string $tag ): string
	{
		return $this->tags[$tag];
	}

	protected function in_filters( string $tag ): bool
	{
		return ! empty( $this->filters[$tag] );
	}

	protected function from_filters( string $tag ): Shortcode_Filter_Interface
	{
		return $this->filters[$tag];
	}

	protected function to_filters( string $tag, Shortcode_Filter_Interface $filter ): void
	{
		$this->filters[$tag] = $filter;
	}
}
