<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /login");
    exit();
}
if (isset($_GET["notification"]) && ($_GET["notification"] !== "1")) {
    header("location: /");
    exit();
}

$_PAGE = [
    "Page"          => "my_messages",
    "Page_Type"     => "my_messages"
];
require "_templates/_structures/main.php";
