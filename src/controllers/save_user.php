<?php
session_start();
RequireValidSession();


//Tratando erro caso na hora de inserir de error
$exception  = null;

if(count($_POST) > 0) {
    try {
        $newUser = new User($_POST);
        $newUser->insert();
        addSucessMsg('Usuario Cadastrado Com Sucesso');
        $_POST = [];
        
    } catch(Exception $e) {
        $exception = $e;
    }
}

loadTemplateView('save_user', $_POST + ['exception' => $exception]);