<?php
/*
Plugin Name: Mharty - Magazine
Plugin URI: http://mharty.com/
Description: This extension will add four magazine components to MH Page Composer.
Version: 3.0.1
Author: mharty.com
Author URI: http://mharty.com/
Text Domain: mh-magazine
Domain Path: /lang/
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! class_exists( 'MHMagazine', false ) ) {
    class MHMagazine {
        private static $instance;
	
		function __construct() {
			//Only one activated instance of this cass
			if ( isset( self::$instance ) ) {
				wp_die( sprintf( '%s is a singleton class and you cannot create a second instance.',
					get_class( $this ) )
				);
			}
			if ( !( defined( 'MHARTY_THEME' ) && MHARTY_THEME ) || !function_exists( 'mh_get_language_fonts' ) || !( defined( 'MHARTY_COMPOSER' ) && MHARTY_COMPOSER ) ) {
				return; // Disable the plugin, if current theme is not mharty and MH Composer not active
			}
			
			$this->load_textdomain();
			$this->setup_mh_magazine();
		}
		
		/**
         * Setup
         */
		function setup_mh_magazine() {
			define( 'MH_MAGAZINE_VER', '3.0.1' );
			define( 'MH_MAGAZINE_URL', plugin_dir_url( __FILE__ ) );
			define( 'MH_MAGAZINE_DIR', plugin_dir_path( __FILE__ ) );

			require_once MH_MAGAZINE_DIR . 'includes/functions.php';
			//hook components to the composer list
			add_action( 'mh_composer_add_extra_components', 'mh_magazine_add_elements' );
		}
		
		/**
         * Internationalization
		 * 		- WP_LANG_DIR/mh-magazine/mh-magazine-$locale.mo
		 * 	 	- mh-magazine/lang/mh-magazine-$locale.mo
         */
		function load_textdomain() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'mh-magazine' );
			load_textdomain( 'mh-magazine', WP_LANG_DIR . '/mh-magazine/mh-magazine-' . $locale . '.mo' );
			load_plugin_textdomain( 'mh-magazine', false, plugin_basename( dirname( __FILE__ ) ) . "/lang" );
		}
	}
}
/**
 * Init MHMagazine when WordPress Initialises.
 */
function mh_magazine_init_plugin() {
	new MHMagazine();
}
add_action( 'init', 'mh_magazine_init_plugin' );

/**
 * Hook the updater!
 */
function mh_magazine_init_updater() {
	$mh_api_id = $mh_api_email = '';
	if (function_exists('mh_get_option') ):
		$mh_api_id = esc_attr( mh_get_option( 'mharty_activate_id', '' ) );
		$mh_api_email = esc_attr( mh_get_option( 'mharty_activate_email', '' ) );
	endif;
	require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/mharty-updater.php' );
	$config = array(
		'base'      => plugin_basename( __FILE__ ),
		'repo_uri'  => 'http://mharty.com/',
		'repo_slug' => 'mhmagazine',
		'username' => $mh_api_id,
		'key'       => $mh_api_email,
		'dashboard' => false,
	);
	new Mh_Magazine_Updater( $config );
}
add_action( 'init', 'mh_magazine_init_updater' );