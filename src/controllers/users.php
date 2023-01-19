<?php
session_start();
RequireValidSession();

$users = User::get();
foreach($users as $user) {//Formatando data para formato Brasileiro.
    $user->start_date = (new DateTime($user->start_date))->format('d/m/Y'); 
    if($user->end_date) {
        $user->end_date = (new DateTime($user->end_date))->format('d/m/Y');
    }
}

loadTemplateView('users', ['users' => $users]);