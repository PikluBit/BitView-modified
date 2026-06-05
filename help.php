<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (isset($_GET["html5"]) && $_GET["html5"] == 1) {
    setcookie("html5_player", 1, ['expires' => time() + (86400 * 30), 'path' => "/"]);
    notification($LANGS['flashenabled'],"/help","cfeeb2"); exit();
} elseif (isset($_GET["html5"])) {
    setcookie("html5_player", "", ['expires' => -1, 'path' => "/"]);
    notification($LANGS['flashdisabled'],"/help","cfeeb2"); exit();
}

$_PAGE = [
    "Page"          => "help",
    "Page_Type"     => "home"
];
require "_templates/_structures/main.php";