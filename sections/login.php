<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Iniciar Sesión";
    require_once('parts/header.php');
    ?>
    <link rel="stylesheet" href="../style/forms.css">
    <link rel="stylesheet" href="../style/sections/login.css">
</head>
<body>

<?php require_once('parts/navbar.php'); ?>

<div class="container">
  <div class="form">
    <h1>Iniciar Sesión</h1>
    <form action="" name="form" method="POST">
        <input type="text" name="username" id="username" class="form-input" placeholder="Nombre de usuario"><br>
        <input type="password" name="password" id="password" class="form-input" placeholder="Contrase&ntilde;a"><br>
        <input type="button" value="Iniciar" class="geek-btn" id="btnLogin">
    </form>
  </div>
</div>

<?php require_once('parts/scripts.php'); ?>

<script src="../javascript/sections/login.js"></script>
</body>
</html>
