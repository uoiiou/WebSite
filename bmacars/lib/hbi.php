<?php

function hbi(&$file_name)
{
    for ($i = 1; $i <= 6; $i++) {
        $nstr = (string) $i;
        preg_match_all("#<h$nstr.*?>(.*?)</h$nstr>#is", $file_name, $arr_inside);
        preg_match_all("#<h$nstr(.*?)>.*?</h$nstr>#is", $file_name, $arr_atrib);

        for ($j = 0; $j < count($arr_inside[1]); $j++) {
            $str = "<h$nstr" . $arr_atrib[1][$j] . ">" . " <font color=\"blue\">" . $arr_inside[1][$j] . "</font> " . "</h$nstr>";
            $file_name = str_replace($arr_inside[0][$j], $str , $file_name);
        }
    }

    preg_match_all("#<i(?!f|m|n).*?>(.*?)</i>#is", $file_name, $arr_inside);
    preg_match_all("#<i(?!f|m|n)(.*?)>.*?</i>#is", $file_name, $arr_atrib);

    for ($j = 0; $j < count($arr_inside[1]); $j++) {
        $str = "<i" . $arr_atrib[1][$j] . ">" . " <font color=\"green\">" . $arr_inside[1][$j] . "</font> " . "</i>";
        $file_name = str_replace($arr_inside[0][$j], $str , $file_name);
    }

    preg_match_all("#<b(?!a|d|l|o|r|u).*?>(.*?)</b>#is", $file_name, $arr_inside);
    preg_match_all("#<b(?!a|d|l|o|r|u)(.*?)>.*?</b>#is", $file_name, $arr_atrib);

    for ($j = 0; $j < count($arr_inside[1]); $j++) {
        $str = "<b" . $arr_atrib[1][$j] . ">" . " <font color=\"red\">" . $arr_inside[1][$j] . "</font> " . "</b>";
        $file_name = str_replace($arr_inside[0][$j], $str , $file_name);
    }
}

/*for ($i = 1; $i <= 6; $i++) {
    $nstr = (string) $i;
    $file_name = preg_replace("#<h$nstr(.+?)>(.+?)</h$nstr>#is", "<h$nstr> <font color=\"blue\"> $2 </font> </h$nstr>", $file_name);
}
$file_name = preg_replace('#<i>(.+?)</i>#is', '<i> <font color="green"> $1 </font> </i>', $file_name);
$file_name = preg_replace('#<b>(.+?)</b>#is', '<b> <font color="red"> $1 </font> </b>', $file_name);
$file_name = preg_replace('#<h2>(.+?)</h2>#is', '<h2> <font color="blue"> $1 </font> </h2>', $file_name);*/