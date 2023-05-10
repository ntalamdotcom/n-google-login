<?php

$redirectAddress = N_GOOGLE_LOGIN__API_NAMESPACE_ADDRESS . '/' . N_GOOGLE_LOGIN__ENDPOINT_REDIRECT_SIGN_UP;

$credentials_file = N_GOOGLE_LOGIN_FOLDER_PATH . '/credentials.json';
if (!file_exists($credentials_file)) {
	echo __('Credentials file does not exist. Google Login unavailable', 'n-google-login') . '<br>';
} else {
	$json_data = file_get_contents($credentials_file);

	// Decode the JSON data into a PHP object
	$data = json_decode($json_data);
	$clientId = $data->web->client_id;
}
?>

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

	function handleCredentialResponse2(response) {
		var code = response.credential;
		if (code) {
			const url = '<?php echo $redirectAddress; ?>?code=' + code
			console.log('url: ', url)
			window.location.href = url;
		} else {
			console.log("<?php echo __('error callback', 'n-google-login') ?>")
		}

	}

	const client_id = "<?php echo $clientId; ?>";
	window.onload = function() {
		var serverTime = '<?php echo date('c'); ?>';
		google.accounts.id.initialize({
			client_id,
			callback: handleCredentialResponse2,
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