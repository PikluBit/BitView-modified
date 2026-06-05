<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//MUST BE LOGGED IN
//REQUIRES $_GET["group"]
//MUST COME FROM A GROUP PAGE
if (!$_USER->Logged_In)                                           { header("location: /"); exit(); }
if (!isset($_GET["group"]))                                       { header("location: /"); exit(); }
if (!str_contains((string) $_SERVER["HTTP_REFERER"],"group_moderation"))     { header("location: /"); exit(); }

$Group_Owner = $DB->execute("SELECT created_by FROM groups WHERE id = :ID", true, [":ID" => $_GET["group"]])["created_by"];

if ($DB->Row_Num > 0) {
    if ($Group_Owner === $_USER->Username || $_USER->Is_Admin || $_USER->Is_Moderator) {
        $DB->modify("DELETE FROM groups WHERE id = :ID", [":ID" => $_GET["group"]]);
        $DB->modify("DELETE FROM groups_members WHERE group_id = :ID", [":ID" => $_GET["group"]]);
        $DB->modify("DELETE groups_messages FROM groups_messages INNER JOIN groups_topics ON groups_topics.id = groups_messages.topic_id WHERE groups_topics.group_id = :ID", [":ID" => $_GET["group"]]);
        $DB->modify("DELETE FROM groups_topics WHERE group_id = :ID", [":ID" => $_GET["group"]]);
        $DB->modify("DELETE FROM groups_videos WHERE group_id = :ID", [":ID" => $_GET["group"]]);
        unlink($_SERVER['DOCUMENT_ROOT'].'/u/grp/'.(int)$_GET["group"].'.jpg');
        notification($LANGS['groupdeleted'],"/groups"); exit();
    }
}

header("location: /");
