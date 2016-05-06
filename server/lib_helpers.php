<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 23/04/2016
 * Time: 11:43 PM
 */
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