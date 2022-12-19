<?php

function RequireValidSession() {
    $user = $_SESSION['user'];
    if(!isset($user)) {
        header('Location: login.php');
        exit();
    }
}