<?php

// $t = time();
// echo ($t . "<br>");

// echo (date("Y-m-d h:m", $t) . "<br>");
// // echo N_GOOGLE_LOGIN__API_NAMESPACE_ADDRESS. "<br>";
// echo date_default_timezone_get() . "<br>";

$redirectAddress = N_GOOGLE_LOGIN__API_NAMESPACE_ADDRESS . '/' . N_GOOGLE_LOGIN__ENDPOINT_REDIRECT_SIGN_UP;

// echo $redirectAddress . "<br>";
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
		alert("success: " + data)
		console.log('YESSS.... upload!: ', data);
		google.accounts.id.prompt();
	}

	function callbackError(error) {
		alert('Error: ' + error)
		console.log(error)
		google.accounts.id.prompt();
	}

	function handleCredentialResponse2(response) {
		var code = response.credential;
		if (code) {
			const url = '<?php echo $redirectAddress; ?>?code=' + code
			console.log('url: ', url)
			window.location.href = url;
		} else {
			console.log('error callback')
		}

	}

	// function handleCredentialResponse(response) {
	// 	console.log("Encoded JWT ID token: ", response);
	// 	var jwt = response.credential;
	// 	const data = new FormData();
	// 	data.append('jwt', jwt);
	// 	// var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
	// 	// data.append('timezone', timezone);
	// 	var url = '<?php echo (N_GOOGLE_LOGIN__API_NAMESPACE_ADDRESS . '/' . N_GOOGLE_LOGIN__ENDPOINT_SIGN_UP); ?>'
	// 	console.log("url out: ", url);
	// 	ajaxRequestLogin(data, uploadAction, callbackError, url)
	// }

	const client_id = "759326901074-a9vtip61r1c9f0d7kimo72mj560pgrua.apps.googleusercontent.com";
	window.onload = function() {
		var serverTime = '<?php echo date('c'); ?>';
		google.accounts.id.initialize({
			client_id,
			// access_type: 'offline',
			// timeZone: '<?php echo date_default_timezone_get(); ?>',
			// callback: handleCredentialResponse,
			callback: handleCredentialResponse2,
			// serverTime: serverTime
			// auto_select: true, it is super annoying
			// ux_mode: 'redirect',
			// redirect_uri: '<?php echo $redirectAddress; ?>',
			// prompt_parent_id: 'prompt-div'
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