<?php

function iuf_ins(&$result) {
    $result = str_replace("{intro_insert}", "", $result);
    $result = str_replace("{upper_insert}", "", $result);
    $result = str_replace("{footer_insert}", "", $result);
}