<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_filter( 'cmplz_known_script_tags', __NAMESPACE__ . '\\provide_cmplz_matomo_script' );
function provide_cmplz_matomo_script( array $tags ): array {
	$config = create_tracking_code_config( setting_values() );

	$tags[] = array(
		'name' => cmplz_integration_name(),
		'category' => 'statistics',
		'urls' => array( $config->url ),
	);

	return $tags;
}

\add_filter( 'cmplz_detected_services', __NAMESPACE__ . '\\provide_cmplz_detected_matomo' );
function provide_cmplz_detected_matomo( $statistics ): array {
	if ( ! in_array( 'matomo', $statistics ) ) {
		$statistics[] = 'matomo';
	}

	return $statistics;
}
