<?php

require_once('../../autoloader.php');

try{
    $product = new Product();

    $search = null;
    if (isset($_POST["search"]) && !empty($_POST["search"])) {
        $search = $_POST['search'];
    }

    $products = $product->all($search);
    respondWithSuccess($products);
}catch(Exception $e){
    respondWithError('Revisa tu conexion a internet para visualizar los productos');
}