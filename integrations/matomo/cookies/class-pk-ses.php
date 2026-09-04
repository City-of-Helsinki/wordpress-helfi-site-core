<?php

declare(strict_types = 1);

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo\Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Pk_Ses implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'Matomo';
	}

	public function name(): string
	{
		return '_pk_ses.*';
	}

	public function label(): string
	{
		return '_pk_ses.*';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Matomo-kävijäseurannan eväste yhdistää istunnon aikana suoritetut toiminnot (esim. sivun katselut, lataukset ja tapahtumat) yksittäiseen vierailuun.',
			'sv' => 'Kakan för Matomo-besökaruppföljningen kopplar ihop aktiviteter som skett under en session (t.ex. sidvisningar, nedladdningar och aktiviteter) med ett enskilt besök.',
			'en' => 'Matomo Analytics - Used to link actions performed during the session (e.g., page views, downloads, events) to a unique visit, thereby allowing Matomo to accurately attribute these actions to a single session.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '1 tunti',
			'sv' => '1 timme',
			'en' => '1 hour'
		);
	}

	public function type(): string
	{
		return 'cookie';
	}

	public function category(): string
	{
		return 'statistics';
	}
}
