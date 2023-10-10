<?php

namespace Helsinki\WordPress\Site\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function textdomain() {
	if ( apply_filters( 'helsinki_site_core_is_must_use_plugin', false ) ) {
		load_muplugin_textdomain(
			'helsinki-site-core',
			apply_filters( 'helsinki_site_core_plugin_dirname', '' ) . '/languages'
		);
	} else {
		load_plugin_textdomain(
			'helsinki-site-core',
			false,
			apply_filters( 'helsinki_site_core_plugin_dirname', '' ) . '/languages'
		);
	}
}
