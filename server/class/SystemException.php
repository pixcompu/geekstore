<?php
define('DUPLICATE_ENTRY', 0);
define('SQL_ERROR', 1);
define('MODEL_ERROR', 2);
define('NOT_FOUND', 3);
define('FIELD_NOT_FOUND', 4);
define('FIELD_NOT_VALID', 5);
define('SALE_ABORTED', 6);
class SystemException extends Exception{

    public function __construct($code, $message){
        parent::__construct($message, $code);
    }

}