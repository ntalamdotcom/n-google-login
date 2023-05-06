<?php

include_once(WP_PLUGIN_DIR . '/n-google-login/constants.php');

$credentials_file = N_GOOGLE_LOGIN_FOLDER_PATH . '/credentials.json';
if (!file_exists($credentials_file)) {
    include_once(N_GOOGLE_LOGIN_FOLDER_PATH . '/admin/get-credentials.php');
} else {
    echo "Credentials file found. All good";
}

?>

<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js">

</script>


<script>
    if (typeof $ === 'function') {

    }
</script>