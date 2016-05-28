/**
 * Created by Elsy on 27/05/2016.
 */

window.onload = init;

function login() {
    var params = {};
    params['username'] = document.form.username.value;
    params['password'] = document.form.password.value;
    ajax.expectJsonProperties(['status']);
    ajax.post(
        '../server/action/session/login.php',
        params,
        onLoginSuccess,
        onLoginFailure
    );

}

function validateFields(){
    notifier.setTheme( MODAL_RED );
    var form = document.form;
    if( form.username.value.length == 0 ){
        notifier.alert(
            'No se pudo iniciar tu sesión',
            'Proporciona un usuario'
        );
        return false;
    }
    if( form.password.value.length == 0 ){
        notifier.alert(
            'No se pudo inicar tu sesión',
            'Proporciona una constraseña'
        );
        return false;
    }

    return true;
}

function init(){
    if( cookieManager.check('user') ){
        redirectTo('principal.php');
    }
    findViewById('btnLogin').onclick = function(){
        if( validateFields() ){
            login();
        }
    }
}

function onLoginSuccess(response){
    cookieManager.create('user', JSON.stringify(response.data), 60);
    redirectTo('principal.php')
}

function onLoginFailure(error){
    notifier.setTheme( MODAL_RED );
    notifier.alert(
        'No se pudo inicar tu sesión',
        error
    );
}