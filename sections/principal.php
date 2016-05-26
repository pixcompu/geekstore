<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../resources/images/tab/tab_icon.png">
    <title>GeekStore - Inicio</title>
    <!--[if !IE]><!-->
    <link rel="stylesheet" href="../style/splash.css">
    <link rel="stylesheet" href="../style/star_wars_effect.css">
    <!--<![endif]-->
    <!--[if IE]>
    <link rel="stylesheet" type="text/css" href="../style/ie/principal.css" />
    <![endif]-->
    <link rel="stylesheet" href="../style/header.css">
    <link rel="stylesheet" href="../style/home.css">
    <link rel="stylesheet" href="../style/notifier.css">
</head>
<body>
<div id="splash">
    <p>Cargando...</p>
    <img src="../resources/images/background/gangnam.gif" alt="">
</div>
<img src="../resources/images/icons/space-bird.png" id="bird" alt="">
<div id="principal">
    <?php require_once('navbar.php'); ?>
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
<script src="../javascript/notifier.js"></script>
<script src="../javascript/ajax.js"></script>
<script src="../javascript/cookies.js"></script>
<script src="../javascript/factory.js"></script>
<script>

    window.onload = init;

    function init(){
        if( cookieManager.check('user') ){
            var sessionPanel = findViewById('session-options');
            clearElement( sessionPanel );

            var user = JSON.parse(cookieManager.getValue('user'));
            var link = newHyperLink('Cerrar Sesión','');
            link.onclick = showLogoutDialog;
            addClassTo(link, 'logout-item');
            appendItemsTo( sessionPanel,
                    [
                        newLi(newParagraph('Bienvenido: ' + user['username'])),
                        newLi(link)
                    ]);

            if( cookieManager.check('user') ){
                addProfileOption();
            }

            if( user['type'] === 'admin' ){
                addExtraOptions();
            }
        }

        removeSplash();
        findViewById('bird').onclick = function(){
            if(this.src.split('/')[this.src.split('/').length-1] == 'space-bird-effect.png'){
                this.src = '../resources/images/icons/space-bird.png';
            }else{
                this.src = '../resources/images/icons/space-bird-effect.png'
            }
        };
    }

    function removeSplash() {
        //findViewById('splash').style.opacity = '0';
        setTimeout(function(){
            removeElement(findViewById('splash'));
        }, 700);
    }

    function addExtraOptions() {
        var navbar = findViewById('navbar-options');
        appendItemsTo( navbar,
                [
                    newLi( addClassTo(newHyperLink('Administrar Productos', 'manage_product.php'), 'navbar-item') ),
                    newLi( addClassTo(newHyperLink('Administrar Usuarios', 'manage_user.php'), 'navbar-item'))
                ]);
    }

    function addProfileOption() {
        var navbar = findViewById('navbar-options');
        navbar.appendChild( newLi( addClassTo(newHyperLink('Mi perfil', 'profile.php'), 'navbar-item')) );
    }

    function showLogoutDialog(event){
        event.preventDefault();
        notifier.setTheme( MODAL_RED );
        notifier.dontExpectsHTMLContent();
        notifier.confirm(
                'Cerrar Sesión',
                '¿Esta seguro que desea cerrar su sesión?',
                function( confirm ){
                    if( confirm ){
                        logout();
                    }
                }
        );
    }

    function logout(){
        cookieManager.erase('user');
        ajax.post(
                '../server/action/session/logout.php',
                {},
                onLogoutSuccess,
                onLogoutError
        );
    }

    function onLogoutSuccess( response ){
        redirectTo('principal.php');
    }

    function onLogoutError( error ){
        appendLog('LOGIN', error);
    }
</script>
</body>
</html>