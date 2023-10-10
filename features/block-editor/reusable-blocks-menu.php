<?php

namespace Helsinki\WordPress\Site\Core\BlockEditor\Menu;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_action( 'admin_menu', __NAMESPACE__ . '\\reusable_blocks_menu' );
}

function reusable_blocks_menu(): void {
	add_menu_page(
		__( 'Blocks', 'helsinki-site-core' ),
		__( 'Blocks', 'helsinki-site-core' ),
		'edit_posts',
		'edit.php?post_type=wp_block',
		'',
		'dashicons-editor-table',
		22
	);
}
