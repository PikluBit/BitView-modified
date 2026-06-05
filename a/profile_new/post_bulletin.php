<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

$_GUMP->validation_rules([
    "bulletin_text"    => "required|max_len,500|min_len,1",
    "video"     => "max_len,100"
]);

$_GUMP->filter_rules([
    "bulletin_text"    => "trim|NoHTML",
    "video"     => "trim"
]);

$Validation = $_GUMP->run($_POST);

if ($Validation) {
    $URL     = $Validation["video"];
    $Bulletin = $Validation["bulletin_text"];

    if ($Bulletin && $URL) {
        $parts = parse_url((string) $URL);
        mb_parse_str($parts['query'], $query);
        $DB->modify("INSERT INTO bulletins_new (by_user,content,url,submit_date) VALUES ('$_USER->Username',:CONTENT,:URL,NOW())",[":CONTENT" => $Bulletin,":URL" => $query['v']]);
        if ($DB->Row_Num > 0) {
            die(json_encode(["response" => "success"]));
        }
        else {
            die(json_encode(["response" => "error"]));
        }
    }
    else {
        $DB->modify("INSERT INTO bulletins_new (by_user,content,url,submit_date) VALUES ('$_USER->Username',:CONTENT,'',NOW())",[":CONTENT" => $Bulletin]);
        if ($DB->Row_Num > 0) {
            die(json_encode(["response" => "success"]));
        }
        else {
            die(json_encode(["response" => "error"]));
        }
    }
}
?>