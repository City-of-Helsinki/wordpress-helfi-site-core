<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function provide_tracking_script(): void {
	$tracking = create_tracking_code(
		create_tracking_code_config( setting_values() )
	);

	if ( $tracking->is_enabled() ) {
		echo $tracking->script_tag();
	}
}

function create_tracking_code_config( array $settings ): Tracking_Code_Config {
	return new Tracking_Code_Config(
		site_id: absint( $settings['tracking']['tracking_id'] )
	);
}

function create_tracking_code( Tracking_Code_Config $config ): Tracking_Code {
	return new Tracking_Code( $config );
}
