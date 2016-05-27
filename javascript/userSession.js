validateUser();

function validateUser() {
    if( !cookieManager.check('user') ){
        redirectTo('login.php');
    }
}