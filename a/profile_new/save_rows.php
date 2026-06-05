<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

$Module = $_POST['module'];
$Rows = $_POST['rows'];

if ($Module == "subscribers") {
    $DB->modify("UPDATE users SET c_subscribers_rows = :ROWS WHERE username = :USERNAME",[":ROWS" => $Rows,":USERNAME" => $_USER->Username]);
    die(json_encode(["response" => "success"]));
}
elseif ($Module == "subscriptions") {
    $DB->modify("UPDATE users SET c_subscriptions_rows = :ROWS WHERE username = :USERNAME",[":ROWS" => $Rows,":USERNAME" => $_USER->Username]);
    die(json_encode(["response" => "success"]));
}
elseif ($Module == "friends") {
    $DB->modify("UPDATE users SET c_friends_rows = :ROWS WHERE username = :USERNAME",[":ROWS" => $Rows,":USERNAME" => $_USER->Username]);
    die(json_encode(["response" => "success"]));
}
else {
    die(json_encode(["response" => "error"]));
}
?>