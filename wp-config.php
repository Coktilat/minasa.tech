<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', '68341123095259f0689300233e19c4acf8448f20f4b2bd9f' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'P&Zo?I%Y:hC!rB>PPnN-P z jc}OcE`xc5: ;KBlt8|2 gM*`Pf<_xGm(/FB@IUe' );
define( 'SECURE_AUTH_KEY',  '4bfhtM~`^=Nt8CTQB-KZ&G4PNMo_k,*|O[SvyqMIu@]Vx#C M[~J$TJZ+s}Js$wj' );
define( 'LOGGED_IN_KEY',    'n/mU4SJo+ixROH%3B`zZuD3r3i^)TI3$!`iPPY|Jj-hqcE$~wFa%<&00eIkxabyZ' );
define( 'NONCE_KEY',        'zz.S2Edw!<L N-#I$cgB2ji:>nsu(ym/lqRtJ5c42e%#)#1I1eIOK]9,*Gs~&g^]' );
define( 'AUTH_SALT',        'RcXoptl}?)+A`%>1N%Qg45r/gn]4#a-M?@j`+(cRHOCE.qL.<GXUbB1-<ta%m|!U' );
define( 'SECURE_AUTH_SALT', '&(/7$)(a-xG%FdRzWX,4QddSC:EY?Zoi9#@G@?kW{L||t!_F/5-]{^s$0<@$qA5I' );
define( 'LOGGED_IN_SALT',   'o3Z0M*D1<3+lNS(}N<8pS9e=#~8OHG64`36cF$gIq}l.P&xaqwsM:fQf:sYh~_ML' );
define( 'NONCE_SALT',       '&Fe1X<T-ge`[oD$iMDLsn xIU%JuFC`_)*%VA5UM(^AjTD.%5M%4t(RB-()Mo,eT' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );
/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', 'minasa.tech');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

define('SUNRISE', true);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
