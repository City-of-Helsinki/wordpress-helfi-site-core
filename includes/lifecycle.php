<?php

namespace Helsinki\WordPress\Site\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function setup() : void {
	if ( ! did_action( 'helsinki_site_core_setup' ) ) {
		do_action( 'helsinki_site_core_setup' );
	}
}

function loaded() : void {
	do_action( 'helsinki_site_core_loaded' );
}

function init() : void {
	do_action( 'helsinki_site_core_init' );
}

function activate() : void {
	do_action( 'helsinki_site_core_activate' );
}

function deactivate() : void {
	do_action( 'helsinki_site_core_deactivate' );
}

function uninstall() : void {
	do_action( 'helsinki_site_core_uninstall' );
}
