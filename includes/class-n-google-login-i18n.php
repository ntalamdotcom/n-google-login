<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://ntalam.com
 * @since      1.0.0
 *
 * @package    N_Google_Login
 * @subpackage N_Google_Login/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    N_Google_Login
 * @subpackage N_Google_Login/includes
 * @author     Nallib Tala <me@ntalam.com>
 */
class N_Google_Login_i18n
{


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
	{
		$path = N_GOOGLE_LOGIN_FOLDER_PATH . '/languages/';
		// $path = dirname(dirname(plugin_basename(__FILE__))) . '/languages/';

		$textDomain = 'n-google-login';
		// load_plugin_textdomain(
		// 	$textDomain,
		// 	false,
		// 	$path
		// );

		$http_accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		// Extract the preferred language
		$preferred_language = '';
		if (isset($http_accept_language) && strlen($http_accept_language) > 0) {
			$languages = explode(',', $http_accept_language);
			$preferred_language = $languages[0];
			if ($preferred_language) {
				setlocale(LC_ALL, $preferred_language);
				// echo "setlocale(LC_ALL, $preferred_language): " . setlocale(LC_ALL, $preferred_language) .    '<br>';
				$preferred_language = '-' . str_replace('-', '_', $preferred_language);
			}
		}

		// Output the preferred language
		// echo "Preferred language: " . $preferred_language .    '<br>';
		$mofile = $path  . "n-google-login" . $preferred_language . ".mo";
		error_log($mofile);
		load_textdomain(
			$textDomain,
			$mofile
		);

		if (is_textdomain_loaded($textDomain)) {
			error_log('Translation files have been loaded');
		} else {
			error_log('Translation files have not been loaded: ' . $path);
		}
	}
}
