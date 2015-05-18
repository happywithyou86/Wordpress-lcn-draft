<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
define( 'WP_DEFAULT_THEME', 'lachambrenoire' );
define('WP_ENV', 'development');
// Include local configuration
if (file_exists(dirname(__FILE__) . '/local-config.php')) {
	include(dirname(__FILE__) . '/local-config.php');
}

// Global DB config
if (!defined('DB_NAME')) {
	define('DB_NAME', 'lachambrenoire');
}
if (!defined('DB_USER')) {
	define('DB_USER', 'username');
}
if (!defined('DB_PASSWORD')) {
	define('DB_PASSWORD', 'userpwd');
}
if (!defined('DB_HOST')) {
	define('DB_HOST', '127.0.0.1');
}

/** Database Charset to use in creating database tables. */
if (!defined('DB_CHARSET')) {
	define('DB_CHARSET', 'utf8');
}

/** The Database Collate type. Don't change this if in doubt. */
if (!defined('DB_COLLATE')) {
	define('DB_COLLATE', '');
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'az%l`S?siyt(g:|Mf5@Oc<B-t%6EU%EK[agSl=,B(g2%Bv1q8`Kq5nZl=0Wg/mlp');
define('SECURE_AUTH_KEY',  'At>RuB.5DB+C<I3vCzSA1=}l6RWMS}H~IaZ`}W_psL|lXDdc:L`^^`NRc@fu7c9h');
define('LOGGED_IN_KEY',    '~}NYQY2a2k=RZy&WhFcLg+ZTiu{;1:,,G)=!O9>D;T--<s(U)~,=]Ce1)l/OJ-~-');
define('NONCE_KEY',        '<v/@U] uT(oeH7r^)I=3v>[KZzN@+!3.v-yW87h-KM+=^1sSSsFM8e;H8#+6[Z|q');
define('AUTH_SALT',        'umna.p=hIGDb,Pdte#~-0!En#{%N,6S2;RiJt$8Uz$fm,lmCXfH::<Gy-:SNi+/Q');
define('SECURE_AUTH_SALT', 'xYS~JVO4.F`?hq1w[xd@n7fz=!g?q,(/|v7?]-opK|o?^Y!`e}0dEo3Tk;~XQ+w7');
define('LOGGED_IN_SALT',   '>?Ntp|#M|H,u> 9=NI==Ol5_Pr}_/`RS54+|SaKAoD_n.SC#5FxPo%3dn`l5#g|0');
define('NONCE_SALT',       'z8BuXa)9a~[ND|L/=ApBaz+]c@5D{AW$!Z?>O.>5j4=,Kf|kt$+2B^N-o O$38_4');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * Set custom paths
 *
 * These are required because wordpress is installed in a subdirectory.
 */
if (!defined('WP_SITEURL')) {
	define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] . '/wordpress');
}
if (!defined('WP_HOME')) {
	define('WP_HOME',    'http://' . $_SERVER['SERVER_NAME'] . '');
}
if (!defined('WP_CONTENT_DIR')) {
	define('WP_CONTENT_DIR', dirname(__FILE__) . '/content');
}
if (!defined('WP_CONTENT_URL')) {
	define('WP_CONTENT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/content');
}


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
if (!defined('WP_DEBUG')) {
	define('WP_DEBUG', false);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
