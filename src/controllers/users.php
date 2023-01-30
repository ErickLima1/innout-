<?php
session_start();
RequireValidSession(true);

//Deletando o Usuario(apenas usuario que não tem registro de ponto);
$exception = null;
if(isset($_GET['delete'])) {
    try {
        User::deleteById($_GET['delete']);
            addSucessMsg('Usuario Excluido com Sucesso');
    }catch(Exception $e) {
        if(stripos($e->getMessage(), 'FOREIGN KEY')) {
            addErrorMsg('Não foi Possivel excluir o usuario com registro de ponto!!!');
        }else{
            $exception = $e;

        }
    }
}

$users = User::get();
foreach($users as $user) {//Formatando data para formato Brasileiro.
    $user->start_date = (new DateTime($user->start_date))->format('d/m/Y'); 
    if($user->end_date) {
        $user->end_date = (new DateTime($user->end_date))->format('d/m/Y');
    }
}

loadTemplateView('users', [
    'users' => $users, 
    'exception' => $exception
]);