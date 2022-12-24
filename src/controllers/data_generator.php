<?php

loadModel('WorkingHours');

Database::executeSQL('DELETE FROM working_hours');
//Database::executeSQL('DELETE FROM users WHERE id > 5');
function getTemplateByOdds($regularRate, $extraRate, $lazyRate) {
    $regularTemplate = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00',
        'worked_time' => DAILY_TIME
    ];
    
    $extraHourDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00',
        'worked_time' => DAILY_TIME + 3600
    ];
    
    $lazyDayTemplate = [
        'time1' => '08:30:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00',
        'worked_time' => DAILY_TIME - 1800
    ];

    $value = rand(0, 100);
    if($value <= $regularRate) {
        return $regularTemplate;
    }else if($value <= $regularRate + $extraRate) {
        return $extraHourDayTemplate;
    }else{
        return $lazyDayTemplate;
    }
}

function populationWorkingHours($userId, $initialDate, $regularRate, $extraRate, $lazyRate) {
    $currentDate = $initialDate;
    $today = new DateTime();
    $columns = ['user_id' => $userId, 'work_date' => $currentDate];

    while(isBefore($currentDate, $today)) {
        if(!isWeekend($currentDate)) {
            $template = getTemplateByOdds($regularRate, $extraRate, $lazyRate);
            $columns = array_merge($columns, $template);
            $workingHours = new WorkingHours($columns);
            $workingHours->save();
        }
        $currentDate = getNextDay($currentDate)->format('Y-m-d');
        $columns['work_date'] = $currentDate;
    }
}
$lastMonth = strtotime('first day of last month');
populationWorkingHours(1, date('Y-m-1'), 70, 20, 10);
populationWorkingHours(3, date('Y-m-d', $lastMonth), 20, 75, 5);
populationWorkingHours(4, date('Y-m-d', $lastMonth), 20, 10, 70);

echo 'Tudo certo';