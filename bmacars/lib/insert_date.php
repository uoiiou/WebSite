<?php

function insert_date($info_name, $date, &$contacts, $title_name, $time_1, $time_2)
{
    $contacts = str_replace($info_name, $date, $contacts);
    $contacts = str_replace("{title_name}", $title_name, $contacts);
    $contacts = str_replace("{work_time_mf}", $time_1, $contacts);
    $contacts = str_replace("{work_time_sa}", $time_2, $contacts);
}