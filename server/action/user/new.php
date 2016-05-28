<?php

require_once('../../autoloader.php');

try{
    validateFields(array(
        'username' => 'Proporciona un nombre de usuario',
        'email' => 'Proporciona un correo electronico',
        'password' => 'Proporciona una contraseña',
        'phone' => 'Proporciona un teléfono'
    ));
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    $user = new User();
    $user->setUsername($username);
    $user->setEmail($email);
    $user->setPhone($phone);
    $user->setPassword(md5($password));
    
    if(isset($_POST['type'])){
        $user->setType($_POST['type']);   
    }else{
        $user->setType(TYPE_USER);
    }

    $user->save();
    respondWithSuccess();
}catch(Exception $e){
    if( $e->getCode() == FIELD_NOT_FOUND || $e->getCode() == FIELD_NOT_VALID){
        respondWithError($e->getMessage());
    }else{
        respondWithError('Revisa tu conexión a internet');
    }
}