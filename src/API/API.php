<?php


namespace MediaFetcher\API;


use MediaFetcher\API\Targets\Directus;
use MediaFetcher\API\Targets\WordPress;
use WP_Error;

class API {

	private $api;

	public function __construct( string $api ) {

		if ( defined( 'MEDIA_FETCHER_API' ) && array_key_exists( $api, MEDIA_FETCHER_API ) ) {

			$api = MEDIA_FETCHER_API[ $api ];

			switch ( $api["type"] ) {
				case "directus":
					$this->api = new Directus( $api );
					break;
				case "wordpress":
					$this->api = new WordPress( $api );
					break;
			}

		}

	}

	public function request( string $url, array $args, string $type = "GET" ) {

		if ( empty( $this->api ) ) {
			return new WP_Error( "missing_api_target", "Please pass an api target with the 'api' parameter" );
		}

		$url  = $this->buildUrl( $url );
		$args = $this->api->authenticate( $args );

		$request = null;

		switch ( strtolower( $type ) ) {
			case "post":
				$request = new Post();
				break;
			default:
				$request = new Get();
		}

		// Cache Result
		$requestName = "media-fetcher" . str_replace( "/", "_", parse_url( $url, PHP_URL_PATH ) );
		$response    = get_transient( $requestName );

		if ( ! $response || $response["url"] !== $url || $response["args"] !== $args || $response["type"] !== $type ) {

			// Exit early on request error
			$response = $this->api->request( $request, $url, $args );
			if ( is_wp_error( $response ) ) {
				return $response;
			}

			$value = [
				"url"      => $url,
				"args"     => $args,
				"type"     => $type,
				"response" => $response
			];
			set_transient( $requestName, $value, 300 );

			return $response;
		}

		// Return cached result
		return $response["response"];
	}

	private function buildUrl( string $url ) {

		if ( filter_var( $url, FILTER_VALIDATE_URL ) != false ) {
			return $url;
		}

		return $this->api->getBaseUrl() . untrailingslashit( $url );
	}

	/**
	 * Pass through of base url from actual api target class
	 *
	 * @return string
	 */
	public function getBaseUrl() {
		return $this->api->getBaseUrl();
	}

}
