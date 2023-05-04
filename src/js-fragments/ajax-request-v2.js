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
                const dataRes = response.data
                // console.log(data);
                if (callback) {
                    callback(dataRes)
                }
            } else {
                console.log(response);
                callbackError(response.responseText);
            }
        } else {
            const response = JSON.parse(xhr.responseText);
            console.log('Error: ' + xhr.statusText);
            console.log('response error: ',response);
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
            console.log('xhrl: ', xhr)
            // const response = JSON.parse(xhr.responseText);xhr.response;
            const response = JSON.parse(xhr.response);
            console.log('response: ', response)
            if (response.success) {
                console.log('upload success');
                const dataResponse = response.data
                // console.log(data);
                if (callback) {
                    callback(dataResponse)
                }
            } else {
                console.log('not success response: ',response);
                callbackError(response.data);
            }
        } else {
            console.log('Error: ' + xhr.statusText);
            callbackError(response.responseText);
        }
        // toggleActiveAllInputs(false)
    };
    xhr.send(data);
}