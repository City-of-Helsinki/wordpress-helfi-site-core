<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Social_Feed_Adapter_Interface
{
	public function render_source(): string;
}
