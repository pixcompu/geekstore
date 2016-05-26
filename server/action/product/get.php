<?php
require_once('../../autoloader.php');

$product = new Product();
try{
    $products = $product->all();
    respondWithSuccess($products);
}catch(Exception $e){
    respondWithError($e->getMessage());
}