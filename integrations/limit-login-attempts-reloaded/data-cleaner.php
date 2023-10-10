<?php

namespace Helsinki\WordPress\Site\Core\Integrations\LimitLoginAttemptsReloaded;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use LLAR\Core\LimitLoginAttempts;
use LLAR\Core\Config;
use ReflectionClass;

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init', 11 );
function init(): void {
	if ( ! is_llar_initialized() ) {
		return;
	}

	add_action( 'admin_init', __NAMESPACE__ . '\\maybe_schedule_llar_cleaner' );
	add_action( schedule_name(), __NAMESPACE__ . '\\clear_llar_logs' );
	add_action( llar_plugin_deactivate_hook(), __NAMESPACE__ . '\\clear_schedule' );
}

/**
  * Config
  */
function llar_plugin_deactivate_hook(): string {
	return 'deactivate_limit-login-attempts-reloaded/limit-login-attempts-reloaded.php';
}

/**
  * Conditionals
  */
function is_llar_initialized(): bool {
	return class_exists( LimitLoginAttempts::class );
}

/**
  * Handlers
  */
function reflect_llar(): LimitLoginAttempts {
	$reflection = new ReflectionClass( LimitLoginAttempts::class );

	return $reflection->newInstanceWithoutConstructor();
}

function init_llar_config(): void {
	Config::init();
}

function clear_llar_logs(): void {
	$llar = reflect_llar();

	init_llar_config();

	$llar->cleanup();

	Config::update(
		'logged',
		filter_unlocked_ips_from_logs( Config::get( 'logged' ) )
	);
}

function filter_unlocked_ips_from_logs( array $logs ): array {
	foreach ($logs as $ip => $entries) {
		foreach ($entries as $user_name => $data) {
			if (! empty( $data['unlocked'] )) {
				unset($logs[$ip][$user_name]);
			}
		}

		if ( empty($logs[$ip]) ) {
			unset($logs[$ip]);
		}
	}

	return $logs;
}

/**
  * Schedule
  */
function schedule_name(): string {
	return apply_filters( 'helsinki_site_core_plugin_slug', '' ) . '_llar_cleaner';
}

function maybe_schedule_llar_cleaner(): void {
	if ( ! wp_next_scheduled( schedule_name() ) ) {
		wp_schedule_event( time(), 'daily', schedule_name() );
	}
}

function clear_schedule(): void {
	wp_clear_scheduled_hook( schedule_name() );
}
