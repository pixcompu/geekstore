<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 26/04/2016
 * Time: 12:45 AM
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/geekstore/server/autoloader.php');

try{
    $product = new Product();
    $product->setId($_POST['id']);
    $product->delete();
    respondWithSuccess();
}catch(Exception $e){
    respondWithError($e->getMessage());
}