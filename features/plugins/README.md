# Plugin management

Helsinki Site Core disables plugin activation and deactivation actions by default as these operations are handled via [wordpress.hel.fi portal](https://wordpress.hel.fi/).

## Constants

Site administrators can override the default behaviour by defining `HELSINKI_PLUGIN_MANAGEMENT_ALLOWED` constant in their `wp-config.php` file.

```
define( 'HELSINKI_PLUGIN_MANAGEMENT_ALLOWED', true );
```

## Filters

Site administrators can also use the following filters to enable or disable plugin management, and to define which actions are allowed.

### Enable or disable plugin management
```
apply_filters( 'helsinki_site_core_plugin_management_disabled', bool $disabled )
```

When using this filter, add your callback on `plugins_loaded` action with priority less than 10.

```
add_action( 'plugins_loaded', function() {
	add_filter( 'helsinki_site_core_plugin_management_disabled', '__return_false' );
}, 9 );
```

### Disallowed plugin actions

Associative array with action names as keys, value can be anything.

```
apply_filters( 'helsinki_site_core_disallowed_plugin_actions', array $disallowed )
```

### Disallowed plugin bulk actions

Associative array with action names as keys, value can be anything.

```
apply_filters( 'helsinki_site_core_disallowed_plugin_bulk_actions', array $disallowed )
```
