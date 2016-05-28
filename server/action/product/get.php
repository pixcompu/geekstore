<?php

require_once('../../autoloader.php');

try{
    $product = new Product();

    if (isset($_POST["search"]) && !empty($_POST["search"])) {
        $products = $product->findAll($_POST["search"]);
    } else {
        $products = $product->all();
    }

    respondWithSuccess($products);
}catch(Exception $e){
    respondWithError('Revisa tu conexion a internet para visualizar los productos');
}