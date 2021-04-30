<?php


namespace MediaFetcher\Shortcodes;


use MediaFetcher\API\API;
use Timber\Timber;

class Ambassadors extends Shortcode {

	public function shortcode_ambassadors( $atts ) {

		$defaults = [
			'url'     => "academy/v1/ambassadors",
			'id'      => "media-ambassadors",
			'style'   => 'grid',
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

		// Normalize
		$result = $this->normalize_for_twig( $result );

		$result = $this->filter_limit_required_field( $result, $atts );

		$output = "";
		switch ( $atts["style"] ) {
			case "grid":
				$output = Timber::compile( 'ambassadors/grid.twig', [
					'classes'  => $atts["classes"],
					'response' => $result,
					'col'      => $atts["col"],
					'masonry'  => $atts["masonry"]
				] );
				break;
		}

		return apply_filters( 'the_content', $output );
	}

	private function normalize_for_twig( $result ) {

		$data = [];
		foreach ( $result as $item ) {
			$ambassador         = $item["ambassador"];
			$ambassador["name"] = $item["name"];
			$data[]             = $ambassador;
		}

		return $data;

	}
}
