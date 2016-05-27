<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Registro";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/forms.css">
    <style>
        a[href='register.php']{
            background-color: white;
        }
    </style>
</head>
<body>
<?php require_once('navbar.php'); ?>
<div class="container">
    <div class="form">
        <h1>Ingresa tu información</h1>
        <form action="" name="form">
            <input type="text" name="username" id="username" placeholder="Nombre de usuario"><br>
            <input type="text" name="email" id="email" placeholder="Correo electrónico"><br>
            <input type="password" name="password" id="password" placeholder="Contrase&ntilde;a"><br>
            <input type="tel" name="phone" id="phone" placeholder="Teléfono"><br>
            <input type="button" name="btnRegister" class="button" value="Registrarse" >
        </form>
    </div>
</div>
<?php
require_once('scripts.php');
?>
<script src="../javascript/sections/register.js"></script>
</body>
</html>
