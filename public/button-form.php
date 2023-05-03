<?php
// Load the Google API client library
// include_once N_GOOGLE_LOGIN_FOLDER_PATH . '/vendor-light/autoload.php';

// // Create a new Google client
// $client = new Google_Client();
// $client->setClientId('YOUR_CLIENT_ID');
// $client->setClientSecret('YOUR_CLIENT_SECRET');
// $client->setRedirectUri('YOUR_REDIRECT_URI');
// $client->addScope('email');
// try {
// 	$client->setAuthConfig(N_GOOGLE_LOGIN_FOLDER_PATH . '/credentials.json');
// } catch (LogicException $e) {
// 	echo '<p>The credentials file is not valid. Please download it again</p>';
// 	include(N_GOOGLE_LOGIN_FOLDER_PATH . '/admin/get-credentials.php');
// 	die();
// }
// // If the user is not already authenticated, redirect them to Google to sign in
// if (!isset($_GET['code'])) {
// 	$auth_url = $client->createAuthUrl();
// 	header("Location: $auth_url");
// 	exit;
// }

// // Exchange the authorization code for an access token
// $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

// // Use the access token to retrieve the user's email address
// $service = new Google_Service_Oauth2($client);
// $user_info = $service->userinfo->get();
// // $email = $user_info->getEmail();
// include_once()
echo N_GOOGLE_LOGIN__API_NAMESPACE_ADDRESS;
?>
<!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->

<style>
	.n-google-wrap {
		height: 70px;
		position: relative;
	}

	.google-button-login {}

	.n-google-wrap div.n-google-wrap-content {
		width: fit-content;
		position: absolute;
		top: 0px;
		left: 0;
		right: 0;
		bottom: 0;
		margin: auto;
		height: 30px;
		margin-top: 0px;
	}

	.n-google-wrap span.dashicons.dashicons-google {
		margin-top: 5px;
		margin-right: 5px;
		margin-left: 5px;
	}

	.or-separator {
		width: fit-content;
		position: absolute;
		top: 0px;
		left: 50%;
	}

	.g-signin2 {
		display: inline-block;
		background-color: #fff;
		color: #444;
		border-radius: 5px;
		border: 1px solid #ddd;
		font-size: 14px;
		padding: 10px 20px;
		cursor: pointer;
		box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2);
	}
</style>

<script src="https://accounts.google.com/gsi/client" async defer></script>

<script>
	<?php include_once(N_GOOGLE_LOGIN_FOLDER_PATH . '/src/js-fragments/ajax-request-v2.js') ?>

	function uploadAction(data) {
		console.log('YESSS.... upload!: ', data);
	}

	function callbackError(error) {
		console.log('YESSS.... error!: ', error)
	}

	function handleCredentialResponse(response) {
		console.log("Encoded JWT ID token: " + response.credential);
		var jwt = response.credential;
		const data = new FormData();
		data.append('jwt', jwt);
		var url = '<?php echo (N_GOOGLE_LOGIN__API_NAMESPACE_ADDRESS . '/' . N_GOOGLE_LOGIN__ENDPOINT_SIGN_UP); ?>'
		console.log("url out: ", url);
		ajaxRequestLogin(data, uploadAction, callbackError, url)
	}
	window.onload = function() {
		google.accounts.id.initialize({
			client_id: "759326901074-a9vtip61r1c9f0d7kimo72mj560pgrua.apps.googleusercontent.com",
			callback: handleCredentialResponse
		});
		google.accounts.id.renderButton(
			document.getElementById("buttonDiv"), {
				theme: "outline",
				size: "large"
			} // customization attributes
		);
		google.accounts.id.prompt(); // also display the One Tap dialog
	}
</script>
<div id="buttonDiv"></div>