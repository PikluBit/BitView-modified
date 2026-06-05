<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////MUST BE LOGGED IN
////REQUIRES $_GET["id"]
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (!isset($_GET["id"]) && !isset($_POST["id"])) {
    header("location: /");
    exit();
}

header("location: /my_playlist?id=".$_GET["id"]);
exit();

$_PAGE = [
    "Page"          => "edit_playlist",
    "Page_Type"     => "browse"
];
require "_templates/_structures/main.php";
