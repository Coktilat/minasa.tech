<?php
// Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'mh_magazine_enqueue_scripts_styles' );
function mh_magazine_enqueue_scripts_styles() {
	$ltr = is_rtl() ? "" : "-ltr";
    wp_enqueue_style( 'mh-magazine-css', plugins_url( 'mh-magazine/assets/css/style'. $ltr .'.min.css' ), false, MH_MAGAZINE_VER, 'all' );
	wp_register_script( 'mh-magazine-js', plugins_url('mh-magazine/assets/js/scripts.js'), array( 'jquery' ), MH_MAGAZINE_VER, true );
}

function mh_magazine_enqueue_admin_inline_css() {
	echo '<style>.mhc-all-modules .mhc_magazine,.mhc-all-modules .mhc_fullwidth_magazine,.mhc_saved_layouts_list .mhc_magazine,.mhc_saved_layouts_list .mhc_fullwidth_magazine,.mhc-all-modules .mhc_ticker,.mhc-all-modules .mhc_fullwidth_ticker,.mhc_saved_layouts_list .mhc_ticker,.mhc_saved_layouts_list .mhc_fullwidth_ticker, .mhc-all-modules .mhc_classified, .mhc_saved_layouts_list .mhc_classified {background-color:transparent; opacity:1;}</style>';
}
add_action('admin_head', 'mh_magazine_enqueue_admin_inline_css');

if ( ! function_exists( 'mh_magazine_get_posts' ) ) :
function mh_magazine_get_posts( $args = array() ) {
	$default_args = array(
		'post_type' => 'post',
	);
	$args = wp_parse_args( $args, $default_args );
	
	return new WP_Query( $args );
}
endif;
//magazine components
function mh_magazine_add_elements() {
	require dirname( __FILE__ ) . '/components.php';
}