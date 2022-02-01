<?php

namespace CWRemote\Lib;

class Fetcher {

	public $reset_time;

	function __construct() {
		$this->reset_time = Storage::$reset_time; // set to the default of the storage
	}

	function url_to_json( $url, $force = false ) {
		$data = $this->url( $url, $force );

		// Return the same result as data if there was an issue
		// TODO: No mechanism was enlisted for errors while updating the option. This can be added if required in the future
		if ( ! $data ) {
			return $data;
		}

		return json_encode( $data );
	}

	function url( $url, $force = false ) {
		$parsed_url = parse_url( $url );
		$url        = strtok( $url, "?" );
		$query      = isset( $parsed_url['query'] ) ? $parsed_url['query'] : '';

		// Create a hook if we want to process anything in relation to the query
		$query_data  = apply_filters( 'cwremote_request_query_data', [], $query );
		$request_url = apply_filters( 'cwremote_request_url_complete', $url, $parsed_url );

		$last_save_timestamp = Storage::get_saved_timestamp();

		// If we're not forcing and reset_time hasn't passed yet
		if ( ( $last_save_timestamp > ( time() - $this->reset_time ) ) && $force == false ) {
			return Storage::get_data_array();
		}

		$data = wp_remote_get( $request_url, $query_data );

		// Return false if error fetching the URL
		if ( is_wp_error( $data ) ) {
			return false;
		}

		$data = $data['body'];
		$data = Storage::save( $data );

		// Return false if update was not possible
		// TODO: No mechanism was enlisted for errors while updating the option. This can be added if required in the future
		if ( ! $data ) {
			return false;
		}

		// return the data
		return json_decode( $data, true );
	}
}