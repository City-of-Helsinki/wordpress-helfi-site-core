<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function provide_tracking_script(): void {
	$settings = setting_values();

	if ( is_tracking_enabled( $settings ) ) {
		echo build_tracking_script( $settings );
	}
}

function is_tracking_enabled( array $settings ): bool {
	return ! empty( $settings['tracking']['tracking_id'] );
}

function tracking_code_config( array $settings ): Tracking_Code_Config {
	return new Tracking_Code_Config(
		site_id: $settings['tracking']['tracking_id']
	);
}

function build_tracking_script( array $settings ): string {
	$config = tracking_code_config( $settings );

	return sprintf(
		'<meta name="helsinki-matomo" content="%d">
		<script%s>%s %s</script>',
		esc_attr( $config->site_id ),
		build_script_attributes( $config ),
		build_script_config( $config ),
		build_script_handler( $config )
	);
}

function build_script_attributes( Tracking_Code_Config $config ): string {
	$attributes = \apply_filters(
		'helsinki_site_core_matomo_script_attributes',
		array(),
		$config
	);

	$html = array();
	foreach ( $attributes as $key => $value ) {
		if ( is_valid_script_attribute( $key ) ) {
			$html = sprintf( '%s="%s"', sanitize_key( $key ), esc_attr( $value ) );
		}
	}

	return $html ? ' ' . implode( ' ', $html ) : '';
}

function is_valid_script_attribute( string $key ): bool {
	return 'type' === $key || 'data-' === substr( $key, 0, 5 );
}

function build_script_config( Tracking_Code_Config $config ): string {
	$out = array( 'var _paq = window._paq = window._paq || [];' );

	if ( $config->track_page_view ) {
		$out[] = "_paq.push(['trackPageView']);";
	}

	if ( $config->enable_link_tracking ) {
		$out[] = "_paq.push(['enableLinkTracking']);";
	}

	return implode( ' ', $out );
}

function build_script_handler( Tracking_Code_Config $config ): string {
	return implode( ' ', array(
		'(function() {',
		sprintf( 'var u="%s";', $config->url ),
		sprintf( "_paq.push(['setTrackerUrl', u+'%s']);", $config->tracker ),
		sprintf( "_paq.push(['setSiteId', '%s']);", (string) $config->site_id ),
		"var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];",
		"g.async=true; g.src=u+'piwik.min.js';",
		's.parentNode.insertBefore(g,s);',
		'})();',
	) );
}
