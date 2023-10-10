<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Redirection;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init', 11 );
function init(): void {
	if ( ! is_redirection_options_available() ) {
		return;
	}

	add_filter( 'redirection_log_data', __NAMESPACE__ . '\\filter_redirection_log_data', 9999 );
	add_filter( 'redirection_404_data', __NAMESPACE__ . '\\filter_redirection_log_data', 9999 );

	add_filter( 'red_default_options', __NAMESPACE__ . '\\filter_redirection_options', 9999 );
	add_filter( 'redirection_save_options', __NAMESPACE__ . '\\filter_redirection_options', 9999 );
	add_filter( redirection_option_filter(), __NAMESPACE__ . '\\filter_redirection_get_options', 9999 );
}

/**
  * Conditionals
  */
function is_redirection_options_available(): bool {
	return defined( 'REDIRECTION_OPTION' ) && REDIRECTION_OPTION;
}

/**
  * Configuration
  */
function options_overwrite(): array {
	return [
		'ip_logging' => 0,
		'log_header' => false,
	];
}

function log_data_overwrite(): array {
	return [
		'ip' => '',
		'request_data' => '',
	];
}

function redirection_option_filter(): string {
	return 'option_' . REDIRECTION_OPTION;
}

/**
  * Options
  */
function filter_redirection_options( array $options ): array {
	return array_merge( $options, options_overwrite() );
}

function filter_redirection_get_options( $options ): array {
	if ( ! is_array( $options ) ) {
		return $options;
	}

	return array_merge( $options, options_overwrite() );
}

/**
  * Log entries
  */
function filter_redirection_log_data( array $data ): array {
	return array_merge( $data, log_data_overwrite() );
}
