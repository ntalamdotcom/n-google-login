<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ntalam.com
 * @since             1.0.0
 * @package           N_Google_Login
 *
 * @wordpress-plugin
 * Plugin Name:       N Google Login
 * Plugin URI:        https://ngooglelogin.ntalam.com
 * Description:       a plugin for loging and register a user in using your Google Accounts
 * Version:           1.0.0
 * Author:            Nallib Tala
 * Author URI:        https://ntalam.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       n-google-login
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'N_GOOGLE_LOGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-n-google-login-activator.php
 */
function activate_n_google_login() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-n-google-login-activator.php';
	N_Google_Login_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-n-google-login-deactivator.php
 */
function deactivate_n_google_login() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-n-google-login-deactivator.php';
	N_Google_Login_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_n_google_login' );
register_deactivation_hook( __FILE__, 'deactivate_n_google_login' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-n-google-login.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_n_google_login() {

	$plugin = new N_Google_Login();
	$plugin->run();

}
run_n_google_login();
