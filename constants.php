<?php
define('N_GOOGLE_LOGIN_THEME_VERSION', '1.0.0');
define('N_GOOGLE_LOGIN_PRIMEUI_VERSION', '4.1.15');
define('N_GOOGLE_LOGIN_PRIMEUI_FOLDER', '4.1.15');
$pluginsUrl = plugins_url('n-google-login');
define('N_GOOGLE_LOGIN_FOLDER_URL', $pluginsUrl);
define('N_GOOGLE_LOGIN_FOLDER_PATH', WP_PLUGIN_DIR . '/n-google-login');
define('N_GOOGLE_LOGIN_REDIRECT_URL', admin_url() . '/admin.php?page=n-google-login-settings');
define('N_GOOGLE_LOGIN_PRIMEUI_FOLDER_NAME', 'primeui-4.1.15');

define('N_GOOGLE_LOGIN__AJAX_ACTION_UPLOAD_CREDENTIALS', 'ngl_upload_credentials');
define('N_GOOGLE_LOGIN__ENDPOINT_SIGN_UP', 'request-sign-up');
define('N_GOOGLE_LOGIN__ENDPOINT_REDIRECT_SIGN_UP', 'redirect-sign-up');
define('N_GOOGLE_LOGIN__AJAX_ACTION_GET_TASKLISTS_ALL', 'get_taskLists_all');
define('N_GOOGLE_LOGIN__ENDPOINT_VERSION', '1');
define('N_GOOGLE_LOGIN__API_NAMESPACE', 'n-google-login');
define('N_GOOGLE_LOGIN__API_NAMESPACE_ADDRESS', home_url() .
    '/wp-json/' . N_GOOGLE_LOGIN__API_NAMESPACE .
    '/v' .
    N_GOOGLE_LOGIN__ENDPOINT_VERSION);