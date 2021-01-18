<?php

include "lib\\request_data.php";

function connection() {
    $users = 0;

    if (is_array($users = get_data("SELECT * FROM `users` ORDER BY `id`"))) {
        session_start();

        if (isset($_POST['login']) && isset($_POST['password'])) {
            $check = 0;
            $login = $_POST['login'];
            $password = $_POST['password'];

            for ($i = 0; $i < count($users); $i++) {
                if (($login == $users[$i]['login']) && (password_verify($password, $users[$i]['password']))) {
                    $_SESSION['Name'] = $login;
                    $check = 1;
                }
            }

            if ($check == 0) {
                header("HTTP/1.0 403 Not Found");
                exit;
            }
        }
    }
}