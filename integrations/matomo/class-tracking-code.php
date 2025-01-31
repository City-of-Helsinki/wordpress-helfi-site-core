<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tracking_Code
{
	public function __construct(
		protected Tracking_Code_Config $config
	) {}

	public function is_enabled(): bool
	{
		return ! empty( $this->config->site_id );
	}

	public function script_tag(): string
	{
		return sprintf(
			'<meta name="helsinki-matomo" content="%d">
			<script>%s %s</script>',
			esc_attr( $this->config->site_id ),
			$this->script_config(),
			$this->script_handler()
		);
	}

	protected function script_config(): string
	{
		$out = array( 'var _paq = window._paq = window._paq || [];' );

		if ( $this->config->track_page_view ) {
			$out[] = "_paq.push(['trackPageView']);";
		}

		if ( $this->config->enable_link_tracking ) {
			$out[] = "_paq.push(['enableLinkTracking']);";
		}

		return implode( ' ', $out );
	}

	protected function script_handler(): string
	{
		return implode( ' ', array(
			'(function() {',
			sprintf(
				'var u="%s";',
				$this->config->url
			),
			sprintf(
				"_paq.push(['setTrackerUrl', u+'%s']);",
				$this->config->tracker
			),
			sprintf(
				"_paq.push(['setSiteId', '%s']);",
				(string) $this->config->site_id
			),
			"var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];",
			"g.async=true; g.src=u+'piwik.min.js';",
			's.parentNode.insertBefore(g,s);',
			'})();',
		) );
	}
}
