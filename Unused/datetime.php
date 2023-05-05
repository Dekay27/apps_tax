<?php

function getCurrentMonth($current_month): string
{
    return date("F", strtotime($current_month . "01"));
}

$current_date = date("Y-m-d");
$current_month = date("m");
$currentDateTime = date('Y-m-d H:i:s');

echo $current_date;
echo "<br>";
echo "<br>";

echo $current_month;
echo "<br>";
echo "<br>";

echo $currentDateTime;
echo "<br>";
echo "<br>";


$currentDateTime = new DateTime();
$currentDateTimeString = $currentDateTime->format('Y-m-d H:i:s');

//echo $currentDateTime;
echo $currentDateTimeString;
echo "<br>";
echo "<br>";

$current_month = date("m");
$current_month_name = getCurrentMonth($current_month);
echo $current_month_name;
echo "<br>";
echo "<br>";
