<?php

require_once('../../autoloader.php');

try{

    validateFields(array(
        'username' => 'Especifica un usuario',
        'password' => 'Especifica una contraseña')
    );

    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = new User();
    $user->setUsername($username);

    $savedUser = $user->getById();
    if( strcmp($savedUser['username'], $username)==0 && strcmp(md5($password), $savedUser['password'])==0 ){
        $session = new Session();
        $session->login($savedUser);
        respondWithSuccess($savedUser);
    }else{
        respondWithError('Contraseña incorrecta');
    }

}catch(Exception $e){
    if( $e->getCode() == NOT_FOUND ){
        respondWithError( 'Ese usuario no existe' );
    }else if( $e->getCode() == FIELD_NOT_FOUND){
        respondWithError($e->getMessage());
    }else{
        respondWithError('Revisa tu conexión a internet');
    }
}