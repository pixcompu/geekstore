<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Carrito";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/cart.css">
</head>
<body>
<?php require_once('navbar.php'); ?>
<div id="cart">
    <h1>&iexcl;Tu carrito está vacio!</h1><br>
    <img id="game_over" src="../resources/images/icons/game_over.png" alt="game_over"><br>
    <button id="start_shopping"><img src="../resources/images/icons/1UP.png" alt=""> Empieza a Comprar</button>
</div>
<div id="options">
    <button id="btn_buy_cart_items"><img src="../resources/images/icons/buy-hand.png" alt="Hand"> Realizar Compra</button>
    <button id="btn_drop_cart"><img src="../resources/images/icons/trash_can.png" alt="Trash"> Vaciar Carrito</button>
    <button id="btn_shop"><img src="../resources/images/icons/tag.png" alt="Shop"> Seguir Comprando</button>
</div>
<?php require_once('scripts.php'); ?>
<script src="../javascript/sections/cart.js"></script>
</body>
</html>