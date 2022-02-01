<?php

namespace CWRemote\Lib;

class Validation {
	function __construct() {
		add_filter( 'cwremote_data_filtering', [ $this, 'validation' ], 10, 1 );
	}

	/**
	 * This function can be used to further sanitize the data
	 *
	 * @param string $data
	 *
	 * @return string
	 */
	function validation( $data ) {
		return sanitize_text_field( $data );
	}
}