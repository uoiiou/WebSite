<?php

include "lib\\insert_date.php";
include "lib\\hbi.php";
include "lib\\iuf_ins.php";
include "lib\\user_connection.php";

function standardization(&$contacts) {
    $contacts = file_get_contents("template.html");
    $contacts = str_replace("{css_style}", "contacts_style", $contacts);
    $contacts = str_replace("{inv_insert}", "", $contacts);
    $contacts = str_replace("{abo_insert}", "", $contacts);
    $contacts = str_replace("{con_insert}", " selected", $contacts);
    $contacts = str_replace("{handler}", "contacts", $contacts);
    iuf_ins($contacts);

    $middle = file_get_contents("contacts\contacts_middle.html");
    $contacts = str_replace("{middle_insert}", $middle, $contacts);

    $date = file_get_contents("home_contacts_date\date.html");
    insert_date("{service_info}", $date, $contacts, "Service hours",
        "09:00AM – 06:00PM", "10:00AM – 02:00PM");
    insert_date("{sales_info}", $date, $contacts, "Sales hours",
        "09:20AM – 09:30AM", "10:20AM – 10:25AM");
}

standardization($contacts);
hbi($contacts);
connection();

echo $contacts;