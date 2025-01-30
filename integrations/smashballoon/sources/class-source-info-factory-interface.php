<?php

namespace Helsinki\WordPress\Site\Core\Integrations\SmashBalloon\Sources;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Source_Info_Factory_Interface
{
	public function social_wall_feeds( array $attributes ): Source_Info_Interface;
	public function facebook_source_info( array $attributes ): Source_Info_Interface;
	public function instagram_source_info( array $attributes ): Source_Info_Interface;
	public function twitter_source_info( array $attributes ): Source_Info_Interface;
	public function youtube_source_info( array $attributes ): Source_Info_Interface;
}
