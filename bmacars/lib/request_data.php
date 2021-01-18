<?php

function get_data($request) {
    try {
        $dbh = new PDO('mysql:dbname=bmacars;host=localhost', 'root', '');
        $sth = $dbh->prepare($request);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
        return "Error";
    }
}