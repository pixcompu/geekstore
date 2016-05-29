/**
 * Created by Elsy on 27/05/2016.
 */
window.onload = init;

function init(){
    if( cookieManager.check('user') ){
        redirectTo('principal.php');
    }

    var btnRegister = document.form.btnRegister;
    btnRegister.onclick = function(){
        if( validateFields()){
            register();
        }
    }
}

function validateFields() {

    var form = document.form;
    var windowTitle = '¡Espera un momento!';

    if (form.username.value.length == 0) {
        notifier.alert(windowTitle, 'Proporciona un nombre de usuario');
        return false;
    }

    if (form.password.value.length == 0) {
        notifier.alert(windowTitle, 'Proporciona una contraseña');
        return false;
    }

    if (form.phone.value.length == 0) {
        notifier.alert(windowTitle, 'Proporciona un teléfono');
        return false;
    }

    if (form.email.value.length == 0) {
        notifier.alert(windowTitle, 'Proporciona un correo electrónico');
        return false;
    }

    return true;
}

function register(){
    var form = document.form;
    var params = {};
    params['username'] = form.username.value;
    params['email'] = form.email.value;
    params['password'] = form.password.value;
    params['phone'] = form.phone.value;
    ajax.expectJsonProperties(['status']);
    ajax.post(
        '../server/action/user/new.php',
        params,
        onRegisterSuccess,
        onRegisterError
    );
}

function onRegisterSuccess(json){
    notifier.dontExpectsHTMLContent();
    notifier.setTheme( MODAL_GREEN );
    notifier.alert(
        'Registro Exitoso',
        'Te has registrado exitosamente en GeekStore, inicia sesión y empieza a sacar tu lado Geek',
        function(){
            redirectTo('login.php');
        }
    );
}
function onRegisterError(error){
    notifier.dontExpectsHTMLContent();
    notifier.setTheme( MODAL_RED );
    notifier.alert(
        'No pudimos registrar tu cuenta',
        error);
}