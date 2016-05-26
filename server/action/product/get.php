<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 23/04/2016
 * Time: 11:52 PM
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/geekstore/server/autoloader.php');

$product = new Product();
try{
    $products = $product->all();
    respondWithSuccess($products);
}catch(Exception $e){
    respondWithError($e->getMessage());
}