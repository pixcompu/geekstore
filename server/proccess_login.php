<?php

require_once 'autoloader.php';

$username = $_POST['username'];
$password = $_POST['password'];

$user = new User();
$user->setUsername($username);

$response = array();

try{
    $jsonUser = $user->getById();
    if( strcmp($jsonUser['username'], $username)==0 && strcmp(md5($password), $jsonUser['password'])==0 ){
        $session = new Session();
        $session->login($jsonUser);
        respondWithSuccess($jsonUser);
    }else{
        respondWithError('Contraseña incorrecta');
    }   
}catch(Exception $e){
    if( $e->getCode() == NOT_FOUND ){
        respondWithError( 'Ese usuario no existe' );
    }else{
        respondWithError($e->getCode() . "   " . $e->getMessage());
    }
}