<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Composite_Feed_Adapter implements Social_Feed_Adapter_Interface
{
	protected array $adapters;

	public function __construct( Social_Feed_Adapter_Interface ...$adapters )
	{
		$this->adapters = $adapters;
	}

	public function render_source(): string
	{
		return implode( '', $this->render_adapter_sources() );
	}

	protected function render_adapter_sources(): array
	{
		return array_map( fn($adapter) => $adapter->render_source(), $this->adapters );
	}
}
