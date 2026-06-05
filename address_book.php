<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /login");
    exit();
}


if (isset($_GET["remove"])) {
    $Friend = new User($_GET["remove"], $DB);

    if (!$_USER->is_blocked($Friend)) { $_USER->remove_friend($Friend); }
    else {
        $DB->modify("DELETE FROM users_block WHERE blocker = :YOU AND blocked = :USER",
                   [
                       ":YOU"   => $_USER->Username,
                       ":USER"  => $Friend->Username
                   ]);
    }

    header("location: /address_book");
    exit();
}

if (isset($_GET["retract"])) {
    $_USER->deny_friend($_GET["retract"]);

    if (!isset($_SERVER["HTTP_REFERER"]) || !str_contains((string) $_SERVER["HTTP_REFERER"], "profile")) {
        header("location: /address_book");
        exit();
    } else {
        header("location: ".$_SERVER["HTTP_REFERER"]);
        exit();
    }
}

if (isset($_GET["accept"])) {
    $_USER->accept_friend($_GET["accept"]);

    header("location: /address_book");
    exit();
}

$_USER->get_info();

if (!isset($_GET['v'])) {
$Friends = $DB->execute("SELECT * FROM users_friends INNER JOIN users ON users_friends.friend_1 = users.username OR users_friends.friend_2 = users.username WHERE (users_friends.friend_1 = :USERNAME OR users_friends.friend_2 = :USERNAME) AND users_friends.status = 1 AND users.username <> :USERNAME AND users.is_banned = 0 ORDER BY users.displayname ASC", false, [":USERNAME" => $_USER->Username]);
}
elseif (isset($_GET['v']) && $_GET['v'] == "bu") {
$Friends = $DB->execute("SELECT * FROM users_block INNER JOIN users ON users_block.blocked = users.username WHERE users_block.blocker LIKE :USERNAME AND users.is_banned = 0 ORDER BY users.displayname ASC", false, [":USERNAME" => $_USER->Username]);
}
else {
$Friends = $DB->execute(
    "SELECT * FROM users_friends INNER JOIN users ON users_friends.friend_1 = users.username WHERE friend_2 = :USERNAME AND status = 0 ORDER BY users.displayname ASC", false, [":USERNAME" => $_USER->Username]);
}

$Blocked_Count = (int)$DB->execute("SELECT count(*) as total FROM users_block INNER JOIN users ON users_block.blocked = users.username WHERE users_block.blocker LIKE :USERNAME AND users.is_banned = 0", true, [":USERNAME" => $_USER->Username])['total'];

$Invites = (int)$DB->execute("SELECT count(id) as total FROM users_friends WHERE friend_2 = :USERNAME AND status = 0", true, [":USERNAME" => $_USER->Username])["total"];

$_PAGE = [
    "Page"          => "address_book",
    "Page_Type"     => "friends"
];
require "_templates/_structures/main.php";
