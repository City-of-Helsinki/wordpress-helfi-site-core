<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Twitter_Feed_Adapter implements Social_Feed_Adapter_Interface
{
	protected string $name;

	public function __construct( string $name )
	{
		if ( ! $name ) {
			throw new \InvalidArgumentException(
				__( 'Twitter or X username required.', 'helsinki-site-core' )
			);
		}

		$this->name = trim( $name );
	}

	public function render_source(): string
	{
		return sprintf(
			'<a href="%1$s" rel="noopener">%2$s</a>',
			esc_url( $this->link_url() ),
			esc_html( $this->anchor_text() )
		);
	}

	protected function link_url(): string
	{
		return 'https://x.com/' . mb_strtolower( $this->name ) . '/';
	}

	protected function anchor_text(): string
	{
		return sprintf(
			_x( 'Follow %1$s on X', '%1$s: profile name', 'helsinki-site-core' ),
			$this->name
		);
	}
}
