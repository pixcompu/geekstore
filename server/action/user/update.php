<?php
require_once('../../autoloader.php');

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$type = $_POST['type'];

$user = new User();
$user->setUsername($username);
$user->setEmail($email);
$user->setPhone($phone);
$user->setPassword(md5($password));
$user->setType(TYPE_USER);

$response = array();
try{
    $user->update();
    respondWithSuccess();
}catch(Exception $e){
    respondWithError($e->getMessage());
}