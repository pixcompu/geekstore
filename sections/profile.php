<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Mi Perfil";
    require_once('header.php');
    ?>
    <script src="../javascript/userSession.js"></script>
    <link rel="stylesheet" href="../style/profile.css">
</head>
<body>

<?php require_once('navbar.php')?>

<div id="profile-panel">
    <div id="image">
        <img src="../resources/images/icons/profile_image.png" alt="">
    </div>
    <div id="attributes">
        <p id="username"></p>
        <p id="email"></p>
        <p id="phone"></p>
    </div>
</div>

<?php require_once('scripts.php'); ?>

<script src="../javascript/userSession.js"></script>
<script src="../javascript/sections/profile.js"></script>
</body>
</html>