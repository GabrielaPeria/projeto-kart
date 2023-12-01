<?php


function timeToMilliseconds($time){
    $dateTime = new DateTime($time);

    $seconds = 0;
    $seconds += $dateTime->format('H') * 3600;
    $seconds += $dateTime->format('i') * 60;
    $seconds += $dateTime->format('s');

    $seconds = floatval($seconds . '.' . $dateTime->format('u'));

    return $seconds * 1000;
}

function formatMilliseconds($milliseconds) {
    $seconds = floor($milliseconds / 1000);
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $milliseconds = $milliseconds % 1000;
    $seconds = $seconds % 60;
    $minutes = $minutes % 60;

    $format = '%u:%02u:%02u.%03u';
    $time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
    return rtrim($time, '0');
}