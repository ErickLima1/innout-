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
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0; //Se tiver setado inteiro 1 caso contrario vai ser 0
        if(!$this->end_date)  $this->end_date = null;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::insert();
    }

    private function validate() {
        $erros = [];

        if(!$this->name) {
            $erros['name'] = 'Nome é um campo obrigatorio';
        }
        
        if(!$this->email) {
            $erros['email'] = 'Email é um campo obrigatorio';
            
        }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $erros['email'] = 'Email Invalido';

        }

        if(!$this->start_date) {
            $erros['start_date'] = 'Data de Admissão é um campo obrigatorio';
        }elseif(!DateTime::createFromFormat('Y-m-d', $this->start_date)){
            $erros['start_date'] = 'Data de Admissão deve seguir padrão dd/mm/aaaa.';
        }
        
        if($this->end_date && !DateTime::createFromFormat('Y-m-d', $this->end_date)) {
            $erros['end_date'] = 'Data de Desligamento deve seguir padrão dd/mm/aaaa.';
        }

        if(!$this->password) {
            $erros['password'] = 'Senha é um campo obrigatorio';
        }

        if(!$this->confirm_password) {
            $erros['confirm_password'] = 'Confirmação de Senha é um campo obrigatorio';
        }

        if($this->password && $this->confirm_password && $this->password !== $this->confirm_password) {
            $erros['password'] = 'As senhas não são iguais.';
            $erros['confirm_password'] = 'As senhas não são iguais.';          
        }
        
        if(count($erros) > 0 ) {
            throw new ValidationExecption($erros);
        }
    }
}