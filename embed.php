<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////"$_GET["v"]" MUST NOT BE LOGGED IN
if (!isset($_GET["v"])) {
    header("location: /");
    exit();
}


$_VIDEO = new Video($_GET["v"], $DB);

if ($_VIDEO->exists()) {
    $Exists = 1;
    $_VIDEO->get_info();
    $_VIDEO->check_info();
} else {
    $Exists = 0;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <style>
        body {
            margin:0;
            width:100%;
            height:100%;
            background: black;
        }
        .videocontainer {
            width:100% !important;
            height:100% !important;
        }
        .vlPlayer2007 {
        position: inherit !important;
        }
        .vlPlayer {
        position: inherit !important;
        }
    </style>
</head>
<body>
<?php if ($Exists == 1) : ?>
    <?php if (!isset($_GET["wt"])) : ?>
        <a href="https://bitview.net/watch?v=<?= $_VIDEO->Info["url"] ?>" style="display:block;position:absolute;z-index:100000000;top: 6px;left: 6px;font-family: Arial,sans-serif;background: #00000070;padding: 2px 6px;color: white;font-size: 14px;font-weight: bold;border-radius: 4px 4px 4px 0;text-decoration: none;" target="_parent"><?= $_VIDEO->Info["title"] ?></a>
        <a href="https://bitview.net/user/<?= $_VIDEO->Info["uploaded_by"] ?>" style="display:block;position:absolute;z-index:100000000;top: 26px;left: 6px;font-family: Arial,sans-serif;background: #00000070;padding: 2px 6px;color: white;font-size: 13px;font-weight: normal;border-radius: 0px 0px 4px 4px;text-decoration: none;" target="_parent"><?= displayname($_VIDEO->Info["uploaded_by"]) ?></a>
    <a style="display:block;position:absolute;z-index:100000000;bottom: 36px;right: 8px;" href="http://www.bitview.net/" target="_parent"><img style="opacity:0.7" src="http://www.bitview.net/img/bitview_transparent.png?2" width="100"></a>
    <?php $_VIDEO->show_video(111, 111, false, $LANGS) ?>
    <style>
    object {
        width:100% !important;
        height:100vh !important;
    }
    </style>
    <?php else : ?>
    <video autoplay style="width:100%;height:100vh">
        <source src="http://www.bitview.net/videos/<?= $_VIDEO->Info["file_url"] ?>.mp4" type="video/mp4"></source>
    </video>
    <?php endif ?>
<?php else: ?>
    <a style="display:block;position:absolute;z-index:100000000;bottom: 36px;right: 8px;" href="http://www.bitview.net/" target="_parent"><img style="opacity:0.7" src="http://www.bitview.net/img/bitview_transparent.png?2" width="100"></a>
    <center style="color: #fff; font-family: Arial, sans-serif;">We're sorry, this video is not available.</center>
<?php endif ?>
</body>
</html>