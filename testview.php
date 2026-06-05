<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (isset($_GET["flash_player"]) && $_GET["flash_player"] == 1) {
    setcookie("html5_player", 1, ['expires' => time() + (86400 * 30), 'path' => "/"]);
    notification($LANGS['flashenabled'], "/testview", "cfeeb2");
    exit();
} elseif (isset($_GET["flash_player"])) {
    setcookie("html5_player", "", ['expires' => -1, 'path' => "/"]);
    notification($LANGS['flashdisabled'], "/testview");
    exit();
}

if (isset($_GET["feather"]) && $_GET["feather"] == 1) {
    setcookie("feather", 1, ['expires' => time() + (86400 * 30), 'path' => "/"]);
    notification($LANGS['featherenabled'], "/testview", "cfeeb2");
    exit();
} elseif (isset($_GET["feather"])) {
    setcookie("feather", "", ['expires' => -1, 'path' => "/"]);
    notification($LANGS['featherdisabled'], "/testview");
    exit();
}

if (isset($_GET["time_machine"]) && $_GET["time_machine"] == 1) {
    setcookie("time_machine", 1, ['expires' => time() + (86400 * 30), 'path' => "/"]);
    notification($LANGS['timemachineenabled'], "/testview", "cfeeb2");
    exit();
} elseif (isset($_GET["time_machine"])) {
    setcookie("time_machine", "", ['expires' => -1, 'path' => "/"]);
    notification($LANGS['timemachinedisabled'], "/testview");
    exit();
}

if (isset($_GET["dark"]) && $_GET["dark"] == 1) {
    setcookie("dark", 1, ['expires' => time() + (86400 * 30), 'path' => "/"]);
    notification($LANGS['lightsoutenabled'], "/testview", "cfeeb2");
    exit();
} elseif (isset($_GET["dark"])) {
    setcookie("dark", "", ['expires' => -1, 'path' => "/"]);
    notification($LANGS['lightsoutdisabled'], "/testview");
    exit();
}

$_PAGE = [
    "Page"       => "testview",
    "Page_Type"  => "home",
    "Title"      => "TestView"
];
require "_templates/_structures/main.php";
