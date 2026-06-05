<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//MUST BE LOGGED IN
//REQUIRES $_GET["id"]
if (!$_USER->Logged_In)  { header("location: /"); exit(); }
if (!isset($_REQUEST["id"])) { header("location: /"); exit(); }

$Group = $DB->execute("SELECT groups.* FROM groups WHERE groups.id = :ID", true, [":ID" => $_REQUEST["id"]]);

if ($DB->Row_Num == 0) { notification($LANGS['groupdoesnotexist'], "/"); exit(); }


if (isset($_POST["create_discussion"])) {
    if (mb_strlen((string) $_POST["title"]) > 100)                  { header("location: /create_discussion?id=".$_REQUEST["id"]); exit(); }
    if (mb_strlen((string) $_POST["description"]) > 5000)           { header("location: /create_discussion?id=".$_REQUEST["id"]); exit(); }

    if (mb_strlen(mb_trim((string) $_POST["title"])) <= 2)        { notification($LANGS['discussiontitle2chars'], "/create_discussion?id=".$_REQUEST["id"]); exit(); }
    if (mb_strlen(mb_trim((string) $_POST["description"])) <= 10) { notification($LANGS['discussiondesc10chars'], "/create_discussion?id=".$_REQUEST["id"]); exit(); }


    $DB->execute("SELECT id FROM groups_topics WHERE created_by = :USERNAME AND DATE(creation_date) = CURDATE()", false, [":USERNAME" => $_USER->Username]);

    if ($DB->Row_Num >= 5) { notification($LANGS['5discussionsday'], "/create_discussion?id=".$_REQUEST["id"]); exit(); }


    $DB->modify("INSERT INTO groups_topics (title,creation_date,created_by,group_id) VALUES (:TITLE,NOW(),:USERNAME,:ID)", [":TITLE" => $_POST["title"], ":USERNAME" => $_USER->Username, ":ID" => $_REQUEST["id"]]);

    if ($DB->Row_Num > 0) {
        $DB->modify("INSERT INTO groups_messages (message,submit_date,topic_id,by_user) VALUES (:MESSAGE,NOW(),:ID,:USERNAME)", [":MESSAGE" => $_POST["description"], ":ID" => $DB->last_id(), ":USERNAME" => $_USER->Username]);
        notification($LANGS['discussionsuccess'], "/group?id=".$_REQUEST["id"], "cfeeb2"); exit();
    } else {
        notification($LANGS['somethingwentwrong'], "/create_discussion?id=".$_REQUEST["id"]); exit();
    }
}


if (isset($_GET["id"])) {
    $_PAGE = [
        "Page" => "create_discussion",
        "Page_Type" => "groups",
        "Show_Search" => false,
        "new" => true
    ];
    require "_templates/_structures/main.php";
}