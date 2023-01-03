<?php
session_start();
RequireValidSession();

$user = $_SESSION['user'];
$registries = WorkingHours::getMonthlyReport($user->id, new DateTime());

loadTemplateView('monthy_report', [
    'registries' => $registries
]);
