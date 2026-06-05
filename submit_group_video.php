<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//MUST BE LOGGED IN
//REQUIRES $_GET["id"]
if (!$_USER->Logged_In)  { header("location: /"); exit(); }
if (!isset($_REQUEST["id"])) { header("location: /"); exit(); }


$Group = $DB->execute("SELECT groups.* FROM groups WHERE groups.id = :ID", true, [":ID" => $_REQUEST["id"]]);

if ($DB->Row_Num == 0) { notification($LANGS['groupdoesnotexist'], "/"); exit(); }

$DB->execute("SELECT member FROM groups_members WHERE member = :MEMBER AND group_id = :GROUP AND accepted = 1", false, [":MEMBER" => $_USER->Username, ":GROUP" => $_REQUEST["id"]]);

if ($DB->Row_Num == 0) { header("location: /"); exit(); }


if (isset($_POST["submit_video"])) {
    $URL = @str_replace("v=","",parse_url((string) $_POST["url"])["query"]);

    if (!empty($URL)) {
        $Uploaded_By = $DB->execute("SELECT uploaded_by FROM videos WHERE url = :URL", true, [":URL" => $URL])["uploaded_by"];
        if ($DB->Row_Num > 0 && $Uploaded_By == $_USER->Username) {
            $DB->execute("SELECT video FROM groups_videos WHERE video = :URL AND group_id = :GROUP", true, [":URL" => $URL, ":GROUP" => $_REQUEST["id"]]);

            if ($DB->Row_Num == 0) {
                $Instant = $DB->execute("SELECT instant_video FROM groups WHERE id = :ID", true, [":ID" => $_REQUEST["id"]])["instant_video"];
                if ($Instant == 1) { $Accepted = 1; } else { $Accepted = 0; }
                
                $DB->modify("INSERT INTO groups_videos (video,group_id,accepted,submit_date) VALUES (:URL,:ID,:ACCEPTED,NOW())", [":URL" => $URL, ":ID" => $_REQUEST["id"], ":ACCEPTED" => $Accepted]);
                notification($LANGS['groupvideoadded'], "/group?id=".$_REQUEST["id"]."&action=videos", "cfeeb2"); exit();
            } else {
                notification($LANGS['groupvideoalreadyadded'], "/submit_group_video?id=".$_REQUEST["id"]); exit();
            }
        } else {
            notification($LANGS['groupvideonotowned'], "/submit_group_video?id=".$_REQUEST["id"]); exit();
        }
    } else {
        notification($LANGS['urlnotvalid'], "/submit_group_video?id=".$_REQUEST["id"]); exit();
    }

}

$_PAGE = [
    "Page" => "submit_group_video",
    "Page_Type" => "groups",
    "Show_Search" => false,
    "new" => true
];
require "_templates/_structures/main.php";