<?php
session_start();
RequireValidSession();


//Tratando erro caso na hora de inserir de error
$exeception = null;

if(count($_POST) > 0) {
    try {
        $newUser = new User($_POST);
        $newUser->insert();
        addSucessMsg('Usuario Cadastrado Com Sucesso');
        $_POST = [];
        
    }catch(Exception $e) {
        $exeception = $e;
    }
}

loadTemplateView('save_user', ['exeception'  => $exeception]);