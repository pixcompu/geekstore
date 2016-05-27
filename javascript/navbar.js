initSessionConfig();

function initSessionConfig() {
    if (cookieManager.check('user')) {
        var sessionOptions = findViewById('session-options');
        clearElement(sessionOptions);
        var user = JSON.parse(cookieManager.getValue('user'));
        var link = newHyperLink('Cerrar Sesión', '');
        link.onclick = showLogoutDialog;
        addClassTo(link, 'logout-item');
        appendItemsTo(sessionOptions,
            [
                newLi(link),
            ]);


        if (cookieManager.check('user')) {
            addProfileOption();
        }

        if (user['type'] === 'admin') {
            addExtraOptions();
        }
    }

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