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
			self::$instance->setup_actions();
		}

		return self::$instance;

	}

	private function setup_actions() {

		if ( defined( 'EASY_MODE_AUTO_DEPLOY_SECRET' )
			&& ! empty( $_GET['easy-mode-auto-deploy'] )
			&& $_GET['easy-mode-auto-deploy'] === EASY_MODE_AUTO_DEPLOY_SECRET ) {

			$this->deploy();

		} else if ( is_admin() && ! defined( 'EASY_MODE_AUTO_DEPLOY_SECRET' ) ) {

			add_action( 'admin_notices', array( $this, 'action_admin_notices' ) );

		}

	}

	/**
	 * Deploy the site
	 */
	private function deploy() {

		// @todo

	}

	/**
	 * Throw an error if the secret isn't defined
	 */
	public function action_admin_notices() {
		?>
		<div class="message error"><?php _e( "Easy Mode Auto Deploys is active, but the secret hasn't been set. See readme for more configuration details.", 'easy-mode-auto-deploy' ); ?></div>
		<?php
	}

}

/**
 * Load the plugin
 */
function Easy_Mode_Auto_Deploy() {
	return Easy_Mode_Auto_Deploy::get_instance();
}
add_action( 'init', 'Easy_Mode_Auto_Deploy' );
