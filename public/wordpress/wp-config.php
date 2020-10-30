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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

define('WP_SITEURL', 'http://publiccloud.local');
define('WP_HOME', 'http://publiccloud.local/');

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'pi_local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

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
define('AUTH_KEY',         '^FuH4i+5|jT8,,8t|3_uJ9oR]OJ-1mt{G&S/`9R MLjgl!(ILk4zrgCu^%n0mnI9');
define('SECURE_AUTH_KEY',  'cp;:~vz^[+^XJ9K15?O,Rx&z4t^B>:(mrGV?_n[x-AaBwf/}cw=tC^3C7G)vK%B{');
define('LOGGED_IN_KEY',    '<wT]^%+LYC{`;c2q#y~ ~:Vk+Qj>&;RS=1@red=k|Z~w/8+p<OSn-.r+O-Nb0VUJ');
define('NONCE_KEY',        '-~{Gp+7b4q*Mc<[gOM~tBJxr[n,%tY;mh(EV7/K^[=+M89o|_D~+oEg4!bt+c]T?');
define('AUTH_SALT',        'K*46/aF76a G%99H:(wK8e>Q|,Lh9L[Ajb2/W)2%`v-sF`Y{|TJUzMi+E?q()c?G');
define('SECURE_AUTH_SALT', '4|.OTVk5^4+NsH_=UGDg;>zcV&81,+`A2@/G%|W}REq2MV|^V$zidki-W}/0Lv-F');
define('LOGGED_IN_SALT',   'rY9#WZK^Wgps_%C9D|U7q^@X%P#i$A{n/K*`n9B6tb>9/OmrP?|u)YX&=I-T*4=*');
define('NONCE_SALT',       'I|)y M}0yZ@?G 12 )B?/ +C>/sTWe*gLg+9u$_ !bZ_y9=frCx-1[Si0Z&}4@|o');

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

define( 'IDP_CLIENT_ID', '91a2adcf-e5da-4703-bd10-495a8ffa178f' );
define( 'IDP_CLIENT_SECRET', 'qnDFF9V8gpPihxNXSzJvFe9HQmjU5mGkVESiUcWD' );
define( 'REDIRECT_URI', 'http://publiccloud.local/auth/callback' );
define( 'URL_AUTHORIZE', 'http://publiccloud.local/oauth/authorize' );
define( 'URL_ACCESS_TOKEN', 'http://publiccloud.local/oauth/token' );
define( 'URL_GET_USER_INFO', 'http://publiccloud.local/api/user' );



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
