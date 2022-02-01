<?php

namespace CWRemote\Lib;

use \WP_CLI;

class CLI {
	function __construct() {
		add_action( 'cli_init', [ $this, 'register' ] );
	}

	/**
	 * Register CLI commands for cwremote
	 */
	function register() {
		WP_CLI::add_command( 'cwremote', __NAMESPACE__ . '\\Cli\\CLI_Fetcher' );
	}
}