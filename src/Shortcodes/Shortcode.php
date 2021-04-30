<?php


namespace MediaFetcher\Shortcodes;


class Shortcode {

	protected function shortcode_atts( array $atts, array $defaults = [] ): array {

		$global_defaults = array(
			'api'      => "",
			'url'      => "",
			'classes'  => "",
			'id'       => "",
			'style'    => '',
			'required' => '',
			'limit'    => '-1',
		);

		// merge global with passed per shortcode defaults
		$defaults = array_merge( $global_defaults, $defaults );

		return shortcode_atts( $defaults, $atts );
	}

	protected function filter_limit_required_field( $data, array $atts ) {

		if ( empty( $data ) ) {
			return [];
		}

		foreach ( $data as $key => &$item ) {

			// Check if required fields exist
			if ( ! empty( $atts["required"] ) ) {

				$required = explode( ",", str_replace( ' ', '', $atts["required"] ) );
				foreach ( $required as $field ) {

					// Split comparing fields
					if ( strpos( $field, "=" ) !== false ) {
						$field = explode( "=", $field );
						$value = $field[1];
						$field = $field[0];

						// If comparing field compare
						if ( $item[ $field ] != $value ) {
							unset( $data[ $key ] );
							continue 2;
						}
					}

					// Remove if field is empty in item
					if ( empty( $item[ $field ] ) ) {
						unset( $data[ $key ] );
						continue 2;
					}
				}

			}

		}

		if ( $atts["limit"] != "-1" ) {
			$data = array_slice( $data, 0, intval( $atts["limit"] ) );
		}

		return $data;

	}

}