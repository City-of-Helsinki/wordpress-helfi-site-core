<?php

namespace Helsinki\WordPress\Site\Core\Integrations\LimitLoginAttemptsReloaded;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {

}
