<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Twitter_Source_Info extends Abstract_Source_Info
{
	protected function extract_sources( array $data ): array
	{
		return array(
			'usernames' => $this->extract_usernames( $data ),
			'hashtags' => $this->extract_hashtags( $data ),
		);
	}

	protected function extract_usernames( array $data ): array
	{
		return ( isset( $data['screenname'] ) && is_string( $data['screenname'] ) )
			? array_map( 'trim', explode( ',', $data['screenname'] ) )
			: array();
	}

	protected function extract_hashtags( array $data ): array
	{
		return ( isset( $data['hashtag'] ) && is_string( $data['hashtag'] ) )
			? array_map( 'trim', explode( ',', $data['hashtag'] ) )
			: array();
	}

	protected function is_valid_source( $source, $key ): bool
	{
		return ! empty( $source ) && ( 'usernames' === $key || 'hashtags' === $key );
	}

	protected function add_username( $source, $key ): void
	{
		foreach ( $source as $name ) {
			if ( $name ) {
				$this->usernames[$name] = $key;
			}
		}
	}
}
