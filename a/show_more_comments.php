\<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

if (!isset($_GET["url"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["limit"])) {
    header("location: /");
    exit();
}

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

$_VIDEO = new Video($_GET["url"],$DB);
$_VIDEO->get_info();
$_VIDEO->check_info();
$_USER->get_info();
$_OWNER = new User($_VIDEO->Info["uploaded_by"],$DB);
$_OWNER->get_info();
$URL = $_GET['url'];
$Limit = $_GET['limit'];

$Video_Comments = $DB->execute("SELECT * FROM videos_comments WHERE url = :URL ORDER BY submit_on DESC LIMIT :LIMIT,10", false, [":URL" => $_VIDEO->URL,":LIMIT" => $Limit]);
?>
<?php foreach ($Video_Comments as $Video_Comment) : ?>
                    <?php if ($Video_Comment['spam'] < 2) : ?>
                    <div id="cid_<?= $Video_Comment["id"] ?>" class="watch-comment-entry">
                        <div class="watch-comment-head" <?php if ($Video_Comment["by_user"] == "vistafan12" || $Video_Comment["by_user"] == "BitView" || $Video_Comment["by_user"] == "Herotrap" || $Video_Comment["by_user"] == "sks2002" || $Video_Comment["by_user"] == "OkayHush") : ?>style="background:#d2ebff !important;"<?php elseif($Video_Comment["by_user"] == $_OWNER->Username) : ?>style="background-color: #fffcc2;"<?php endif?>>
                            <div class="watch-comment-info">
                                <a class="watch-comment-auth" href="/user/<?= $Video_Comment["by_user"] ?>" rel="nofollow"><?= displayname($Video_Comment["by_user"]) ?></a>
                                <span class="watch-comment-time"> (<?= get_time_ago($Video_Comment["submit_on"]) ?>) </span>
                                <a id="show_link_commentid" class="watch-comment-head-link" onclick="">Show</a>
                                <a id="hide_link_commentid" class="watch-comment-head-link" onclick="">Hide</a>
                            </div>
                            <?php $Comment_Score = $Video_Comment['likes']-$Video_Comment['dislikes']; if ($Comment_Score > 0) {$Comment_Score = "+".$Comment_Score; }?>
                            <?php if (!$_USER->Logged_In): ?>
                            <div id="comment_vote_<?= $Video_Comment["id"] ?>" class="watch-comment-voting">

                            <span class="watch-comment-score watch-comment-<?php if ($Comment_Score > 0): ?>green<?php elseif ($Comment_Score == 0): ?>gray<?php else: ?>red<?php endif?>"><?= $Comment_Score ?></span>

                            <a href="/login"><button class="watch-comment-down" title="<?= $LANGS['poorcomment'] ?>" onmouseover="displayLoginMsg('<?= $Video_Comment["id"] ?>', 1);" onmouseout="displayLoginMsg('<?= $Video_Comment["id"] ?>', 0);"></button></a>
                            <a href="/login"><button class="watch-comment-up" title="<?= $LANGS['goodcomment'] ?>" onmouseover="displayLoginMsg('<?= $Video_Comment["id"] ?>', 1);" onmouseout="displayLoginMsg('<?= $Video_Comment["id"] ?>', 0);"></button></a>
                                    <span id="comment_msg_<?= $Video_Comment["id"] ?>" class="watch-comment-msg" style="display: none;"><?= $LANGS['pleasesignin'] ?></span>

                                </div>
                            <?php else: ?>
                            <?php $User_Has_Voted = $DB->execute("SELECT rating FROM comment_votes WHERE id = :ID and by_user = :USERNAME", true, array(":ID" => $Video_Comment['id'], ":USERNAME" => $_USER->Username)); if (!isset($User_Has_Voted['rating'])) {$User_Has_Voted['rating'] = 2;}?>
                                <div class="watch-comment-voting">
                                    <span id="watch-comment-score-<?= $Video_Comment['id'] ?>" class="watch-comment-score watch-comment-<?php if ($Comment_Score > 0): ?>green<?php elseif ($Comment_Score == 0): ?>gray<?php else: ?>red<?php endif?>"><span id="comment-rating-<?= $Video_Comment['id'] ?>"><?= $Comment_Score ?></span></span>
                                    <a href="#"><button id="watch-comment-down-<?php if ($User_Has_Voted['rating'] == 0): ?>on<?php else: ?>hover<?php endif?>-<?= $Video_Comment['id'] ?>" class="watch-comment-down-<?php if ($User_Has_Voted['rating'] == 0): ?>on<?php else: ?>hover<?php endif?>" title="Poor comment" onclick="rateComment('<?= $Video_Comment["id"] ?>',0);return false"></button></a>
                                    <a href="#"><button id="watch-comment-up-<?php if ($User_Has_Voted['rating'] == 1): ?>on<?php else: ?>hover<?php endif?>-<?= $Video_Comment['id'] ?>" class="watch-comment-up-<?php if ($User_Has_Voted['rating'] == 1): ?>on<?php else: ?>hover<?php endif?>" title="Good comment" onclick="rateComment('<?= $Video_Comment["id"] ?>',1);return false"></button></a>
                                    <span class="watch-comment-msg"></span>
                                </div>
                            <?php endif ?>
                            <div id="reply_comment_form_id_commentid" class="watch-comment-action">
                                <?php if ($_USER->Logged_In && (($_USER->Is_Admin || $_USER->Is_Moderator) || ($_USER->Username == $_VIDEO->Info["uploaded_by"]) || ($_USER->Username == $Video_Comment["by_user"]) )) : ?>
                                    <a href="javascript:void(0)" onclick="delete_comment(<?= $Video_Comment["id"] ?>)"><?= $LANGS['delete'] ?></a> |
                                <?php endif ?>
                                <a onclick="document.getElementById('comment_text').value = '@<?= $Video_Comment["by_user"] ?> ';" <?php if (!$_USER->Logged_In) : ?>href="/login"<?php endif?>><?= $LANGS['reply'] ?></a>
                                <?php $User_Has_Marked = $DB->execute("SELECT * FROM videos_spam WHERE id = :ID and by_user = :USERNAME", true, [":ID" => $Video_Comment['id'], ":USERNAME" => $_USER->Username]); if ($_USER->Logged_In and !$User_Has_Marked) : ?>
                                    | <a href="javascript:void(0)" id="mark-spam-button-<?= $Video_Comment['id'] ?>" onclick="mark_as_spam(<?= $Video_Comment["id"] ?>)"><?= $LANGS['spambutton'] ?></a>
                                    <span id="comment_spam_bug_commentid_<?= $Video_Comment['id'] ?>" class="watch-comment-spam-bug" style="margin-left: 4px;"><?= $LANGS['marked'] ?></span>
                                <?php elseif ($_USER->Logged_In and $User_Has_Marked) : ?>
                                    | <a href="javascript:void(0)" id="not-spam-button-<?= $Video_Comment['id'] ?>" onclick="not_spam(<?= $Video_Comment["id"] ?>)"><?= $LANGS['notspambutton'] ?></a>
                                    <a href="javascript:void(0)" style="display:none" id="mark-spam-button-<?= $Video_Comment['id'] ?>" onclick="mark_as_spam(<?= $Video_Comment["id"] ?>)"><?= $LANGS['spambutton'] ?></a>
                                    <span id="comment_spam_bug_commentid_<?= $Video_Comment['id'] ?>" class="watch-comment-spam-bug" style="margin-left: 4px;"><?= $LANGS['marked'] ?></span>
                                <?php endif ?>
                            </div>
                            <div class="clearL"></div>
                        </div>
                        <div id="comment_body_commentid">
                            <div class="watch-comment-body">
                                <?= make_user_clickable(make_links_clickable(nl2br((string) $Video_Comment["content"]))) ?>
                            </div>
                            <div id="div_comment_form_id_commentid"></div>
                        </div>
                    </div>
                <?php else: ?>
                <div class="watch-comment-head watch-comment-marked-spam smallText opacity30" id="spam_comment_btn_<?= $Video_Comment['id'] ?>"><?= $LANGS['commentsspam'] ?> <a href="#" class="hLink smallText" onclick="show_spam_comment('<?= $Video_Comment['id'] ?>'); return false;" rel="nofollow"><?= $LANGS['spamshow'] ?></a>
                </div>
                <div class="watch-comment-head watch-comment-marked-spam smallText opacity80" id="spam_comment_hide_btn_<?= $Video_Comment['id'] ?>" style="display: none;">
                <?= $LANGS['commentsspam'] ?> <a href="#" class="hLink smallText" onclick="hide_spam_comment('<?= $Video_Comment['id'] ?>'); return false;" rel="nofollow"><?= $LANGS['spamhide'] ?></a>
                </div>
                <div class="watch-comment-spam" id="spam_comment_<?= $Video_Comment['id'] ?>" style="display: none;">
                    <div id="cid_<?= $Video_Comment["id"] ?>" class="watch-comment-entry">
                        <div class="watch-comment-head" <?php if ($Video_Comment["by_user"] == "vistafan12" || $Video_Comment["by_user"] == "BitView" || $Video_Comment["by_user"] == "Herotrap" || $Video_Comment["by_user"] == "sks2002" || $Video_Comment["by_user"] == "OkayHush") : ?>style="background:#d2ebff !important;"<?php elseif($Video_Comment["by_user"] == $_OWNER->Username) : ?>style="background-color: #fffcc2;"<?php endif?>>
                            <div class="watch-comment-info">
                                <a class="watch-comment-auth" href="/user/<?= $Video_Comment["by_user"] ?>" rel="nofollow"><?= displayname($Video_Comment["by_user"]) ?></a>
                                <span class="watch-comment-time"> (<?= get_time_ago($Video_Comment["submit_on"]) ?>) </span>
                                <a id="show_link_commentid" class="watch-comment-head-link" onclick="">Show</a>
                                <a id="hide_link_commentid" class="watch-comment-head-link" onclick="">Hide</a>
                            </div>
                            <?php $Comment_Score = $Video_Comment['likes']-$Video_Comment['dislikes']; if ($Comment_Score > 0) {$Comment_Score = "+".$Comment_Score; }?>
                            <?php if (!$_USER->Logged_In): ?>
                            <div id="comment_vote_<?= $Video_Comment["id"] ?>" class="watch-comment-voting">

                            <span class="watch-comment-score watch-comment-<?php if ($Comment_Score > 0): ?>green<?php elseif ($Comment_Score == 0): ?>gray<?php else: ?>red<?php endif?>"><?= $Comment_Score ?></span>

                            <a href="/login"><button class="watch-comment-down" title="<?= $LANGS['poorcomment'] ?>" onmouseover="displayLoginMsg('<?= $Video_Comment["id"] ?>', 1);" onmouseout="displayLoginMsg('<?= $Video_Comment["id"] ?>', 0);"></button></a>
                            <a href="/login"><button class="watch-comment-up" title="<?= $LANGS['goodcomment'] ?>" onmouseover="displayLoginMsg('<?= $Video_Comment["id"] ?>', 1);" onmouseout="displayLoginMsg('<?= $Video_Comment["id"] ?>', 0);"></button></a>
                                    <span id="comment_msg_<?= $Video_Comment["id"] ?>" class="watch-comment-msg" style="display: none;"><?= $LANGS['pleasesignin'] ?></span>

                                </div>
                            <?php else: ?>
                            <?php $User_Has_Voted = $DB->execute("SELECT rating FROM comment_votes WHERE id = :ID and by_user = :USERNAME", true, array(":ID" => $Video_Comment['id'], ":USERNAME" => $_USER->Username)); if (!isset($User_Has_Voted['rating'])) {$User_Has_Voted['rating'] = 2;}?>
                                <div class="watch-comment-voting">
                                    <span id="watch-comment-score-<?= $Video_Comment['id'] ?>" class="watch-comment-score watch-comment-<?php if ($Comment_Score > 0): ?>green<?php elseif ($Comment_Score == 0): ?>gray<?php else: ?>red<?php endif?>"><span id="comment-rating-<?= $Video_Comment['id'] ?>"><?= $Comment_Score ?></span></span>
                                    <a href="#"><button id="watch-comment-down-<?php if ($User_Has_Voted['rating'] == 0): ?>on<?php else: ?>hover<?php endif?>-<?= $Video_Comment['id'] ?>" class="watch-comment-down-<?php if ($User_Has_Voted['rating'] == 0): ?>on<?php else: ?>hover<?php endif?>" title="Poor comment" onclick="rateComment('<?= $Video_Comment["id"] ?>',0);return false"></button></a>
                                    <a href="#"><button id="watch-comment-up-<?php if ($User_Has_Voted['rating'] == 1): ?>on<?php else: ?>hover<?php endif?>-<?= $Video_Comment['id'] ?>" class="watch-comment-up-<?php if ($User_Has_Voted['rating'] == 1): ?>on<?php else: ?>hover<?php endif?>" title="Good comment" onclick="rateComment('<?= $Video_Comment["id"] ?>',1);return false"></button></a>
                                    <span class="watch-comment-msg"></span>
                                </div>
                            <?php endif ?>
                            <div id="reply_comment_form_id_commentid" class="watch-comment-action">
                                <?php if ($_USER->Logged_In && (($_USER->Is_Admin || $_USER->Is_Moderator) || ($_USER->Username == $_VIDEO->Info["uploaded_by"]) || ($_USER->Username == $Video_Comment["by_user"]) )) : ?>
                                    <a href="javascript:void(0)" onclick="delete_comment(<?= $Video_Comment["id"] ?>)"><?= $LANGS['delete'] ?></a> |
                                <?php endif ?>
                                <a onclick="document.getElementById('comment_text').value = '@<?= $Video_Comment["by_user"] ?> ';" <?php if (!$_USER->Logged_In) : ?>href="/login"<?php endif?>><?= $LANGS['reply'] ?></a>
                                <?php $User_Has_Marked = $DB->execute("SELECT * FROM videos_spam WHERE id = :ID and by_user = :USERNAME", true, [":ID" => $Video_Comment['id'], ":USERNAME" => $_USER->Username]); if ($_USER->Logged_In and !$User_Has_Marked) : ?>
                                    | <a href="javascript:void(0)" id="mark-spam-button-<?= $Video_Comment['id'] ?>" onclick="mark_as_spam(<?= $Video_Comment["id"] ?>)"><?= $LANGS['spambutton'] ?></a>
                                    <span id="comment_spam_bug_commentid_<?= $Video_Comment['id'] ?>" class="watch-comment-spam-bug" style="margin-left: 4px;"><?= $LANGS['marked'] ?></span>
                                <?php elseif ($_USER->Logged_In and $User_Has_Marked) : ?>
                                    | <a href="javascript:void(0)" id="not-spam-button-<?= $Video_Comment['id'] ?>" onclick="not_spam(<?= $Video_Comment["id"] ?>)"><?= $LANGS['notspambutton'] ?></a>
                                    <a href="javascript:void(0)" style="display:none" id="mark-spam-button-<?= $Video_Comment['id'] ?>" onclick="mark_as_spam(<?= $Video_Comment["id"] ?>)"><?= $LANGS['spambutton'] ?></a>
                                    <span id="comment_spam_bug_commentid_<?= $Video_Comment['id'] ?>" class="watch-comment-spam-bug" style="margin-left: 4px;"><?= $LANGS['marked'] ?></span>
                                <?php endif ?>
                            </div>
                            <div class="clearL"></div>
                        </div>
                        <div id="comment_body_commentid">
                            <div class="watch-comment-body">
                                <?= make_user_clickable(make_links_clickable(nl2br((string) $Video_Comment["content"]))) ?>
                            </div>
                            <div id="div_comment_form_id_commentid"></div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php endforeach ?>