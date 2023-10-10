<?php

namespace Helsinki\WordPress\Site\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function textdomain() {
	load_plugin_textdomain(
		'helsinki-site-core',
		false,
		apply_filters( 'helsinki_site_core_plugin_dirname', '' ) . '/languages'
	);
}
