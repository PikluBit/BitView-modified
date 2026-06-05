<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

$_USER->get_info();

$Page = is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$From = ($Page - 1) * 30;

if (!isset($_GET['from']) || $_GET['from'] == "all") {
    $Show = "all";
    $Feed = $DB->execute("SELECT * FROM users_friends INNER JOIN users ON users_friends.friend_1 = users.username OR users_friends.friend_2 = users.username WHERE (users_friends.friend_1 = :USERNAME OR users_friends.friend_2 = :USERNAME) AND users_friends.status = 1 ORDER BY users_friends.id DESC LIMIT 2000",false,[":USERNAME" => $_USER->Username]);

    $Feed_Array  = [];
    foreach($Feed as $Array) {
        if ($Array["username"] != $_USER->Username) {
            $Feed_Array[] = $Array["username"];
        }
    }
    $Subscriptions = $DB->execute("SELECT * FROM users INNER JOIN subscriptions ON subscriptions.subscriber = :USERNAME WHERE subscriptions.subscription = users.username AND is_banned = 0",false,[":USERNAME" => $_USER->Username]);
    $Subscriptions_Array = [];

    if ($Subscriptions) {
        foreach($Subscriptions as $Subscription) {
            $Subscriptions_Array[] = $Subscription["username"];
        }
        $SQL_Subs  = sql_IN_fix($Subscriptions_Array);
    }
    array_push($Feed_Array, $_USER->Username);

    $SQL_Friends  = sql_IN_fix($Feed_Array);
    
    if ($SQL_Friends) {
        //BULLETINS
        $SELECT = "SELECT 'bulletin' as type_name, by_user as id, content, submit_date as date, url as title, 'a' as video_by, 'a' as video_uploader, id as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM bulletins_new WHERE by_user IN ($SQL_Friends)";
        //COMMENTS
        $SELECT .= " UNION ALL SELECT 'comment' as type_name, videos.url as id, videos_comments.content as content, videos_comments.submit_on as date, videos.title as title, videos_comments.by_user as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_comments INNER JOIN videos ON videos_comments.url = videos.url WHERE by_user IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL";
        //RATINGS
        $SELECT .= " UNION ALL SELECT 'rating' as type_name, videos.url as id, videos_ratings.rating as content, videos_ratings.submit_date as date, videos.title as title, videos_ratings.username as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_ratings INNER JOIN videos ON videos_ratings.url = videos.url WHERE username IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL";
        //FAVORITES
        $SELECT .= " UNION ALL SELECT 'favorite' as type_name, videos.url as id, 'a' as content, videos_favorites.submit_on as date, videos.title as title, videos_favorites.username as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_favorites INNER JOIN videos ON videos_favorites.url = videos.url WHERE username IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL";
        //UPLOADS
        $SELECT .= " UNION ALL SELECT 'uploaded' as type_name, url as id, description as comment, uploaded_on as date, title as title, uploaded_by as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, uploaded_on as upload_date, videos.views as views FROM videos WHERE uploaded_by IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL";
        //SUBSCRIPTIONS
        $SELECT .= " UNION ALL SELECT 'subscription' as type_name, subscriber as id, subscription as content, submit_date as date, '' as title, 'a' as video_by, 'a' as video_uploader, 'a' as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM subscriptions WHERE subscriber IN ($SQL_Friends)";
        //SUBSCRIPTION VIDEOS
        if ($Subscriptions) {
        $SELECT .= " UNION ALL SELECT 'sub_videos' as type_name, url as id, description as comment, uploaded_on as date, title as title, uploaded_by as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, uploaded_on as upload_date, videos.views as views FROM videos WHERE uploaded_by IN ($SQL_Subs) AND videos.uploaded_by NOT IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL";
        }
        //FRIENDS
        $SELECT .= " UNION ALL SELECT 'friend' as type_name, friend_1 as id, friend_2 as content, submit_on, '' as title, 'a' as video_by, 'a' as video_uploader, 'a' as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM users_friends as date WHERE (friend_1 IN ($SQL_Friends) OR friend_2 IN ($SQL_Friends)) AND status = 1";
        $Feed_Activity = $DB->execute("$SELECT ORDER BY date DESC LIMIT $From,30");
        $Amount = $DB->Row_Num;
    }
}
else {
    $Show = "subscriptions";
    $Subscriptions = $DB->execute("SELECT * FROM users INNER JOIN subscriptions ON subscriptions.subscriber = :USERNAME WHERE subscriptions.subscription = users.username AND is_banned = 0",false,[":USERNAME" => $_USER->Username]);
    $Subscriptions_Array = [];

    if ($Subscriptions) {
        foreach($Subscriptions as $Subscription) {
            $Subscriptions_Array[] = $Subscription["username"];
        }
        $SQL_Subs  = sql_IN_fix($Subscriptions_Array);

    if ($SQL_Subs) {
        $SELECT = "SELECT 'sub_videos' as type_name, url as id, description as comment, uploaded_on as date, title as title, uploaded_by as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, uploaded_on as upload_date, videos.views as views FROM videos WHERE uploaded_by IN ($SQL_Subs) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL";
        $Feed_Activity = $DB->execute("$SELECT ORDER BY date DESC LIMIT $From,30");
        $Amount = $DB->Row_Num;
    }
} else {
    $Amount = 0;
}
}
?>        
<?php if ($Amount > 0) : ?>
<div class="homepage-sub-block-contents" id="page-<?= $Page ?>" style="max-height: revert; <?php if ($Page > 1): ?>margin: 0;<?php endif ?>">
                    <?php $Count = 0 ?>
                    <?php for ($i = 0; $i < $Amount; $i++) : ?>
                        <?php $Count++ ?>
                        <?php if ($Feed_Activity[$i]["type_name"] == "comment") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-C" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Feed_Activity[$i]['video_by'] ?>"><?= displayname($Feed_Activity[$i]['video_by']) ?></a> <?= $LANGS['activitycomment'] ?> <a id="video-long-title" href="/watch?v=<?= $Feed_Activity[$i]["id"] ?>" title="<?= $Feed_Activity[$i]["title"] ?>" rel="nofollow"><?= short_title($Feed_Activity[$i]["title"],20) ?></a>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Feed_Activity[$i]['date']) ?>)</span>
                                    <div class="video-entry">
                                        <?= load_thumbnail($Feed_Activity[$i]['id']) ?>
                                        <div class="video-main-content" id="video-main-content" style="width: 440px;padding-left: 12px;">
                                            <i>"<?= short_title(nl2br((string) $Feed_Activity[$i]['content']),300) ?>"</i>
                                        <div class="video-clear-list-left"></div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ($Feed_Activity[$i]["type_name"] == "bulletin") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-BUL" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Feed_Activity[$i]['id'] ?>"><?= displayname($Feed_Activity[$i]['id']) ?></a> 
                                </span> <span id="bulletin-content"><?= nl2br((string) $Feed_Activity[$i]['content']) ?> </span>
                                <span class="timestamp">(<?= get_time_ago($Feed_Activity[$i]['date']) ?>)</span>
                                <?= videoEntry($Feed_Activity[$i]['title'], 440, true) ?>
                            </div> 
                        <?php elseif ($Feed_Activity[$i]["type_name"] == "rating") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-E" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <?= str_replace("{u}",'<a href=/user/'.$Feed_Activity[$i]['video_by'].'> '. displayname($Feed_Activity[$i]['video_by']) .'</a>',$LANGS['likedby']) ?>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Feed_Activity[$i]['date']) ?>)</span>
                                <?php if (isset($Feed_Activity[$i+1]) && $Feed_Activity[$i+1]["type_name"] == "rating" && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$i+1]["video_by"]): ?>
                                    <div class="video-entry">
                                    <?php $j_count = 0; ?>
                                    <?php for ($j = $i; $j < $Amount && $j_count < 4; $j++): ?>
                                    <?php if (isset($Feed_Activity[$j]) && ($Feed_Activity[$j]["type_name"] == "rating") && $Feed_Activity[$j]["video_by"] == $Feed_Activity[$i]["video_by"]): ?>
                                        <?= videoEntryGrid($Feed_Activity[$j]["id"],true,true) ?>
                                    <?php if (isset($Feed_Activity[$i+1]) && $Feed_Activity[$i+1]["type_name"] == "rating" && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$i + 1]["video_by"]) { $i++; } ?>
                                    <?php endif ?>
                                    <?php $j_count++; ?>
                                <?php endfor ?>
                                </div>
                                <?php else: ?>
                                    <?= videoEntry($Feed_Activity[$i]['id'], 440, true) ?>
                                <?php endif ?>
                                </div>
                        <?php elseif ($Feed_Activity[$i]["type_name"] == "uploaded") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-U" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <?= str_replace("{u}",'<a href=/user/'.$Feed_Activity[$i]['video_by'].'> '. displayname($Feed_Activity[$i]['video_by']) .'</a>',$LANGS['uploadedby']) ?>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Feed_Activity[$i]['date']) ?>)</span>
                                <?php if (isset($Feed_Activity[$i+1]) && $Feed_Activity[$i+1]["type_name"] == "uploaded" && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$i+1]["video_by"]): ?>
                                    <div class="video-entry">
                                    <?php $j_count = 0; ?>
                                    <?php for ($j = $i; $j < $Amount && $j_count < 4; $j++): ?>
                                    <?php if (isset($Feed_Activity[$j]) && ($Feed_Activity[$j]["type_name"] == "uploaded") && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$j]["video_by"]): ?>
                                    <?= videoEntryGrid($Feed_Activity[$j]["id"],false,true) ?>
                                    <?php if (isset($Feed_Activity[$i+1]) && $Feed_Activity[$i+1]["type_name"] == "uploaded" && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$i + 1]["video_by"]) { $i++; } ?>
                                    <?php endif ?>
                                    <?php $j_count++; ?>
                                <?php endfor ?>
                                </div>
                                <?php else: ?>
                                    <?= videoEntry($Feed_Activity[$i]['id'], 440, true) ?>
                                <?php endif ?>
                            </div>
                        <?php elseif ($Feed_Activity[$i]["type_name"] == "sub_videos") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-U" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <?= str_replace("{u}",'<a href=/user/'.$Feed_Activity[$i]['video_by'].'> '. displayname($Feed_Activity[$i]['video_by']) .'</a>',$LANGS['uploadedby']) ?>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Feed_Activity[$i]['date']) ?>)</span>
                                <?php if (isset($Feed_Activity[$i+1]) && ($Feed_Activity[$i+1]["type_name"] == "sub_videos") && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$i+1]["video_by"]): ?>
                                    <div class="video-entry">
                                    <?php $j_count = 0; ?>
                                    <?php for ($j = $i; $j < $Amount && $j_count < 4; $j++): ?>
                                    <?php if (isset($Feed_Activity[$j]) && ($Feed_Activity[$j]["type_name"] == "sub_videos") && $Feed_Activity[$j]["video_by"] == $Feed_Activity[$i]["video_by"]): ?>
                                    <?= videoEntryGrid($Feed_Activity[$j]["id"],false,true) ?>
                                    <?php if (isset($Feed_Activity[$i+1]) && $Feed_Activity[$i+1]["type_name"] == "sub_videos" && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$i + 1]["video_by"]) { $i++; } ?>
                                    <?php endif ?>
                                    <?php $j_count++; ?>
                                <?php endfor ?>
                                </div>
                                <?php else: ?>
                                    <?= videoEntry($Feed_Activity[$i]['id'], 440, true) ?>
                                <?php endif ?>
                            </div>
                        <?php elseif ($Feed_Activity[$i]["type_name"] == "friend") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-FRI" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Feed_Activity[$i]['id'] ?>"><?= displayname($Feed_Activity[$i]['id']) ?></a> <?= $LANGS['activityfriend'] ?> <a id="video-long-title" href="/user/<?= $Feed_Activity[$i]['content'] ?>" rel="nofollow"><?= displayname($Feed_Activity[$i]["content"]) ?></a>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Feed_Activity[$i]['date']) ?>)</span>
                            </div> 
                        <?php elseif ($Feed_Activity[$i]["type_name"] == "favorite") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-F" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <?= str_replace("{u}",'<a href=/user/'.$Feed_Activity[$i]['video_by'].'> '. displayname($Feed_Activity[$i]['video_by']) .'</a>',$LANGS['favoritedby']) ?>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Feed_Activity[$i]['date']) ?>)</span>
                                <?php if (isset($Feed_Activity[$i+1]) && $Feed_Activity[$i+1]["type_name"] == "favorite" && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$i+1]["video_by"]): ?>
                                    <div class="video-entry">
                                    <?php $j_count = 0; ?>
                                    <?php for ($j = $i; $j < $Amount && $j_count < 4; $j++): ?>
                                    <?php if (isset($Feed_Activity[$j]) && $Feed_Activity[$j]["type_name"] == "favorite" && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$j]["video_by"]): ?>
                                    <?= videoEntryGrid($Feed_Activity[$j]["id"],true,true) ?>
                                    <?php if (isset($Feed_Activity[$i+1]) && $Feed_Activity[$i+1]["type_name"] == "favorite" && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$i + 1]["video_by"]) { $i++; } ?>
                                    <?php endif ?>
                                    <?php $j_count++; ?>
                                <?php endfor ?>
                                </div>
                                <?php else: ?>
                                    <?= videoEntry($Feed_Activity[$i]['id'], 440, true) ?>
                                <?php endif ?>
                            </div>
                        <?php elseif ($Feed_Activity[$i]["type_name"] == "subscription") : ?>
                               <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-S" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Feed_Activity[$i]['id'] ?>"><?= displayname($Feed_Activity[$i]['id']) ?></a> <?= $LANGS['activitysubscription'] ?> <a id="video-long-title" href="/user/<?= $Feed_Activity[$i]['content'] ?>" rel="nofollow"><?= displayname($Feed_Activity[$i]["content"]) ?></a>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Feed_Activity[$i]['date']) ?>)</span>
                            </div> 
                        <?php endif ?>
                    <?php endfor ?>
                    <?php if ($Amount >= 30): ?>
                    <button type="button" class="search-button yt-uix-button" onclick="loadMoreVids(this, '<?= $Show ?>')" tabindex="2"><span class="yt-uix-button-content"><?= $LANGS['loadmorevideos'] ?></span></button>
                    <?php endif ?>
        <div class="clearL" style="height: 1px;"></div>
        </div>
<?php endif ?>