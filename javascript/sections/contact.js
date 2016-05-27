/**
 * Created by Elsy on 27/05/2016.
 */

window.onload = init;

function init(){
    findViewById('send').onclick = function(){
        if( validateFields() ){
            sendMessage();
        }
    }
}


function validateFields(){
    notifier.setTheme(MODAL_RED);
    if( findViewById('email').value.length > 0 ){
        if( findViewById('message').value.length > 0 ){
            return true;
        }else{
            notifier.alert(
                '¡Espera un momento!',
                "El mensaje no puede ser vacio",
                function(){}
            );
        }
    }else{
        notifier.alert(
            '¡Espera un momento!',
            "El correo no puede ser vacio",
            function(){}
        );
    }
    return false;
}


function sendMessage() {
    var params = {};
    params['destinatary'] = findViewById('email').value;
    params['message'] = findViewById('message').value;
    ajax.expectJsonProperties(['status']);
    ajax.post(
        '../server/action/mail/send.php',
        params,
        onSendSuccess,
        onSendFailure
    );
}
function onSendSuccess(response){
    notifier.setTheme(MODAL_GREEN);
    notifier.alert(
        'Gracias por tu opinion',
        "El correo ha sido enviado",
        function(){
            redirectTo('principal.php');
        }
    );
}

function onSendFailure(error){
    notifier.setTheme(MODAL_RED);
    notifier.alert(
        '¡Espera un momento!',
        'No se pudo enviar el mensaje' + error,
        function(){}
    );
}
