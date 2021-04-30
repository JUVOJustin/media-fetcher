<?php


namespace MediaFetcher\Shortcodes;


use MediaFetcher\API\API;
use Timber\Timber;

class Testimonials extends Shortcode {

	public function shortcode_testimonials( $atts ) {

		$defaults = [
			'url'     => "items/testimonials?fields=*,products.product.*",
			'id'      => "media-testimonials",
			'style'   => 'grid',
			'col'     => '3',
			'masonry' => '0',
			'product' => '',
		];

		// Add global default attributes
		$atts = $this->shortcode_atts( $atts, $defaults );

		// Additional validation
		if ( ! empty( $atts["product"] ) && is_string( $atts["product"] ) ) {
			$atts["url"] .= add_query_arg( 'filter[products.product.name][contains]', $atts["product"], $atts["url"] );
		}
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

		$output = "";
		switch ( $atts["style"] ) {
			case "grid":
				$output = Timber::compile( 'testimonials/grid.twig', [
					'classes'  => $atts["classes"],
					'response' => $result,
					'col'      => $atts["col"],
					'masonry'  => $atts["masonry"]
				] );
				break;
		}

		return apply_filters( 'the_content', $output );
	}

}
