<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["module"] AND $_GET["num"]
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

if(!isset($_GET['b']) || isset($_GET['b']) && $_GET['b'] != 1) {
    $New = 1;
}
else {
    $New = 0;
}

$DB->modify("UPDATE users SET h_feed = :FEED WHERE username = :USERNAME",[":FEED" => $New,":USERNAME" => $_USER->Username]);
notification($LANGS['changessaved'],"/","cfeeb2"); exit();
header("location: /");
?>