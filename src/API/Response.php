<?php


namespace MediaFetcher\API;



class Response {

	private array $headers;
	private array $data;

	public function __construct( array $headers, array $data ) {
		$this->data    = $data;
		$this->headers = $headers;
	}

	/**
	 * @return array
	 */
	public function getData(): array {
		return $this->data;
	}

	/**
	 * @param string $header
	 *
	 * @return array
	 */
	public function getHeaders(): array {
		return $this->headers;
	}

	/**
	 * @param string $header
	 *
	 * @return string
	 */
	public function getHeader( string $header ): string {

		if ( isset( $this->headers[ $header ] ) ) {
			return $this->headers[ $header ];
		}

		return "";
	}

}
