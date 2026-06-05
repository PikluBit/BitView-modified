<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

$Users = $DB->execute("SELECT username FROM users WHERE e_subscriptions = 1 AND subscriptions > 0", false);

foreach ($Users as $User) {
    error_log(1);
    $Username = $User["username"];
    $Send_Mail = $_SERVER["DOCUMENT_ROOT"]."/send_email.php";
    exec("php $Send_Mail s $Username > /dev/null 2>&1 &");
}
