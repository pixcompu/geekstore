<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 23/04/2016
 * Time: 04:09 PM
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/geekstore/server/autoloader.php');

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];

$user = new User();
$user->setUsername($username);
$user->setEmail($email);
$user->setPhone($phone);
$user->setPassword(md5($password));
$user->setType(TYPE_USER);

$response = array();
try{
    $user->save();
    respondWithSuccess();
}catch(Exception $e){
   respondWithError($e->getMessage());
}