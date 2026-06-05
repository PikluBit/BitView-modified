<?php if ($_USER->Logged_In && $_USER->Info['h_feed'] == 1): ?>
<div class="homepage-content-block">
        <div class="feed-bar">
            <div class="user-thumb-semismall" style="float: left;">
                <a href="/user/<?= $_USER->Username ?>"><img src="<?= avatar($_USER->Username) ?>"></a>
            </div>
            <div class="feed-user-info" style="float: left;">
                <div><a href="/user/<?= $_USER->Username ?>" class="username"><?= displayname($_USER->Username) ?></a></div>
                <?php 
                $Notifications_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND (is_notification = 1 or type = 2 or type = 4 or type = 5) AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
                ?>
                <div style="height: 11px;margin-top: 2px;"><a href="/inbox?v=c" class=""><span class="feed_icon"><img class="icon-C" src="/img/pixel.gif">
                </span><?= $Notifications_Amount ?></a>
                <a href="/inbox?v=p" class=""><span class="feed_icon"><img class="icon-FBC" src="/img/pixel.gif">
                </span><?= $Messages ?></a></div>
            </div>
            <div class="feed-buttons" style="float: left;">
                <a href="#all" id="all" class="current" onclick="changeFeedPage('all');return false;"><?= $LANGS['allactivity'] ?></a>
                <a href="#subscriptions" id="subscriptions" onclick="changeFeedPage('subscriptions');return false;"><?= $LANGS['subscriptionuploads'] ?></a>
            </div>
        </div>
        <div class="feed-bar feed-bar-loading hid">
            <?= $LANGS['loading'] ?> <img src="/img/icn_loading_animated.gif" style="vertical-align: middle;">
        </div>
        <div class="homepage-sub-block-contents" id="page-1" style="max-height: revert;">
            <?php if (count($Feed_Activity) > 0) : ?>
                    <?php $Amount = count($Feed_Activity) ?>
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
                        <?php elseif ($Feed_Activity[$i]["type_name"] == "sub_videos") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-U" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <?= str_replace("{u}",'<a href=/user/'.$Feed_Activity[$i]['video_by'].'> '. displayname($Feed_Activity[$i]['video_by']) .'</a>',$LANGS['uploadedby']) ?>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Feed_Activity[$i]['date']) ?>)</span>
                                <?php if (isset($Feed_Activity[$i+1]) && ($Feed_Activity[$i+1]["type_name"] == "sub_videos") && $Feed_Activity[$i]["video_uploader"] == $Feed_Activity[$i + 1]["video_uploader"]): ?>
                                    <div class="video-entry">
                                    <?php $j_count = 0; ?>
                                    <?php for ($j = $i; $j < $Amount && $j_count < 4; $j++): ?>
                                    <?php if (isset($Feed_Activity[$j]) && ($Feed_Activity[$j]["type_name"] == "sub_videos") && $Feed_Activity[$i]["video_uploader"] == $Feed_Activity[$j]["video_uploader"]): ?>
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
                        <?php elseif ($Feed_Activity[$i]["type_name"] == "uploaded") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-U" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <?= str_replace("{u}",'<a href=/user/'.$Feed_Activity[$i]['video_by'].'> '. displayname($Feed_Activity[$i]['video_by']) .'</a>',$LANGS['uploadedby']) ?>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Feed_Activity[$i]['date']) ?>)</span>
                                <?php if (isset($Feed_Activity[$i+1]) && ($Feed_Activity[$i+1]["type_name"] == "uploaded") && $Feed_Activity[$i]["video_uploader"] == $Feed_Activity[$i]["video_uploader"]): ?>
                                    <div class="video-entry">
                                    <?php $j_count = 0; ?>
                                    <?php for ($j = $i; $j < $Amount && $j_count < 4; $j++): ?>
                                    <?php if (isset($Feed_Activity[$j]) && ($Feed_Activity[$j]["type_name"] == "uploaded") && $Feed_Activity[$i]["video_uploader"] == $Feed_Activity[$j]["video_uploader"]): ?>
                                    <?= videoEntryGrid($Feed_Activity[$j]["id"],false,true) ?>
                                    <?php if (isset($Feed_Activity[$i+1]) && isset($Feed_Activity[$i+1]) && $Feed_Activity[$i+1]["type_name"] == "uploaded" && $Feed_Activity[$i]["video_by"] == $Feed_Activity[$i + 1]["video_by"]) { $i++; } ?>
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
                    <?php if (isset($Recommended_Videos) && $Recommended_Videos) : ?>
                    <?php $Count++ ?>
                    <div class="feed-item-<?= $Count ?>" id="feed-item">
                        <span class="feed_icon">
                            <img class="icon-REC" src="/img/pixel.gif">
                        </span>
                        <span class="feed_title">
                            <?= $LANGS['recommendedforyou'] ?>
                        </span>
                        <span class="timestamp">(<?= get_time_ago($Recommended_Videos[0]['uploaded_on']) ?>)</span>
                        <div class="video-entry">
                            <?php foreach ($Recommended_Videos as $Video): ?>
                            <?= videoEntryGrid($Video['url'],true,true) ?>
                            <?php endforeach ?>
                            <?php $j_count++; ?>
                        </div>
                    </div> 
                    <?php endif ?>
                    <button type="button" class="search-button yt-uix-button" onclick="loadMoreVids(this, 'all')" tabindex="2"><span class="yt-uix-button-content"><?= $LANGS['loadmorevideos'] ?></span></button>
                <?php else : ?>
                    <strong><?= $LANGS['homenofriendactivity'] ?></strong><br>
        <span style="color: #666;margin-bottom: 5px;display: inline-block;"><?= $LANGS['homenofriendactivitydesc'] ?></span>
                <?php endif ?>
        <div class="clearL" style="height: 1px;"></div>
        </div>
    </div>
<?php endif ?>