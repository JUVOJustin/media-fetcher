<?php


namespace MediaFetcher\API\Targets;


use MediaFetcher\API\Response;
use WP_Error;

class Target {

	protected string $base_url;

	/**
	 * API_Target constructor.
	 *
	 * @param string $base_url
	 */
	protected function __construct( string $base_url ) {
		$this->base_url = $base_url;
	}

	/**
	 * @return string
	 */
	public function getBaseUrl(): string {
		return trailingslashit( $this->base_url );
	}

	protected function basic_auth( array $args, string $username, string $password ): array {
		$authorization = [ "Authorization" => 'Basic ' . base64_encode( "$username:$password" ) ];

		return $this->add_authorization_header( $args, $authorization );
	}

	protected function bearer_auth( array $args, string $token ) {
		$authorization = [ "Authorization" => "Bearer $token" ];

		return $this->add_authorization_header( $args, $authorization );
	}

	private function add_authorization_header( array $args, array $authorization ) {

		$headers = isset( $args["headers"] ) ? $args["headers"] : [];

		$args["headers"] = array_merge( $headers, $authorization );

		return $args;

	}

	protected function add_page_parameter( $url, $value ) {
		return add_query_arg( "page", $value, $url );
	}

	protected function processResponse( $response ) {

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$body    = wp_remote_retrieve_body( $response );
		$body    = json_decode( $body );
		$headers = wp_remote_retrieve_headers( $response )->getAll();

		// If data object inside request make as main body
		if ( isset( $body->data ) ) {
			$body = $body->data;
		}

		// Check if request was possible but failed on api
		if ( ! empty( $body->error ) ) {
			return new WP_Error( $body->error->code, $body->error->message );
		}

		return new Response( $headers, $body );
	}

	protected function processBody( $response ) {
		return json_decode( wp_remote_retrieve_body( $response ), true );
	}

}