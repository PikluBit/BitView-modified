<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

$_PAGE = [
    "Page"          => "donate",
    "Page_Type"     => "home"
];
require "_templates/_structures/main.php";