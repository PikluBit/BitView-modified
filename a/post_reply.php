<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In)          { header("location: /"); exit(); } // MUST BE LOGGED IN
if (!isset($_POST["topic_id"]))  { header("location: /"); exit(); } // MUST HAVE $_POST["topic_id"]
if (!isset($_POST["reply"]))     { header("location: /"); exit(); } // MUST HAVE $_POST["reply"]



$Topic = $DB->execute("SELECT group_id FROM groups_topics WHERE id = :ID", true, [":ID" => $_POST["topic_id"]]);

if ($DB->Row_Num == 0)                  { header("location: /"); exit(); }
if (mb_strlen($_POST["reply"]) > 5000)  { header("location: /"); exit(); }

$DB->execute("SELECT member FROM groups_members WHERE member = :USERNAME AND group_id = :GROUP_ID AND accepted = 1", false, [":USERNAME" => $_USER->Username, ":GROUP_ID" => $Topic["group_id"]]);

if ($DB->Row_Num == 0) { header("location: /"); exit(); }


if (empty($_POST["reply"])) { notification($LANGS['discussionreplyempty'], $_SERVER["HTTP_REFERER"]); exit(); }


$DB->modify("INSERT INTO groups_messages (message,submit_date,topic_id,by_user) VALUES (:MESSAGE,NOW(),:ID,:USERNAME)", [":MESSAGE" => $_POST["reply"], ":ID" => $_POST["topic_id"], ":USERNAME" => $_USER->Username]);
notification($LANGS['discussionreplysubmitted'], $_SERVER["HTTP_REFERER"], "cfeeb2");