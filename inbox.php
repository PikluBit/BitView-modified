<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

$_PAGE = [
    "Page"      => "my_messages",
    "Page_Type" => "home",
    "Title"     => isset($LANGS['messagesmenu']) ? $LANGS['messagesmenu'] : 'Messages',
    "Show_Search" => true,
    "new"         => true
];
require "_templates/_structures/main.php";
