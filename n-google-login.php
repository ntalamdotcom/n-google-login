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
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       n-google-login
 * Domain Path:       /languages
 */

$http_accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
// Extract the preferred language
$preferred_language = '';
if (isset($http_accept_language) && strlen($http_accept_language) > 0) {
	$languages = explode(',', $http_accept_language);
	$preferred_language = $languages[0];
	if ($preferred_language) {
		setlocale(LC_ALL, $preferred_language);
	}
}

// Output the preferred language
// echo "Preferred language: " . $preferred_language .    '<br>';


// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('N_GOOGLE_LOGIN_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-n-google-login-activator.php
 */
function activate_n_google_login()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-n-google-login-activator.php';
	N_Google_Login_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-n-google-login-deactivator.php
 */
function deactivate_n_google_login()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-n-google-login-deactivator.php';
	N_Google_Login_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_n_google_login');
register_deactivation_hook(__FILE__, 'deactivate_n_google_login');

add_action('rest_api_init', 'n_google_login_register_endpoint');
function n_google_login_register_endpoint()
{
	register_rest_route(N_GOOGLE_LOGIN__API_NAMESPACE .
		'/v' .
		N_GOOGLE_LOGIN__ENDPOINT_VERSION, '/' . N_GOOGLE_LOGIN__ENDPOINT_REDIRECT_SIGN_UP, array(
		'methods' => 'GET',
		'callback' => function ($request) {
			try {
				$code = $_REQUEST['code'];
				$code = sanitize_text_field($code);
				if (isset($code)) {

					$token_validation_url = sprintf(
						'https://oauth2.googleapis.com/tokeninfo?id_token=%s',
						$code // Replace $code with the sign-in code obtained from the client side
					);

					// Send a GET request to the token validation URL to get the token information
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $token_validation_url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$token_info_json = curl_exec($ch);
					curl_close($ch);

					// Parse the token information from the JSON response
					$payload = json_decode($token_info_json, true);

					if ($payload) {
						$sub = $payload['sub'];
						$email = $payload['email'];
						$email_verified = $payload['email_verified'];
						$family_name = $payload['family_name'];
						$given_name = $payload['given_name'];
						$hd = $payload['hd'];
						$iat = $payload['iat'];
						$iss = $payload['iss'];
						$jti = $payload['jti'];
						$name = $payload['name'];
						$nbf = $payload['nbf'];
						$alg = $payload['alg'];
						$aud = $payload['aud'];
						$picture = $payload['picture'];
						$azp = $payload['azp'];
						$exp = $payload['exp'];
						$kid = $payload['kid'];
						$typ = $payload['typ'];

						$username = $name;
						$password = wp_generate_password(12, true);
						if (email_exists($email)) {
							$user = get_user_by('email', $email);
							$username = $user->user_login;
						} else {
							$user_id = wp_create_user($username, $password, $email);

							// Check if the user was created successfully
							if (!is_wp_error($user_id)) {
								$url = wp_lostpassword_url() . '?user_email=' . urlencode($email);
							} else {
								$msg = __('Error creating user:', 'n-google-login') . ' ' . $user_id->get_error_message();
								wp_send_json_error($msg);
							}
							$user = get_user_by('id', $user_id);
						}

						// Check if the user object is not a WP_Error instance
						$error = is_wp_error($user);
						if (!$error) {
							// Log in the user
							wp_set_current_user($user->ID);
							wp_set_auth_cookie($user->ID);
							do_action('wp_login', $user->user_login);

							// Redirect the user to the appropriate page
							wp_redirect(home_url());
							exit;
						} else {
							echo __('there was an error creating the user:Redirecting in 5 seconds', 'n-google-login') . "...<br>";
							$error_messages = $user->get_error_messages();
							echo var_dump($error_messages) . '<br>';
							// Wait for 5 seconds before redirecting
							header("Refresh: 5; URL=" . wp_login_url());
						}
					} else {
						// Invalid ID token
						wp_send_json_error($payload);
					}
				} else {
					wp_send_json_error(__('the code is null:', 'n-google-login'));
				}
			} catch (Firebase\JWT\BeforeValidException $e) {
				wp_send_json_error(__('Sync token error. Contact Admin:', 'n-google-login') . ' ' . $e->getMessage());
			} catch (\Throwable $th) {
				throw $th;
				wp_send_json_error(__('credentials file does not exist. Check n-google-login settings', 'n-google-login'));
			}
		},

		'args' => array(
			'code' => array(
				'required' => true,
				'type' => 'string',
				'description' => 'google authentication code',
			),
		),
	));
}

add_action('wp_ajax_ngl_upload_credentials', 'callback_upload_credentials_ngl');

//As an WP Ajax, uploads the google credentials file as JSON
function callback_upload_credentials_ngl()
{
	// Check if user is logged in
	if (!is_user_logged_in()) {
		wp_send_json_error(__('You must be logged in to perform this action.', 'n-google-login'));
		wp_die();
	}
	if (empty($_FILES) || !isset($_FILES['file'])) {
		wp_send_json_error(__('No file uploaded', 'n-google-login'));
	}

	// Handle the file upload
	$file = $_FILES['file'];
	$file_path = N_GOOGLE_LOGIN_FOLDER_PATH . '/credentials.json';
	$result = move_uploaded_file($file['tmp_name'], $file_path);
	if ($result) {
		wp_send_json_success(__('File uploaded successfully', 'n-google-login'));
	} else {
		wp_send_json_error(__('Error uploading file.', 'n-google-login'));
	}
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-n-google-login.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_n_google_login()
{

	$plugin = new N_Google_Login();
	$plugin->run();
}
run_n_google_login();
