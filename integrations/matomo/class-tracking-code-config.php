<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tracking_Code_Config
{
	public function __construct(
		public readonly int $site_id,
		public readonly string $url = '//webanalytics.digiaiiris.com/js/',
		public readonly string $tracker = 'tracker.php',
		public readonly string $script = 'piwik.min.js',
		public readonly bool $track_page_view = true,
		public readonly bool $enable_link_tracking = true
	) {}
}
