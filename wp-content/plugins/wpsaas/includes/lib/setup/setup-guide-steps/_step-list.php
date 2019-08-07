<?php
/**
 * Steps for the setup guide.
 *
 * @since 1.5.0
 */

global $tgmpa;

/** Create the steps */

$steps = array();

$steps['setup-network'] = array(
	'title'     => __( 'Setup WordPress Multisite Network', 'listify' ),
	'completed' => is_multisite(),
);

if (!is_multisite())
	return $steps;

$steps['install-plugins'] = array(
	'title'     => __( 'Install Required Plugins', 'listify' ),
	'completed' => class_exists( 'WPMenuEditor' ) && class_exists( 'Clientside' ) && class_exists( 'WP_Ultimo' ),
);

$steps['install-theme'] = array(
	'title'     => __( 'Install Required Theme', 'listify' ),
	'completed' => !wp_get_theme( 'Divi' )->errors() && !wp_get_theme( 'WPSAAS' )->errors(),
);

if ( current_user_can( 'import' ) ) {
	$steps['import-content'] = array(
		'title'     => __( 'Import Content (optional)', 'listify' ),
		'completed' => get_option( 'page_for_posts' ),
	);
}

// $steps['google-maps'] = array(
// 	'title'     => __( 'Setup Google Maps', 'listify' ),
// 	'completed' => listify_get_google_maps_api_key(),
// );

// $steps['customize-theme'] = array(
// 	'title'     => __( 'Customize Your Site', 'listify' ),
// 	'completed' => 'n/a',
// );

$steps['theme-updater'] = array(
	'title'     => __( 'Enable Automatic Updates', 'listify' ),
	'completed' => 'n/a',
);

$steps['support-us'] = array(
	'title'     => __( 'Get Involved', 'listify' ),
	'completed' => 'n/a',
);

$steps['wpultimo-setup'] = array(
	'title'     => __( 'Setup WP Ultimo', 'listify' ),
	'completed' => 'n/a',
);

return $steps;
