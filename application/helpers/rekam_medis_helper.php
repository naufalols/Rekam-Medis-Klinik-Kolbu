<?php
// periksa_helper.php

if (!function_exists('count_rekam_medis')) {
    function count_rekam_medis($db)
    {
        $db->from('rekam_medis');
        return $db->count_all_results();
    }
}

function count_records_this_month($db)
{
    $currentMonth = date('m');
    $currentYear = date('Y');

    $db->where("MONTH(FROM_UNIXTIME(tanggal_buat)) =", $currentMonth);
    $db->where("YEAR(FROM_UNIXTIME(tanggal_buat)) =", $currentYear);
    $db->from('rekam_medis');
    return $db->count_all_results();
}

function count_records_month($db, $month = null)
{
    $currentMonth = date('m') - $month;
    $currentYear = date('Y');

    $db->where("MONTH(FROM_UNIXTIME(tanggal_buat)) =", $currentMonth);
    $db->where("YEAR(FROM_UNIXTIME(tanggal_buat)) =", $currentYear);
    $db->from('rekam_medis');
    return $db->count_all_results();
}

function get_records_this_month($db)
{
    $currentMonth = date('m');
    $currentYear = date('Y');

    $db->where("MONTH(FROM_UNIXTIME(tanggal_buat)) =", $currentMonth);
    $db->where("YEAR(FROM_UNIXTIME(tanggal_buat)) =", $currentYear);
    $query = $db->get('rekam_medis');
    return $query->result();
}
