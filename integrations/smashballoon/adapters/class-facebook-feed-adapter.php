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
		$this->title = $title;
	}

	public function render_source(): string
	{
		return sprintf(
			'<a href="https://www.facebook.com/%1$s">%2$s</a>',
			esc_url( $this->page_id ),
			esc_html( $this->title ?: 'Facebook' )
		);
	}
}
