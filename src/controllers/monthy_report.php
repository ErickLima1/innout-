<?php
session_start();
RequireValidSession();

$currentDate = new DateTime();

$user = $_SESSION['user'];
$selectUserId = $user->id;
$users = null; // Quem pode ver o filtro de relatorio e apenas o admin/
if($user->is_admin) {
    $users = User::get();
    $selectUserId = isset($_POST['user']) && $_POST['user'] ? $_POST['user'] : $user->id;
}

//Pegando informação do Usuario de um relatio mensal de um determinado mes
$selectedPeriod = isset($_POST['period']) && $_POST['period'] ? $_POST['period'] : $currentDate->format('Y-m');
$periods = [];

for($yearDiff = 0; $yearDiff <= 5; $yearDiff++) {
    $year = date('Y') - $yearDiff; //Vai pegar 2022 - 2 anos = 2020;
    for($month = 12; $month >= 1; $month--) {
        $date = new DateTime("{$year}-{$month}-1");
        $periods[$date->format('Y-m')] = strftime('%B de %Y', $date->getTimestamp()); 
    }
}

$registries = WorkingHours::getMonthlyReport($selectUserId, $selectedPeriod);

$report = [];
$workDay = 0;
$sumOfWorkedTime = 0;
$lastDay = getLastDayOfMonth($currentDate)->format('d');

for($day = 1; $day <= $lastDay; $day++) {
    //$date = $currentDate->format('Y-m') . '.' . sprintf('%02d', $day); //Estava dando erro maldito 
    $date = $selectedPeriod . '-' . sprintf('%02d', $day); //Solução que encontrtrei
    $registry = isset($registries[$date]) && $registries[$date]? $registries[$date]: null;
    
    if(isPastWorkday($date)) $workDay++;

    if($registry) {
        $sumOfWorkedTime += $registry->worked_time;
        array_push($report, $registry);
    }else{
        array_push($report, new WorkingHours([
            'worked_time' => 0,
            'work_date' => $date
        ]));
    }
}

$expectedTime = $workDay * DAILY_TIME;
$balance = getTimeStringFromSeconds(abs($sumOfWorkedTime -  $expectedTime));
$sign = ($sumOfWorkedTime >= $expectedTime) ? '+' : '-';

loadTemplateView('monthy_report', [
    'report' => $report,
    'sumOfWorkedTime' => getTimeStringFromSeconds($sumOfWorkedTime),
    'balance' => "{$sign}{$balance}",
    'selectedPeriod' => $selectedPeriod,
    'periods' => $periods,
    'selectUserId' => $selectUserId,
    'users' => $users,
]);
