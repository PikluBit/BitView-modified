<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_POST["v"]
if (!$_USER->Logged_In)      { header("location: /"); exit(); }
if (!isset($_POST["v"]))      { header("location: /"); exit(); }

$_VIDEO = new Video($_POST["v"],$DB);
$_USER->get_info();
$_GUMP->validation_rules([
    "number"   => "required|max_len,5|min_len,1",
    "info"     => "max_len,500"
]);

$_GUMP->filter_rules([
    "number"   => "trim",
    "info"     => "trim|NoHTML"
]);

$Validation = $_GUMP->run($_POST);

if ($Validation) {
    $Number = $Validation["number"];
    $Info 	= $Validation["info"];
    if ($_USER->has_flagged($_VIDEO)) {
	    die(json_encode(["response" => "error"]));
	} else {
	    $DB->modify("INSERT INTO videos_flags (url,username,number,additional_info,submit_date) VALUES (:URL,:USERNAME,:NUM,:INFO,NOW())", [":URL" => $_VIDEO->URL, ":USERNAME" => $_USER->Username, ":NUM" => $Number, ":INFO" => $Info]);
	    die(json_encode(["response" => "success"]));
	}
} else {
	die(json_encode(["response" => "error"]));
}
?>