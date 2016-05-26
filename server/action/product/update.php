<?php
require_once('../../autoloader.php');

try{

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $id = $_POST['id'];
    $updatedImage = isset($_FILES['image']);

    $product = new Product();
    $product->setId($id);

    $product->setId($id);
    $product->setName($name);
    $product->setDescription($description);
    $product->setPrice($price);
    $product->setQuantity($quantity);
    if( $updatedImage ){
        $fileUploader = new FileUploader();
        $fileUploader->upload('image');
        $imagePath = $fileUploader->getUploadedFileURL();
        $product->setImage($imagePath);
    }

    $product->update();
    respondWithSuccess($product);
}catch(Exception $e){
    respondWithError($e->getMessage());
}