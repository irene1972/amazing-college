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
define('DB_NAME', 'wp-amazing2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '-sHR+5xeL-gWLnYO.;/;8Z8*^.gOS|/Q>XS$mVPw!{9oE/pc8;7k1=nTSH5GteMF');
define('SECURE_AUTH_KEY',  'Dv5b>>|np##2gcp9#9/CH</|_H!V^H`lnlm,!6%B1a*{wn08P`_beoQ5hnzdwkN#');
define('LOGGED_IN_KEY',    'rBd3pJ=7OJP=?O~^9c]A3HJdSW;*FfRW6]{?*39G8uKLO^;NPspr@OIUxHfU@|gL');
define('NONCE_KEY',        'p,lb0mq7@sKaL0cQf>1C3RwDC!;lB]psR~{UQ@8n]F-]rP{N]}-yT[tMh)+?i([i');
define('AUTH_SALT',        '#bBh<`hCDR#UMkQifT0!xoj/#D*)<[aP-vhv>zp_}t])i?tTv~=pM~PXZk{8TUT%');
define('SECURE_AUTH_SALT', 'GMQxtQ^2]m(1++W]yZ4ufU4^fTe6ela{7$-f+/fkolLVZ+%e|lX^)_GFs1}%VdRx');
define('LOGGED_IN_SALT',   'NJ?A`EDKgY|urtN(M8O%N%RE}>{u^oi`=;4Z7]9T4cjJ.OnxkdYMO9heZ34sad0~');
define('NONCE_SALT',       ')?JW|m((eVuv}y>zE!``<J5U]7eS4.UmK:woh{@C3=oY9]mY/(CY0DRgP8vxb]wF');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
