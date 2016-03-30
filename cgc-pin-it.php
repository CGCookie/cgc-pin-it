<?php
/**
 *
 * @package   CGC pin It 2.0
 * @author    Nick Haskins <nick@cgcookie.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 *
 * Plugin Name:       CGC pin It
 * Plugin URI:        http://cgcookie.com
 * Description:       Creates a social following/follower system
 * Version:           1.0
 * GitHub Plugin URI: https://github.com/cgcookie/cgc-PINIT
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Set some constants
define('CGC_PINIT_VERSION', '1.0');
define('CGC_PINIT_DIR', plugin_dir_path( __FILE__ ));
define('CGC_PINIT_URL', plugins_url( '', __FILE__ ));

require_once( plugin_dir_path( __FILE__ ) . 'public/class-cgc-pin-it.php' );

register_activation_hook( __FILE__, array( 'CGC_Pinit', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'CGC_Pinit', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'CGC_PINIT', 'get_instance' ) );

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-cgc-pin-it-admin.php' );
	add_action( 'plugins_loaded', array( 'CGC_Pinit_Admin', 'get_instance' ) );

}
