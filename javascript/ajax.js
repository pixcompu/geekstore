/**
 * XmlHttp request wrapper By PIXCOMPU (Felix).
 * 
 * This class allows an ajax call with Javascript.
 *
 *  Usage(with response = {'foo' : 'bar'}) :
 *  ajax.expectJsonProperties(['foo']); //optional
 *  ajax.get(
 *      'dispatcher.php',
 *      function(response){
                    console.log(JSON.stringify( response ));
                },
 *      function(error){
                    alert('Hubo un error ' + error);
                }
 *  );
 *
 * @constructor
 */
function Ajax(){

    var xmlhttp = getAjaxObject();
    var async = true;
    var expectsJson = true;
    var expectedProperties = [];

    /**
     * Do one ajax call to a scriptURL with the specified parameters with POST method,
     * returns response in success callback or return error in error callback,
     * if json verification is enabled the response will be JSON object,
     * else the response will be String
     * @param scriptURL String
     * @param params Array
     * @param onSuccessFunction Callback
     * @param onErrorFunction Callback
     */
    this.post = function(scriptURL, params, onSuccessFunction, onErrorFunction){
        setUpResponseListener(onSuccessFunction, onErrorFunction);
        xmlhttp.open('POST', scriptURL, async);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var encodedParams = encode(params);
        xmlhttp.send(encodedParams);
    };

    /**
     * Do one ajax call to a scriptURL with the specified parameters with POST method,
     * returns response in success callback or return error in error callback while capture the upload progress in callback,
     * if json verification is enabled the response will be JSON object,
     * else the response will be String
     * @param scriptURL String
     * @param params FormData
     * @param onSuccessFunction Callback
     * @param onErrorFunction Callback
     * @param onProgressFunction Callback
     */
    this.postWithProgress = function(scriptURL, params, onSuccessFunction, onErrorFunction, onProgressFunction){
        setUpResponseListener(onSuccessFunction, onErrorFunction);
        xmlhttp.open('POST', scriptURL, async);
        xmlhttp.upload.onprogress = function(e){
            if( e.lengthComputable ){
                onProgressFunction(e.loaded, e.total);
            }
        };
        xmlhttp.send(params);
    };

    /**
     * Do one ajax call to a scriptURL with the specified parameters with GET method,
     * returns response in success callback or return error in error callback,
     * if json verification is enabled the response will be JSON object,
     * else the response will be String
     * @param scriptURL
     * @param onSuccessFunction
     * @param onErrorFunction
     */
    this.get = function(scriptURL, onSuccessFunction, onErrorFunction){
        setUpResponseListener(onSuccessFunction, onErrorFunction);
        xmlhttp.open('GET', scriptURL, async);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send();
    };

    /**
     * Enable aditional JSON verification
     */
    this.expectsJson = function(){
        expectsJson = true;
    };

    /**
     * Disable aditional JSON verification
     */
    this.dontExpectJson = function(){
        expectsJson = false;
    };

    /**
     * Enable aditional json properties verification also enable aditional json verification
     * @param properties
     */
    this.expectJsonProperties = function(properties){

        this.expectsJson();

        var isArray = Object.prototype.toString.call( properties ) === '[object Array]';
        if( isArray ) {
            for( var property in properties ){
                if( properties.hasOwnProperty(property) && property.length > 0){
                    var current = properties[property];
                    expectedProperties.push(current);
                }
            }
        }
    };

    /**
     * Disable aditional json properties verification
     */
    this.dontExpectProperties = function(){
        expectedProperties.length = 0;
    };

    //PRIVATE METHODS SECTION

    function getAjaxObject(){
        var isInternetExplorer = !window.XMLHttpRequest;
        if ( isInternetExplorer ) {
            return new ActiveXObject("Microsoft.XMLHTTP");
        } else {
            return new XMLHttpRequest();
        }
    }

    function setUpResponseListener(onSuccessFunction, onErrorFunction){
        var ajax = xmlhttp;
        ajax.onreadystatechange = function() {
            if ( ajax.readyState == XMLHttpRequest.DONE ) {
                if( ajax.status == 200){
                    proccessResponse( ajax.responseText,onSuccessFunction, onErrorFunction );
                }
                else{
                    onErrorFunction( ajax.status );
                }
            }
        };
    }

    function proccessResponse( response,onSuccessFunction,onErrorFunction ){
        if( expectsJson ){
            validateJson( response, onSuccessFunction, onErrorFunction);
        }else{
            onSuccessFunction( response );
        }
    }

    function validateJson( response,onSuccessFunction,onErrorFunction ){
        if( isValidJson( response )){
            var expectsProperties = expectedProperties.length > 0;
            var jsonObject = JSON.parse( response );
            if( expectsProperties ){
                validateProperties( jsonObject, onSuccessFunction, onErrorFunction );
            }else{
                onSuccessFunction( jsonObject );
            }
        }else{
            onErrorFunction('Response is not newHyperLink valid JSON format, response = ' + response);
        }
    }

    function validateProperties( jsonObject, onSuccessFunction, onErrorFunction ){
        var validProperties = true;
        for( var i = 0; i < expectedProperties.length && validProperties; i++ ){
            var current = expectedProperties[i];
            var jsonProperty = jsonObject[current];
            if(typeof jsonProperty === 'undefined'){
                validProperties = false;
                onErrorFunction('Property \"' + current + '\" not found in response = ' + JSON.stringify(jsonObject));
            }
        }
        if( validProperties ){
            if( jsonObject['status'] == 'success' ){
                onSuccessFunction( jsonObject );
            }else{
                onErrorFunction(jsonObject['description']);
            }
        }
    }

    function encode(params) {
        var encodedParams = "";
        for( var key in params ){
            if(params.hasOwnProperty(key) && params[key].length > 0){
                if(encodedParams.length > 0){
                    encodedParams += "&";
                }
                encodedParams += key + "=" + params[key];
            }
        }
        return encodedParams;
    }

    function isValidJson(response){
        try{
            JSON.parse(response);
        }catch(error){
            return false;
        }
        return true;
    }
}

var ajax = new Ajax();