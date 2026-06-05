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

if (!in_array($_VIDEO->Info["url"], $_USER->QuickList)) {
$_USER->QuickList[]     = $_VIDEO->Info["url"];
$_SESSION["quicklist"][]   = $_VIDEO->Info["url"];
}
