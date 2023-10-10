<?php

namespace Helsinki\WordPress\Site\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function setup_filters() : void {
	$filters = [
	  'plugin_version',
	  'plugin_main_file',
	  'plugin_path',
	  'plugin_dirname',
	  'plugin_basename',
	  'plugin_slug',
	  'plugin_name',
	  'plugin_url',
	  'is_debug',
	  'asset_version',
	  'assets_url',
	  'script_url',
	  'style_url',
	  'path_to_file',
	  'path_to_php_file',
	  'load_config',
	];

	foreach ($filters as $filter) {
		add_filter( 'helsinki_site_core_' . $filter, __NAMESPACE__ . '\\' . $filter );
	}
}
