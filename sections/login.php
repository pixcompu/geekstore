<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Iniciar Sesión";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/forms.css">
    <style>
        a[href='login.php']{
            background-color: white;
        }
    </style>
</head>
<body>
<?php require_once('navbar.php'); ?>
<div class="container">
  <div class="form">
    <h1>Iniciar Sesión</h1>
    <form action="" name="form" method="POST">
        <input type="text" name="username" id="username" placeholder="Nombre de usuario"><br>
        <input type="password" name="password" id="password" placeholder="Contrase&ntilde;a"><br>
        <input type="button" value="Iniciar" class="button" id="btnLogin">
    </form>
  </div>
</div>
<?php
require_once('scripts.php');
?>
<script src="../javascript/sections/login.js"></script>
</body>
</html>
