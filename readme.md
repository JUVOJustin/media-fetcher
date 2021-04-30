[![CI](https://github.com/JUVOJustin/media-fetcher/actions/workflows/main.yml/badge.svg)](https://github.com/JUVOJustin/media-fetcher/actions/workflows/main.yml)

=== Media Fetcher === Contributors: juvodesign Requires at least: 5.5 Tested up to: 5.5 Requires PHP: 7.4

The Media Fetcher plugin visualizes media assets provided by a Rest API.

== Description == The plugin has various handy shortcodes to display various kinds of media assets. Every request is
cached using native WordPress transients for 5 minutes.

## Shortcodes

The following parameters are available for all shortcodes

| Parameter | Type | | Description
|---|---|---|---|
| `api`| `string` | Required | Name of the api specified in within the `MEDIA_FETCHER_API` constant |
| `url`| `string` | Optional | Custom url path relative to api´s base url |
| `classes` | `string` | Optional| CSS classes. E.g. "text-dark rounded-circle" |
| `id` | `string` | Optional| CSS ID. |
| `style` | `string` | Optional | Style variation to display the shortcode. |
| `required` | `string` | Optional | Fields that need to have a value. Simple comparisions are possible. Eg. `video,highlighted=1` |
| `limit` | `int` | Optional | Limit the number of elements. Default `-1` |

### [articles]

Possible styles = `grid`,`swiper`, `list`

| Parameter | Type | | Description
|---|---|---|---|
| `col`| `int` | Optional | Number of columns for grid view |
| `masonry`| `int` | Optional | 0 or 1 to activate masonry for grids |

### [videos]

Possible styles = `grid`,`fixed`

| Parameter | Type | | Description
|---|---|---|---|
| `col`| `int` | Optional | Number of columns for grid view |
| `masonry`| `int` | Optional | 0 or 1 to activate masonry for grids |

### [testimonials]

Possible styles = `grid`

| Parameter | Type | | Description
|---|---|---|---|
| `col`| `int` | Optional | Number of columns for grid view |
| `masonry`| `int` | Optional | 0 or 1 to activate masonry for grids |
| `product`| `string` | Optional | Product name to filter testimonials for |

### [ambassadors]

Possible styles = `grid`

| Parameter | Type | | Description
|---|---|---|---|
| `col`| `int` | Optional | Number of columns for grid view |
| `masonry`| `int` | Optional | 0 or 1 to activate masonry for grids |

== Installation ==

1. Download the latest release as zip folder
1. Upload the plugin to WordPress and activate it
1. Define the required configuration constant in your `wp-config.php` file.

```php
define('MEDIA_FETCHER_API' , [
	"directus_media" => [
		"type" => 'directus',
		"base_url" => "https://domain.tld",
		"token" => 'Bar'
	],
	"wordpress_members" => [
		"type" => 'wordpress',
		"base_url" => "https://domain.tld/wp-json/",
		"user" => 'Foo',
		"password" => 'Bar'
	]
]);
```
