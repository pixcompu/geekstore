<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 09/02/2016
 * Time: 03:25 PM
 */
header('Content-Type: text/html; charset=utf-8');
define('CHARSET', "utf8");
define('WITH_FAILURE', false);
define('WITH_SUCCESS', true);

class Executor{
    private static $mysqli_object;
    private static $firstAndOnlyInstance;

    private function __construct(){
        self::$mysqli_object = new mysqli();
        if(self::connect()){
            self::$mysqli_object->set_charset(CHARSET);
        }
    }

    public function __destruct(){
        if($this->isConnected()){
            self::$mysqli_object->close();
        }
    }

    public function executeQuery($instruction){
        $query_result = self::$mysqli_object->query($instruction);
        return $query_result;
    }

    public static function getInstance(){
        if(self::$firstAndOnlyInstance == null){
            self::$firstAndOnlyInstance = new Executor();
        }
        if((self::$mysqli_object->connect_errno != 0)){
            if(self::connect()){
                self::$mysqli_object->set_charset(CHARSET);
            }
        }
        return self::$firstAndOnlyInstance;
    }

    public function startTransaction(){
        self::$mysqli_object->autocommit(false);
    }

    public function endTransaction($transactionSuccessful){
        if( $transactionSuccessful ){
            self::$mysqli_object->commit();
        }else{
            self::$mysqli_object->rollback();
        }
        self::$mysqli_object->autocommit(true);
    }

    public function disconnect(){
        self::$mysqli_object->close();
    }

    public function isConnected(){
        return (self::$mysqli_object->connect_errno == 0);
    }

    public function getLastAutoincrementId(){
        return self::$mysqli_object->insert_id;
    }

    public function getAffectedRows(){
        return self::$mysqli_object->affected_rows;
    }

    public function scapeString($string){
        return self::$mysqli_object->real_escape_string($string);
    }

    public function getLastError(){
        return mysqli_error(self::$mysqli_object);
    }

    private function connect(){
        self::$mysqli_object->connect(DIRECCION, USER, PASSWORD, DATABASE);
        return (!self::$mysqli_object->error);
    }
}

