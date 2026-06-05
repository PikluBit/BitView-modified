<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) { header("location: /login"); exit(); }


if (isset($_POST["add_friend"]) && ctype_alnum((string) $_POST["username"]) && strlen((string) $_POST["username"]) <= 20) {
    $Invite_User = new User($_POST["username"],$DB);

    if ($_USER->add_friend($Invite_User)) {
        notification($LANGS['invitesent'],"/sharing","008000"); exit();
    }
}


$_USER->get_info();

$_PAGE = [
    "Page"          => "share",
    "Page_Type"     => "my_videos"
];
require "_templates/_structures/main.php";
