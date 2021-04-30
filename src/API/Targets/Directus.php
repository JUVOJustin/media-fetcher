<?php


namespace MediaFetcher\API\Targets;


class Directus extends Target {

	private $api;

	/**
	 * Directus constructor.
	 *
	 * @param array $api
	 */
	public function __construct( array $api ) {

		parent::__construct( $api["base_url"] );
		$this->api = $api;

	}

	public function authenticate( array $args ): array {
		return $this->bearer_auth( $args, $this->api["token"] );
	}

	public function request( $request, $url, $args ) {

		$output = [];
		$next   = "";

		do {

			// Make request for first page or next if set
			if ( empty( $next ) ) {
				$response = $request->request( add_query_arg( "meta", "*", $url ), $args );
			} else {
				$response = $request->request( $next, $args );
			}

			if ( is_wp_error( $response ) ) {
				return $response;
			}
			$data   = $this->processBody( $response );
			$output = array_merge( $output, $data["data"] );

			$next = isset( $data['meta']["links"]["next"] ) ? $data['meta']["links"]["next"] : "";

		} while ( $next != "" );

		return $output;

	}
}