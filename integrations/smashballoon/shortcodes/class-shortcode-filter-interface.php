<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Shortcode_Filter_Interface
{
	public function filter_output( string $output, array $attributes ): string;
}
