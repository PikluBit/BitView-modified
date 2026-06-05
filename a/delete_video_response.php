<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

if (!$_USER->Logged_In)     { header("location: /"); exit(); } // MUST BE LOGGED IN
if (!isset($_GET["v"]))  { header("location: /"); exit(); } // REQUIRES $_GET["v"]
if (!isset($_GET["org"]))  { header("location: /"); exit(); } // REQUIRES $_GET["org"]

$DB->modify("DELETE FROM videos_responses WHERE vid_id = :vid AND basevid_id = :org", [":vid" => $_GET["v"], ":org" => $_GET["org"]]);
notification($LANGS['responsedeleted'], $_SERVER["HTTP_REFERER"]); exit();
