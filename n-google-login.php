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
		N_GOOGLE_LOGIN__ENDPOINT_VERSION, '/' . N_GOOGLE_LOGIN__ENDPOINT_SIGN_UP, array(
		'methods' => 'POST',
		'callback' => function ($request) {
			// $_POST['awt'];

			$jwt = $_REQUEST['jwt'];

			try {
				include_once N_GOOGLE_LOGIN_FOLDER_PATH . '/vendor-light/autoload.php';

				// Get $id_token via HTTPS POST.
				$CLIENT_ID = '759326901074-a9vtip61r1c9f0d7kimo72mj560pgrua.apps.googleusercontent.com';
				$client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
				// $payload = $client->verifyIdToken($jwt);
				$payload = $client->verifyIdToken($jwt, $CLIENT_ID, ['leeway' => 600]);
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
					$picture = $payload['picture'];
					// $sub = $payload['sub'];
					$username = 'newuser';
					$password = 'password123';
					if(email_exists($email)){

						wp_send_json_success('User exists');
					}else{
						wp_send_json_success('User doesnt exists');
					}
					// Create the user
					$user_id = wp_create_user($username, $password, $email);

					// Check if the user was created successfully
					if (!is_wp_error($user_id)) {
						wp_send_json_success('User created successfully. ID: ' . $user_id);
						// wp_send_json_success($payload);
						// echo ;
					} else {
						echo 'Error creating user: ' . $user_id->get_error_message();
					}

					// If request specified a G Suite domain:
					//$domain = $payload['hd'];
				} else {
					// Invalid ID token
					wp_send_json_error($payload);
				}


				wp_send_json_success($response);
				// wp_send_json_success($user_info->names[0]->givenName);
			} catch (BeforeValidException $e) {
				wp_send_json_error('Sync token error. Contact Admin');
			} catch (\Throwable $th) {
				throw $th;
				wp_send_json_error('credentials file does not exist. Check n-google-login settings');
			}



			// return $jwt;
			// return $data['awt'];;
		},
		// 'permission_callback' => function () {
		// 	return current_user_can('edit_posts');
		// },
		'args' => array(
			'jwt' => array(
				'required' => true,
				'type' => 'string',
				'description' => 'google jwt',
			),
		),
	));
}

add_action('wp_ajax_ngl_upload_credentials', 'callback_upload_credentials_ngl');

//As an WP Ajax, uploads the google credentials file as JSON
function callback_upload_credentials_ngl()
{
	// wp_send_json_error($_POST);
	// wp_die();
	// Check if user is logged in
	if (!is_user_logged_in()) {
		wp_send_json_error('You must be logged in to perform this action.');
		wp_die();
	}
	if (empty($_FILES) || !isset($_FILES['file'])) {
		wp_send_json_error('No file uploaded.');
	}

	// Handle the file upload
	$file = $_FILES['file'];
	$file_name = sanitize_file_name($file['name']);
	$file_path = N_GOOGLE_LOGIN_FOLDER_PATH . '/credentials.json';
	$result = move_uploaded_file($file['tmp_name'], $file_path);
	if ($result) {
		wp_send_json_success('File uploaded successfully');
	} else {
		wp_send_json_error('Error uploading file.');
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
