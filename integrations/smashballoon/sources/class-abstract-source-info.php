<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Abstract_Source_Info implements Source_Info_Interface
{
	protected array $usernames;

	public function __construct( array $data )
	{
		$this->usernames = array();

		$sources = $this->extract_sources( $data );
		array_walk( $sources, array( $this, 'process_source' ) );
	}

	protected function extract_sources( array $data ): array
	{
		return ( isset( $data['sources'] ) && is_array( $data['sources'] ) )
			? $data['sources']
			: array();
	}

	protected function process_source( $source, $key ): void
	{
		if ( $this->is_valid_source( $source, $key ) ) {
			$this->add_username( $source, $key );
		}
	}

	abstract protected function is_valid_source( $source, $key ): bool;

	abstract protected function add_username( $source, $key ): void;

	public function usernames(): array
	{
		return $this->usernames;
	}
}
