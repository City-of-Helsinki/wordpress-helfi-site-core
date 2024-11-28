<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Adapters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Twitter_Feed_Adapter implements Social_Feed_Adapter_Interface
{
	public function __construct()
	{

	}

	public function render_source(): string
	{
		return '';
	}
}
