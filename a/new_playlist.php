<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

function random_string($Characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", $Length = null) {
    $charactersLength   = mb_strlen((string) $Characters);
    $randomString       = '';
    for ($i = 0; $i < $Length; $i++) {
        $randomString .= $Characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$_GUMP->validation_rules([
    "pl_title"    => "required|max_len,100|min_len,1",
    "pl_desc"     => "max_len,500",
    "pl_tags"     => "max_len,256"
]);

$_GUMP->filter_rules([
    "pl_title"    => "trim|NoHTML",
    "pl_desc"     => "trim|NoHTML",
    "pl_tags"     => "trim|NoHTML"
]);

$Validation = $_GUMP->run($_POST);

if ($Validation) {
    $Title    = $Validation["pl_title"];
    $Desc     = ($Validation["pl_desc"]!=null)?$Validation["pl_desc"]:"";
    $Tags     = ($Validation["pl_tags"]!=null)?$Validation["pl_tags"]:"";
    $ID = random_string("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",11);

    $DB->modify("INSERT INTO playlists(id,by_user,title,description,tags,submit_date,update_date,views) VALUES(:ID,:USERNAME,:TITLE,:DESCRIPTION,:TAGS,NOW(),NOW(),0)",[":ID" => $ID, ":USERNAME" => $_USER->Username, ":TITLE" => $Title, ":DESCRIPTION" => $Desc, ":TAGS" => $Tags]);
    die(json_encode(["response" => "success", "id" => $ID]));
}
else {
    die(json_encode(["response" => "error"]));
}