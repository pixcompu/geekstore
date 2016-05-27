<?php
require_once('../../autoloader.php');

$product = new Product();
if (isset($_POST["search"]) && !empty($_POST["search"])) {
    try{
        $products = $product->findAll($_POST["search"]);
        respondWithSuccess($products);
    }catch(Exception $e){
        respondWithError($e->getMessage());
    }
} else {
    try{
        $products = $product->all();
        respondWithSuccess($products);
    }catch(Exception $e){
        respondWithError($e->getMessage());
    }
}
