<?php

namespace Helsinki\WordPress\Site\Core\Integrations\Matomo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Config
 */
function settings_group_name(): string {
    return 'helsinki-site-core-matomo';
}

function default_setting_values(): array {
    $defaults = array();

    foreach ( matomo_settings_fields() as $type => $fields ) {
        $defaults[$type] = array();

        foreach ( $fields as $key => $field ) {
            $defaults[$type][$key] = $field['default'];
        }
    }

    return $defaults;
}

/**
 * Values
 */
function setting_values(): array {
    return \get_option( settings_group_name(), array() );
}

/**
 * Sanitize
 */
function sanitize_matomo_settings( $values ): array {
    $sanitized = array();

    foreach ( matomo_settings_fields() as $type => $fields ) {
        $sanitized[$type] = array();

        foreach ( $fields as $key => $field ) {
            $sanitized[$type][$key] = call_user_func(
                $field['sanitize_callback'],
                $values[$type][$key] ?? '',
                $type,
                $key
            );
        }
    }

    return $sanitized;
}

/**
 * Register
 */
function register_matomo_settings(): void {
    $group = settings_group_name();
    $page = menu_page_slug();

    \register_setting(
        $group,
        $group,
        array(
			'type' => 'array',
			'description' => '',
			'sanitize_callback' => __NAMESPACE__ . '\\sanitize_matomo_settings',
			'show_in_rest' => false,
			'default' => default_setting_values(),
        )
    );

	add_settings( $page, $group, matomo_settings_fields() );
}

function add_settings( string $page, string $group, array $config ): void
{
    $saved = setting_values();

    foreach ( $config as $type => $fields ) {
        $section = "{$group}_{$type}";

        \add_settings_section(
            $section,
            '',
            '__return_empty_string',
            $page
        );

		foreach ( $fields as $key => $field ) {
            \add_settings_field(
				$key,
				$field['label'],
				$field['callback'],
				$page,
				$section,
				array_merge(
					$field['attributes'],
					array(
						'label_for' => "{$group}-{$type}-{$key}",
						'name' => "{$group}[{$type}][{$key}]",
						'value' => $saved[$type][$key] ?? $field['default'],
					)
				)
			);
		}
    }
}

/**
 * Render
 */
function settings_form(): void {
    echo '<form id="helsinki-matomo-settings" class="settings" action="options.php" method="post">';

    \settings_fields( settings_group_name() );

    \do_settings_sections( menu_page_slug() );

    \submit_button();

    echo '</form>';
}

function render_input( array $args ): void {
	$attributes = array();
	foreach ( $args as $key => $value ) {
		if ( 'label_for' === $key ) {
			$key = 'id';
		}

		$attributes[] = sprintf(
			'%s="%s"',
			\sanitize_key( $key ),
			\esc_attr( $value )
		);
	}

	printf( '<input %s>', implode( ' ', $attributes ) );
}
