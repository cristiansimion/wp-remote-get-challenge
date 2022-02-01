<?php
/**
 * Plugin name: WP Remote Get [Test1]
 * Description: Get an API response, store it and deliver it to the frontend.
 * Author: Cristian Simion
 * Author URI: https://cristiansimion.com
 * Version: 1.0
 * License: GPLv3
 */

define( 'CWREMOTE_RESET_TIME', 3600 ); // in seconds
define( 'CWREMOTE_ENDPOINT_URL', 'https://miusage.com/v1/challenge/1/' );

define( 'CWREMOTE_DIR', __DIR__ );
define( 'CWREMOTE_FILE', __FILE__ );
define( 'CWREMOTE_IMGS', plugins_url( 'img/', CWREMOTE_FILE ) );
define( 'CWREMOTE_TEMPLATE', __DIR__ . '/templates/' );
define( 'CWREMOTE_TEXT_DOMAIN', 'cwremote-textdomain' );

require_once( 'autoload.php' );

$app = new \CWRemote\Lib\App();