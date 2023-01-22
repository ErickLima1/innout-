<?php

class User extends model {
    protected static $tableName = 'users';
    protected static $columns = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin', 
    ];

    //Quantidade de Usuarios Ativo.
    public static function getActiveUsersCount() {
        return static::getCount(['raw' => 'end_date IS NULL']);
    }

    //Meotod para inserir usuario;
    public function insert() {
        $this->is_admin = $this->is_admin ? 1 : 0; //Se tiver setado inteiro 1 caso contrario vai ser 0
        if(!$this->end_date)  $this->end_date = null;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::insert();
    }
}