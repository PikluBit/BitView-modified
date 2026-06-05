<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!isset($_GET["v"]) || mb_strlen((string) $_GET["v"]) > 11) {
    header("location: /");
    exit();
}

$_VIDEO = new Video($_GET["v"], $DB);

if (!$_VIDEO->exists()) {
    header("location: /");
    exit();
}

$_VIDEO->get_info();

$Position = array_search($_VIDEO->Info["url"], $_USER->QuickList);
$Position2 = array_search($_VIDEO->Info["url"], $_SESSION["quicklist"]);

array_splice($_USER->QuickList, $Position, 1);
array_splice($_SESSION["quicklist"], $Position2, 1);