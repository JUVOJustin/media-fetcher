<?php


namespace MediaFetcher;


use MediaFetcher\Shortcodes\Ambassadors;
use MediaFetcher\Shortcodes\Articles;
use MediaFetcher\Shortcodes\Filter;
use MediaFetcher\Shortcodes\Testimonials;
use MediaFetcher\Shortcodes\Videos;

class Media_Fetcher {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected Loader $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected string $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected string $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MEDIA_FETCHER_VERSION' ) ) {
			$this->version = MEDIA_FETCHER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'media-fetcher';

		$this->loader = new Loader();

		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

//		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
//		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		add_filter( 'timber/locations', function( $locations ) {

			if ( file_exists( get_stylesheet_directory() . '/media-fetcher/templates' ) ) {
				$locations[] = get_stylesheet_directory() . '/media-fetcher/templates';
			}

			$locations = array_merge( $locations, array(
				MEDIA_FETCHER_PATH . 'templates'
			) );

			return $locations;
		} );

		//Bootstrap
		$this->loader->add_action( "wp_enqueue_scripts", $this, "load_bootstrap" );

		// Load Frontend Scripts and styles
		$this->loader->add_action( "wp_enqueue_scripts", $this, "load_frontend_scripts_styles" );

		$this->loader->add_shortcode( "articles", new Articles(), "shortcode_articles" );

		$this->loader->add_shortcode( "videos", new Videos(), "shortcode_videos" );

		$this->loader->add_shortcode( "testimonials", new Testimonials(), "shortcode_testimonials" );

		$this->loader->add_shortcode( "ambassadors", new Ambassadors(), "shortcode_ambassadors" );

		$this->loader->add_filter( "media-fetcher-results", new Filter(), "filter_results", 10, 2 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Loader Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	public function load_bootstrap() {
		wp_enqueue_style( "bootstrap-css", MEDIA_FETCHER_URL . 'node_modules/bootstrap/dist/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_script( "bootstrap-js", MEDIA_FETCHER_URL . 'node_modules/bootstrap/dist/js/bootstrap.min.js', array("jQuery"), $this->version, false );
	}

	public function load_frontend_scripts_styles() {
		wp_enqueue_script( $this->plugin_name . "_swiper_js", MEDIA_FETCHER_URL ."node_modules/swiper/swiper-bundle.js", array(), $this->version, false );
		wp_enqueue_script( $this->plugin_name . "_swiper_config_js", MEDIA_FETCHER_URL ."assets/js/swiper-config.js", array("jquery"), $this->version, true );
		wp_enqueue_script( $this->plugin_name . "_masonry_js", MEDIA_FETCHER_URL ."node_modules/masonry-layout/dist/masonry.pkgd.min.js", array(), $this->version, false );
		wp_enqueue_script( $this->plugin_name . "_masonry_config_js", MEDIA_FETCHER_URL ."assets/js/masonry.js", array("jquery"), $this->version, true );
		wp_enqueue_style( $this->plugin_name, MEDIA_FETCHER_URL . "assets/css/media-fetcher.css", array(), $this->version, 'all' );
	}

}
