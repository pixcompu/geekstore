<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Usuarios";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/notifier.css">
    <link rel="stylesheet" href="../style/floating_button.css">
</head>
<body>
<?php require_once('navbar.php'); ?>
<div id="users"></div>
<button class="floating-button" onclick="showRegister()">+</button>
<?php
require_once('scripts.php');
?>
<script src="../javascript/adminSession.js"></script>
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
