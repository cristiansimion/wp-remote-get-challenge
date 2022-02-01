<?php

namespace CWRemote\Lib;

use CWRemote\Utils\CWR_Loader;

class App {
	public $exclude = [
		'App',
		'Template'
	];

	function __construct( $exclude = [] ) {
		$this->exclude = array_merge( $this->exclude, $exclude );
		$this->load_libs( $this->exclude );
	}

	function load_libs( $exclude = [] ) {
		$defaults = [
			'.',
			'..',
		];

		$exclude     = array_merge( $defaults, $exclude );
		$current_dir = scandir( __DIR__ );

		foreach ( $current_dir as $key => $value ) {
			$no_extension = str_replace( '.php', '', $value );
			if ( ! in_array( $no_extension, $exclude ) ) {
				if ( ! is_dir( __DIR__ . DIRECTORY_SEPARATOR . $value ) ) {
					CWR_Loader::load( __NAMESPACE__ . "\\" . $no_extension );
				}
			}
		}
	}
}