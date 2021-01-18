<?php

include "lib\\hbi.php";
include "lib\\iuf_ins.php";
include "lib\\user_connection.php";

function add_car($result, &$cars)
{
    $result = str_replace("{image_name}", $cars['image_name'], $result);
    $result = str_replace("{alt_name}", $cars['alt_name'], $result);
    $result = str_replace("{mark}", $cars['mark'], $result);
    $result = str_replace("{price}", $cars['price'], $result);
    $result = str_replace("{year}", $cars['year'], $result);
    $result = str_replace("{engine}", $cars['engine'], $result);
    $result = str_replace("{fuel}", $cars['fuel'], $result);
    $result = str_replace("{body_type}", $cars['body'], $result);
    $result = str_replace("{transmission}", $cars['transmission'], $result);
    return $result;
}

function without_cars(&$all_cars, $car, $cars) {
    for ($i = 0; $i < count($cars); $i++)
        $all_cars .= add_car($car, $cars[$i]);
}

function with_cars(&$all_cars, $car, $cars, $key, $value) {
    for ($i = 0; $i < count($cars); $i++)
        if ($cars[$i][$key] == $value)
            $all_cars .= add_car($car, $cars[$i]);
}

function find_cars($car, &$all_cars) {
    $cars = get_data("SELECT * FROM `cars` ORDER BY `id`");

    if ($cars != "Error") {
        if ((count($_POST) == 0) || (isset($_POST['login']) && isset($_POST['password']))) {
            without_cars($all_cars, $car, $cars);
        } else {
            $key = array_keys($_POST)[0];
            $value = $_POST[$key];

            ($key == "reset") ? without_cars($all_cars, $car, $cars) : with_cars($all_cars, $car, $cars, $key, $value);
        }
    }
}

function standardization(&$inventory) {
    $inventory = file_get_contents("template.html");
    $inventory = str_replace("{css_style}", "inventory_style", $inventory);
    $inventory = str_replace("{inv_insert}", " selected", $inventory);
    $inventory = str_replace("{abo_insert}", "", $inventory);
    $inventory = str_replace("{con_insert}", "", $inventory);
    $inventory = str_replace("{handler}", "inventory", $inventory);
    iuf_ins($inventory);

    $middle = file_get_contents("inventory\inventory_middle.html");
    $inventory = str_replace("{middle_insert}", $middle, $inventory);

    $car = file_get_contents("inventory\car\car.html");
    $all_cars = "";

    find_cars($car, $all_cars);
    $inventory = str_replace("{car_insert}", $all_cars, $inventory);
}

standardization($inventory);
hbi($inventory);
connection();

echo $inventory;