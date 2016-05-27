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
    if( findViewById('email').value.length > 0 ){
        if( findViewById('message').value.length > 0 ){
            return true;
        }else{
            alert('El mensaje no puede ser vacío');
        }

    }else{
        alert('El correo no puede ser vacio');
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
    alert('Mensaje enviado '+response);

}

function onSendFailure(error){
    alert('No se pudo enviar el mensaje' + error);
}
