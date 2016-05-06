<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 26/04/2016
 * Time: 12:42 PM
 */
require_once 'autoloader.php';

$user = new User();
try{
    $users = $user->all();
    respondWithSuccess($users);
}catch(Exception $e){
    respondWithError($e->getMessage());
}