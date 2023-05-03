function ajaxRequestV2(data, callback, callbackError) {
    // toggleActiveAllInputs(true)
    const xhr = new XMLHttpRequest();
    xhr.open('POST', ajaxurl);
    console.log('ajaxurl: ', ajaxurl)
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                console.log('upload success');
                const data = response.data
                // console.log(data);
                if (callback) {
                    callback(data)
                }
            } else {
                console.log(response);
                callbackError(response.responseText);
            }
        } else {
            console.log('Error: ' + xhr.statusText);
            callbackError(response.responseText);
        }
        // toggleActiveAllInputs(false)
    };
    xhr.send(data);
}

function ajaxRequestLogin(data, callback, callbackError, url) {
    // toggleActiveAllInputs(true)
    const xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    console.log('url: ', url)
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                console.log('upload success');
                const data = response.data
                // console.log(data);
                if (callback) {
                    callback(data)
                }
            } else {
                console.log(response);
                callbackError(response.responseText);
            }
        } else {
            console.log('Error: ' + xhr.statusText);
            callbackError(response.responseText);
        }
        // toggleActiveAllInputs(false)
    };
    xhr.send(data);
}