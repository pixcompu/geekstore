<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Iniciar Sesión";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/forms.css">
</head>
<body>
<?php require_once('navbar.php'); ?>
<div class="container">
  <div class="form">
    <h1>Iniciar Sesión</h1>
    <form action="" name="form" method="POST">
        <input type="text" name="username" id="username" placeholder="Nombre de usuario"><br>
        <input type="password" name="password" id="password" placeholder="Contrase&ntilde;a"><br>
        <input type="button" value="Iniciar" class="button" name="btnLogin">
    </form>
  </div>
</div>
<?php
require_once('scripts.php');
?>
<script>
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
      var form = document.form;
      if( form.username.value.length > 0 ){
          if( form.password.value.length > 0 ){
              return true;
          }else{
              alert('La contraseña no debe ser vacia');
          }

      }else{
          alert('El campo usuario no puede ser vacio');
      }
      return false;
    }

    function init(){
        if( cookieManager.check('user') ){
            redirectTo('principal.php');
        }
        document.form.btnLogin.onclick = function(){
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
</script>
</body>
</html>
