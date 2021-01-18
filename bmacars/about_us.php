<?php

include "lib\\hbi.php";
include "lib\\iuf_ins.php";
include "lib\\user_connection.php";

function insert_middle_title($dest, &$src, &$about_us, $image_name, $alt_name, $width, $height, $title_name, $info_name)
{
    $about_us = str_replace($dest, $src, $about_us);
    $about_us = str_replace("{image_name}", $image_name, $about_us);
    $about_us = str_replace("{alt_name}", $alt_name, $about_us);
    $about_us = str_replace("{width}", $width, $about_us);
    $about_us = str_replace("{height}", $height, $about_us);
    $about_us = str_replace("{title_name}", $title_name, $about_us);
    $info = file_get_contents("about_us\middle_img_info\\".$info_name);
    $about_us = str_replace("{info}", $info, $about_us);
}

function standardization(&$about_us) {
    $about_us = file_get_contents("template.html");
    $about_us = str_replace("{css_style}", "aboutus_style", $about_us);
    $about_us = str_replace("{inv_insert}", "", $about_us);
    $about_us = str_replace("{abo_insert}", " selected", $about_us);
    $about_us = str_replace("{con_insert}", "", $about_us);
    $about_us = str_replace("{handler}", "about_us", $about_us);
    iuf_ins($about_us);

    $middle = file_get_contents("about_us\about_us_middle.html");
    $about_us = str_replace("{middle_insert}", $middle, $about_us);

    $leftside = file_get_contents("about_us\middle_img_info\leftside.html");
    $title_name = file_get_contents("about_us\middle_img_info\company\\title.html");

    insert_middle_title("{leftside_company}", $leftside, $about_us, "12-mercedes-benz-ag-company-2560x1440.jpeg",
        "about_company", "550", "370", $title_name, "company\info.html");

    insert_middle_title("{leftside_mercedes}", $leftside, $about_us, "mercedes_8.jpg",
        "mercedes", "580", "320", "MERCEDES", "mercedes\info.html");

    $rightside = file_get_contents("about_us\middle_img_info\\rightside.html");
    insert_middle_title("{rightside_bmw}", $rightside, $about_us, "p1758683-1528369159.jpg",
        "bmw", "550", "370", "BMW", "bmw\info.html");

    insert_middle_title("{rightside_audi}", $rightside, $about_us, "audi_3.jpg",
        "audi", "550", "370", "AUDI", "audi\info.html");
}

standardization($about_us);
hbi($about_us);
connection();

echo $about_us;