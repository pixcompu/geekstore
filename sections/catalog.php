<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Catálogo";
    require_once('parts/header.php');
    ?>
    <link rel="stylesheet" href="../style/sections/catalog.css">
</head>
<body>

<?php require_once('parts/navbar.php'); ?>

<div class="box-container">
    <input id="search" class="search-box" type="text" name="search" onkeyup="search()" placeholder="Buscar..">
</div>
<div id="catalog"></div>

<?php require_once('parts/scripts.php'); ?>

<script src="../javascript/sections/catalog.js"></script>
</body>
</html>
