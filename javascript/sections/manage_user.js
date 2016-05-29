
window.onload = init;

var cachedValues = {};

function init(){
    ajax.expectJsonProperties(['status']);
    ajax.get(
        '../server/action/user/get.php',
        onFetchSuccess,
        onFetchFailure
    );
}

function onFetchSuccess(response){
    var data = response.data;
    showUsers( data );
}

function onFetchFailure(error){
    console.log(error);
}

function showUsers( users ){
    var table = newTable( newTableHeader(['USUARIO','CORREO','TIPO','TELEFONO', '']) );
    for( var i = 0; i < users.length; i++ ){
        var user = users[i];
        if(user['username'] != JSON.parse(cookieManager.getValue('user'))['username']){
            var deleteButton = newButton('X', showDeleteDialog);
            deleteButton.setAttribute('data-id', user['username']);
            var row = newTableRow([ user['username'], user['email'], user['type'], user['phone'], deleteButton]);
            row.setAttribute('data-user', JSON.stringify(user));
            row.onclick = showUpdateForm;
            table.appendChild(row);
        }
    }
    findViewById('users').appendChild(table);
}

function showUpdateForm(){
    var user = JSON.parse(this.getAttribute('data-user'));
    var form = getUserForm();
    notifier.expectsHTMLContent();
    notifier.setTheme( MODAL_BLUE );
    notifier.confirm(
        'Actualizar',
        form.outerHTML,
        function(confirm){
            if( confirm ){
                updateProduct();
            }
        }
    );
    findViewById('username').value = user['username'];
    findViewById('username').disabled = true;
    findViewById('email').value = user['email'];
    findViewById('password').value = user['password'];
    findViewById('type').value = user['type'];
    findViewById('phone').value = user['phone'];
}

function updateProduct() {
    if( validateFormData() ) {
        var formData = getUserFormData();
        ajax.postWithProgress(
            '../server/action/user/update.php',
            formData,
            onUpdateSuccess,
            onUpdateFailure,
            onUpdateProgress
        );
    }
}

function onUpdateProgress( total, current) {
    appendLog('UPDATE', total + 'of' + current);
}

function onUpdateFailure( error ){
    appendLog('UPDATE', error);
}

function onUpdateSuccess(){
    notifier.setTheme( MODAL_GREEN );
    notifier.dontExpectsHTMLContent();
    notifier.alert(
        'Éxito',
        'El usuario ha sido actualizado exitosamente',
        refreshPage
    );
}

function getUserFormData() {
    var formData = new FormData();
    formData.append('username', findViewById('username').value);
    formData.append('email', findViewById('email').value);
    formData.append('password', findViewById('password').value);
    formData.append('type', findViewById('type').value);
    formData.append('phone', findViewById('phone').value);
    return formData;
}

function showDeleteDialog(){
    event.stopPropagation();
    var id = this.getAttribute('data-id');
    notifier.dontExpectsHTMLContent();
    notifier.setTheme( MODAL_RED );
    notifier.confirm(
        'Eliminar',
        'A continuación se eliminara el usuario ' + id + ', ¿Desea Continuar?',
        function(confirm){
            if( confirm ){
                deleteUser(id);
            }
        }
    );
}

function deleteUser(id){
    var params = {};
    params['username'] = id;
    ajax.post(
        '../server/action/user/delete.php',
        params,
        onDeleteSuccess,
        onDeleteFailure
    );
}

function onDeleteSuccess(){
    notifier.dontExpectsHTMLContent();
    notifier.setTheme( MODAL_ORANGE );
    notifier.alert(
        'Eliminacion Exitosa',
        'El usuario ha sido eliminado con exito',
        refreshPage
    );
}

function onDeleteFailure( error ){
    appendLog('DELETE', error);
}

function showRegister(){
    var form = getUserForm();
    notifier.expectsHTMLContent();
    notifier.setTheme( MODAL_BLUE );
    notifier.confirm(
        '¿Desea registrar este usuario?',
        form.outerHTML,
        function( confirm ){
            if( confirm ){
                registerUser();
            }
        }
    );

    var cacheHasContent = !objectIsEmpty(cachedValues);
    if( cacheHasContent ){
        for( var inputID in cachedValues ){
            if( cachedValues.hasOwnProperty(inputID)){
                findViewById(inputID).value = cachedValues[inputID];
            }
        }
    }
}

function registerUser(){
    if( validateFormData() ) {
        var formData = getUserFormData();
        ajax.postWithProgress(
            '../server/action/user/new.php',
            formData,
            onRegisterSuccess,
            onRegisterFailure,
            onRegisterProgress
        );
    }
}

function validateFormData(){

    notifier.setTheme(MODAL_RED);
    var errorWindowTitle = '¡Espera un momento!';

    if( findViewById('username').value.length == 0 ) {
        notifier.alert( errorWindowTitle, 'Proporciona un usuario');
        return false;
    }
    cachedValues['username'] = findViewById('username').value;

    if( findViewById('email').value.length == 0 ) {
        notifier.alert( errorWindowTitle, 'Proporciona un correo electrónico');
        return false;
    }else if( !emailIsValid(findViewById('email').value)){
        notifier.alert( errorWindowTitle, 'El correo proporcionado no es válido');
        return false;
    }
    cachedValues['email'] = findViewById('email').value;

    if( findViewById('password').value.length == 0 ) {
        notifier.alert( errorWindowTitle, 'Proporciona una contraseña');
        return false;
    }
    cachedValues['password'] = findViewById('password').value;

    if( findViewById('type').value.length == 0 ) {
        notifier.alert( errorWindowTitle, 'Proporciona un tipo de usuario');
        return false;
    }
    cachedValues['type'] = findViewById('type').value;

    if( findViewById('phone').value.length == 0 ) {
        notifier.alert( errorWindowTitle, 'Proporciona un teléfono');
        return false;
    }else if(isNaN(findViewById('phone').value)){
        notifier.alert( errorWindowTitle, 'El teléfono proporcionado no es válido');
        return false;
    }
    cachedValues['phone'] = findViewById('phone').value;

    return true;
}

function onRegisterSuccess( data ){
    cachedValues
    notifier.setTheme( MODAL_GREEN );
    notifier.dontExpectsHTMLContent();
    notifier.alert(
        'Éxito',
        'El usuario ha sido registrado exitosamente',
        refreshPage
    );
}

function onRegisterFailure( error ){
    appendLog('REGISTER', error);
}

function onRegisterProgress( total, current ){
    appendLog('REGISTER', 'Total : ' + total + ' Current : ' + current);
}

function getUserForm() {
    var container = newDiv();
    container.setAttribute('id', 'container');
    var formDiv = newDiv();
    formDiv.setAttribute('id', 'form');
    var breakLine = newElement('br');

    var form = newForm('', 'POST', 'form');
    var username = newFormGroupInput('Nombre de Usuario : ', 'text', 'username', 'username');
    var email = newFormGroupInput('Correo Electronico : ','email', 'email', 'email');
    var password = newFormGroupInput('Password : ', 'password', 'password', 'password');
    var type = newFormGroupSelect('Tipo : ', ['admin', 'user'], 'type', 'type');
    var phone = newFormGroupInput('Telefono : ', 'text', 'phone', 'phone');
    appendItemsTo(
        form,
        [username, breakLine,  email, breakLine, password, breakLine, type, breakLine, phone]
    );
    formDiv.appendChild(form);
    container.appendChild(formDiv);
    return container;
}
