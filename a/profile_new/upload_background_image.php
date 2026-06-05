<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";

if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

echo print_r($_FILES);

$Uploader = new upload($_FILES["file"]);
$Uploader->file_new_name_body      = $_USER->Username;
$Uploader->file_overwrite          = true;
$Uploader->image_background_color  = '#000000';
$Uploader->image_convert           = 'jpg';
$Uploader->image_ratio_fill        = false;
$Uploader->file_max_size           = 2000000;
$Uploader->jpeg_quality            = 85;
$Uploader->allowed                 = ['image/jpeg','image/pjpeg','image/png','image/bmp','image/x-windows-bmp'];
$Uploader->process($_SERVER['DOCUMENT_ROOT'] . '/u/bck');
if ($Uploader->processed) {
$DB->modify("UPDATE users SET c_background_image = :FILENAME WHERE username = :USERNAME",[":FILENAME" => "/u/bck/".$_USER->Username.".jpg", ":USERNAME" => $_USER->Username]);
}

?>