<?php

namespace Helsinki\WordPress\Site\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Autoloading
  */
function class_loader( $class ) {
	if ( false === stripos( $class, __NAMESPACE__ ) ) {
		return;
	}

	$parts = array_filter(
		explode(
			DIRECTORY_SEPARATOR,
			str_replace(
				[__NAMESPACE__, '\\'],
				['', DIRECTORY_SEPARATOR],
				$class
			)
		)
	);

	$class = array_pop( $parts );

	$file = path_to_php_file(array_merge(
		array_map('strtolower', $parts),
		[$class]
	));

	if ( file_exists( $file ) ) {
		require_once $file;
	}
}

/**
  * Execution
  */
function load_includes() : void {
	load_php_files( 'includes', load_config('includes') );
}

function load_features() : void {
	load_php_files( 'features', load_config('features') );
}

function load_integrations() : void {
	load_php_files( 'integrations', load_config('integrations') );
}

/**
  * Files
  */
function path_to_file( string $name ) : string {
	return plugin_path() . trim( $name );
}

function path_to_php_file( $name ) : string {
	return is_array( $name )
		? path_to_file( implode( DIRECTORY_SEPARATOR, $name ) . '.php' )
		: path_to_file( $name . '.php' );
}

function load_php_files( string $path, array $files ) : void {
	foreach ( $files as $dir => $file ) {
		$parts = array( $path );

		if ( is_string( $dir ) && $dir ) {
			$parts[] = $dir;
		}

		if ( is_array( $file ) ) {
			load_php_files( implode( DIRECTORY_SEPARATOR , $parts ), $file );
		} else {
			$parts[] = $file;
			require_once path_to_php_file( implode( DIRECTORY_SEPARATOR , $parts ) );
		}
	}
}

function load_config( string $name ) : array {
	$file = path_to_php_file(['config', $name]);
	if ( file_exists( $file ) ) {
		$config = include $file;
		return $config;
	} else {
		return [];
	}
}
