<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["module"]
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (!isset($_GET["module"])) {
    header("location: /");
    exit();
}

$Module = $_GET['module'];
if ($Module == "h_beingwatched") {
$DB->modify("UPDATE users SET h_beingwatched = 0 WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
}
if ($Module == "h_featured") {
$DB->modify("UPDATE users SET h_featured = 0 WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
}
if ($Module == "h_mostpop") {
$DB->modify("UPDATE users SET h_mostpop = 0 WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
}
if ($Module == "h_recommended") {
$DB->modify("UPDATE users SET h_recommended = 0 WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
}
if ($Module == "h_subscriptions") {
$DB->modify("UPDATE users SET h_subscriptions = 0 WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
}
if ($Module == "h_activity") {
$DB->modify("UPDATE users SET h_activity = 0 WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
}