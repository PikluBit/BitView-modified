<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In)         exit();

$file = $DB->execute("SELECT vid FROM videos_uploads WHERE username = :USERNAME ORDER BY updateDate DESC LIMIT 1", true, [":USERNAME" => $_USER->Username]);

if ($file) {
    $_VIDEO = new Video($file["vid"],$DB);
    if ($_VIDEO->exists()) {
        $_VIDEO->get_info();
        if ($_VIDEO->Info["uploaded_by"] === $_USER->Username) {
            if ($_VIDEO->delete()) {
                $DB->modify("DELETE FROM videos_uploads WHERE vid = :URL", [":URL" => $file["vid"]]);
                header("location: /my_videos_upload"); exit();
            } else {
                header("location: /"); exit();
            }
        }
    }
    header("location: /");
}