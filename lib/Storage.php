<?php

namespace CWRemote\Lib;

class Storage {
	static $option_name = 'cwremote_custom_save';
	static $reset_time = CWREMOTE_RESET_TIME; // in seconds


	/**
	 * This function will save the data at any given point
	 *
	 * @param string $json : json encoded data fetched
	 *
	 * @return string|bool: JSON formatted data, or false if unable to save
	 */
	static function save( $json ) {
		$data = json_decode( $json, true );
		$data = self::sanitize_data( $data );

		$formatted = self::format_data( $data, time() );
		$json_data = json_encode( $formatted );

		$updated = update_option( self::$option_name, $json_data );

		return $updated ? $json_data : false;
	}

	/**
	 * Recursive function to sanitize data in an array. cwremote_data_filtering filter hook to apply additional filtering to the data if required.
	 *
	 * @param $data
	 *
	 * @return array|string
	 */
	static function sanitize_data( $data ) {
		if ( ! is_array( $data ) ) {
			return apply_filters( 'cwremote_data_filtering', $data ); // include RAW if we want to change the method of sanitizing
		}

		$filtered = [];
		foreach ( $data as $key => $value ) {
			$filtered[ self::sanitize_data( $key ) ] = self::sanitize_data( $value );
		}

		return $filtered;
	}

	/**
	 * Format the data accordingly to be consistent throughout the whole plugin
	 *
	 * @param $data
	 * @param $timestamp
	 *
	 * @return array
	 */
	static function format_data( $data, $timestamp ) {
		$formatted_data = [
			'title' => __( "Lorem ipsum default title", CWREMOTE_TEXT_DOMAIN ),
			'data'  => [
				'headers' => [],
				'rows'    => []
			]
		];

		$formatted_data = wp_parse_args( $data, $formatted_data );

		return apply_filters( 'cwremote_data_format', [
			'data'      => $formatted_data,
			'timestamp' => $timestamp
		], $data, $timestamp );
	}

	static function get_data_array() {
		return json_decode( self::get_data(), true );
	}

	/**
	 * Retrieves saved data, or give defaults
	 * @return string: formatted data
	 */
	static function get_data() {
		return get_option( self::$option_name, self::return_defaults() );
	}

	/**
	 * @return string: formatted data
	 */
	static function return_defaults() {
		$data      = apply_filters( 'cwremote_default_data', [] );
		$timestamp = apply_filters( 'cwremote_default_expire', time() - ( self::$reset_time + 1 ) ); // +1 to make sure that it's older than 1 hour

		return json_encode( self::format_data( $data, $timestamp ) );
	}

	/**
	 * Returns the unix timestamp for the last saved record, or the default value.
	 * @return int: unix timestamp
	 */
	static function get_saved_timestamp() {
		$saved_data       = self::get_data();
		$saved_data_array = json_decode( $saved_data, true );

		return $saved_data_array['timestamp'];
	}
}