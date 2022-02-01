<?php

namespace CWRemote\Lib;

class Shortcodes {
	function __construct() {
		add_shortcode( 'cwremote_noajax', [ $this, 'backend' ] );
		add_shortcode( 'cwremote_frontend', [ $this, 'frontend' ] );
	}

	/**
	 * Shortcode to get data without AJAX
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return false|string
	 */
	function backend( $atts, $content = null ) {
		EnqueueScripts::frontend();
		ob_start();
		// Sanitize data
		$atts    = Storage::sanitize_data( $atts );
		$content = Storage::sanitize_data( $content );

		// Optionally run the fetcher here if we set the url attribute by default
		if ( isset( $atts['url'] ) ) {
			$fetcher = new Fetcher();
			$fetcher->url( $atts['url'] );
		}

		if ( isset( $atts['before'] ) ) {
			echo $content;
		}

		Template::load( 'frontend' );

		if ( isset( $atts['after'] ) ) {
			echo $content;
		}

		return ob_get_clean();
	}

	/**
	 * Shortcode to get data using AJAX
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return false|string
	 */
	function frontend( $atts, $content = null ) {
		EnqueueScripts::frontend();
		ob_start();
		// Sanitize data
		$atts    = Storage::sanitize_data( $atts );
		$content = Storage::sanitize_data( $content );

		if ( isset( $atts['before'] ) ) {
			echo $content;
		}

		Template::load( 'frontend_ajax' );

		if ( isset( $atts['after'] ) ) {
			echo $content;
		}

		return ob_get_clean();
	}
}