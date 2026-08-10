<?php

declare(strict_types = 1);

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo\Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Mtm_Cookie_Consent implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'Matomo';
	}

	public function name(): string
	{
		return 'mtm_cookie_consent';
	}

	public function label(): string
	{
		return 'mtm_cookie_consent';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Tallentaa Matomon evästeiden suostumusasetukset.',
			'sv' => 'Lagrar Matomos inställningar för cookie-samtycke.',
			'en' => 'Stores Matomo cookie consent preferences.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '1 vuosi',
			'sv' => '1 år',
			'en' => '1 year'
		);
	}

	public function type(): string
	{
		return 'cookie';
	}

	public function category(): string
	{
		return 'functional';
	}
}
