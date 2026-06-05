<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In) { header("location: /"); exit(); } // MUST BE LOGGED IN
if (!isset($_GET["id"])){ header("location: /"); exit(); } // REQUIRES $_GET["id"]


$Message = $DB->execute("SELECT * FROM groups_messages WHERE id = :ID", true, [":ID" => $_GET["id"]]);

if ($DB->Row_Num > 0) {
    $First_Message = $DB->execute("SELECT id FROM groups_messages WHERE topic_id = :TOPIC", true, [":TOPIC" => $Message["topic_id"]])["id"];
    $Owner         = $DB->execute("SELECT groups.created_by FROM groups INNER JOIN groups_topics ON groups_topics.group_id = groups.id WHERE groups_topics.id = :TOPIC", true, [":TOPIC" => $Message["topic_id"]])["created_by"];

    if ($First_Message != $Message["id"] && ($_USER->Username == $Message["by_user"] || $_USER->Username == $Owner || $_USER->Is_Admin || $_USER->Is_Moderator)) {
        $DB->modify("DELETE FROM groups_messages WHERE id = :ID", [":ID" => $_GET["id"]]);
        notification($LANGS['messagedeleted'], $_SERVER["HTTP_REFERER"], "008000"); exit();
    }
}
header("location: /");