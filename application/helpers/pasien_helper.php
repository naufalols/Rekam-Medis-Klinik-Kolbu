<?php
// periksa_helper.php

if (!function_exists('get_riwayat')) {
    function get_riwayat($db)
    {
        $db->from('rekam_medis');
        return $db->count_all_results();
    }
}

function count_age($age)
{
    $dateString = $age;
    $now = new DateTime();  // Current date and time
    $date = new DateTime($dateString);  // The given date

    $interval = $now->diff($date);  // Calculate the difference between the dates
    $years = $interval->y;  // Get the number of years

    return $years;
}

function check_pasien_status($dateString)
{
    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    // Get the month and year of the input timestamp
    $inputMonth = date('m', $dateString);
    $inputYear = date('Y', $dateString);

    // Compare the current month and year with the input date's month and year
    if ($currentMonth == $inputMonth && $currentYear == $inputYear) {
        return 'Baru';
    } else {
        return 'Lama';
    }
}
