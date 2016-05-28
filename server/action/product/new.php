<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 25/04/2016
 * Time: 07:04 PM
 */
require_once('../../autoloader.php');

try{
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $product = new Product();
    $product->setName($name);
    $product->setDescription($description);
    $product->setPrice($price);
    $product->setQuantity($quantity);
    if(isset($_FILES['image'])){
        $fileUploader = new FileUploader();
        $fileUploader->upload('image');
        $imagePath = $fileUploader->getUploadedFileURL();
        $product->setImage($imagePath);
    }
    $product->save();
    respondWithSuccess($product);
}catch(Exception $e){
    respondWithError($e->getMessage());
}