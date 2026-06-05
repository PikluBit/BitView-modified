<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

//PERMISSIONS AND REQUIREMENTS
////"$_GET["v"]" MUST NOT BE LOGGED IN
if (!isset($_GET["v"])) { notification($LANGS['videonotexist'],"/"); exit(); }
if (!$_CONFIG->Config["videos"])    { notification($LANGS['watchdisabled'],"/"); exit(); }
$_VIDEO = new Video($_GET["v"],$DB);
$_INBOX = new Inbox($_USER,$DB);

$_USER->get_info();

if ($_VIDEO->exists()) {
    $_VIDEO->get_info();
    $_VIDEO->check_info();

    $_OWNER = new User($_VIDEO->Info["uploaded_by"],$DB);
    $_OWNER->get_info();

    if ($_VIDEO->Info["comments"] > 0) { $Video_Comments = $_VIDEO->comments(true,1,100000); }
    $_PAGE = [
        "Page"          => "watch_comments",
        "Page_Type"     => "browse"
    ];
    require "_templates/_structures/main.php";
} else {
    $Strike = $DB->execute("SELECT * FROM copyright_strikes WHERE copyright_strikes.url = :URL", true, [":URL" => $_VIDEO->URL]);
    $Copyright_Holder = $Strike['copyright_holder'];
    header("location: /");
    if ($Strike) {
    notification("This video is no longer available due to a copyright claim by $Copyright_Holder.","/"); exit();
    }
    else {
        notification($LANGS['videonotexist'],"/"); exit();
    }
}