<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 26/05/2016
 * Time: 02:53 PM
 */
require_once('../../autoloader.php');

try{
    $user = new User();
    $user->setUsername($_POST['username']);
    $user->delete();
    respondWithSuccess();
}catch(Exception $e){
    respondWithError($e->getMessage());
}