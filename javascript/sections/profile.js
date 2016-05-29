/**
 * Created by Elsy on 27/05/2016.
 */
window.onload = function(){
    var user = JSON.parse(cookieManager.getValue('user'));
    appendText(findViewById('username'), user['username']);
    appendText(findViewById('email'), user['email']);
    appendText(findViewById('phone'), user['phone']);
};