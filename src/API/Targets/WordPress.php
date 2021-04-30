<?php


namespace MediaFetcher\API\Targets;


class WordPress extends Target {

	private $api;

	/**
	 * WordPress constructor.
	 *
	 * @param array $api
	 */
	public function __construct( array $api ) {

		parent::__construct( $api["base_url"] );
		$this->api = $api;

	}

	public function authenticate( array $args ): array {
		return $this->basic_auth( $args, $this->api["user"], $this->api["password"] );
	}

	public function request( $request, $url, $args ) {

		$page = 1;
		$data = [];

		// Initial request for first page
		$response = $request->request( $this->add_page_parameter( $url, $page ), $args );
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		$data = array_merge( $data, $this->processBody( $response ) );
		$page ++;

		// get totalpages to see if paged
		$totalPages = wp_remote_retrieve_header( $response, "x-wp-totalpages" );

		if ( ! empty( $totalPages ) ) {

			while ( $page <= $totalPages ) {

				$response = $request->request( $this->add_page_parameter( $url, $page ), $args );
				if ( is_wp_error( $response ) ) {
					return $response;
				}
				$data = array_merge( $data, $this->processBody( $response ) );

				$page ++;

			}

		}

		return $data;

	}
}