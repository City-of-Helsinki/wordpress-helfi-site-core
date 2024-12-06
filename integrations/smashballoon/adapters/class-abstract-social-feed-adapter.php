<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources\Source_Info_Interface;

abstract class Abstract_Social_Feed_Adapter implements Social_Feed_Adapter_Interface
{
	protected Source_Info_Interface $source_info;

	public function __construct( Source_Info_Interface $source_info )
	{
		$this->source_info = $source_info;
	}

	public function render_source(): string
	{
		return $this->list_html( $this->source_links() );
	}

	protected function source_links(): array
	{
		$links = array();

		foreach ( $this->source_info->usernames() as $key => $value ) {
			$link = $this->create_source_link( (string) $key, (string) $value );

			if ( $link ) {
				$links[] = $link;
			}
		}

		return $links;
	}

	protected function create_source_link( string $key, string $value ): string
	{
		$url = $this->link_url( $key, $value );
		$anchor = $this->anchor_text( $key, $value );

		return ( $url && $anchor ) ? $this->link_html( $url, $anchor ) : '';
	}

	protected function link_url( string $key, string $value ): string
	{
		return '';
	}

	protected function anchor_text( string $key, string $value ): string
	{
		return '';
	}

	protected function list_html( array $items ): string
	{
		return sprintf(
			'<ul>%s</ul>',
			implode( '', array_map( array( $this, 'list_item_html' ), $items ) )
		);
	}

	protected function list_item_html( string $content ): string
	{
		return sprintf( '<li>%s</li>', $content );
	}

	protected function link_html( string $url, string $anchor ): string
	{
		return sprintf(
			'<a href="%1$s" target="_blank" rel="noopener">%2$s</a>',
			esc_url( $url ),
			esc_html( $anchor )
		);
	}
}
