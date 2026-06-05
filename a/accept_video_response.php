<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In)     { header("location: /"); exit(); } // MUST BE LOGGED IN
if (!isset($_GET["v"]))  { header("location: /"); exit(); } // REQUIRES $_GET["v"]
if (!isset($_GET["org"]))  { header("location: /"); exit(); } // REQUIRES $_GET["org"]

$DB->modify("UPDATE videos_responses SET is_added = 1 WHERE vid_id = :vid AND basevid_id = :org AND by_user = :user", [":vid" => $_GET["v"], ":org" => $_GET["org"], ":user" => $_USER->Username]);
notification($LANGS['responseaccepted'], $_SERVER["HTTP_REFERER"], "cfeeb2"); exit();
