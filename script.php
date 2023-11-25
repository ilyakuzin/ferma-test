<?php

function getPromoDates($sendYear)
{
    $startYear = 2000;
    $endYear = date("Ymd", $sendYear);
    $promoDates = [];
    $chairsPromoDaysCtr = 0;
    $tablesPromoDaysCtr = 0;
    $flag = true; //flag == true - акция на стулья по четным числам месяца

    for ($year = $startYear; $year <= $sendYear; $year++) {
        for ($month = 0; $month < 12; $month++) {
            $daysInMonth = days_in_month($month, $year);

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dateNum = date("w", mktime(0, 0, 0, date($month), date($day), date($year)));
                if ($dateNum == 5) {
                    if ($day % 2 == 0) {
                        if ($flag) {
                            $chairsPromoDaysCtr++;
                        }
                        if ($flag == false) {
                            $tablesPromoDaysCtr++;
                            $promoDates[] = formattedDate($day, $month, $year);
                        }
                    } else {
                        if ($flag) {
                            $tablesPromoDaysCtr++;
                            $promoDates[] = formattedDate($day, $month, $year);
                        }
                        if ($flag == false) {
                            $chairsPromoDaysCtr++;
                        }
                    }
                }
            }
        }
        if ($chairsPromoDaysCtr > $tablesPromoDaysCtr) $flag = !$flag;
        if ($tablesPromoDaysCtr > $chairsPromoDaysCtr) $flag = !$flag;
    }

    printDates($promoDates);
}

function days_in_month($month, $year)
{
    // calculate number of days in a month
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

function formattedDate($day, $month, $year)
{
    $dayFormatted = date('jS', mktime(0, 0, 0, $month, $day, $year));

    $monthName = date('M.', mktime(0, 0, 0, $month, $day, $year));

    return "$dayFormatted $monthName $year";
}

function printDates($dates)
{
    foreach ($dates as $date) {
        echo $date;
        echo "\n";
    }
}

getPromoDates(2002);