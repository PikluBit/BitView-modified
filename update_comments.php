<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

session_write_close();

$Users = $DB->execute("SELECT username FROM users");

foreach ($Users as $User) {

	$Amount = $DB->execute("SELECT count(*) as amount FROM channel_comments WHERE on_channel = :USERNAME", true, [":USERNAME" => $User["username"]])["amount"];

	$DB->modify("UPDATE users SET channel_comments = :AMOUNT WHERE username = :USERNAME", [":AMOUNT" => $Amount, ":USERNAME" => $User["username"]]);

}