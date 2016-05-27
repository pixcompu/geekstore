<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Catálogo";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/catalog.css">
    <style>
        a[href='catalog.php']{
            color: white;
            background-color: black;
        }
    </style>
</head>
<body>
<?php require_once('navbar.php'); ?>
<div id="catalog"></div>
<?php require_once('scripts.php'); ?>
<script src="../javascript/sections/catalog.js"></script>
</body>
</html>
