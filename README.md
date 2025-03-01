# Helsinki Site Core
Opinionated default customizations for Helsinki WordPress sites.

Intended to be used as a Must Use plugin on every Helsinki WordPress site.

## Features
WordPress core customizations with actions and filters.

### Block Editor
- Add Blocks admin menu item
- Disable full screen editor by default

### Dashboard
- Remove Welcome Panel
- Remove PHP nag widget
- Disable default widgets other than Right Now and Activity

### Login
- Use generic login error message
- Use `home_url()` as header url
- Use custom logo or site name as header text
- Use custom styles for header

### Notices
- Remove WordPress update nag
- Remove admin footer text
- Remove update footer text

### Search

- Replace search page `document_title` and `wp_title` with content from `helsinki_site_core_search_meta_title` filter
- Provide translated *n results for the search term x* text via `helsinki_site_core_search_meta_title` filter

### Toolbar
- Remove search item
- Remove WP item

### Users
- Disable user contact methods
- Disable user url field
- Disable user description field
- Disable user avatars

### WP Head
- Remove unnecessary links and meta data from `wp_head()`

## Integrations
Plugin integrations with actions and filters.

### Cache Enabler
[Cache Enabler on wordpress.org](https://wordpress.org/plugins/cache-enabler/)

- Execute `cache_enabler_clear_site_cache` on `helsinki_site_core_cache_clear` action

### Limit Login Attempts Reloaded
[Limit Login Attempts Reloaded on wordpress.org](https://fi.wordpress.org/plugins/limit-login-attempts-reloaded/)

- Daily scheduled operation to clear lockout logs

### Matomo

- Custom `Settings > Helsinki Matomo` menu page
- `helsinki_site_core_matomo[tracking][tracking_id]` setting for storing Matomo ID
- If `tracking_id` is given, the plugin adds Matomo script tag to `wp_head`

### Polylang
[Polylang on wordpress.org](https://fi.wordpress.org/plugins/polylang/)

- Remove `pll_user` script from user related admin views

### Redirection
[Redirection on wordpress.org](https://fi.wordpress.org/plugins/redirection/)

- Overwrite plugin options to prevent IP logging and HTTP header information logging
- Prevent IP or HTTP header information from being stored to log entries

### Smash Balloon
[Smash Balloon social media plugins](https://smashballoon.com/)

- Wraps social media feeds in a `aria-hidden="true"` `div` and  provides source links as a replacement for screen readers

### Yoast SEO
[Yoast SEO on wordpress.org](https://wordpress.org/plugins/wordpress-seo/)

- On search page replace `wpseo_title` with content from `helsinki_site_core_search_meta_title` filter
