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
define('DB_NAME', 'cleanclean');

/** MySQL database username */
define('DB_USER', 'wp-admin');

/** MySQL database password */
define('DB_PASSWORD', 'Minta.1022');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

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
define('AUTH_KEY',         'Jd$B;!0wnaENuH9GRLl#brj9>[>2ovv%N$5(h4){mtNs|~gTJK_(UxuhU7XB#J_%');
define('SECURE_AUTH_KEY',  'CqB4zne itu7|/1[,V4cD-%c!IT?GSqC`xja@yXjA691R*3o566z)(ag7]:c[B!I');
define('LOGGED_IN_KEY',    '3hwGX3_30&6>QIIUcPP`f+KpQ3_{`JlT>rw5zeg~KWsN}h=iJ>[>szg`zOU?xQ`>');
define('NONCE_KEY',        'Ey]XG?Oa<7Hpg)~.NK|vJa[m3Vt)IBv4Z:c j(f%Q2jIK;,b|@>SC:6VF?J^pr)%');
define('AUTH_SALT',        'Pz4VufHD9}orMQy<W`av;=!(5[DbrbPEDuZyv9e<H]j8$sV.j9Ev4;+`lm;j51C0');
define('SECURE_AUTH_SALT', '06]BuIe:3T1Xyvwiu}Ut3xq)0fzQh^A]wvYfFN%)=c?)buztS#y]9#kH)VJ_KcmC');
define('LOGGED_IN_SALT',   '9MQ?nKB|,ChN/%unxsGn0iu=r+Aj*dfL(IwN+dEB|(p|6ec;n=0-vS/-JZo8059<');
define('NONCE_SALT',       'XT]OLR#U-*Wq ?:BYCrwS}?p4``-%Sq>FjSgw2NgF>^c]`==Z-~S`5fpp8F[M!U>');

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
