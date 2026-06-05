<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//MUST BE LOGGED IN
//REQUIRES $_GET["group"]
//MUST COME FROM A GROUP PAGE
if (!$_USER->Logged_In)                                           { header("location: /"); exit(); }
if (!isset($_GET["group"]))                                       { header("location: /"); exit(); }
if (!str_contains((string) $_SERVER["HTTP_REFERER"],"group"))     { header("location: /"); exit(); }

$Group = $DB->execute("SELECT instant_join, created_by FROM groups WHERE id = :ID", true, [":ID" => $_GET["group"]]);
if ($DB->Row_Num > 0) {
    $DB->execute("SELECT accepted FROM groups_members WHERE member = :USERNAME AND group_id = :ID", true, [":USERNAME" => $_USER->Username, ":ID" => $_GET["group"]]);
    if ($DB->Row_Num == 0) {
        if ($Group["instant_join"] == 1) {
            $DB->modify("INSERT INTO groups_members (member,group_id,accepted,submit_date) VALUES (:USERNAME,:ID,1,NOW())", [":USERNAME" => $_USER->Username, ":ID" => $_GET["group"]]);
            notification($LANGS['joinedgroup'], "/group?id=".$_GET["group"], "cfeeb2"); exit();
        } else {
            $DB->modify("INSERT INTO groups_members (member,group_id,accepted,submit_date) VALUES (:USERNAME,:ID,0,NOW())", [":USERNAME" => $_USER->Username, ":ID" => $_GET["group"]]);
            notification($LANGS['grouprequest'], "/group?id=".$_GET["group"], "cfeeb2"); exit();
        }
    } elseif ($Group["created_by"] === $_USER->Username) {
            notification("You can't leave a group you created!", "/group?id=".$_GET["group"]); exit();
    } else {
        $DB->modify("DELETE FROM groups_members WHERE member = :USERNAME AND group_id = :ID", [":USERNAME" => $_USER->Username, ":ID" => $_GET["group"]]);
        notification($LANGS['leftgroup'], "/group?id=".$_GET["group"], "cfeeb2"); exit();
    }
}
header("location: /");
