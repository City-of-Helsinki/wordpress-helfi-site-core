<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function matomo_settings_fields(): array {
	return array(
		'tracking' => tracking_settings_fields(),
	);
}

function tracking_settings_fields(): array {
	return array(
		'tracking_id' => array(
			'label' => __( 'Matomo ID', 'helsinki-site-core' ),
			'callback' => __NAMESPACE__ . '\\render_input',
			'default' => 0,
			'sanitize_callback' => 'sanitize_text_field',
			'attributes' => array(
				'type' => 'number',
				'min' => 0,
				'step' => 1,
			),
		),
	);
}
