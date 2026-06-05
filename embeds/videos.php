<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////"$_GET["user"]" MUST NOT BE LOGGED IN
if (!isset($_GET["user"]) && ctype_alnum((string) $_GET["user"])) { header("location: /"); exit(); }


$OWNER = new User($_GET["user"],$DB);

if ($OWNER->exists() && !$OWNER->is_banned()) {
    $Videos = new Videos($DB,$_USER);
    $Videos->WHERE_P    = ["videos.uploaded_by" => $OWNER->Username];
    $Videos->LIMIT      = 16;
    $Videos->ORDER_BY   = "uploaded_on DESC";
    $Videos->get();

    if ($Videos::$Amount > 0) {
        $Has_Videos = true;

        $Videos_Amount = $Videos::$Amount;
        $Videos = $Videos->fix_values(true,false);
    } else {
        $Has_Videos = false;
    }
} else {
    header("location: /"); exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT']."/_templates/_heads/main.php" ?>
    <style>
        body {
            max-width: 400px !important;
            min-width: 400px !important;
            margin: 0;
        }
        .videos_box_head {
            border-bottom: 1px solid #467777;
        }
        .videos_box_conainer > div:last-of-type {
            border-left: 1px solid #518a8a;
            border-right: 1px solid #518a8a;
        }
        .my_videos_on {
            position: absolute;
            bottom: 5px;
            right: 6px;
            z-index: 100000;
            width: 200px;
        }
        .v_video_title {
            max-width: 230px;
        }
    </style>
</head>
<body>
<div class="videos_box" style="width:400px">
    <div class="videos_box_conainer" style="position: relative">
        <div class="videos_box_head">
            <div style="display:table;width:100%">
                <div>
                    My Videos
                </div>
            </div>
        </div>
        <?php if ($Has_Videos) : ?>
            <div style="overflow-y:scroll;max-height:425px;">
                <?php foreach ($Videos as $Video) : ?>
                    <div class="videos_box_in" style="padding:5px 2px 9px 5px">
                        <div style="float:left;width:115px;margin:0 10px 0 0">
                            <a href="<?= $Video["link"] ?>" target="_parent">
                                <img src="<?= $Video["thumb"] ?>" class="thumb" width="100" height="75" />
                            </a>
                        </div>
                        <div style="float:left">
                            <div class="v_video_title">
                                <a href="<?= $Video["link"] ?>" target="_parent"><?= $Video["title"] ?></a>
                            </div>
                            <div style="font-size:11px;color:#444;margin:3px 0 5px">
                                <div style="padding:0 0 2px 0">Added: <?= date("F d, Y",strtotime((string) $Video["uploaded_on"])) ?></div>
                                <div style="padding:0 0 2px 0">By: <a href="<?= $Video["uploader_link"] ?>" target="_parent"><?= $Video["uploaded_by"] ?></a></div>
                                <div style="padding:0 0 2px 0">Views: <?= $Video["views"] ?></div>
                                <div style="padding:0 0 2px 0">Comments: <?= $Video["comments"] ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                <?php if ($Videos_Amount > 2) : ?>
                <a href="http://www.bitview.net/" target="_parent"><img src="/img/my_videos_on.png" class="my_videos_on"></a>
                <?php endif ?>
            </div>
        <?php else : ?>
            <div style="font-size:13px;color:#444;text-align:center;border-bottom:1px solid #518a8a;padding:19px 0 16px">No Videos were found.</div>
        <?php endif ?>
    </div>
</div>
</body>
</html>
