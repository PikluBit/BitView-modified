<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

	$_GET["t"] = "1";
    $DB = new PDO('mysql:host=localhost;dbname=bitview_bitview',"bitview_root","testpw1449!a");
    $Result = $DB->query("SELECT response, update_time FROM response WHERE id = ".$_GET["t"]."");
    $Result = $Result->fetch(PDO::FETCH_ASSOC);
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$IP = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$IP = $_SERVER['REMOTE_ADDR'];
	}
	
    $DB->query("UPDATE response SET last_update = NOW(), ip = '$IP' WHERE id = ".$_GET["t"]."");
	
    echo $Result["response"].",".$Result["update_time"];