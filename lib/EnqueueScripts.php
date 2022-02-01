<?php

namespace CWRemote\Lib;

use CWRemote\Utils\CWR_Nonce;

class EnqueueScripts {
	function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'register_backend' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_frontend' ] );
	}

	/**
	 * Enqueues scripts for the frontend
	 */
	static function frontend() {
		wp_enqueue_script( 'cwremote-js' );
	}

	/**
	 * Enqueues scripts for the backend
	 */
	static function backend() {
		if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == Menus::$settings_slug ) {
			wp_enqueue_style( 'cwremote-admin' );
			wp_enqueue_script( 'cwremote-js' );
		}
	}

	/**
	 * Register backend scripts
	 */
	function register_backend() {
		// Load the same as on the frontend
		$this->register_frontend();

		// Include a new admin.css style
		wp_register_style( 'cwremote-admin', plugins_url( 'css/admin.min.css', CWREMOTE_FILE ) );
	}

	/**
	 * Register frontend scripts
	 */
	function register_frontend() {
		wp_register_script( 'jquery-request', plugins_url( 'js/jquery.request.min.js', CWREMOTE_FILE ), [ 'jquery' ] );
		wp_register_script( 'cwremote-js', plugins_url( 'js/cwremote.min.js', CWREMOTE_FILE ), [
			'jquery',
			'jquery-request'
		] );
		$nonce_name = CWR_Nonce::get_nonce_name( 'security' );

		wp_localize_script( 'jquery-request', 'ajax_object', array(
			'ajax_url'        => admin_url( 'admin-ajax.php' ),
			'security_action' => wp_create_nonce( $nonce_name )
		) );
	}
}