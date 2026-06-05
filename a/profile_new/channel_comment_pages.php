<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!isset($_GET["channel"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["page"])) {
    header("location: /");
    exit();
}

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

$_PROFILE = new User($_GET["channel"],$DB);
$_PROFILE->get_info();
$_USER->get_info();
$Channel = $_GET['channel'];
$Page = is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$Limit = ($Page - 1) * 10;

$Comments = $DB->execute("SELECT * FROM channel_comments WHERE on_channel = :USERNAME ORDER BY submit_date DESC LIMIT $Limit,10", false, [":USERNAME" => $_PROFILE->Username]);
$Page_Amount = $_PROFILE->Info["channel_comments"] / 10;
if (is_float($Page_Amount)) { $Page_Amount = (int)$Page_Amount + 1; }

$Modules_L = explode(",", (string) $_PROFILE->Info['c_modules_l']);
$Modules_R = explode(",", (string) $_PROFILE->Info['c_modules_r']);
?>
<?php if (in_array("comments", $Modules_L)):  ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/_templates/_profile/profile_modules/comments_l.php" ?>
<?php else: ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/_templates/_profile/profile_modules/comments_r.php" ?>
<?php endif ?>