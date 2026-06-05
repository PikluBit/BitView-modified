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
$Modules = explode(",", (string) $_USER->Info['h_modules']);
$Position = array_search($Moved_Module, $Modules);

$Position_2 = array_search(mb_substr((string) $_GET['info'],23), $Modules);

if ($Direction == "up") {
    array_swap($Modules,$Position,$Position_2);
    $Modules_Final = implode(",", $Modules);
    $DB->modify("UPDATE users SET h_modules = :MODULES WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":MODULES" => $Modules_Final]);
}
elseif ($Direction == "down") {
    array_swap($Modules,$Position,$Position_2);
    $Modules_Final = implode(",", $Modules);
    $DB->modify("UPDATE users SET h_modules = :MODULES WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":MODULES" => $Modules_Final]);
}