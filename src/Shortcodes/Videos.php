<?php


namespace MediaFetcher\Shortcodes;


use MediaFetcher\API\API;
use Timber\Timber;

class Videos extends Shortcode {

	public function shortcode_videos( $atts ) {

		$defaults = [
			'url'     => "items/videos?sort=-views&&fields=*,thumbnail.private_hash",
			'id'      => "media-videos",
			'style'   => 'grid',
			'col'     => '3',
			'masonry' => '0',
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

		$output  = "";
		$context = [
			'base_url' => $api->getBaseUrl(),
			'classes'  => $atts["classes"],
			'response' => $result,
			'col'      => $atts["col"],
			'masonry'  => $atts["masonry"],
		];
		switch ( $atts["style"] ) {
			case "fixed":
				$output = Timber::compile( 'videos/fixed.twig', $context );
				break;
			case "grid":
				$output = Timber::compile( 'videos/grid.twig', $context );
				break;
		}

		return apply_filters( 'the_content', $output );
	}
}
