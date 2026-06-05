<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In)         exit();

$file = $DB->execute("SELECT converting.*, videos.file_url FROM converting INNER JOIN videos ON converting.url = videos.url WHERE videos.uploaded_by = :USERNAME ORDER BY converting.date LIMIT 1", true, [":USERNAME" => $_USER->Username]);
if ($file && $file["status"] == 0) {
    $URL        = $file["url"];
    $FILE_URL   = $file["file_url"];
    $Video_File = glob($_SERVER['DOCUMENT_ROOT']."/u/tmp/$FILE_URL.*")[0];
    $Video           = new ffmpeg();
    $Video->Location = $Video_File;
    $Length          = $Video->Get_Length(true) - 1;
    $VSec            = 0;
    $Video->Get_Info();
    for ($i = 0; $i < 5; $i++) {
        $VSec += round($Length / 5);
        $Video->Preview($VSec, $URL, $i);
    }
    echo "success";
}
else {
    echo "error";
}