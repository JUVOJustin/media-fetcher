<?php
/**
 * Plugin Name:     Media Fetcher
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Display Media Assets from an API with predefined layouts.
 * Author:          JUVO Webdesign - Justin Vogt
 * Author URI:      https://juvo-design.de
 * Text Domain:     media-fetcher
 * Domain Path:     /languages
 * Version:         1.1.0
 *
 * @package         Media_Fetcher
 */

// If this file is called directly, abort.
use MediaFetcher\Activator;
use MediaFetcher\Deactivator;
use MediaFetcher\Media_Fetcher;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MEDIA_FETCHER_VERSION', '1.0.6' );


/**
 * Plugin absolute path
 */
define( 'MEDIA_FETCHER_PATH', plugin_dir_path( __FILE__ ) );
define( 'MEDIA_FETCHER_URL', plugin_dir_url( __FILE__ ) );

/**
 * Use Composer PSR-4 Autoloading
 */
require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_media_fetcher() {
	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_media_fetcher() {
	Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_media_fetcher' );
register_deactivation_hook( __FILE__, 'deactivate_media_fetcher' );


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_media_fetcher() {
	$plugin = new Media_Fetcher();
	$plugin->run();
}

run_media_fetcher();

$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'http://plugins.juvo-design.de/media-fetcher/details.json',
	__FILE__,
	'media-fetcher'
);
