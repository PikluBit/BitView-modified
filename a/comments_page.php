<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["url"]
if (!isset($_GET["url"])) { header("location: /"); exit();}

function make_links_clickable($text) {
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

$_VIDEO = new Video($_GET["url"],$DB);

if ($_VIDEO->exists()) {
    $_VIDEO->get_info();
    $_VIDEO->check_info();
    $_PAGINATION = new Pagination(10, 1000);
    $_PAGINATION->total($_VIDEO->Info["comments"]);
    $_PAGINATION->Current_Page = intval($_GET['page']);
    $From = ($_GET['page'] - 1) * 10;
    if ($_VIDEO->Info["comments"] > 0) { $Video_Comments = $_VIDEO->comments(true,1,10,$From); }
}

?>
<ul id="recent-comments" style="margin:0">
    <?php if ($Video_Comments): ?>
        <?php foreach ($Video_Comments as $Comment): ?>
            <?php $User_Vote = $DB->execute("SELECT rating FROM comment_votes WHERE id = :ID and by_user = :USERNAME", true, [":ID" => $Comment['id'], ":USERNAME" => $_USER->Username]); if (!isset($User_Vote['rating'])) {$User_Vote['rating'] = 2;} ?>
            <?php $Comment_Score = $Comment['likes'] - $Comment['dislikes'];?>
            <?php $User_Has_Marked = $DB->execute("SELECT * FROM videos_spam WHERE id = :ID and by_user = :USERNAME", true, [":ID" => $Comment['id'], ":USERNAME" => $_USER->Username]); if ($User_Has_Marked) { $User_Has_Marked = 1; } else { $User_Has_Marked = 0; } ?>
            <li data-id="<?= $Comment['id'] ?>" data-score="<?= $Comment_Score ?>" user-flag="<?= $User_Has_Marked ?>" user-score="<?= $User_Vote['rating'] ?>" data-author="<?= displayname($Comment['by_user']) ?>" onmouseover="showActions(this);" class="comment">
                <?php if ($Comment['spam'] > 1 || $User_Has_Marked == 1): ?>
                <div class="content"><i><?= $LANGS['marked'] ?></i> <a href="#" onclick="showSpam(this); return false;" rel="nofollow"><?= $LANGS['spamshow'] ?></a> <br class="spambr"><span class="hidden-comment"><?= make_user_clickable(make_links_clickable(nl2br((string) $Comment["content"]))) ?></span></div>
                <?php endif ?>

                <?php if ($Comment['spam'] < 2 && $User_Has_Marked != 1) : ?>
                <div class="content">
                    <div class="comment-text" dir="ltr">
                        <p><?= make_user_clickable(make_links_clickable(nl2br((string) $Comment["content"]))) ?></p>
                    </div>
                    <div class="metadata-inline">
                        <a class="author" href="/user/<?= $Comment['by_user'] ?>" title="<?= displayname($Comment['by_user']) ?>"><?= displayname($Comment['by_user']) ?></a>
                        <span class="time"><?= get_time_ago($Comment["submit_on"]) ?></span>
                        <?php if ($Comment_Score > 0): ?><span class="comments-rating-positive"><?= $Comment_Score ?> <img class="master-sprite comments-rating-thumbs-up" src="/img/pixel.gif">
                    </span><?php endif ?>
                    </div>
                </div>
                <?php endif ?>
                <div class="metadata" <?php if ($Comment['spam'] > 1 || $User_Has_Marked == 1): ?>style="margin-top: 6px;"<?php endif ?>>
                    <a class="author" href="/user/<?= $Comment['by_user'] ?>" title="<?= displayname($Comment['by_user']) ?>"><?= displayname($Comment['by_user']) ?></a>
                    <span class="time"><?= get_time_ago($Comment["submit_on"]) ?></span>
                    <?php if ($Comment_Score > 0): ?><span class="comments-rating-positive"><?= $Comment_Score ?> <img class="master-sprite comments-rating-thumbs-up" src="/img/pixel.gif">
                    </span><?php endif ?>
                </div>
            </li>
        <?php endforeach ?>
    <?php endif ?>
    <li class="watch-comments-pagination">
    <div class="yt-uix-pager">
        <?php $_PAGINATION->new_show_pages_videos("v=".$_GET['v'], false, true) ?>
    </div>
    </li>
    </ul>