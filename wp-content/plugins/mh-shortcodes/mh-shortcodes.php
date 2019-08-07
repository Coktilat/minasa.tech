<?php
/*
Plugin Name: Mharty - Shortcodes
Plugin URI: http://mharty.com/
Description: Add buttons, dividers, marker, info boxes via easy to use shortcodes.
Version: 1.3.0
Author: mharty.com
Author URI: http://mharty.com/
Text Domain: mh-shortcodes
Domain Path: /lang/
 */
define( 'MH_SHORTCODES_URL', plugins_url( '', __FILE__ ) );
define( 'MH_SHORTCODES_DIR', trailingslashit( dirname(__FILE__) ) );
// Initialize the Plugin 
function mhsc_shortcodes_init() {
//Outputs the plugin's version number as a <body> class.
function mhsc_shortcodes_body_class( $output ) {

$version = '1_0';

$output[] = 'mhsc_shortcodes_v' . $version;

return $output;

}

add_filter( 'body_class', 'mhsc_shortcodes_body_class', 10001 ); // 1


// Checks for the existence of a shortcode.
if ( ! function_exists( 'mhsc_has_shortcode' ) ) :
	function mhsc_has_shortcode( $shortcode = '', $attribute = '' ) {

		$post_to_check = get_post( get_the_ID() );
		$post_content  = $post_to_check->post_content;
		$found         = false;

		if ( ! $shortcode ) {
			return $found;
		}

		if ( stripos( $post_content, '[' . $shortcode ) !== false ) {
			$found = true;
		}

		return $found;

	}
endif;

require_once( 'shortcodes.php' );

function mhsc_shortcodes_tiny_styles($hook) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_style( 'mhsc_shortcodes_tiny', MH_SHORTCODES_URL . '/css/tiny.css', false, NULL, 'all' );
	}

}
add_action( 'admin_enqueue_scripts', 'mhsc_shortcodes_tiny_styles' );
// Register and Enqueue Site Styles
function mhsc_shortcodes_enqueue_site_styles() {
wp_enqueue_style( 'mhsc_shortcodes', MH_SHORTCODES_URL . '/css/mhsc_shortcodes.css', false, NULL, 'all' );
}
add_action( 'wp_enqueue_scripts', 'mhsc_shortcodes_enqueue_site_styles' );


// Register and Enqueue Site Scripts
function mhsc_shortcodes_enqueue_site_scripts() {
	wp_register_script( 'easing', MH_SHORTCODES_URL . '/js/lib/easing.min.js', 'jquery', NULL, true);
	wp_register_script( 'bootstrap', MH_SHORTCODES_URL . '/js/lib/bootstrap.min.js', 'jquery', NULL, true);
	wp_enqueue_script('mhsc_shortcodes');
	wp_enqueue_script('easing');
	wp_enqueue_script('bootstrap');
}
add_action( 'wp_enqueue_scripts', 'mhsc_shortcodes_enqueue_site_scripts' );

} //end mhsc_shortcodes_init
add_action( 'init', 'mhsc_shortcodes_init' );

// Add Shortcode Generator Button
class MH_Shortcodes_Add_Shortcode_Generator_Button {

function __construct() {
	add_action( 'init', array( &$this, 'init' ) );
}

function init() {
	if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	if ( get_user_option( 'rich_editing' ) == 'true' ) {
		add_filter( 'mce_external_plugins', array( &$this, 'mhsc_shortcodes_plugin' ) );
		add_filter( 'mce_buttons', array( &$this,'mhsc_shortcodes_register' ) );
	}  
}

function mhsc_shortcodes_plugin( $plugin_array ) {
	if ( floatval( get_bloginfo( 'version' ) ) >= 3.9 ) {
		$ltr = is_rtl() ? "" : "-ltr";
		$tinymce_js = MH_SHORTCODES_URL .'/js/mhsc_tinymce'. $ltr .'.js';
	
	} else {
		$tinymce_js = MH_SHORTCODES_URL .'/js/mhsc_tinymce-legacy.js';
	}
	$plugin_array['mhsc_shortcodes'] = $tinymce_js;
	return $plugin_array;
}


function mhsc_shortcodes_register( $buttons ) {
	array_push( $buttons, 'mhsc_shortcodes_button' );
	return $buttons;
}
}

$mhsc_shortcodes = new MH_Shortcodes_Add_Shortcode_Generator_Button;

//remove empty <p>
if ( ! function_exists( 'mhsc_remove_p_shortcodes' ) ) :
function mhsc_remove_p_shortcodes( $content ) {

	$array = array (
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']'
	);

	$content = strtr( $content, $array );

	return $content;

}
add_filter( 'the_content', 'mhsc_remove_p_shortcodes' );
endif;
//translate strings
function mhsc_shortcodes_tiny_lang($locales) {
	$locales['mhtinylang'] = MH_SHORTCODES_DIR . 'tinymce.php';
	return $locales;
}
add_filter( 'mce_external_languages', 'mhsc_shortcodes_tiny_lang');


//hook the updater!
add_action( 'init', 'mh_shortcodes_updater_init' );
function mh_shortcodes_updater_init() {
	$mh_api_id = $mh_api_email = '';
	if (function_exists('mh_get_option') ):
		$mh_api_id = esc_attr( mh_get_option( 'mharty_activate_id', '' ) );
		$mh_api_email = esc_attr( mh_get_option( 'mharty_activate_email', '' ) );
	endif;
	require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/mharty-updater.php' );
	$config = array(
		'base'      => plugin_basename( __FILE__ ),
		'repo_uri'  => 'https://mharty.com/',
		'repo_slug' => 'mhshortcodes',
		'username' => $mh_api_id,
		'key'       => $mh_api_email,
		'dashboard' => false,
	);
	new Mh_Shortcodes_Updater( $config );
}