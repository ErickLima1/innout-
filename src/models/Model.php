<?php

class Model {   
    protected static $tableName = '';
    protected static $columns = [];
    protected $values = [];

    function __construct($arr) {
        $this->loadFromArray($arr);
    }

    public function loadFromArray($arr) {
        if($arr) {
            foreach($arr as $key => $value) {
                $this-> $key = $value;
            }
        }
    }
    public function __get($key) {
        return $this->values[$key] ?? null;

    }

    public function __set($key, $value) {
        $this->values[$key] = $value;
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

    public function update() {
        $sql = "UPDATE " . static::$tableName . " SET ";
        foreach(static::$columns as $col) {
            $sql .= " ${col} =" . static::getFormatedValue($this->$col) . ",";
        }
        $sql[strlen($sql) - 1] = ' ';
        $sql .= "WHERE id ={$this->id}";
        Database::executeSQL($sql);
    }

    public static function getCount($filters = []) { //Pegando->COntador ou usuario
        $result = static::getResultSetFromSelect($filters, 
            'count(*) as count');
        return $result->fetch_assoc()['count'];
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