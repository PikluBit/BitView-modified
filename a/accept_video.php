<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In)     { header("location: /"); exit(); } // MUST BE LOGGED IN
if (!isset($_GET["url"]))   { header("location: /"); exit(); } // REQUIRES $_GET["url"]
if (!isset($_GET["id"]))    { header("location: /"); exit(); } // REQUIRED $_GET["id"]

$Group_Owner = $DB->execute("SELECT groups.created_by FROM groups INNER JOIN groups_videos ON groups_videos.group_id = groups.id WHERE groups.id = :ID AND groups_videos.video = :URL", true, [":ID" => $_GET["id"], ":URL" => $_GET["url"]])["created_by"];

if ($DB->Row_Num > 0) {
    if ($Group_Owner == $_USER->Username) {
        $DB->modify("UPDATE groups_videos SET accepted = 1 WHERE video = :VIDEO AND group_id = :ID", [":VIDEO" => $_GET["url"], ":ID" => $_GET["id"]]);
        notification($LANGS['videoaccepted'], $_SERVER["HTTP_REFERER"],"cfeeb2"); exit();
    }
}

header("location: /");
