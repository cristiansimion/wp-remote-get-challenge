<?php

namespace CWRemote\Utils;


class CWR_Nonce {
	static function create_nonce( $nonce_name ) {
		wp_nonce_field( $nonce_name . '_action', $nonce_name . '_name_nonce' );
	}

	static function validate_nonce( $nonce_name ) {
		return wp_verify_nonce( $_POST[ $nonce_name . '_name_nonce' ], $nonce_name . '_action' );
	}

	static function get_nonce_action( $nonce_name ) {
		return $nonce_name . '_action';
	}

	static function get_nonce_name( $nonce_name ) {
		return $nonce_name . '_name_nonce';
	}
}