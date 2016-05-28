<?php
function respondWithSuccess($data = 'Operacion completada con exito'){
    $response = array();
    $response['status'] = 'success';
    $response['data'] = $data;
    echo json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
}

function respondWithError($message){
    $response = array();
    $response['status'] = 'failure';
    $response['description'] = $message;
    echo json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
}

function validateFields($fields){
    foreach ($fields as $field => $message){
        if( !isset($_POST[$field]) ){
            throw new SystemException(FIELD_NOT_FOUND, $message);
        }
    }
}