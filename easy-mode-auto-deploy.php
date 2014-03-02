<?php
/*
Plugin Name: Easy Mode Auto Deploy
Version: 0.1-alpha
Description: Easily deploy your site from a Github webhook
Author: Daniel Bachhuber
Author URI: http://danielbachhuber.com
Plugin URI: http://danielbachhuber.com
Text Domain: easy-mode-auto-deploy
Domain Path: /languages
*/

class Easy_Mode_Auto_Deploy {

	private static $instance;

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new Easy_Mode_Auto_Deploy;
		}

		return self::$instance;

	}

}

/**
 * Load the plugin
 */
function Easy_Mode_Auto_Deploy() {
	return Easy_Mode_Auto_Deploy::get_instance();
}
add_action( 'plugins_loaded', 'Easy_Mode_Auto_Deploy' );
