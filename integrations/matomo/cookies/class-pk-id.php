<?php

declare(strict_types = 1);

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo\Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Pk_Id implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'Matomo';
	}

	public function name(): string
	{
		return '_pk_id.*';
	}

	public function label(): string
	{
		return '_pk_id.*';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Matomo-kävijäseurannan eväste kerää käyttäjätietoja, kuten käyttäjän uniikin kävijätiedon.',
			'sv' => 'Matomo-statistiksystemets kaka samlar information om hur webbplatsen används.',
			'en' => 'Matomo Analytics - used to store a few details about the user such as the unique visitor ID.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '393 päivää',
			'sv' => '393 dagar',
			'en' => '393 days'
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
