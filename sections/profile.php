<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../resources/images/tab/tab_icon.png">
    <title>GeekStore - Mi Perfil</title>
</head>
<body>
<div id="session"></div>
<script src="../javascript/cookies.js"></script>
<script src="../javascript/factory.js"></script>
<script>
    window.onload = function(){
        if( cookieManager.check('user') ){
            var sessionPanel = findViewById('session');
            clearElement( sessionPanel );
            sessionPanel.appendChild( newParagraph(cookieManager.getValue('user')) );
        }
    }
</script>
</body>
</html>