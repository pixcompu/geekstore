<?php
require_once 'autoloader.php';

try{
    $item = new Sale_item();
    $item->setFpId($_POST['product_id']);
    $item->setQuantity($_POST['purchase_quantity']);
    $item->setSubtotal($_POST['subtotal']);
    $item->save();
    respondWithSuccess($item);
}catch(Exception $e){
    respondWithError($e->getMessage());
}