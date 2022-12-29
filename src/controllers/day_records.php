<?php
session_start();
RequireValidSession();

loadModel('WorkingHours');

$date = (new DateTime())->getTimestamp();
$today = strftime('%d de %B de %Y', $date);

loadTemplateView('day_records', [
    'today'=> $today, 
]);