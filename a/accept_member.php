<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In)     { header("location: /"); exit(); } // MUST BE LOGGED IN
if (!isset($_GET["user"]))  { header("location: /"); exit(); } // REQUIRES $_GET["user"]
if (!isset($_GET["id"]))    { header("location: /"); exit(); } // REQUIRED $_GET["id"]

$Group_Owner = $DB->execute("SELECT groups.created_by FROM groups INNER JOIN groups_members ON groups_members.group_id = groups.id WHERE groups.id = :ID AND groups_members.member = :MEMBER", true, [":ID" => $_GET["id"], ":MEMBER" => $_GET["user"]])["created_by"];

if ($DB->Row_Num > 0) {
    if ($Group_Owner == $_USER->Username) {
        $DB->modify("UPDATE groups_members SET accepted = 1 WHERE member = :MEMBER AND group_id = :ID", [":MEMBER" => $_GET["user"], ":ID" => $_GET["id"]]);
        notification($LANGS['memberaccepted1'].' '.$_GET["user"].' '.$LANGS['memberaccepted2'], $_SERVER["HTTP_REFERER"], "cfeeb2"); exit();
    }
}

header("location: /");
