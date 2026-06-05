<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!isset($_GET["channel"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["page"])) {
    header("location: /");
    exit();
}

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

$_PROFILE = new User($_GET["channel"],$DB);
$_PROFILE->get_info();
$_USER->get_info();
$Channel = $_GET['channel'];
$Page = is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$Limit = ($Page - 1) * 10;

$Video_Comments = $DB->execute("SELECT * FROM videos_comments WHERE url = :URL ORDER BY submit_on DESC LIMIT $Limit,10", false, [":URL" => $_VIDEO->URL]);
$Comments = $DB->execute("SELECT * FROM channel_comments WHERE on_channel = :USERNAME ORDER BY submit_date DESC LIMIT $Limit,10", false, [":USERNAME" => $_PROFILE->Username]);
$Page_Amount = $_PROFILE->Info["channel_comments"] / 10;
if (is_float($Page_Amount)) { $Page_Amount = (int)$Page_Amount + 1; }
?>
<div id="commentsBoxRight" class="basicBoxes profileRightCol">
        <div class="BoxesInnerOpacity">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <?php if ($Comments) : ?>
                        <?php foreach ($Comments as $Comment) : ?>
        
        <tr class="commentsTableFull" id="cc_<?= $Comment["id"] ?>">
        <td width="60" valign="top" align="left" style="padding-bottom:15px">
            <div class="user-thumb-large" style="width:46px; height:46px;">
            <a href="/user/<?= $Comment["by_user"] ?>"><img src="<?= avatar($Comment["by_user"]) ?>"></a>
            </div>
        </td>
        <td valign="top" align="left" style="padding-bottom: 15px;">
            <div class="comment-top" style="padding-bottom: 5px;"><a href="/user/<?= $Comment["by_user"] ?>" style="font-weight: bold;"><?= displayname($Comment["by_user"]) ?></a>
<span class="labels">(<?= get_time_ago($Comment["submit_date"]) ?>)</span> <?php if ($_USER->Logged_In && ($_USER->Is_Admin || $_USER->Is_Moderator || $_USER->Username == $_PROFILE->Username || $_USER->Username == $Comment["by_user"])) : ?><span class="labels"> <a style="float:right" href="javascript:void(0)" onclick="delete_channel_comment(<?= $Comment["id"] ?>)"><?= $LANGS['delete'] ?></a></span><?php endif ?>
                <span>
                    </span>
            </div>

                <span><?= make_links_clickable(nl2br((string) $Comment["content"])) ?></span>
        </td>
        </tr>
                        <?php endforeach ?>
                        <?php if ($_USER->Logged_In) : ?>
                            <script>
                                function delete_channel_comment(id) {
                                    var url = "/a/delete_channel_comment?id="+id;
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('GET', url, true);

                                    xhr.onload = function() {
                                        if (xhr.status >= 200 && xhr.status < 400) {
                                            document.getElementById("cc_"+id).outerHTML = "";
                                            changeCommentAmount();
                                        } else {
                                            showErrorMessage();
                                        }
                                    };

                                    xhr.onerror = function() {
                                        showErrorMessage();
                                    };

                                    xhr.send();
                                }
                                function changeCommentAmount() {
                                    var x = document.getElementById('comment-amount');
                                    x.innerHTML = x.innerHTML - 1;
                                }
                            </script>
                        <?php endif ?>
                    <?php endif ?>
                <tr>
                    <td colspan="3" align="center">
                        <div class="comments-bottom" style="padding: 6px; text-align: center; font-weight: bold;">
                            <?php if (!$_USER->Logged_In) : ?>
    <a href="/login" style="font-weight: normal;"><?= $LANGS['addcomment'] ?></a><br><br>
    <?php endif ?>
                            <span style="float:right">
                            <?php if ($Page > 1):?><a href="#" id="change-page-next" style="font-weight: bold;font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif;" onclick="change_comments_page('<?= $_PROFILE->Username ?>',<?= $Page - 1 ?>); return false;"><?= $LANGS['previous'] ?></a>&nbsp;<?php endif ?><?php foreach (range(1,$Page_Amount) as $Num):?>
                            <?php if ($Num != $Page):?><a href="#" id="change-page-<?= $Num ?>" style="font-weight: bold;font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif;" onclick="change_comments_page('<?= $_PROFILE->Username ?>',<?= $Num ?>); return false;"><?= $Num ?></a>&nbsp;<?php else: ?><span id="current-page-<?= $Num ?>"><?= $Num ?></span>&nbsp;<?php endif ?>
                            <?php endforeach ?><?php if ($Page_Amount > 1 and $Page < $Page_Amount):?><a href="#" id="change-page-next" style="font-weight: bold;font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif;" onclick="change_comments_page('<?= $_PROFILE->Username ?>',<?= $Page + 1 ?>); return false;"><?= $LANGS['next'] ?></a><?php endif ?>
                        </span>
                            <?php if ($_USER->Logged_In) : ?>
                            <form action="/user/<?= $_PROFILE->Username ?>" method="POST">
<table cellpadding="4px" style="position:relative;">
    <tr>
        <td><div style="font-weight:bold;margin-bottom:4px;text-align:left;"><?= $LANGS['addacomment'] ?></div><textarea style="font-family: <?= $_PROFILE->Info["c_font"] ?>;min-width: 598px;max-width: 598px;width: 400px;" maxlength="500" name="comment" cols="66" rows="6"></textarea></td>
    </tr>
    <tr>
        <td style="text-align: left;"><input type="submit" class="yt-button yt-button-primary" name="post_comment" value="<?= $LANGS['postreplychannel'] ?>"></td>
    </tr>
</table>
</form> 
    <?php endif ?>
                        </div>
                    </td>
                </tr>
            </tbody></table>
        </div>
        <div class="basicBoxesOpacity"></div>
        <div class="loading-div" id="loading-div"><table cellspacing="0" cellpadding="0" width="638" height="808" style="
"><tbody><tr><td align="center" valign="middle"><img src="/img/icn_loading_animated.gif"></td></tr></tbody></table></div>
    </div>