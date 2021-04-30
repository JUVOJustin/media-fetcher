<?php


namespace MediaFetcher\API;


class Get {

	public function request(string $url, array $args) {
		return wp_safe_remote_get($url, $args);
	}

}
