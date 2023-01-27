<?php

class Model {   
    protected static $tableName = '';
    protected static $columns = [];
    protected $values = [];

    //$sanitize metodo para evitar sqlInject
    function __construct($arr, $sanitize = true) { 
        $this->loadFromArray($arr, $sanitize);
    }

    //$sanitize metodo para evitar sqlInject
    public function loadFromArray($arr, $sanitize = true) {
        if($arr) {
            $conn = Database::getConnection();
            foreach($arr as $key => $value) {
                $cleanValue = $value;
                if($sanitize && isset($cleanValue)) {
                    $cleanValue = strip_tags(trim($cleanValue));
                    $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
                    $cleanValue = mysqli_real_escape_string($conn, $cleanValue);
                    
                } 
                $this-> $key = $cleanValue;
            }
            $conn->close();
        }
    }
    public function __get($key) {
        return $this->values[$key] ?? null;

    }

    public function __set($key, $value) {
        $this->values[$key] = $value;
    }

    public function getValues() {
        return $this->values;
    }
    //getResultSetFromSelect
    public static function getOne($filters = [], $columns = '*') {
        $class = get_called_class();
        $result = static::getResultSetFromSelect($filters, $columns);
        
        return $result ? new $class($result->fetch_assoc()) : null;
    }//

    //get_called_class()-> Esse metodo vai dizer extamente qual foi a classe que chamou essa função Get
    public static function get($filters = [], $column = '*') { //Obtendo Usuários do banco
        $objects = [];
        $result = static::getResultSetFromSelect($filters, $column);
        if($result) {
            $class = get_called_class(); 
            while($row = $result->fetch_assoc()) {
                array_push($objects, new $class($row, false));
            }
        }
        return $objects;
    }

    public static function getResultSetFromSelect($filters = [], $columns = '*') {
        $sql = "SELECT ${columns} FROM " . static::$tableName . static::getFilters($filters);    
        $result = Database::getResultFromQuery($sql);
        if($result->num_rows === 0 ) {
            return null;
        }else {
            return $result;
        }
    }

    public function insert() {//Metodo Que vai fazer a inserção do banco de dados
        $sql = "INSERT INTO " . static::$tableName . " ("
            . implode(",", static::$columns) . ") VALUES ("; //Implode transforma array em string;
        foreach(static::$columns as $col) {
            $sql .= static::getFormatedValue($this->$col) . ",";
        }
        $sql[strlen($sql) - 1] = ')';
        $id = Database::executeSQL($sql);
        $this->id = $id;
    }

    public function update() { //Metodo atualizando usuario;
        $sql = "UPDATE " . static::$tableName . " SET ";
        foreach(static::$columns as $col) {
            $sql .= " ${col} =" . static::getFormatedValue($this->$col) . ",";
        }
        $sql[strlen($sql) - 1] = ' ';
        $sql .= "WHERE id ={$this->id}";
        Database::executeSQL($sql);
    }

    public static function getCount($filters = []) { //Pegando->Contador ou usuario
        $result = static::getResultSetFromSelect($filters, 
            'count(*) as count');
        return $result->fetch_assoc()['count'];
    }

    public function delete() {
        static::deleteById($this->id);
    }
    public static function deleteById($id) {
        $sql = "DELETE FROM " . static::$tableName . " WHERE id = {$id}";
        Database::executeSQL($sql);
    }

    private static function getFilters($filters) {
        $sql = '';
        if(count($filters) > 0 ) {
            $sql .= " WHERE 1 = 1"; 
            foreach($filters as $column => $value) {
                if($column == 'raw') {
                    $sql .= " AND {$value}";
                }else{
                    $sql .= " AND ${column} = " . static::getFormatedValue($value);
                }
            }
        }
        return $sql;
    }
    
    private static function getFormatedValue($value) {
        if(is_null($value)) {
            return "null";
        }elseif(gettype($value) === 'string') {
            return "'${value}'";
        }else {
            return $value;
        }
    }
}