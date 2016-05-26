<?php
require_once('../../autoloader.php');

try{
    $product = new Product();
    $product->setId($_POST['id']);
    $product->delete();
    respondWithSuccess();
}catch(Exception $e){
    respondWithError($e->getMessage());
}