<?php

function RequireValidSession($requeresAdmin = false) {
    $user = $_SESSION['user'];
    if(!isset($user)) {
        header('Location: login.php');
        exit();
    }elseif($requeresAdmin && !$user->is_admin) {
        addErrorMsg('Acesso Negado!');
        header('Location: day_records.php');
        exit();

    }
}