<?php

// echo N_GOOGLE_LOGIN__API_NAMESPACE_ADDRESS;

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js">

</script>
<div>
    <p>This plugin works with Google Credentials (a file to be put in your installation) More info about Authentication <a href="https://cloud.google.com/docs/authentication" target="new">Here</a></p>
    <p>Credentials file were not found</p>
    <p>In order to use Google Services, we need to register this page and associate it to your Google Account.</p>
    <p>You need to register a project (page) and get credentials.</p>
    <ol>
        <li>Go to the Google API Console and select your project. More info about how to create a project <a href="https://cloud.google.com/resource-manager/docs/creating-managing-projects" target="new">Here</a></li>
        <li>go here <a href="https://console.cloud.google.com/apis/credentials" target="new">https://console.cloud.google.com/apis/credentials</a></li>
        <li>Click on the "Credentials" tab on the left-hand side of the page.</li>
        <li>Click on the "+ Create Credentials"</li>
        <li>Click on the "Oath client ID"</li>
        <li>Select "Web Application" on "Application Type"</li>
        <li>Type a name for your web application</li>
        <li>On Authorised redirect URIS click on "+ Add URI" </li>
        <li>
            <p>Copy and paste the following:</p>
            <?php echo  admin_url(); ?>?page=n-google-login
        </li>
        <li>Click on "Create". A floating window should appear with the credentials "OAuth client created"</li>
        <li>Click on "DOWNLOAD JSON" to Download the Json file.</li>
        <li>Click the following button to Upload the JSON file into your plugin folder.</li>
        <!-- <li></li>
        <li></li>
        <li></li> -->
    </ol>

    <div>
        <input type="file" name="file" id="buttonFileSelect" value="asdf" accept=".json"></input>
        <button id="uploadButton" type="button">Upload JSON</button>
    </div>

    <script>
        const uploadButton = document.getElementById('uploadButton');
        const buttonFileSelect = document.querySelector('input[type="file"]');
        // const buttonFileSelect = document.getElementById('buttonFileSelect');
        function uploadAction() {

        }

        
        function enableButtonUploader() {
            uploadButton.addEventListener('click', function() {
                console.log('pressed');
                const data = new FormData();
                data.append('action', '<?php echo N_GOOGLE_LOGIN__AJAX_ACTION_UPLOAD_CREDENTIALS; ?>');
                console.log('pressed: ', '<?php echo N_GOOGLE_LOGIN__AJAX_ACTION_UPLOAD_CREDENTIALS; ?>');
                data.append('file', buttonFileSelect.files[0])
                // data.append('textColor', color);
                ajaxRequest(data, uploadAction())
            });
        }
        enableButtonUploader()
        window.onload = function() {
            if (typeof $ === 'function') {
                console.log('jQuery is loaded!');
                enableButtonUploader()

            } else {
                console.log('jQuery is NOT loaded!');
            }
        }


        function detectIfFileSelected() {
            const fileInput = document.getElementById('buttonFileSelect');

            fileInput.addEventListener('change', (event) => {
                const selectedFile = event.target.files[0];
                if (selectedFile) {
                    console.log('File selected:', selectedFile.name);
                    // Do something with the selected file
                } else {
                    console.log('No file selected');
                }
            });
        }

        function ajaxRequest(data, callback) {
            // toggleActiveAllInputs(true)
            const xhr = new XMLHttpRequest();
            xhr.open('POST', ajaxurl);
            console.log('ajaxurl: ', ajaxurl)
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        console.log('upload success');
                        console.log(response.data);
                        if (callback) {
                            callback()
                        }
                    } else {
                        console.log(response.data);
                    }
                } else {
                    console.log('Error: ' + xhr.statusText);
                }
                // toggleActiveAllInputs(false)
            };
            xhr.send(data);
        }
        <?php include_once(N_GOOGLE_LOGIN_FOLDER_PATH . '/src/js-fragments/ajax-request-v2.js') ?>
    </script>
</div>