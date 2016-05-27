<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    $sectionTitle = "GeekStore - Contacto";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/star_wars_effect.css">
    <link rel="stylesheet" href="../style/contact.css">
    <link rel="stylesheet" href="../style/forms.css">
    <style>
        a[href='contact.php']{
            color: white;
            background-color: black;
        }
    </style>
</head>
<body>
<?php require_once('navbar.php'); ?>
<img src="../resources/images/icons/pacman.gif" id="pacman" alt="">
<div id="container">
    <div id="form-map">
        <p>Ven a visitarnos</p>
        <div id="map"></div>
    </div>
    <div id="form-message">
        <p>Envíanos un correo.</p>
        <div id="forms">
            <input id="email" name="emailInput" type="email" placeholder="Correo electrónico"> <br>
            <textarea id="message" name="messageInput"></textarea><br>
            <button id="send" name="btnSend"><img src="../resources/images/icons/inky.png" alt="">Enviar</button><br>
        </div>
    </div>

</div>
<?php
require_once('scripts.php');
?>
<script type="text/javascript">
    var map;
    function initMap() {
        var fmatLocation = {lat: 21.047777, lng: -89.644536};
        map = new google.maps.Map(document.getElementById('map'), {
            center: fmatLocation,
            zoom: 18
        });
        var marker = new google.maps.Marker({
            position: fmatLocation,
            map: map,
            title: 'Ubicacion de nuestra tienda'
        });
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTeBniIi0z5iw6yhE4FqOT7SSbUvM3qe0&callback=initMap">
</script>
<script src="../javascript/sections/contact.js"></script>

</body>
</html>
