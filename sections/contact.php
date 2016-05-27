<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    $sectionTitle = "GeekStore - Contacto";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/star_wars_effect.css">
    <style type="text/css">
        html, body { height: 100%; margin: 0; padding: 0; }

        @font-face {
            font-family: game;
            src: url('../resources/fonts/game/PressStart2P-Regular.ttf');
        }

        body{
            font-family: game, serif;
            background: lightgrey url('../resources/images/background/pacman2.jpg') center;
        }

        #map {
            width: 350px;
            height: 350px;
            border-radius: 10%;
        }

        #container{
            margin-top: 100px;
            margin-left: 100px;
        }

        #email{
            width: 400px;
            height: 30px;
            margin: 20px;
        }

        #message{
            width: 400px;
            height: 100px;
            margin: 20px;
        }

        #container p {
            color: #fefefe;
            font-size: 20px;
        }

        #send{
            width: 200px;
            height: 30px;
            margin: 20px;

        }

        #container>div{
            width: 100px;
        }

        table{
            text-align: center;
            margin-left: 20%;
            margin-right: 20%;
        }

        td{
            padding: 50px;
        }
        a[href='contact.php']{
            background-color: white;
        }
    </style>
</head>
<body>
<?php require_once('navbar.php'); ?>
<img src="../resources/images/icons/pacman.gif" id="bird" alt="">
<div id="container">
    <table>
        <tr>
            <td>
                <p>Encuentranos en esta dirección</p>
                <div id="map"></div>
            </td>
            <td>
                <p>Envíanos un correo.</p>
                <div >
                    <input id="email" type="email" placeholder="Correo electrónico"> <br>
                    <textarea id="message"></textarea><br>
                    <button id="send">Enviar</button><br>
                </div>
            </td>
        </tr>
    </table>
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
</body>
</html>