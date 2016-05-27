validateAdmin();

function validateAdmin() {
    if( !cookieManager.check('user') ){
        redirectTo('login.php');
    }else{
        var user = JSON.parse(cookieManager.getValue('user'));
        if( user['type'] !== 'admin' ){
            redirectTo('principal.php');
        }
    }
}