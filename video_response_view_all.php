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

    $Video_Responses = new Videos($DB, $_USER);
    $Video_Responses->WHERE_C = "AND videos_responses.basevid_id = :VIDEOID AND videos_responses.is_added=1";
    $Video_Responses->JOIN = "INNER JOIN videos_responses ON videos_responses.vid_id = videos.url";
    $Video_Responses->ORDER_BY = "videos.uploaded_on DESC";
    $Video_Responses->Execute = [":VIDEOID" => $_GET["v"]];
    $Video_Responses->get();
    $Responses_Amount = $Video_Responses::$Amount;
    if ($Video_Responses::$Videos) {
        $Video_Responses = $Video_Responses->fix_values(true, false);
    } else {
        $Video_Responses = false;
    }
    
    $_PAGE = [
        "Page"          => "video_response_view_all",
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