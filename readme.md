[![CI](https://github.com/JUVOJustin/media-fetcher/actions/workflows/main.yml/badge.svg)](https://github.com/JUVOJustin/media-fetcher/actions/workflows/main.yml)

=== Media Fetcher ===
Contributors: juvodesign
Requires at least: 5.5
Tested up to: 5.5
Requires PHP: 7.4

The Media Fetcher plugin visualizes media assets provided by a Rest API.

== Description ==
The plugin has various handy shortcodes to display various kinds of media assets. Every request is cached using native WordPress transients.

== Installation ==

1. Download the latest release as zip folder
1. Upload the plugin to WordPress and activate it
1. Define the two required configuration constants in your `wp-config.php` file.
```
define('MEDIA_FETCHER_TOKEN', "your_token");
define('MEDIA_FETCHER_BASE_URL', "your_api_base_url");
```
