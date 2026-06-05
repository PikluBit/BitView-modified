<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

// PERMISSIONS AND REQUIREMENTS
// USER MUST BE LOGGED IN
// REQUIRES $_GET["id"]
if (!$_USER->Logged_In) { header("location: /login"); exit(); }
if (!isset($_GET["id"])) { header("location: /"); exit(); }

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

$Message = $DB->execute("SELECT * FROM users_messages WHERE for_user = :USERNAME AND id = :ID", true, [":USERNAME" => $_USER->Username, ":ID" => $_GET["id"]]);

if ($DB->Row_Num == 0) { notification("Message not found!", "/inbox"); exit(); }

$DB->modify("UPDATE users_messages SET seen = 1 WHERE id = :ID", [":ID" => $_GET["id"]]);

// Transfer to the correct page with the correct ID
$messagesPerPage = 16;
$pageNumber = ceil(($DB->Row_Num + 1) / $messagesPerPage);
if($pageNumber>1) {
    $redirectUrl = "/inbox?p=$pageNumber&readid={$_GET["id"]}";
} else {
    $redirectUrl = "/inbox?readid={$_GET["id"]}";
}
header("Location: $redirectUrl");
exit();
?>
