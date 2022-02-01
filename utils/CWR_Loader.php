<?php

namespace CWRemote\Utils;

class CWR_Loader {
	static function load( $class_name, $params = [] ) {
		! empty( $params ) ? new $class_name( $params ) : new $class_name();
	}
}