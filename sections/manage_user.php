<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Usuarios";
    require_once('parts/header.php');
    ?>
    <script src="../javascript/adminSession.js"></script>
    <link rel="stylesheet" href="../style/floating_button.css">
    <link rel="stylesheet" href="../style/forms.css">
    <link rel="stylesheet" href="../style/tables.css">
    <link rel="stylesheet" href="../style/sections/manage_user.css">
</head>
<body>

<?php require_once('parts/navbar.php'); ?>

<div id="users"></div>
<button class="floating-button" onclick="showRegister()">+</button>

<?php require_once('parts/scripts.php'); ?>

<script src="../javascript/sections/manage_user.js"></script>
</body>
</html>
