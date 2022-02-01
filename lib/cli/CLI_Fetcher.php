<?php

namespace CWRemote\Lib\Cli;

use CWRemote\Lib\Fetcher;
use \WP_CLI;

class CLI_Fetcher {

	public function force_fetch() {
		$this->fetch( true );
	}

	public function fetch( $force = false ) {
		$fetcher     = new Fetcher();
		$json_result = $fetcher->url_to_json( CWREMOTE_ENDPOINT_URL, $force );

		if ( ! $json_result ) {
			WP_CLI::error( __( 'Could not fetch the endpoint ' . CWREMOTE_ENDPOINT_URL, CWREMOTE_TEXT_DOMAIN ) );
		}

		WP_CLI::success( $json_result );
	}
}