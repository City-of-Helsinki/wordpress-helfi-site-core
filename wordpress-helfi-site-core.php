<?php
/**
	* Plugin Name: Helsinki Site Core
	* Description: Opinionated default customizations for Helsinki WordPress sites
	* Requires at least: 6.0
	* Requires PHP: 7.4
	* Version: 2.0.0
	* Author: ArtCloud
	* Author URI: https://www.artcloud.fi
	* License: GPL v3 or later
	* License URI: https://www.gnu.org/licenses/gpl-3.0.html
	* Text Domain: helsinki-site-core
	* Domain Path: /languages
	*/

namespace Helsinki\WordPress\Site\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Setup
  */
require_once plugin_dir_path( __FILE__ ) . 'constants.php';
define_constants( __FILE__ );

require_once plugin_dir_path( __FILE__ ) . 'functions.php';
load_includes();

spl_autoload_register( __NAMESPACE__ . '\\class_loader' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\loaded' );

/**
  * Init
  */
add_action( 'init', __NAMESPACE__ . '\\textdomain' );
add_action( 'init', __NAMESPACE__ . '\\init', 100 );
