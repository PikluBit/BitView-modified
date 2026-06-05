<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["module"] AND $_GET["direction"]
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (!isset($_GET["module"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["direction"])) {
    header("location: /");
    exit();
}

function array_swap(&$array,$swap_a,$swap_b){
   [$array[$swap_a], $array[$swap_b]] = [$array[$swap_b],$array[$swap_a]];
}

$_USER->get_info();

$Moved_Module = $_GET['module'];
$Direction = $_GET['direction'];
$CloseModule = $_GET['info'];

if ($_GET['module'] == "hubber_links") {
    $Moved_Module = "otherchannels";
}
if ($_GET['module'] == "branding") {
    $Moved_Module = "custombox";
}
if ($_GET['module'] == "recent_activity") {
    $Moved_Module = "recentactivity";
}

if ($_GET['info'] == "user_hubber_links") {
    $CloseModule = "user_otherchannels";
}
if ($_GET['info'] == "user_branding") {
    $CloseModule = "user_custombox";
}
if ($_GET['info'] == "user_recent_activity") {
    $CloseModule = "user_recentactivity";
}

if ($_GET['side'] == "main-channel-right") {
    $Modules = explode(",", (string) $_USER->Info['c_modules_r']);
}
else {
    $Modules = explode(",", (string) $_USER->Info['c_modules_l']);  
}
$Position = array_search($Moved_Module, $Modules);
$Position_2 = array_search(mb_substr((string) $CloseModule,5), $Modules);

if ($Direction == "up") {
    array_swap($Modules,$Position,$Position_2);
    $Modules = array_filter($Modules);
    $Modules_Final = implode(",", $Modules);
    if ($_GET['side'] == "main-channel-right") {
        $DB->modify("UPDATE users SET c_modules_r = :MODULES WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":MODULES" => $Modules_Final]);
    }
    elseif ($_GET['side'] == "main-channel-left") {
        $DB->modify("UPDATE users SET c_modules_l = :MODULES WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":MODULES" => $Modules_Final]);
    }
}
elseif ($Direction == "down") {
    array_swap($Modules,$Position,$Position_2);
    $Modules = array_filter($Modules);
    $Modules_Final = implode(",", $Modules);
    if ($_GET['side'] == "main-channel-right") {
        $DB->modify("UPDATE users SET c_modules_r = :MODULES WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":MODULES" => $Modules_Final]);
    }
    elseif ($_GET['side'] == "main-channel-left") {
        $DB->modify("UPDATE users SET c_modules_l = :MODULES WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":MODULES" => $Modules_Final]);
    }
}