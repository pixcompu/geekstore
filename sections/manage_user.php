<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Usuarios";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/notifier.css">
    <link rel="stylesheet" href="../style/floating_button.css">
    <style>
        body{
            background-color: black;
        }
        a[href='manage_user.php']{
            background-color: white;
        }
        #users tr:hover{
            cursor: pointer;
        }
        #users tr th{
            background-color: darkgray;
            padding: 1%;
        }
        #users table{
            margin-top: 5%;
        }
        #users table button{
            padding: 10px;
            border: 0;
            background-color: red;
            color: white;
            margin: 2px;
        }
        #users table button:hover{
            cursor: pointer;
            background-color: darkred;
        }
        #users tr td{
            text-align: center;
        }
        #users tr:nth-child(odd) {
            background-color: white;
        }
        #users tr:nth-child(even) {
            background-color: lightgrey;
        }
        #users{
            margin-left: 20%;
            margin-right: 20%;
            width: 60%;
        }
    </style>
    <link rel="stylesheet" href="../style/forms.css">
    <script src="../javascript/adminSession.js"></script>
</head>
<body>
<?php require_once('navbar.php'); ?>
<div id="users"></div>
<button class="floating-button" onclick="showRegister()">+</button>
<?php
require_once('scripts.php');
?>
<script>

    window.onload = init;

    function init(){
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
        var table = newTable( newTableHeader(['USUARIO','CORREO','TIPO','TELEFONO', '']) );
        for( var i = 0; i < users.length; i++ ){
            var user = users[i];
            if(user['username'] != JSON.parse(cookieManager.getValue('user'))['username']){
                var deleteButton = newButton('X', showDeleteDialog);
                deleteButton.setAttribute('data-id', user['username']);
                var row = newTableRow([ user['username'], user['email'], user['type'], user['phone'], deleteButton]);
                row.setAttribute('data-user', JSON.stringify(user));
                row.onclick = showUpdateForm;
                table.appendChild(row);
            }
        }
        findViewById('users').appendChild(table);
    }

    function showUpdateForm(){
        var user = JSON.parse(this.getAttribute('data-user'));
        var form = getUserForm();
        notifier.expectsHTMLContent();
        notifier.setTheme( MODAL_BLUE );
        notifier.confirm(
            'Actualizar',
            form.outerHTML,
            function(confirm){
                if( confirm ){
                    updateProduct();
                }
            }
        );
        findViewById('username').value = user['username'];
        findViewById('username').disabled = true;
        findViewById('email').value = user['email'];
        findViewById('password').value = user['password'];
        findViewById('type').value = user['type'];
        findViewById('phone').value = user['phone'];
    }

    function updateProduct() {
        var formData = getUserFormData();
        ajax.postWithProgress(
            '../server/action/user/update.php',
            formData,
            onUpdateSuccess,
            onUpdateFailure,
            onUpdateProgress
        );
    }

    function onUpdateProgress( total, current) {
        appendLog('UPDATE', total + 'of' + current);
    }

    function onUpdateFailure( error ){
        appendLog('UPDATE', error);
    }

    function onUpdateSuccess(){
        notifier.setTheme( MODAL_GREEN );
        notifier.dontExpectsHTMLContent();
        notifier.alert(
            'Éxito',
            'El usuario ha sido actualizado exitosamente',
            refreshPage
        );
    }

    function getUserFormData() {
        var formData = new FormData();
        formData.append('username', findViewById('username').value);
        formData.append('email', findViewById('email').value);
        formData.append('password', findViewById('password').value);
        formData.append('type', findViewById('type').value);
        formData.append('phone', findViewById('phone').value);
        return formData;
    }
    
    function showDeleteDialog(){
        event.stopPropagation();
        var id = this.getAttribute('data-id');
        notifier.dontExpectsHTMLContent();
        notifier.setTheme( MODAL_RED );
        notifier.confirm(
            'Eliminar',
            'A continuación se eliminara el usuario ' + id + ', ¿Desea Continuar?',
            function(confirm){
                if( confirm ){
                    deleteUser(id);
                }
            }
        );
    }

    function deleteUser(id){
        var params = {};
        params['username'] = id;
        ajax.post(
            '../server/action/user/delete.php',
            params,
            onDeleteSuccess,
            onDeleteFailure
        );
    }

    function onDeleteSuccess(){
        notifier.dontExpectsHTMLContent();
        notifier.setTheme( MODAL_ORANGE );
        notifier.alert(
            'Eliminacion Exitosa',
            'El usuario ha sido eliminado con exito',
            refreshPage
        );
    }

    function onDeleteFailure( error ){
        appendLog('DELETE', error);
    }

    function showRegister(){
        var form = getUserForm();
        notifier.expectsHTMLContent();
        notifier.setTheme( MODAL_BLUE );
        notifier.confirm(
                '¿Desea registrar este usuario?',
                form.outerHTML,
                function( confirm ){
                    if( confirm ){
                        registerUser();
                    }
                }
        );
    }

    function registerUser(){
        var formData = getUserFormData();
        ajax.postWithProgress(
            '../server/action/user/new.php',
            formData,
            onRegisterSuccess,
            onRegisterFailure,
            onRegisterProgress
        );
    }

    function onRegisterSuccess( data ){
        notifier.setTheme( MODAL_GREEN );
        notifier.dontExpectsHTMLContent();
        notifier.alert(
            'Éxito',
            'El usuario ha sido registrado exitosamente',
            refreshPage
        );
    }

    function onRegisterFailure( error ){
        appendLog('REGISTER', error);
    }

    function onRegisterProgress( total, current ){
        appendLog('REGISTER', 'Total : ' + total + ' Current : ' + current);
    }

    function getUserForm() {
        var container = newDiv();
        container.setAttribute('id', 'container');
        var formDiv = newDiv();
        formDiv.setAttribute('id', 'form');

        var form = newForm('', 'POST', 'form');
        var username = newFormGroupInput('Nombre de Usuario : ', 'text', 'username', 'username');
        var email = newFormGroupInput('Correo Electronico : ','email', 'email', 'email');
        var password = newFormGroupInput('Password : ', 'password', 'password', 'password');
        var type = newFormGroupSelect('Tipo : ', ['admin', 'user'], 'type', 'type');
        var phone = newFormGroupInput('Telefono : ', 'text', 'phone', 'phone');
        appendItemsTo(
            form,
            [username, email, password, type, phone]
        );
        formDiv.appendChild(form);
        container.appendChild(formDiv);
        return container;
    }
</script>
</body>
</html>
