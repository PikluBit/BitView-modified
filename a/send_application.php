<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["user"]
if (!$_USER->Logged_In)      { header("location: /"); exit(); }

$_USER->get_info();

$DB->execute("SELECT username FROM partner_applications WHERE username = :USERNAME",false,[":USERNAME" => $_USER->Username]);

if ($_USER->Info["subscribers"] < 75) {
notification($LANGS['nocriteria'],"/partners"); exit();
}
elseif ($_USER->Info["is_partner"] == 1) {
notification($LANGS['alreadypartner'],"/partners"); exit();
}
elseif ($DB->Row_Num > 0) {
notification($LANGS['alreadyapplied'],"/partners"); exit();
}
else {
$DB->modify("INSERT INTO partner_applications (username,submit_date) VALUES (:USERNAME,NOW())",[":USERNAME" => $_USER->Username]);
notification($LANGS['applicationsent'],"/partners","cfeeb2"); exit();
}