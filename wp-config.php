<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'nguyenhanh.local.com' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '990614' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3316' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'v>T{_-vw7)VJ22#24,z%&`i<=;) K%@z-2x(V`)YT%uI/j=ZF]bt?re]>wk?VxC.' );
define( 'SECURE_AUTH_KEY',  '{r+NN-)OHXtl=O:c0B{Y,@ 1R}g~j{r*aV0eo8-~}j^!J%;8gT753E0sKfEU%o(P' );
define( 'LOGGED_IN_KEY',    'mec|5u2[/BgJ=mv%s*Y)p>$bC |<.mcGDa=JN*N~BOq[I7*.iD0tJGX!%)L+$Ps!' );
define( 'NONCE_KEY',        'BA5Tf=v<reoew^J:B?S~q^]&=;EkU9P2R<kN 4;bjwub<:Vy]0bn9Kv9E@fok2.z' );
define( 'AUTH_SALT',        'yz-z2&X9`k9s5O7[b@W]K?jB-[RIfx ;rJ6}yk</=%y.}e4H/,-[Gkq4a3Ovx}7g' );
define( 'SECURE_AUTH_SALT', 'Q;ii2+OcL)YRXX2o|vW UwDT<paNRz>X>|d5PF8px2oD?e$?RXOdsrDmL{~=v02F' );
define( 'LOGGED_IN_SALT',   'fA9hHv#UB@7ins!7u6HKjTClK{^#jpk!;nn9Pg04N&flrz6$gMU!H>^9.68a7[m.' );
define( 'NONCE_SALT',       '$!X7Y6|m>6FOIwg fMBg8j@n<l|koC0Kzm;MHZm#-:5]*-e W#!|%rNQ[D/%$`|o' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



define( 'DUPLICATOR_AUTH_KEY', 'b#MLH] Na}6&RS0[R @e HscVTS0 7N{EC4`1B}/*XNjq5I0l7&xg%7,vs76H1S=' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
