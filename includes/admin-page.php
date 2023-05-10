<?php

include_once(WP_PLUGIN_DIR . '/n-google-login/constants.php');
// load_plugin_textdomain('n-google-login', false, N_GOOGLE_LOGIN_FOLDER_PATH . '/languages');
$credentials_file = N_GOOGLE_LOGIN_FOLDER_PATH . '/credentials.json';
if (!file_exists($credentials_file)) {
    include_once(N_GOOGLE_LOGIN_FOLDER_PATH . '/admin/get-credentials.php');
} else {
    
    $msg = __('Credentials file found. All good', 'n-google-login');

    // echo locale_get_default() . '<br>';
    echo $msg;
}

?>

<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js">

</script>


<script>
    if (typeof $ === 'function') {
        const locale = navigator.language; // Get the user's preferred language
        //    alert(locale); // Print the user's preferred language to the console

    }
</script>