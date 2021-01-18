<?php

include "lib\\request_data.php";

function find_cars(&$cars, &$count, &$keys) {
    $cars = get_data("SELECT * FROM `cars` ORDER BY `id`");
    $count = count($cars);
    $keys = 0;
    if ($count > 0)
        $keys = array_keys($cars[0]);
}

function default_load(&$edit, &$cars, $count, &$keys) {
    $loadhtml = file_get_contents("admin\\count.html");
    $edit = str_replace("{edit_insert}", "", $edit);
    $edit = str_replace("{count_insert}", $loadhtml, $edit);
    $edit = str_replace("{numb_insert}", $count, $edit);

    $loadhtml = file_get_contents("admin\\table.html");
    $edit = str_replace("{table_insert}", $loadhtml, $edit);

    $str = '<tr>';
    for ($i = 0 ; $i < count($keys); $i++)
        $str .= '<td align="center" valign="top"><b>' . $keys[$i] . '</b></td>';
    $str .= '</tr>';

    for ($i = 0; $i < $count; $i++) {
        $str .= '<tr>';
        for ($j = 0; $j < count($keys); $j++)
            $str .= '<td align="center" valign="top"><b>' . $cars[$i][$keys[$j]] . '</b></td>';
        $id = $cars[$i]['id'];
        $str .= "<td align='center' valign='top'><b> <input type='submit' name='Delete$id' value='Delete'></b><br></td>";
        $str .= "<td align='center' valign='top'><b> <input type='submit' name='Edit$i' value='Edit'></b></td>";
        $str .= '</tr>';
    }

    $edit = str_replace("{items_insert}", $str, $edit);
    echo $edit;
}

function delete_car(&$post_keys) {
    $id = str_replace("Delete", "", $post_keys[0]);
    $dbh = new PDO('mysql:dbname=bmacars;host=localhost', 'root', '');
    $dbh->exec("DELETE FROM `cars` WHERE `id` = $id");
}

function ea_common(&$edit, $cycle, &$str, &$keys) {
    $edit = str_replace("{count_insert}", "", $edit);
    $edit = str_replace("{table_insert}", "", $edit);
    $loadhtml = file_get_contents("admin\\edit.html");
    $edit = str_replace("{edit_insert}", $loadhtml, $edit);

    for ($i = $cycle; $i < count($keys); $i++) {
        $value = $keys[$i];
        $str .= "<input class='edit_style' type='text' size='10' value='$value'>";
    }
    $str .= "<br/>";
}

function edit_load(&$edit, &$cars, &$keys, &$post_keys) {
    $numb = str_replace("Edit", "", $post_keys[0]);

    $str = "";
    ea_common($edit, 0, $str, $keys);

    for ($i = 0; $i < count($keys); $i++) {
        $value = $cars[$numb][$keys[$i]];
        $str .= "<input class='edit_style' type='text' size='10' value='$value' name='$i'>";
    }
    $id = $cars[$numb][$keys[0]];
    $str .= "<br/> <input class='nav__link add' type='submit' value='Edit' name='edit$id'>";

    $edit = str_replace("{fields_insert}", $str, $edit);
    echo $edit;
}

function edit_car() {
    $keys = array_keys($_POST);
    $old_id = str_replace("edit", "", $keys[count($keys) - 1]);
    $dbh = new PDO('mysql:dbname=bmacars;host=localhost', 'root', '');
    $sql = "UPDATE cars SET id=?, image_name=?, alt_name=? , mark=?, price=?, year=?, engine=?,
                                            fuel=? , body=?, transmission=? WHERE id=?";
    $sth= $dbh->prepare($sql);
    $sth->execute([$_POST[0], $_POST[1], $_POST[2], $_POST[3], $_POST[4], $_POST[5], $_POST[6], $_POST[7], $_POST[8],
        $_POST[9], $old_id]);
}

function add_load(&$edit, &$keys) {
    $str = "";
    ea_common($edit, 1, $str, $keys);

    for ($i = 1; $i < count($keys); $i++) {
        $str .= "<input class='edit_style' type='text' size='10' value='' name='$i'>";
    }
    $str .= "<br/> <input class='nav__link add' type='submit' value='Add' name='add'>";

    $edit = str_replace("{fields_insert}", $str, $edit);
    echo $edit;
}

function add_car() {
    $keys = array_keys($_POST);
    $dbh = new PDO('mysql:dbname=bmacars;host=localhost', 'root', '');
    $sql = "INSERT INTO cars (image_name, alt_name, mark, price, year, engine,
                                            fuel, body, transmission) VALUES (?,?,?,?,?,?,?,?,?)";
    $sth= $dbh->prepare($sql);
    $sth->execute(array($_POST[1], $_POST[2], $_POST[3], $_POST[4], $_POST[5], $_POST[6], $_POST[7], $_POST[8],
        $_POST[9]));
}


session_start();

if (isset($_SESSION['Name'])) {
    $edit = file_get_contents("admin\\admin.html");
    $cars = $count = $keys = 0;

    find_cars($cars, $count, $keys);

    if (count($_POST) == 0) {
        default_load($edit, $cars, $count, $keys);
    } else {
        $post_key = array_keys($_POST);

        if (count($_POST) == 1) {
            $is_delete = strripos($post_key[0], "Delete");
            $is_edit = strripos($post_key[0], "Edit");
            $is_add = strripos($post_key[0], "Add");

            if (!($is_delete === false)) {
                delete_car($post_key);
                find_cars($cars, $count, $keys);
                default_load($edit, $cars, $count, $keys);
            } else if (!($is_edit === false)) {
                edit_load($edit, $cars, $keys, $post_key);
            } else {
                add_load($edit, $keys);
            }
        } else if (count($_POST) == 11) {
            edit_car();
            find_cars($cars, $count, $keys);
            default_load($edit, $cars, $count, $keys);
        } else {
            add_car();
            find_cars($cars, $count, $keys);
            default_load($edit, $cars, $count, $keys);
        }
    }
} else {
    header("HTTP/1.0 403 Not Found");
    exit;
}