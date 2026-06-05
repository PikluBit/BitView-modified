<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /login");
    exit();
}
if (!isset($_GET["status"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["url"])) {
    header("location: /");
    exit();
}

$_VIDEO = new Video($_GET["url"],$DB);
$_VIDEO->get_info();
$_VIDEO->check_info();

$DB->execute("SELECT blocker FROM users_block WHERE (blocker = :USERNAME AND blocked = :OTHER) OR (blocker = :OTHER AND blocked = :USERNAME)", false,
                        [
                            ":USERNAME" => $_USER->Username,
                            ":OTHER"    => $_VIDEO->Info['uploaded_by']
                        ]);

if ($DB->Row_Num > 0) {
    die();
}

if ($_VIDEO->Info['e_ratings'] != 0) {
    $Rated = $_USER->has_rated($_VIDEO);

    if ($Rated > 0 && $Rated < 3) {
        $OG_Rating = 1;
    }
    else {
        $OG_Rating = 5;
    }

    if ($_GET['status'] == 0) {
        $Rating = 1;
    }
    else {
        $Rating = 5;
    }

    $Total_Ratings = $_VIDEO->Info["1stars"] + $_VIDEO->Info["2stars"] + $_VIDEO->Info["3stars"] + $_VIDEO->Info["4stars"] + $_VIDEO->Info["5stars"];

    $Likes = $_VIDEO->Info["3stars"] + $_VIDEO->Info["4stars"] + $_VIDEO->Info["5stars"];
    $Dislikes = $_VIDEO->Info["1stars"] + $_VIDEO->Info["2stars"];

    if (!$Rated) {
        $_USER->rate_video($_VIDEO, $Rating);
        if ($_GET['status'] == 0) {
            $Dislikes++;
            $Total_Ratings++;
        }
        else {
            $Likes++;
            $Total_Ratings++;
        }
    }
    else {
        if ($OG_Rating == $Rating) {
            $Column = $Rated."stars";
            $DB->modify("DELETE FROM videos_ratings WHERE url = :URL AND username = :USERNAME", [":URL" => $_VIDEO->URL, ":USERNAME" => $_USER->Username]);
            $DB->modify("UPDATE videos SET $Column = $Column - 1 WHERE url = :URL", [":URL" => $_VIDEO->Info['url']]);
        }
        else {
            $_USER->rate_video($_VIDEO, $Rating);
            if ($_GET['status'] == 0) {
                $Likes--;
                $Dislikes++;
            }
            else {
                $Likes++;
                $Dislikes--;
            }
        }
    }

    if ($Total_Ratings != 0) {
        $Like_Ratio = round($Likes / $Total_Ratings, 2);
        $Dislike_Ratio = round(1 - $Like_Ratio, 2);
    }
    else {
        $Like_Ratio = 1;
        $Dislike_Ratio = 0;
    }
}
?>
<div id="watch-actions-area-container">
                    <div id="watch-actions-area" class="yt-rounded"><div class="close-button" onclick="closeDiv(this);"></div>
                    <img class="watch-check-grn-circle" src="/img/check-grn-circle-vfl91176.png" style="float: left;margin-right: 8px;">
                    <?php if ($_GET['status'] == 1): ?>
                    <div><?= $LANGS['likemessage'] ?></div>
                    <?php else: ?>
                        <div><?= $LANGS['dislikemessage'] ?></div>
                    <?php endif ?>
                    <div style="margin-left: 24px;margin-top: 8px;">
                        <span style="margin-bottom: 4px; display: inline-block;"><strong><?= $LANGS['ratingsforthisvideo'] ?></strong> <span style="color:#666">(<?= str_replace("{l}", $Total_Ratings, $LANGS['liketotal']) ?>)</span></span>
                        <div style="margin-bottom: 4px;"><img src="/img/pixel.gif" class="like-icon"><span class="like-amount"><?= $Likes ?></span><span class="like-ratio" style="width: <?= 530 * $Like_Ratio ?>px"></span></div>
                        <div style="margin-bottom: 4px;"><img src="/img/pixel.gif" class="unlike-icon"><span class="like-amount"><?= $Dislikes ?></span><span class="unlike-ratio" style="width: <?= 530 * $Dislike_Ratio ?>px"></span></div>
                    </div>
                    </div>
                </div>