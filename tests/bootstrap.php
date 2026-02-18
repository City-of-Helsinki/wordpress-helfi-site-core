<?php

require_once __DIR__ . '/../vendor/autoload.php';

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/../' );
}

function __( string $text, string $namespace ): string {
	return $text;
}

spl_autoload_register( function ( string $class ) {
	$namespace = 'Helsinki\WordPress\Site\Core';

	if ( false === stripos( $class, $namespace ) ) {
		return;
	}

	$parts = array_filter(
		explode(
			DIRECTORY_SEPARATOR,
			str_replace(
				[$namespace, '\\'],
				['', DIRECTORY_SEPARATOR],
				$class
			)
		)
	);

	$class = array_pop( $parts );
	$class = 'class-' . str_replace( '_', '-', strtolower( $class ) );

	$file = implode(
		DIRECTORY_SEPARATOR,
		array(
			dirname( __FILE__, 2 ),
			...array_map('strtolower', $parts ),
			$class . '.php'
		)
	);

	if ( file_exists( $file ) ) {
		require_once $file;
	}
} );
