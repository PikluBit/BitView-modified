<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

if (!$_USER->Logged_In)         exit();

$file = $DB->execute("SELECT * FROM videos_uploads WHERE username = :USERNAME ORDER BY updateDate DESC LIMIT 1", true, [":USERNAME" => $_USER->Username]);

if ($file) {
    $_VIDEO = new Video($file["vid"],$DB);
    if ($_VIDEO->exists()) {
        if ($_VIDEO->get_info() && $file['status'] == 0) {
            echo "no";
        }
        else {
            echo "yes";
        }
    }
    else {
        echo "yes";
    }
}
