<?php
require_once('../../autoloader.php');

$user = new User();
try{
    $users = $user->all();
    respondWithSuccess($users);
}catch(Exception $e){
    respondWithError($e->getMessage());
}