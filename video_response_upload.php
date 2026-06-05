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
    
    $Videos = new Videos($DB,$_USER);
    $Videos->WHERE_P    = ["videos.uploaded_by" => $_USER->Username];
    $Videos->ORDER_BY   = "videos.uploaded_on DESC";
    $Videos->get();
    $Videos = $Videos->fix_values(true, false);

    if ($_USER->Logged_In && isset($_POST["video_submit"])) {
        $_GUMP->validation_rules([
            "video_response_id"   => "max_len,100"
        ]);

        $_GUMP->filter_rules([
            "video_response_id"   => "trim"
        ]);
        $Validation     = $_GUMP->run($_POST);

        if ($Validation) {
                $query["v"] = $_POST["video_response_id"];
                if (isset($query["v"]) && !empty($query["v"]) && $query["v"] != $_GET["v"]) {
                    $Res_URL = new Video($query["v"],$DB);
                    if ($Res_URL->exists()) {
                        $Resp_URL = $Res_URL->URL;
                    } else {
                        notification($LANGS['responseerror'],"/watch?v=".$_VIDEO->URL); exit();
                    }
                } else {
                    notification($LANGS['responseerror'],"/watch?v=".$_VIDEO->URL); exit();
                }

                $Response_URL = new Video($Resp_URL,$DB);
                
                $CheckVideoExist = $DB->execute("SELECT count(*) as li FROM videos_responses WHERE vid_id = :URL",true,[":URL" => $Resp_URL])["li"];
                if ($CheckVideoExist) { notification($LANGS['responseexist'],"/watch?v=".$_VIDEO->URL); exit(); }
                if ($_USER->Username == $_VIDEO->Info["uploaded_by"]) { $Is_Added = 1; } else { $Is_Added = null; }

                if($Is_Added==null) {
                    //SEND MESSAGE
                    $res_URL = $DB->execute("SELECT * FROM videos WHERE url = :URL AND status = 2 AND privacy = 1",true,[":URL" => $Resp_URL]);
                    $ResponseNotification = 'I added a new video response: "'.$res_URL["title"].'" into your video: "'.$_VIDEO->Info["title"].'". Please accept it! https://www.bitview.net/a/accept_video_response?v='.$Resp_URL.'&org='.$_GET["v"].'';
                    $_INBOX->send_message($_VIDEO->Info["title"],$ResponseNotification,$_VIDEO->Info["uploaded_by"],$_VIDEO->Info["url"],3);
                }

                $DB->modify("INSERT INTO videos_responses (vid_id,basevid_id,from_user,by_user,is_added) VALUES (:VIDURL,:URL,:USERNAME,:AUTHOR,:IS_ADDED)",
                        [":VIDURL" => $Resp_URL, ":URL" => $_GET["v"], ":USERNAME" => $_USER->Username, ":AUTHOR" => $_VIDEO->Info["uploaded_by"], ":IS_ADDED" => $Is_Added]);
                notification($LANGS['responseadded'],"/watch?v=".$_VIDEO->URL, "cfeeb2"); exit();
            }
    }

    $_PAGE = [
        "Page"          => "video_response_upload",
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