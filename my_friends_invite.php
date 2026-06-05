<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) { header("location: /login"); exit(); }

if (isset($_GET["user"]) && ctype_alnum((string) $_GET["user"]) && strlen((string) $_GET["user"]) <= 20) {
    $Invite_User = new User($_GET["user"],$DB);

    $Blocked = $DB->execute("SELECT blocker, blocked FROM users_block WHERE (blocker = :USERNAME AND blocked = :USER) OR (blocker = :USER AND blocked = :USERNAME)", true, [":USERNAME" => $_USER->Username, ":USER" => $Invite_User->Username]);

    if ($DB->Row_Num > 0) {
        notification("You can't add blocked users as friends!", false);
    } else {
        $_USER->add_friend($Invite_User);
    }

    if (!isset($_SERVER["HTTP_REFERER"]) || !str_contains((string) $_SERVER["HTTP_REFERER"],"profile")) {
        header("location: /my_friends_invite"); exit();
    } else {
        header("location: ".$_SERVER["HTTP_REFERER"]); exit();
    }

}

if (isset($_GET["retract"])) {
    $_USER->deny_friend($_GET["retract"]);

    if (!isset($_SERVER["HTTP_REFERER"]) || !str_contains((string) $_SERVER["HTTP_REFERER"],"profile")) {
        header("location: /my_friends_invite"); exit();
    } else {
        header("location: ".$_SERVER["HTTP_REFERER"]); exit();
    }
}

if (isset($_GET["accept"])) {
    $_USER->accept_friend($_GET["accept"]);

    header("location: /my_friends_invite"); exit();
}

$Other_Invites = $DB->execute("SELECT * FROM users_friends WHERE friend_2 = :USERNAME AND status = 0 ORDER BY submit_on DESC",false,
                              [":USERNAME" => $_USER->Username]);

$_PAGINATION1 = new Pagination(1000,1);
$_PAGINATION1->total($DB->Row_Num);


$My_Invites    = $DB->execute("SELECT * FROM users_friends WHERE friend_1 = :USERNAME AND status = 0 ORDER BY submit_on DESC",false,
                              [":USERNAME" => $_USER->Username]);

$_PAGINATION2 = new Pagination(1000,1);
$_PAGINATION2->total($DB->Row_Num);


$_PAGE = [
    "Page"          => "my_friends_invite",
    "Page_Type"     => "friends"
];
require "_templates/_structures/main.php";