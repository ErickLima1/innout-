<?php

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
