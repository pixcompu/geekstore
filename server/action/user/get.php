<?php

require_once('../../autoloader.php');

try{
    $user = new User();
    $users = $user->all();
    respondWithSuccess($users);
}catch(Exception $e){
    respondWithError('Revisa tu conexion a internet para visualizar los usuarios');
}