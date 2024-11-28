<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Facebook_Feed_Adapter implements Social_Feed_Adapter_Interface
{
	protected string $page_id;
	protected string $title;

	public function __construct( string $page_id, string $title )
	{
		if ( ! $page_id ) {
			throw new \InvalidArgumentException(
				__( 'Facebook page ID required.', 'helsinki-site-core' )
			);
		}

		$this->page_id = $page_id;
		$this->title = trim( $title );
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
		return 'https://www.facebook.com/' . $this->page_id . '/';
	}

	protected function anchor_text(): string
	{
		if ( $this->title ) {
			return sprintf(
				_x( 'Follow %1$s on Facebook', '%1$s: profile name', 'helsinki-site-core' ),
				$this->title
			);
		} else {
			return __( 'Follow us on Facebook', 'helsinki-site-core' );
		}
	}
}
