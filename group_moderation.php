<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//MUST BE LOGGED IN
//REQUIRES $_GET["id"]
if (!$_USER->Logged_In)         { header("location: /"); exit(); }
if (!isset($_REQUEST["id"]))    { header("location: /"); exit(); }

$Group_Category = [1 => $LANGS['cat1'], 2 => $LANGS['cat2'], 3 => $LANGS['cat3'], 4 => $LANGS['cat4'], 5 => $LANGS['cat5'], 6 => $LANGS['cat6'], 7 => $LANGS['cat7'], 8 => $LANGS['cat8'], 9 => $LANGS['cat9'], 10 => $LANGS['cat10'], 11 => $LANGS['cat11'], 12 => $LANGS['cat12'], 13 => $LANGS['cat13'], 14 => $LANGS['cat14'], 15 => $LANGS['cat15'], 16 => $LANGS['cat16'], 17 => $LANGS['cat17'], 18 => $LANGS['cat18'], 19 => $LANGS['cat19'], 20 => $LANGS['cat20'], 21 => $LANGS['cat21']];

$Group = $DB->execute("SELECT groups.* FROM groups WHERE groups.id = :ID", true, [":ID" => $_REQUEST["id"]]);

if ($DB->Row_Num == 0) { notification($LANGS['groupdoesnotexist'], "/groups"); exit(); }

if ($Group["created_by"] != $_USER->Username && !$_USER->Is_Admin && !$_USER->Is_Moderator) { header("location: /"); exit(); }


if (isset($_POST["change_info"])) {
    if (mb_strlen((string) $_POST["name"]) > 100)                    { header("location: /"); exit(); }
    if (mb_strlen((string) $_POST["description"]) > 5000)            { header("location: /"); exit(); }
    if (!isset($_CONFIG::$Categories[$_POST["category"]]))  { header("location: /"); exit(); }

    if (empty($_POST["name"]))        { notification($LANGS['groupnameempty'], false); $Error = true; unset($_POST["name"]); }
    if (empty($_POST["description"])) { notification($LANGS['groupdescempty'], "/group_moderation?id=".$_REQUEST["id"]); exit(); }

    if ($_POST["instant"] == 1)       { $Instant = 1; } else { $Instant = 0; }
    if ($_POST["instant_video"] == 1) { $Instant_Video = 1; } else { $Instant_Video = 0; }


    $DB->modify("UPDATE groups SET instant_join = :INSTANT, title = :TITLE, description = :DESCRIPTION, categories = :CATEGORY, instant_video = :INSTANTVIDEO WHERE id = :ID", [":INSTANT" => $Instant, ":INSTANTVIDEO" => $Instant_Video, ":TITLE" => $_POST["name"], ":DESCRIPTION" => $_POST["description"], ":CATEGORY" => (int)$_POST["category"], ":ID" => $_REQUEST["id"]]);

    notification($LANGS['descriptionchanged'], "/group_moderation?id=".$_REQUEST["id"], "cfeeb2"); exit();
}

if (isset($_POST["change_image"])) {
    $Uploader = new upload($_FILES["image"]);
    $Uploader->file_new_name_body = $Group["id"];
    $Uploader->image_resize = true;
    $Uploader->file_overwrite          = true;
    $Uploader->image_x                 = 100;
    $Uploader->image_y                 = 100;
    $Uploader->image_background_color  = '#000000';
    $Uploader->image_convert           = 'jpg';
    $Uploader->image_ratio_fill        = false;
    $Uploader->file_max_size           = 1000000;
    $Uploader->jpeg_quality            = 40;
    $Uploader->allowed                 = ['image/jpeg','image/pjpeg','image/png','image/gif','image/bmp','image/x-windows-bmp'];
    $Uploader->process("u/grp/");
    if ($Uploader->processed) {
        notification($LANGS['imageupdated'], "/group_moderation?id=".$_REQUEST["id"], "cfeeb2"); exit();
    } else {
        notification($LANGS['groupimageerror'], false); exit();
    }
}

if (isset($_POST["send_message"])) {
    $Inbox = new Inbox($_USER,$DB);

    if (mb_strlen((string) $_POST["message"]) > 500) { header("location: /"); exit(); }

    if (empty($_POST["message"])) { notification($LANGS['emptymessage'], "/group_moderation?id=".$_REQUEST["id"]); exit(); }

    $Members = $DB->execute("SELECT member FROM groups_members WHERE group_id = :ID AND accepted = 1", false, [":ID" => $_REQUEST["id"]]);

    foreach ($Members as $Member) {
        $Inbox->send_message("Group Message from: ".$Group["title"], $_POST["message"], $Member["member"]);
    }
    notification($LANGS['messagesent'], "/group_moderation?id=".$_REQUEST["id"], "cfeeb2"); exit();
}

$_PAGE = [
    "Page" => "group_moderation",
    "Page_Type" => "groups",
    "Show_Search" => false,
    "new" => true
];
require "_templates/_structures/main.php";