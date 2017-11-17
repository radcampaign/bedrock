<?php
/**
 * Our pantheon specific environment settings.
 * taken out of the pantheon-systems wordpress upstream wp-config.php
 * https://github.com/pantheon-systems/WordPress/blob/master/wp-config.php
 */

/** Production */
ini_set('display_errors', 0);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);
/** Disable all file modifications including updates and update notifications */
define('DISALLOW_FILE_MODS', true);

// ** MySQL settings - included in the Pantheon Environment ** //
/** The name of the database for WordPress */
define('DB_NAME', $_ENV['DB_NAME']);
/** MySQL database username */
define('DB_USER', $_ENV['DB_USER']);
/** MySQL database password */
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
/** MySQL hostname; on Pantheon this includes a specific port number. */
define('DB_HOST', $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT']);
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
 * Pantheon sets these values for you also. If you want to shuffle them you
 * must contact support: https://pantheon.io/docs/getting-support
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         $_ENV['AUTH_KEY']);
define('SECURE_AUTH_KEY',  $_ENV['SECURE_AUTH_KEY']);
define('LOGGED_IN_KEY',    $_ENV['LOGGED_IN_KEY']);
define('NONCE_KEY',        $_ENV['NONCE_KEY']);
define('AUTH_SALT',        $_ENV['AUTH_SALT']);
define('SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT']);
define('LOGGED_IN_SALT',   $_ENV['LOGGED_IN_SALT']);
define('NONCE_SALT',       $_ENV['NONCE_SALT']);
/**#@-*/
/** A couple extra tweaks to help things run well on Pantheon. **/
if (isset($_SERVER['HTTP_HOST'])) {
    // HTTP is still the default scheme for now.
    $scheme = 'http';
    // If we have detected that the end use is HTTPS, make sure we pass that
    // through here, so <img> tags and the like don't generate mixed-mode
    // content warnings.
    if (isset($_SERVER['HTTP_USER_AGENT_HTTPS']) && $_SERVER['HTTP_USER_AGENT_HTTPS'] == 'ON') {
        $scheme = 'https';
    }
    define('WP_HOME', $scheme . '://' . $_SERVER['HTTP_HOST']);
    define('WP_SITEURL', $scheme . '://' . $_SERVER['HTTP_HOST'] . '/wp');
}
// Don't show deprecations; useful under PHP 5.5
error_reporting(E_ALL ^ E_DEPRECATED);
// Force the use of a safe temp directory when in a container
if ( defined( 'PANTHEON_BINDING' ) ):
    define( 'WP_TEMP_DIR', sprintf( '/srv/bindings/%s/tmp', PANTHEON_BINDING ) );
endif;
// FS writes aren't permitted in test or live, so we should let WordPress know to disable relevant UI
if ( in_array( $_ENV['PANTHEON_ENVIRONMENT'], array( 'test', 'live' ) ) && ! defined( 'DISALLOW_FILE_MODS' ) ) :
    define( 'DISALLOW_FILE_MODS', true );
endif;
