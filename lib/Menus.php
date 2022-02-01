<?php

namespace CWRemote\Lib;


class Menus {
	static $settings_slug = 'cwremote-settings';

	function __construct() {
		add_action( 'admin_menu', [ $this, 'settings' ] );
	}

	/**
	 * Settings menu definition
	 */
	function settings() {
		add_menu_page( __( 'CWRemote Settings', CWREMOTE_TEXT_DOMAIN ), __( 'CWRemote', CWREMOTE_TEXT_DOMAIN ), 'manage_options', self::$settings_slug, [
			$this,
			'settings_content'
		] );
	}

	/**
	 * Settings menu content
	 */
	function settings_content() {
		EnqueueScripts::backend();
		require_once( CWREMOTE_TEMPLATE . 'settings.php' );
	}
}