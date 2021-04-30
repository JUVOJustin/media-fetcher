<?php


namespace MediaFetcher\Shortcodes;


use MediaFetcher\API\API;
use Timber\Timber;

class Articles extends Shortcode {

	public function shortcode_articles( $atts ) {

		$defaults = [
			'url'     => "items/articles?sort=-release&fields=*,outlet.*,outlet.logo.private_hash",
			'id'      => "media-articles",
			'style'   => 'list',
			'col'     => '3',
			'masonry' => '0',
			'limit'   => '-1',
		];

		// Add global default attributes
		$atts = $this->shortcode_atts( $atts, $defaults );

		if ( ! is_numeric( $atts["col"] ) || $atts["col"] == 0 ) {
			$atts["col"] = "1";
		}

		// Actual request
		$api    = new API( $atts["api"] );
		$result = $api->request( $atts["url"], [], "GET" );

		// Handle request error
		if ( is_wp_error( $result ) ) {
			print_r( $result );

			return "";
		}

		// Filter response
		$result = apply_filters( "media-fetcher-results", $result, $atts );

		$result = $this->filter_limit_required_field( $result, $atts );

		$context = [
			'base_url' => $api->getBaseUrl(),
			'classes'  => $atts["classes"],
			'response' => $result,
			'id'       => $atts["id"],
			'col'      => $atts["col"]
		];
		switch ( $atts["style"] ) {
			case "list":
				return Timber::compile( 'articles/list.twig', $context );
			case "swiper":
				return Timber::compile( 'articles/swiper.twig', $context );
			case "grid":
				return Timber::compile( 'articles/grid.twig', $context );
		}
	}
}
