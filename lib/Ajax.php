<?php

namespace CWRemote\Lib;

class Ajax {
	function __construct() {
		add_action( 'wp_ajax_get_entries', [ $this, 'get_entries' ] );
		add_action( 'wp_ajax_nopriv_get_entries', [ $this, 'get_entries' ] );
	}

	function get_entries() {
		$force = false;
		if ( isset( $_POST['data']['force'] ) ) {
			$force = true;
		}

		$fetcher = new Fetcher();
		$fetcher->url( CWREMOTE_ENDPOINT_URL, $force );

		ob_start();
		Template::load( 'frontend' );
		$data = ob_get_clean();

		wp_send_json_success( $data );
	}
}