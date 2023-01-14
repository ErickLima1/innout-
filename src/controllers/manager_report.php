<?php
session_start();
RequireValidSession();

//Tudo isso vai para Interface Grafica do Monthy_Report viesw
$activeUsersCount = User::getActiveUsersCount();
$absentUsers = WorkingHours::getAbsentUsers();

$yearAndMonth = (new DateTime())->format('Y-m');
$seconds = WorkingHours::getWorkedTimeInMoth($yearAndMonth);
//Funcionalidade do Explode: ele define uma caractere ele transforma uma String em um Array
$hoursInMonth = explode(':', getTimeStringFromSeconds($seconds))[0]; 

loadTemplateView('manager_report', [
    'activeUsersCount' => $activeUsersCount,
    'absentUsers' => $absentUsers,
    'hoursInMonth' => $hoursInMonth,
]);
