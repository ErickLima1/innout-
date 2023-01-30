<?php
session_start();
RequireValidSession(true);


//Tratando erro caso na hora de inserir de error
$exception  = null;
$userDate = [];

if(count($_POST) === 0 && isset($_GET['update'])) {
    $user = User::getOne(['id' => $_GET['update']]);
    $userDate = $user->getValues();
    $userDate['password'] = null;
}elseif(count($_POST) > 0) {
    try {
        $dbUser = new User($_POST);
        if($dbUser->id) {
            $dbUser->update();
            addSucessMsg('Usuario Atualizado Com Sucesso');
            header('Location: users.php');
            exit();
        }else{
            $dbUser->insert();
            addSucessMsg('Usuario Cadastrado Com Sucesso');
        }
        $_POST = [];
        
    } catch(Exception $e) {
        $newEmail = new User($_POST);
        if($newEmail->email) { //Caso o Email Já Esteja sendo utilizado
            addErrorMsg('Esse Email Já Esta Sendo Utilizado!');
            header('Location: users.php');
            exit();
        }else{
            $exception = $e;

        }

    }finally {
        $userDate = $_POST;
    }
}

loadTemplateView('save_user', $userDate + ['exception' => $exception]);


// }else{
//     try {
//         $dbUser = new User($_POST);
//         if(!$dbUser->email) {
//             addErrorMsg('Esse Email Já Foi Cadastrado');
//         }else{
//             $dbUser->insert();
//             addSucessMsg('Usuario Cadastrado Com Sucesso');

//         }
//     }catch(Exception $b)  {
//         $exception = $b;
//     }
// }