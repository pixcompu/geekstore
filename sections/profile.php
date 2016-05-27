<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Mi Perfil";
    require_once('header.php');
    ?>
    <script src="../javascript/userSession.js"></script>
</head>
<body>

<?php require_once('navbar.php')?>

<div id="profile-panel"></div>

<?php require_once('scripts.php'); ?>

<script src="../javascript/userSession.js"></script>
<script>
    window.onload = function(){
        if( cookieManager.check('user') ){
            var sessionPanel = findViewById('profile-panel');
            clearElement( sessionPanel );
            sessionPanel.appendChild( newParagraph(cookieManager.getValue('user')) );
        }
    }
</script>
</body>
</html>