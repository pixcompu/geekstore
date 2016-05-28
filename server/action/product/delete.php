<?php

require_once('../../autoloader.php');

try{
    validateFields(array(
        'id' => 'Selecciona un producto'
    ));
    $product = new Product();
    $product->setId($_POST['id']);
    $product->delete();
    respondWithSuccess();
}catch(Exception $e){
    if( $e->getCode() == FIELD_NOT_FOUND){
        respondWithError($e->getMessage());
    }else{
        respondWithError('Revisa tu conexión a internet');
    }
}