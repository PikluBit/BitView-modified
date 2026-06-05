<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) { header("location: /login"); exit(); }

$Group_Category = [1 => $LANGS['cat1'], 2 => $LANGS['cat2'], 3 => $LANGS['cat3'], 4 => $LANGS['cat4'], 5 => $LANGS['cat5'], 6 => $LANGS['cat6'], 7 => $LANGS['cat7'], 8 => $LANGS['cat8'], 9 => $LANGS['cat9'], 10 => $LANGS['cat10'], 11 => $LANGS['cat11'], 12 => $LANGS['cat12'], 13 => $LANGS['cat13'], 14 => $LANGS['cat14'], 15 => $LANGS['cat15'], 16 => $LANGS['cat16'], 17 => $LANGS['cat17'], 18 => $LANGS['cat18'], 19 => $LANGS['cat19'], 20 => $LANGS['cat20'], 21 => $LANGS['cat21']];

if (isset($_POST["create_group"])) {
    $DB->execute("SELECT id FROM groups WHERE created_by = :USERNAME", false, [":USERNAME" => $_USER->Username]);

    if ($DB->Row_Num >= 3) { notification($LANGS['3groups'], "/groups"); exit(); }

    $Error = false;

    if (mb_strlen((string) $_POST["name"]) > 100)                    { header("location: /"); exit(); }
    if (mb_strlen((string) $_POST["description"]) > 5000)            { header("location: /"); exit(); }
    if (!isset($_CONFIG::$Categories[$_POST["category"]]))  { header("location: /"); exit(); }


    if (empty($_POST["name"]))          { notification($LANGS['groupnameempty'], false); $Error = true; unset($_POST["name"]); }
    if (empty($_POST["description"]))   { notification($LANGS['groupdescempty'], false); $Error = true; unset($_POST["description"]); }
    if (empty($_FILES["image"]["name"])){ notification($LANGS['groupnoimage'], false); $Error = true; }
    if ($_POST["instant"] == 1)             { $Instant = 1; } else { $Instant = 0; }
    if ($_POST["instant_video"] == 1)       { $Instant_Video = 1; } else { $Instant_Video = 0; }


    if (!$Error) {
        $DB->modify("INSERT INTO groups (title,description,categories,created_by,creation_date,instant_join,instant_video) VALUES (:TITLE,:DESCRIPTION,:CATEGORY,:USERNAME,NOW(),:INSTANT,:INSTANTVIDEO)",
                   [
                       ":TITLE"         => $_POST["name"],
                       ":DESCRIPTION"   => $_POST["description"],
                       ":CATEGORY"      => (int)$_POST["category"],
                       ":USERNAME"      => $_USER->Username,
                       ":INSTANT"       => $Instant,
                       ":INSTANTVIDEO"  => $Instant_Video
                   ]);
        $This_ID = $DB->last_id();

        $Uploader = new upload($_FILES["image"]);
        $Uploader->file_new_name_body = $This_ID;
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
            $DB->modify("INSERT INTO groups_members (member,group_id,accepted,submit_date) VALUES (:USERNAME,:ID,1,NOW())", [":USERNAME" => $_USER->Username, ":ID" => $This_ID]);
            notification($LANGS['groupcreated'], "/group?id=$This_ID", "cfeeb2"); exit();
        } else {
            $DB->modify("DELETE FROM groups WHERE id = :ID",[":ID" => $This_ID]);
            notification($LANGS['groupimageerror'], false); exit();
        }
    }


}

$_PAGE = [
    "Page"          => "create_group",
    "Page_Type"     => "groups"
];
require "_templates/_structures/main.php";