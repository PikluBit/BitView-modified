<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["module"] AND $_GET["num"]
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (!isset($_GET["module"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["num"])) {
    header("location: /");
    exit();
}

$_USER->get_info();
$Module = $_GET['module'];
$Num = $_GET['num'];

if ($Module == "h_activity") {
    $Friends = $_USER->get_friends(1000, true);
    $Friends_Array  = [];
    foreach($Friends as $Array) {
        $Friends_Array[] = $Array["username"];
    }
    $SQL_Friends  = sql_IN_fix($Friends_Array);

    if ($SQL_Friends) {
    //BULLETINS
    $SELECT = "SELECT 'bulletin' as type_name, by_user as id, content, submit_date as date, url as title, 'a' as video_by, 'a' as video_uploader, id as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM bulletins_new WHERE by_user IN ($SQL_Friends)";
    //COMMENTS
    $SELECT .= " UNION ALL SELECT 'comment' as type_name, videos.url as id, videos_comments.content as content, videos_comments.submit_on as date, videos.title as title, videos_comments.by_user as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_comments INNER JOIN videos ON videos_comments.url = videos.url WHERE by_user IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1";
    //RATINGS
    $SELECT .= " UNION ALL SELECT 'rating' as type_name, videos.url as id, videos_ratings.rating as content, videos_ratings.submit_date as date, videos.title as title, videos_ratings.username as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_ratings INNER JOIN videos ON videos_ratings.url = videos.url WHERE username IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1";
    //FAVORITES
    $SELECT .= " UNION ALL SELECT 'favorite' as type_name, videos.url as id, 'a' as content, videos_favorites.submit_on as date, videos.title as title, videos_favorites.username as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_favorites INNER JOIN videos ON videos_favorites.url = videos.url WHERE username IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1";
    //UPLOADS
    $SELECT .= " UNION ALL SELECT 'uploaded' as type_name, url as id, description as comment, uploaded_on as date, title as title, uploaded_by as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, uploaded_on as upload_date, videos.views as views FROM videos WHERE uploaded_by IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1";
    //SUBSCRIPTIONS
    $SELECT .= " UNION ALL SELECT 'subscription' as type_name, subscriber as id, subscription as content, submit_date as date, '' as title, 'a' as video_by, 'a' as video_uploader, 'a' as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM subscriptions WHERE subscriber IN ($SQL_Friends)";
    //FRIENDS
    $SELECT .= "UNION ALL SELECT 'friend' as type_name, friend_1 as id, friend_2 as content, submit_on, '' as title, 'a' as video_by, 'a' as video_uploader, 'a' as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM users_friends as date WHERE (friend_1 IN ($SQL_Friends) OR friend_2 IN ($SQL_Friends)) AND status = 1 ";
    $Friends_Activity = $DB->execute("$SELECT ORDER BY date DESC LIMIT " . (is_numeric($Num) ? (int)$Num : 0));
    $DB->modify("UPDATE users SET h_activity_limit = :LIMIT WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":LIMIT" => $Num]);
}
}
?>
<div class="homepage-sub-block-contents" id="homepage-sub-block-contents-h_activity" style="max-height: revert;padding: 0px 0px 0px 0px;">
            <?php if (isset($Friends_Activity) && count($Friends_Activity) > 0) : ?>
                    <?php $Amount = count($Friends_Activity) ?>
                    <?php $Count = 0 ?>
                    <?php foreach ($Friends_Activity as $Activity) : ?>
                        <?php $Count++ ?>
                        <?php if ($Activity["type_name"] == "comment") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-C" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Activity['video_by'] ?>"><?= displayname($Activity['video_by']) ?></a> <?= $LANGS['activitycomment'] ?> <a id="video-long-title" href="/watch?v=<?= $Activity["id"] ?>" title="<?= $Activity["title"] ?>" rel="nofollow"><?= short_title($Activity["title"],20) ?></a>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    <div class="video-entry">
                                        <?= load_thumbnail($Activity["id"]) ?>
                                        <div class="video-main-content" id="video-main-content" style="width: 440px;padding-left: 12px;">
                                            <i>"<?= short_title(nl2br((string) $Activity['content']),300) ?>"</i>
                                        <div class="video-clear-list-left"></div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ($Activity["type_name"] == "bulletin") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-BUL" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Activity['id'] ?>"><?= displayname($Activity['id']) ?></a> 
                                </span> <span id="bulletin-content"><?= nl2br((string) $Activity['content']) ?> </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                <?= videoEntry($Activity['title'], 440, false) ?>
                            </div> 
                        <?php elseif ($Activity["type_name"] == "rating") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-E" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Activity['video_by'] ?>"><?= displayname($Activity['video_by']) ?></a> <?= $LANGS['activitylike'] ?>&nbsp;
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                <?= videoEntry($Activity['id'], 440, false) ?>
                            </div>
                        <?php elseif ($Activity["type_name"] == "uploaded") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-U" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Activity['video_by'] ?>"><?= displayname($Activity['video_by']) ?></a> <?= $LANGS['activityupload'] ?>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                <?= videoEntry($Activity['id'], 440, false) ?>
                            </div>
                        <?php elseif ($Activity["type_name"] == "friend") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-FRI" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Activity['id'] ?>"><?= displayname($Activity['id']) ?></a> <?= $LANGS['activityfriend'] ?> <a id="video-long-title" href="/user/<?= $Activity['content'] ?>" rel="nofollow"><?= displayname($Activity["content"]) ?></a>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                            </div> 
                        <?php elseif ($Activity["type_name"] == "favorite") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-F" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Activity['video_by'] ?>"><?= displayname($Activity['video_by']) ?></a> <?= $LANGS['activityfavorite'] ?>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                <?= videoEntry($Activity['id'], 440, false) ?>
                            </div>
                        <?php elseif ($Activity["type_name"] == "subscription") : ?>
                               <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-S" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Activity['id'] ?>"><?= displayname($Activity['id']) ?></a> <?= $LANGS['activitysubscription'] ?> <a id="video-long-title" href="/user/<?= $Activity['content'] ?>" rel="nofollow"><?= displayname($Activity["content"]) ?></a>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                            </div> 
                        <?php endif ?>
                    <?php endforeach ?>
                <?php else : ?>
                    <strong><?= $LANGS['homenofriendactivity'] ?></strong><br>
        <span style="color: #666;margin-bottom: 5px;display: inline-block;"><?= $LANGS['homenofriendactivitydesc'] ?></span>
                <?php endif ?>
        <div class="clearL" style="height: 1px;"></div>
        </div>