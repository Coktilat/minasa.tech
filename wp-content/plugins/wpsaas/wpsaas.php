<?php
/*
 * Plugin Name: WPSAAS
 * Version: 1.0
 * Plugin URI: http://www.wpsaas.com/
 * Description: WPSAAS WordPress plugin.
 * Author: Stepan Stepasyuk
 * Author URI: 
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: wpsaas
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-wpsaas.php' );
require_once( 'includes/class-wpsaas-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-wpsaas-admin-api.php' );
require_once( 'includes/lib/class-wpsaas-post-type.php' );
require_once( 'includes/lib/class-wpsaas-taxonomy.php' );
require_once( 'includes/lib/class-tgm-plugin-activation.php' );
require_once( 'includes/lib/setup/class-setup.php' );


/**
 * Returns the main instance of WPSAAS to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object WPSAAS
 */
function WPSAAS () {
	$instance = WPSAAS::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = WPSAAS_Settings::instance( $instance );
	}

	return $instance;
}

WPSAAS();