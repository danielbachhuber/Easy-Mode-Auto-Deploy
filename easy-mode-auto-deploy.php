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
	 * 
	 * @todo support for custom deploy callback
	 * @todo support for alternative origins and branches
	 * @todo Support for subversion (maybe)
	 */
	private function deploy() {

		// WordPress installed in main directory vs. subdirectory
		if ( file_exists( ABSPATH . '/wp-config.php' ) ) {
			$webroot = ABSPATH;
		} else if ( file_exists( dirname( ABSPATH ) . '/wp-config.php' ) ) {
			$webroot = dirname( ABSPATH );
		} else {
			wp_die( __( "Couldn't find WordPress webroot", 'easy-mode-auto-deploy' ) );
		}

		shell_exec( "cd $webroot; git checkout -f master; git fetch origin --tags; git pull origin master; git submodule update --init --recursive" );

		wp_die( __( 'Site deployed.', 'easy-mode-auto-deploy' ) );

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
