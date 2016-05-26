<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 25/04/2016
 * Time: 07:04 PM
 */
require_once('../../autoloader.php');

try{
    
    $fileUploader = new FileUploader();
    $fileUploader->upload('image');
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $imagePath = $fileUploader->getUploadedFileURL();

    $product = new Product();
    $product->setName($name);
    $product->setDescription($description);
    $product->setPrice($price);
    $product->setQuantity($quantity);
    $product->setImage($imagePath);
    $product->save();
    respondWithSuccess($product);
}catch(Exception $e){
    respondWithError($e->getMessage());
}