<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Inicio";
    require_once('parts/header.php');
    ?>
    <!--[if !IE]><!-->
    <link rel="stylesheet" href="../style/splash.css">
    <link rel="stylesheet" href="../style/star_wars_effect.css">
    <!--<![endif]-->
    <!--[if IE]>
    <link rel="stylesheet" type="text/css" href="../style/ie/principal.css" />
    <![endif]-->
</head>
<body>

<?php require_once('parts/navbar.php'); ?>

<div id="splash">
    <p>Cargando...</p>
    <img src="../resources/images/background/gangnam.gif" alt="">
</div>
<img src="../resources/images/icons/space-bird.png" id="bird" alt="">
<div id="principal">
    <div id="content">
        <div id="products">
            <h1>Episodio Geekstore</h1>
            <p>
                En una tienda no tan lejana...
            </p>
            <p>
                Una nueva esperanza para los amantes de lo geek como nunca lo hab&iacute;as visto ha surgido.
            </p>
            <p>
                Acabas de llegar al lugar indicado para comprar, tenemos una gran variedad de productos para ti, y
                claro todos a un gran precio para que puedas vivir tus aficiones al m&aacute;ximo.
            </p>
            <p>
                &iquest;Sigues aqui? &iquest;Qu&eacute; esperas?
            </p>
            <p>
                Visita nuestro cat&aacute;logo dando click en la siguiente imagen
            </p>
            <a href="catalog.php"><img src="../resources/images/icons/zelda-dangerous.png" alt=""></a>
        </div>
    </div>
</div>

<?php require_once('parts/scripts.php'); ?>
<script src="../javascript/sections/principal.js"></script>
</body>
</html>
