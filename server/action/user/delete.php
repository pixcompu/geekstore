<?php

require_once('../../autoloader.php');

try{
    validateFields(array(
        'username' => 'Selecciona un usuario'
    ));
    $user = new User();
    $user->setUsername($_POST['username']);
    $user->delete();
    respondWithSuccess();
}catch(Exception $e){
    if( $e->getCode() == FIELD_NOT_FOUND){
        respondWithError($e->getMessage());
    }else{
        respondWithError('Revisa tu conexión a internet');
    }
}