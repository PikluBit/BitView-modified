<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In) { header("location: /"); exit(); } // MUST BE LOGGED IN
if (!isset($_GET["id"])){ header("location: /"); exit(); } // REQUIRES $_GET["id"]

$Bulletin = $DB->execute("SELECT * FROM bulletins WHERE id = :ID", true, [":ID" => $_GET["id"]]);

if ($DB->Row_Num > 0) {
    if ($Bulletin["by_user"] == $_USER->Username || $_USER->Is_Admin || $_USER->Is_Moderator) {
        $DB->modify("DELETE FROM bulletins_comments WHERE bulletin_id = :TOPIC", [":TOPIC" => $_GET["id"]]);
        $DB->modify("DELETE FROM bulletins WHERE id = :TOPIC", [":TOPIC" => $_GET["id"]]);
        notification($LANGS['bulletindeleted'], "/user/".$Bulletin["by_user"]); exit();
    }
}
header("location: /");