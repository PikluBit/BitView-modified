<?php if ($_USER->Logged_In && $_USER->Info['h_activity'] && $_USER->Info['h_feed'] == 0): ?>
<div class="homepage-content-block" id="homepage-content-block-h_activity">
        <div class="homepage-block-heading"><?= $LANGS['friendactivity'] ?>
        <div class="feedmodule-updown">
            <span id="medit-FRI" class="iyt-edit-link" onclick="open_option_box('FRI')"><?= $LANGS['edit'] ?></span><span id="mup" class="up-button" onclick="move_up('h_activity')"><img class="img-php-up-arrow" src="/img/pixel.gif"></span><span id="mdown" class="down-button" onclick="move_down('h_activity')"><img class="img-php-down-arrow" src="/img/pixel.gif"></span><span id="mclose" onclick="close_module('h_activity')"><img class="img-php-close-button" src="/img/pixel.gif"></span>
            </div></div>
        <div id="FRI-options" class="opt-pane" style="">
        <div class="opt-box-top">
            <img class="homepage-sprite img-php-opt-box-caret" src="/img/pixel.gif">
        </div>
        <div class="opt-banner">
            <div class="opt-links">
                <div class="opt-edit"><?= $LANGS['homeediting'] ?>: <?= $LANGS['friendactivity'] ?></div>
                <div class="opt-close opt-close-button" onclick="open_option_box('FRI')"><img class="img-php-close-button" src="/img/pixel.gif"></div>
                <div class="opt-close opt-close-text" onclick="open_option_box('FRI')"><?= $LANGS['close'] ?></div>
                <div id="h_activity-loading-msg" class="opt-loading-msg" style="display: none;">
                <?= $LANGS['saving'] ?>
                </div>
                <div id="h_activity-loading-icn" class="opt-loading-icn" style="display: none;">
                    <img width="16" id="FRI-loading-icn-image" src="/img/pixel.gif" image="/img/icn_loading_animated.gif">
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="opt-main">
            <div class="opt-divider">
                <table class="opt-tbl">
                <tbody><tr>
                    <td class="opt-name">
<?= $LANGS['homerows'] ?>:
                    </td>
                    <td class="opt-val">
                        <select id="h_activity-options-num" name="FRI-options-num" onchange="set_num_activity('h_activity', this.value)">
                                <option value="1" <?php if ($_USER->Info['h_activity_limit'] == 1): ?>selected<?php endif ?>>1</option>
                                <option value="2" <?php if ($_USER->Info['h_activity_limit'] == 2): ?>selected<?php endif ?>>2</option>
                                <option value="3" <?php if ($_USER->Info['h_activity_limit'] == 3): ?>selected<?php endif ?>>3</option>
                                <option value="4" <?php if ($_USER->Info['h_activity_limit'] == 4): ?>selected<?php endif ?>>4</option>
                                <option value="5" <?php if ($_USER->Info['h_activity_limit'] == 5): ?>selected<?php endif ?>>5</option>
                                <option value="6" <?php if ($_USER->Info['h_activity_limit'] == 6): ?>selected<?php endif ?>>6</option>
                                <option value="7" <?php if ($_USER->Info['h_activity_limit'] == 7): ?>selected<?php endif ?>>7</option>
                                <option value="8" <?php if ($_USER->Info['h_activity_limit'] == 8): ?>selected<?php endif ?>>8</option>
                                <option value="9" <?php if ($_USER->Info['h_activity_limit'] == 9): ?>selected<?php endif ?>>9</option>
                                <option value="10" <?php if ($_USER->Info['h_activity_limit'] == 10): ?>selected<?php endif ?>>10</option>
                                <option value="11" <?php if ($_USER->Info['h_activity_limit'] == 11): ?>selected<?php endif ?>>11</option>
                                <option value="12" <?php if ($_USER->Info['h_activity_limit'] == 12): ?>selected<?php endif ?>>12</option>
                        </select>
                    </td>
                </tr>
                </tbody></table>
            </div>
        </div>
    </div>
        <div class="homepage-sub-block-contents" id="homepage-sub-block-contents-h_activity" style="max-height: revert;">
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
                                        <?= load_thumbnail($Activity['id']) ?>
                            
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
    </div>
<?php endif ?>