<?php

use losthost\Orthodox\Calendar;

require_once 'vendor/autoload.php';

$first_day = new DateTimeImmutable('2025-01-01');
$one_day = date_interval_create_from_date_string('1 day');
$calendar = new Calendar();
$day = $first_day;

foreach (range(1,200) as $value) {
    
    echo "\n". $calendar->getDayAsText($day). "\n";
    $day = $day->add($one_day);
    
}