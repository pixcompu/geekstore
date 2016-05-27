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
            width: 280px;
            height: 280px;
            border-radius: 10%;
        }

        #container{
            margin-top: 5%;
            margin-left: 15%;
            margin-right: 15%;
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

        #options button img{
            width: 20px;
            height: 20px;
        }

        #form-map, #form-message{
            float: left;
            width: 50%;
            border: 0;
            margin: 0;
        }

        #send{

            border-radius: 5%;
            border: none;
            font-family: game, sans-serif;
            color: white;
            background-color: blue;
            width: inherit;
            padding: 1%;
            margin: 20px;

        }
        #send:hover{
            background-color: dodgerblue;
            cursor: pointer;
        }

        #forms button img{
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }

        a[href='contact.php']{
            background-color: white;
        }

    </style>
    <link rel="stylesheet" href="../style/forms.css">
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
<script type="text/javascript">
    window.onload = init;

    function init(){
        findViewById('send').onclick = function(){
            if( validateFields() ){
                sendMessage();
            }
        }
    }


    function validateFields(){
        if( findViewById('email').value.length > 0 ){
            if( findViewById('message').value.length > 0 ){
                return true;
            }else{
                alert('El mensaje no puede ser vacío');
            }

        }else{
            alert('El correo no puede ser vacio');
        }
        return false;
    }


    function sendMessage() {
        var params = {};
        params['destinatary'] = findViewById('email').value;
        params['message'] = findViewById('message').value;
        ajax.expectJsonProperties(['status']);
        ajax.post(
            '../server/action/mail/send.php',
            params,
            onSendSuccess,
            onSendFailure
        );
    }
    function onSendSuccess(response){
        alert('Mensaje enviado '+response);

    }

    function onSendFailure(error){
        alert('No se pudo enviar el mensaje' + error);
    }

</script>

</body>
</html>