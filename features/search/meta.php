<?php

namespace Helsinki\WordPress\Site\Core\Search\Meta;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Init
  */
add_action( 'helsinki_site_core_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	add_filter( 'document_title', __NAMESPACE__ . '\\provide_search_meta_title', 9999, 1 );
	add_filter( 'wp_title', __NAMESPACE__ . '\\provide_search_meta_title', 9999, 1 );

	add_filter( 'helsinki_site_core_search_meta_title', __NAMESPACE__ . '\\search_meta_title' );
}

function provide_search_meta_title( string $title ): string {
	return is_search() ? apply_filters( 'helsinki_site_core_search_meta_title', $title ) : $title;
}

function search_meta_title(): string {
	return implode( ' | ', search_meta_title_parts( search_found_items_count(), search_term() ) );
}

function search_meta_title_parts( int $found, string $term ): array {
	return array(
		$found ? n_search_items_found_text( $found, $term ) : no_search_items_found_text( $term ),
		site_name(),
		__( 'City of Helsinki', 'helsinki-site-core' )
	);
}

function no_search_items_found_text( string $term ): string {
	return sprintf( _x(
		'0 results for the search term %1$s',
		'search meta_title %1$s: search term',
		'helsinki-site-core'
	), $term );
}

function n_search_items_found_text( int $count, string $term ): string {
	return sprintf( _nx(
		'%1$d result for the search term %2$s',
		'%1$d results for the search term %2$s',
		$count,
		'search meta_title %1$d: count %2$s: search term',
		'helsinki-site-core'
	), $count, $term );
}

function search_found_items_count(): int {
	global $wp_query;

	return $wp_query->found_posts;
}

function search_term(): string {
	return get_query_var( 's' );
}

function site_name(): string {
	return get_bloginfo( 'name' );
}
