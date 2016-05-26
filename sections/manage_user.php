<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../resources/images/tab/tab_icon.png">
    <link rel="stylesheet" href="../style/notifier.css">
    <link rel="stylesheet" href="../style/floating_button.css">
    <title>GeekStore - Administrar Usuarios</title>
</head>
<body>
<div id="users"></div>
<button class="floating-button" onclick="showRegister()">+</button>
<script src="../javascript/ajax.js"></script>
<script src="../javascript/factory.js"></script>
<script src="../javascript/notifier.js"></script>
<script src="../javascript/cookies.js"></script>
<script>

    window.onload = init;

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

    function init(){
        validateAdmin();
        ajax.expectJsonProperties(['status']);
        ajax.get(
                '../server/action/user/get.php',
                onFetchSuccess,
                onFetchFailure
        );
    }

    function onFetchSuccess(response){
        var data = response.data;
        showUsers( data );
    }

    function onFetchFailure(error){
        console.log(error);
    }

    function showUsers( users ){
        findViewById('users').appendChild( newParagraph(JSON.stringify(users)) );
    }

    function showRegister(){
        var form = newForm('', 'POST', 'form');
        var username = newFormGroupInput('Usuario: ', 'text', 'username', 'username');
        var password = newFormGroupInput('Contraseña :', 'password', 'password', 'password');
        var type = newFormGroupSelect('Tipo : ', ['administrador', 'usuario'], 'type', 'type');
        appendItemsTo( form,
        [username, password, type]);

        notifier.expectsHTMLContent();
        notifier.setTheme( MODAL_BLUE );
        notifier.confirm(
                '¿Desea registrar este usuario?',
                form.outerHTML,
                function( confirm ){
                    if( confirm ){
                        console.log(findViewById('username').value);
                        console.log(findViewById('password').value);
                        console.log(findViewById('type').value);
                    }
                }
        );
    }
</script>
</body>
</html>
