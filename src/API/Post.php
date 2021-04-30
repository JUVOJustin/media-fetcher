<?php


namespace MediaFetcher\API;


class Post {

	public function request(string $url, array $args) {
		return wp_safe_remote_post($url, $args);
	}

}
