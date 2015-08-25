<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
// test
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_soa');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '`C-lLAtZcr#B-5T.LG+~?:IC}Fc8XrvOw61Qo![H1>^`u/)at~A@gr1ZW+Y hrV^');
define('SECURE_AUTH_KEY',  '@$<Qb80 ]VQle6Y4<>vKovh{?fnB$0WG-ku$LKfin{!|pGqZ0>RQ+7^C#-1ysB2-');
define('LOGGED_IN_KEY',    '|oIF>%|V6wxO4^|w%wi^K9)VQ80W(a& d+Fs$[{V*6|OpQnVXg5VMd|=xBs&x%Pv');
define('NONCE_KEY',        'j5c4~u7*d^>M)I-d10HNFWik4aQKrvrK-+*a[]8.39w|p2U--RLGpMiG?Hj||hX(');
define('AUTH_SALT',        '3+]O~? gq*-za ^Nd8>|U!Gev-MJAxF9<K/SnjFAl%V?++]5&$,(p-`_p2UvWs[k');
define('SECURE_AUTH_SALT', '+@L~d^W,-h/uoP]Fu_4g-p@G|,]@5YmI{:V)!8y;1[V)#,QN762[?`$N#$xiWo;0');
define('LOGGED_IN_SALT',   'h<8X%mg&i|vJTR2@&t_|I#oP7szvaqZ:Ik[V(U96e=`zY@G}jp:#RFlTclVBq%-0');
define('NONCE_SALT',       '(/1+5W cJTXlC[He2=r|l6a3#`b5h+k/PXPo|bP2~Y  t8Mx{oC+S<| yH$*-`2w');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
