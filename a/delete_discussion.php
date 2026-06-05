<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In) { header("location: /"); exit(); } // MUST BE LOGGED IN
if (!isset($_GET["id"])){ header("location: /"); exit(); } // REQUIRES $_GET["id"]


$Topic = $DB->execute("SELECT groups.created_by, groups.id FROM groups_topics INNER JOIN groups ON groups_topics.group_id = groups.id WHERE groups_topics.id = :ID", true, [":ID" => $_GET["id"]]);

if ($DB->Row_Num > 0) {
    if ($Topic["created_by"] == $_USER->Username || $_USER->Is_Admin || $_USER->Is_Moderator) {
        $DB->modify("DELETE FROM groups_messages WHERE topic_id = :TOPIC", [":TOPIC" => $_GET["id"]]);
        $DB->modify("DELETE FROM groups_topics WHERE id = :TOPIC", [":TOPIC" => $_GET["id"]]);
        notification($LANGS['discussiondeleted'], "/group?id=".$Topic["id"]); exit();
    }
}
header("location: /");