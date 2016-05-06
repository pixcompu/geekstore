<?php

abstract class Model{
    protected $tableName = null;
    protected $fields;
    protected $executor;
    protected $tableID = ['id'];
    protected $hidden = [];

    public function __construct(){
        if( $this->tableName == null ){
            $this->tableName = strtolower(get_class($this));
        }
        $this->fields = $this->getFields();
        $this->executor = Executor::getInstance();
    }

    protected function getFields(){
        $fields = array();
        $members = new ReflectionClass($this);
        foreach ( $members->getDefaultProperties() as $key => $value){
            if( strcasecmp($key,'tablename') != 0 &&
                strcasecmp($key,'fields') !=0 &&
                strcasecmp($key,'executor') != 0 &&
                strcasecmp($key,'hidden') != 0 &&
                strcasecmp($key,'tableid') != 0
            ){
                if( ! in_array($key, $this->hidden)){
                    $fields[$key] = $value;
                }
            }
        }
        return $fields;
    }

    protected function updateValues(){
        $fields = array();
        foreach($this->fields as $field => $value){
            $current = $this->{$field};
            if( gettype($current) == 'string'){
                $current = "'" . $this->executor->scapeString($current) . "'";
            }
            $fields[$field] = $current;
        }
        unset($this->fields);
        $this->fields = $fields;
    }

    private function getFormattedValues(){
        $formattedValues = "";
        $keys = array_keys($this->fields);
        $fieldsNum = count($keys);
        for($i=0; $i<$fieldsNum; $i++){
            $current = $this->fields[$keys[$i]];
            $formattedValues .= $current;
            if( $i != $fieldsNum - 1 ){
                $formattedValues.=",";
            }
        }
        return $formattedValues;
    }

    private function getFormattedFields($array){
        $formattedFields = "";
        $keys = $array;
        $fieldsNum = count($keys);
        for( $i=0; $i<$fieldsNum; $i++ ){
            $formattedFields.=$keys[$i];
            if( $i != $fieldsNum - 1 ){
                $formattedFields.=",";
            }
        }
        return $formattedFields;
    }

    public function save(){
        $this->updateValues();
        $saveQuery = "INSERT INTO " . $this->tableName . "(".$this->getFormattedFields(array_keys($this->fields)).") VALUES(". $this->getFormattedValues() . ")";
        try{
            $result = $this->executor->executeQuery($saveQuery);
            if( ! $result){
                throw new SystemException(DUPLICATE_ENTRY, "Ya existe un item con ese ID");
            }
        }catch(Exception $e){
            throw new SystemException(SQL_ERROR, $e->getMessage());
        }
    }


    public function update(){
        $this->updateValues();
        $updateQuery = "UPDATE " . $this->tableName . " SET " . $this->getFormatedSetPairs() . " WHERE " . $this->getUniqueCondition();
        try{
            $this->executor->executeQuery( $updateQuery );
        }catch(Exception $e){
            throw new SystemException(SQL_ERROR, $e->getMessage());
        }
    }

    public function delete(){
        $deleteQuery = " DELETE FROM " . $this->tableName . " WHERE " . $this->getUniqueCondition();
        try{
            $this->executor->executeQuery( $deleteQuery );
        }catch(Exception $e){
            throw new SystemException(SQL_ERROR, $e->getMessage());
        }
    }

    public function all($startPage = 0, $limit = 100){
        $allFields = $this->getAllFields();
        $selectQuery = "SELECT * FROM " . $this->tableName . " LIMIT " . $startPage . "," . $limit;
        try{
            $resultSet = $this->executor->executeQuery( $selectQuery );
            $entities = array();
            while($row = $resultSet->fetch_assoc()){
                $entity = array();
                foreach($allFields as $field){
                    $entity[$field] = $row[$field];
                }
                $entities[] = $entity;
            }
            return $entities;
        }catch(Exception $e){
            throw new SystemException(SQL_ERROR, $e->getMessage());
        }
    }

    public function getById(){
        $allFields = $this->getAllFields();
        $selectQuery = "SELECT * FROM " . $this->tableName . " WHERE " . $this->getUniqueCondition();
        try{
            $resultSet = $this->executor->executeQuery( $selectQuery );
        }catch(Exception $e){
            throw new SystemException(SQL_ERROR, $e->getMessage());
        }
        if($resultSet && $resultSet->num_rows > 0){
            $entity = array();
            $row = $resultSet->fetch_assoc();
            foreach($allFields as $field){
                $entity[$field] = $row[$field];
            }
            return $entity;
        }else{
            throw new SystemException(NOT_FOUND, 'No se ha encontrado ninguna coincidencia');
        }
    }

    private function getFormatedSetPairs()
    {
        $formattedSetPairs = "";
        $keys = array_keys($this->fields);
        $numKeys = count($keys);
        for($i = 0; $i<$numKeys; $i++){
            $formattedSetPairs .= $keys[$i] . "=" . $this->fields[$keys[$i]];
            if( $i != $numKeys - 1 ){
                $formattedSetPairs.=",";
            }
        }
        return $formattedSetPairs;
    }

    private function getUniqueCondition(){
        if( count($this->tableID) == 1 ){
            $fieldName = $this->tableID[0];
            $fieldValue = $this->{$fieldName};
            if( gettype($fieldValue) == 'string' ){
                $fieldValue = "'" . $fieldValue . "'";
            }
            return $fieldName . "=" . $fieldValue;
        }else{
            $condition = "";
            $numFields = count($this->tableID);
            for($i=0; $i<$numFields ;$i++ ){
                $fieldName = $this->tableID[$i];
                $fieldValue = ${$fieldName};
                if( gettype($fieldValue) == 'string' ){
                    $fieldValue = "'" . $fieldValue . "'";
                }
                $condition .= $fieldName . "=" . $fieldValue;
                if( $i != $numFields - 1 ){
                    $condition.=" AND ";
                }
            }
            return $condition;
        }
    }

    private function getAllFields(){
        $fields = array();
        foreach($this->fields as $fieldName => $fieldValue){
            $fields[] = $fieldName;
        }

        foreach($this->tableID as $idField){
            if( !in_array($idField, $fields)){
                $fields[] = $idField;
            }
        }
        return $fields;
    }
}
define('PROJECT_FOLDER_NAME', 'geekstore');
class Product extends Model{

    protected $id;
    protected $name;
    protected $description;
    protected $price;
    protected $image;
    protected $quantity;
    protected $hidden = ['id'];

    public function save()
    {
        parent::save();
        $this->id = $this->executor->getLastAutoincrementId();
    }
    
    public function all($startPage = 0, $limit = 100){
        $products = parent::all($startPage, $limit);
        $transformedProducts = array();
        foreach( $products as $product){
            $relativePath = $product['image'];
            $product['image'] = 'http://' .  $_SERVER['SERVER_NAME'] . "/" ;
            if( strcmp( $_SERVER['SERVER_NAME'], 'localhost') == 0){
                $product['image'] .= PROJECT_FOLDER_NAME . "/";
            }
            $product['image'] .= $relativePath;

            $transformedProducts[] = $product;
        }
        return $transformedProducts;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }


}

define('TYPE_ADMIN', "admin");
define('TYPE_USER', "user");
class User extends Model{
    protected $username;
    protected $email;
    protected $password;
    protected $type;
    protected $phone;
    protected $tableID = ['username'];

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

}

