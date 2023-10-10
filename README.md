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

### Limit Login Attempts Reloaded
[Limit Login Attempts Reloaded on wordpress.org](https://fi.wordpress.org/plugins/limit-login-attempts-reloaded/)

### Redirection
[Redirection on wordpress.org](https://fi.wordpress.org/plugins/redirection/)

- Overwrite plugin options to prevent IP logging and HTTP header information logging
- Prevent IP or HTTP header information from being stored to log entries

### Polylang
[Polylang on wordpress.org](https://fi.wordpress.org/plugins/polylang/)

- Remove `pll_user` script from user related admin views
