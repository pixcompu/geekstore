<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    $sectionTitle = "GeekStore - Contacto";
    require_once('parts/header.php');
    ?>
    <link rel="stylesheet" href="../style/star_wars_effect.css">
    <link rel="stylesheet" href="../style/forms.css">
    <link rel="stylesheet" href="../style/sections/contact.css">
    <style>
        a[href='contact.php']{
            color: white;
            background-color: black;
        }
    </style>
</head>
<body>
<?php require_once('parts/navbar.php'); ?>
<img src="../resources/images/icons/pacman.gif" id="pacman" alt="">

<div class="container contact-container">
    <div class="form">
        <h1>Comunícate con nosotros</h1>
        <div class="contact-form ">
            <input id="email" class="form-input" name="emailInput" type="email" placeholder="Correo electrónico">
            <textarea id="message" class="form-textarea" name="messageInput" placeholder="Escribe tus comentarios y sugerencias"></textarea>
            <input id="send" type="button" value="Enviar" class="geek-btn" name="btnSend" ></input>
        </div>
    </div>
</div>

<?php
require_once('parts/scripts.php');
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
