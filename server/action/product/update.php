<?php

require_once('../../autoloader.php');

try{
    validateFields(
        array(
            'id' => 'Selecciona un producto',
            'name' => 'Proporciona un nombre',
            'description' => 'Proporciona una descripcion',
            'price' => 'Proporciona un precio',
            'quantity' => 'Proporciona una cantidad')
    );
    
    validateIntegers(
        array('quantity' => 'La cantidad debe ser un número entero')
    );

    validateDecimals(
        array('price' => 'El precio debe ser numérico')
    );
    
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $id = $_POST['id'];

    $product = new Product();
    $product->setId($id);
    $product->setName($name);
    $product->setDescription($description);
    $product->setPrice($price);
    $product->setQuantity($quantity);
    
    $updatedImage = isset($_FILES['image']);
    if( $updatedImage ){
        $fileUploader = new FileUploader();
        $fileUploader->upload('image');
        $imagePath = $fileUploader->getUploadedFileURL();
        $product->setImage($imagePath);
    }
    $product->update();
    
    respondWithSuccess($product);
}catch(Exception $e){
    if( $e->getCode() == FIELD_NOT_FOUND || $e->getCode() == FIELD_NOT_VALID){
        respondWithError($e->getMessage());
    }else{
        respondWithError('Revisa tu conexión a internet');
    }
}