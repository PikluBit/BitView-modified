<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) { header("location: /"); exit(); }

if ($_POST['avatar_type'] == "1") {
    if ($_FILES["avatar_image"]["size"] <= 0) {
        die(json_encode(["response" => "file_error"]));
    }
    $Uploader = new upload($_FILES["avatar_image"]);
    $Uploader->file_new_name_body = $_USER->Username;
    $Uploader->image_resize            = true;
    $Uploader->file_overwrite          = true;
    $Uploader->image_x                 = 300;
    $Uploader->image_y                 = 300;
    $Uploader->image_background_color  = '#000000';
    $Uploader->image_convert           = 'jpg';
    $Uploader->image_ratio_fill        = false;
    $Uploader->file_max_size           = 2000000;
    $Uploader->jpeg_quality            = 80;
    $Uploader->allowed                 = ['image/jpeg','image/pjpeg','image/png','image/bmp','image/x-windows-bmp'];
    $Uploader->process($_SERVER['DOCUMENT_ROOT']."/u/av/");
    if ($Uploader->processed) {
        $DB->modify("UPDATE users SET avatar = :USERNAME WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
        $DB->modify("UPDATE users SET is_avatar_video = '0' WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
        die(json_encode(["response" => "success"]));
    } else {
        die(json_encode(["response" => "error"]));
    }
}
elseif ($_POST['avatar_type'] == "2") {
    $_VIDEO = new Video($_POST["still-url"], $DB);
    if ($_VIDEO->exists()) {
        $_VIDEO->get_info();

        if ($_USER->Username == $_VIDEO->Info["uploaded_by"]) {
            if ($_USER->change_avatar($_VIDEO)) {
                die(json_encode(["response" => "success"]));
            }
        }
    }
    die(json_encode(["response" => "error"]));
}
else {
    $DB->modify("UPDATE users SET avatar = NULL WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
    $DB->modify("UPDATE users SET is_avatar_video = '0' WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
    unlink($_SERVER['DOCUMENT_ROOT'].'/u/av/'.$_USER->Username.'.jpg');
    die(json_encode(["response" => "success"]));
}

die(json_encode(["response" => "error"]));