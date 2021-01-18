<?php

include "lib\\insert_date.php";
include "lib\\hbi.php";
include "lib\\user_connection.php";

function insert_main_parts($src, $dest, &$home)
{
    $temp = file_get_contents($src);
    $home = str_replace($dest, $temp, $home);
}

function insert_upper_image($car_image, $upper_image, &$home, $car, $image_name, $alt_name)
{
    $home = str_replace("{image_".$car_image."}", $upper_image, $home);
    $home = str_replace("{typecar}", $car, $home);
    $home = str_replace("{image_name}", $image_name, $home);
    $home = str_replace("{alt_name}", $alt_name, $home);
}

function standardization(&$home) {
    $home = file_get_contents("template.html");
    $home = str_replace("{css_style}", "home_style", $home);
    $home = str_replace("{inv_insert}", "", $home);
    $home = str_replace("{abo_insert}", "", $home);
    $home = str_replace("{con_insert}", "", $home);
    $home = str_replace("{handler}", "home", $home);

    insert_main_parts("home\home_intro.html", "{intro_insert}", $home);
    insert_main_parts("home\home_upper.html", "{upper_insert}", $home);

    $upper_image = file_get_contents("home\upper_image\image.html");

    insert_upper_image("sedan", $upper_image, $home, "Sedan", "bmw_sedan.jpg", "bmw_sedan");
    insert_upper_image("wagon", $upper_image, $home, "Wagon", "audi_wagon.jpg", "audi_wagon");
    insert_upper_image("luxury", $upper_image, $home, "Luxury", "mercedes_luxury.jpg", "mercedes_luxury");
    insert_upper_image("suv", $upper_image, $home, "SUV", "bmw_suv.jpg", "bmw_suv");

    insert_main_parts("home\home_middle.html", "{middle_insert}", $home);
    insert_main_parts("home\home_footer.html", "{footer_insert}", $home);

    $date = file_get_contents("home_contacts_date\date.html");
    insert_date("{service_info}", $date, $home, "Service hours", "09:00AM – 06:00PM", "10:00AM – 02:00PM");
    insert_date("{sales_info}", $date, $home, "Sales hours", "09:20AM – 09:30AM", "10:20AM – 10:25AM");
}

standardization($home);
hbi($home);
connection();

echo $home;