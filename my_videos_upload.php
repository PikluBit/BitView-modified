<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////UPLOAD MUST BE ENABLED
if (!$_USER->Logged_In)             { header("location: /login"); exit();   }
if (!$_CONFIG->Config["upload"])    { notification($LANGS['uploaddisabled'],"/"); exit(); }

$_USER->get_info();

//MAX 3 VIDEOS A DAY
$Count = $DB->execute("SELECT count(*) as amount FROM videos WHERE uploaded_by = :USERNAME AND is_deleted IS NULL AND DATE(uploaded_on) = CURDATE()",
                      true,
                      [":USERNAME" => $_USER->Username])["amount"];
//if ($Count >= 3) { notification($LANGS['vidsday'],"/"); exit();; }
//WAIT 3 MINUTES AFTER UPLOADING A NEW VIDEO
$CountLastVideo = $DB->execute("SELECT UNIX_TIMESTAMP(uploaded_on) as last_upl FROM videos WHERE uploaded_by = :USERNAME AND is_deleted IS NULL ORDER BY `last_upl` DESC LIMIT 1",
                      true,
                      [":USERNAME" => $_USER->Username]);
if ($DB->Row_Num > 0 && $CountLastVideo["last_upl"]+180 >= time() && $_USER->Info["is_partner"] != 1) { notification($LANGS['3mins'],"/"); exit();; }

//NO UPLOADS AT THE SAME TIME
$DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 0 AND is_deleted IS NULL LIMIT 1", true, [":USERNAME" => $_USER->Username]);
if ($DB->Row_Num > 0) {
    notification("You can't upload more than one video at the same time!","/"); exit();
}

if ($_USER->Info['is_partner'] == 0) {
$Duration = 900;
} else {
$Duration = 3601;
}

$Categories = [1 => $LANGS['cat1'], 2 => $LANGS['cat2'], 3 => $LANGS['cat3'], 4 => $LANGS['cat4'], 5 => $LANGS['cat5'], 6 => $LANGS['cat6'], 7 => $LANGS['cat7'], 8 => $LANGS['cat8'], 9 => $LANGS['cat9'], 10 => $LANGS['cat10'], 11 => $LANGS['cat11'], 12 => $LANGS['cat12'], 13 => $LANGS['cat13'], 14 => $LANGS['cat14'], 15 => $LANGS['cat15'], 16 => $LANGS['cat16'], 17 => $LANGS['cat17'], 18 => $LANGS['cat18'], 19 => $LANGS['cat19'], 20 => $LANGS['cat20'], 21 => $LANGS['cat21']];


$_PAGE = [
    "Page"          => "uploadNew",
    "Page_Type"     => "upload"
];
require "_templates/_structures/main.php";