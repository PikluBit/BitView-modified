<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) { header("location: /login"); exit(); }


if (isset($_GET["remove"])) {
    $Friend = new User($_GET["remove"],$DB);

    $_USER->remove_friend($Friend);

    header("location: /my_friends"); exit();
}

$_USER->get_info();

$_PAGINATION = new Pagination(20,99);
$_PAGINATION->total($_USER->Info["friends"]);

$Friends = $_USER->get_friends($_PAGINATION,true);


$_PAGE = [
    "Page"          => "my_friends",
    "Page_Type"     => "friends"
];
require "_templates/_structures/main.php";