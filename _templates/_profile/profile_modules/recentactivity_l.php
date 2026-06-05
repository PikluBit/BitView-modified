<?php if ($_PROFILE->Info['c_ratings_box'] == 1): ?>
<div class="inner-box" id="user_recent_activity">
        <div style="zoom:1">
        <div class="box-title title-text-color">
                <?= $LANGS['recentratings'] ?> &nbsp;
        </div>
        <?php if ($_PROFILE->Username == $_USER->Username): ?><div class="updown_arrows "><img id="user_recent_activity-left-arrow" src="/img/pixel.gif" class="module-left-arrow disabled"><img id="user_recent_activity-up-arrow" src="/img/pixel.gif" class="module-up-arrow <?php if ($Modules_L[0] == "recentactivity"): ?> disabled<?php endif ?>" onclick="move_up('recent_activity');return false"><img id="user_recent_activity-down-arrow" src="/img/pixel.gif" class="module-down-arrow <?php if (end($Modules_L) == "recentactivity"): ?>disabled<?php endif ?>" onclick="move_down('recent_activity');return false"><img id="user_recent_activity-right-arrow" src="/img/pixel.gif" class="module-right-arrow" onclick="move_right('recent_activity')"></div><?php endif ?>
        <div style="float:right;zoom:1;_display:inline;white-space:nowrap">
            <div style="float:right">
            </div>
        </div>
        <div class="cb"></div>
        </div>


    <div id="user_recent_activity-messages" style="color:#333;margin:1em;padding:1em;display:none"></div>
    
    <div id="user_recent_activity-body">
    <div id="feed_success" style="display: none;">
Your bulletin has been posted.
    </div>

    <div id="feed_success_custom" style="display: none;">
    </div>

    <div id="feed_error" style="display: none;">
Sorry, an error occurred.
    </div>

    <div id="feed_error_custom" style="display: none;">
    </div>

    <div id="feed_loading" style="display: none; text-align: center;">
        <img src="/img/icn_loading_animated.gif">
    </div>
    <?php if ($_PROFILE->Username == $_USER->Username): ?>
    <div id="feed_bulletin">
            <form name="post_bulletin">

        <table border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
                <td class="input_box_left">
                    <span style="font-weight: bold; margin: 0px 3px;"><?= displayname($_PROFILE->Username) ?></span>
                </td>
                <td class="input_box_right" width="100%">
                    <input id="bulletin_input" type="text" placeholder ="..." onkeyup="document.getElementById('post_button_input').disabled = 0;">
                </td>
            </tr>
        </tbody></table>

        <table border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
                <td id="video_link_icon">
                    <img src="/img/pixel.gif" onclick="attach_video(); return false;">
                </td>
                <td width="100%">
                    <div id="bulletin_video_link" style="display: block;">
                        <a href="#" style="font-size: 10px;" class="hLink" onclick="attach_video(); return false;">
Attach a video
                        </a>
                    </div>
                    <div id="bulletin_video" class="input_box" style="display: none;">
                        <input id="bulletin_video_input" type="text" maxlength="250" placeholder="Paste a URL to a BitView video.">
                    </div>
                </td>
                <td>
                    <div id="post_button" style="display: block;">
                        <input id="post_button_input" type="button" value="<?= mb_strtolower((string) $LANGS['postbulletin']) ?>" onclick="post_channel_bulletin()" disabled="">
                    </div>
                </td>
            </tr>
        </tbody></table>
            </form>
        </div>
    <?php endif ?>

    <div class="text-field recent-activity-content outer-box-bg-as-border" style="_height:expression(this.scrollHeight>349?'350px':'auto');_width:610px">
    <table id="feed_table" border="0" cellspacing="0" cellpadding="0" width="97%">
        <tbody>
            <?php if (count($Recent_Activity) > 0) : ?>
                    <?php $Amount = count($Recent_Activity) ?>
                    <?php $Count = 0 ?>
                    <?php foreach ($Recent_Activity as $Activity) : ?>
                        <?php $Count++ ?>
                        <?php if ($Activity["type_name"] == "comment") : ?>
                            <tr id="feed_item_<?= $Activity['id'] ?>" valign="top">
                                <td class="feed_icon">
                                    <img class="icon-C" src="/img/pixel.gif">
                                </td>
                                <td>
                                    <div class="feed_title"><?= displayname($_PROFILE->Username) ?> <?= $LANGS['activitycomment'] ?> <a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><?= $Activity['title'] ?></a>
                                    <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    </div>
                                    <div class="centerpiece">
                                        <div style="float:left; margin-right: 8px;"><a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><img style="width: 60px; height: 45px; border: 1px solid #999;"<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Activity["id"].'.jpg')): ?>src="/u/thmp/<?= $Activity["id"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?>></a></div>
                                            <div style="width:210px">
                                <span id="feed_item_j_<?= $Count ?>_collapsed" style="display: block;"><i>"<?= short_title($Activity['content'],80) ?>"</i>&nbsp;
                    <?php if (mb_strlen((string) $Activity['content']) > 80): ?>
                        <a href="#" onclick="showHide('<?= $Count ?>'); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['dropdownmore'] ?></a>
                        </span>
                        <span id="feed_item_j_<?= $Count ?>_expanded" style="display:none">
            <i>"<?= nl2br((string) $Activity['content']) ?>"</i>
                        &nbsp;
                        <a href="#" onclick="showHide('<?= $Count ?>'); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['honorless'] ?></a>
                    <?php endif ?>
                    </div>

                                    </div>
                                </td>
                                <td class="feed_delete">
                                    &nbsp;
                                </td>
                            </tr>
                            <?php if ($Count != 5): ?><tr id="feed_divider_<?= $Activity['id'] ?>" class="divider">
                                <td colspan="3" class="outer-box-bg-as-border divider">&nbsp;</td>
                            </tr><?php endif?>
                        <?php elseif ($Activity["type_name"] == "bulletin") : ?>
                            <tr id="feed_item_<?= $Activity['id'] ?>" valign="top">
                                <td class="feed_icon">
                                    <img class="icon-BUL" src="/img/pixel.gif">
                                </td>
                                <td>
                                    <div><b><?= displayname($_PROFILE->Username) ?></b>&nbsp;<?= $Activity['content'] ?>&nbsp;<span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span></div>
                                    <?php if ($Activity['rating']): ?>
                                    <?php
                                    $_VIDEO = new Video($Activity["rating"],$DB);

                                    if ($_VIDEO->exists()) {
                                    $_VIDEO->get_info();
                                    } 
                                    ?>
                                    <div class="centerpiece">
                                        <div style="float:left; margin-right: 8px;"><a href="/watch?v=<?= $_VIDEO->URL ?>" rel="nofollow"><img style="width: 60px; height: 45px; border: 1px solid #999;" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$_VIDEO->URL.'.jpg')): ?>src="/u/thmp/<?= $_VIDEO->URL ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?>></a></div>
                                        <div>
                                        <a href="/watch?v=<?= $_VIDEO->URL ?>" rel="nofollow"><?= short_title($_VIDEO->Info['title'],24) ?></a>
                                    </div>
                                    <div>
                                <span id="feed_item_j_<?= $Count ?>_collapsed" style="display: block;"><?= short_title($_VIDEO->Info['description'],80) ?>&nbsp;
                    <?php if (mb_strlen((string) $Activity['content']) > 80): ?>
                        <a href="#" onclick="showHide('<?= $Count ?>'); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['dropdownmore'] ?></a>
                        </span>
                        <span id="feed_item_j_<?= $Count ?>_expanded" style="display:none">
            <?= nl2br((string) $Activity['content']) ?>
                        &nbsp;
                        <a href="#" onclick="showHide('<?= $Count ?>'); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['honorless'] ?></a>
                    <?php endif ?>
                    </div>
                        </div><?php endif ?>

                                </td>
                                <td class="feed_delete">
                                    &nbsp;
                                    <?php if ($_USER->Logged_In && ($_USER->Is_Admin || $_USER->Is_Moderator || $_USER->Username == $_PROFILE->Username)): ?>
                                    <a href="#" onclick="delete_bulletin(<?= $Activity['id'] ?>);return false;" style="text-decoration: none; color: #000;"><img src="/img/pixel.gif"></a>
                                 <?php endif ?>
                                </td>
                            </tr>
                            <?php if ($Count != 5): ?><tr id="feed_divider_<?= $Activity['id'] ?>" class="divider">
                                <td colspan="3" class="outer-box-bg-as-border divider">&nbsp;</td>
                            </tr><?php endif ?>
                        <?php elseif ($Activity["type_name"] == "favorite") : ?>
                            <tr id="feed_item_<?= $Activity['id'] ?>" valign="top">
                                <td class="feed_icon">
                                    <img class="icon-F" src="/img/pixel.gif">
                                </td>
                                <td>
                                    <div class="feed_title"><?= displayname($_PROFILE->Username) ?> <?= $LANGS['activityfavorite'] ?> <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span></div>
                                    </div>
                                    <div class="centerpiece">
                                        <div style="float:left; margin-right: 8px;"><a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><img style="width: 60px; height: 45px; border: 1px solid #999;" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Activity["id"].'.jpg')): ?>src="/u/thmp/<?= $Activity["id"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?>></a></div>
                                        <div>
                                        <a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><?= short_title($Activity['title'],24) ?></a>
                                    </div>
                                    <div style="width:210px">
                                <span id="feed_item_j_<?= $Count ?>_collapsed" style="display: block;"><?= short_title($Activity['content'],80) ?>&nbsp;
                    <?php if (mb_strlen((string) $Activity['content']) > 80): ?>
                        <a href="#" onclick="showHide('<?= $Count ?>'); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['dropdownmore'] ?></a>
                        </span>
                        <span id="feed_item_j_<?= $Count ?>_expanded" style="display:none">
            <?= nl2br((string) $Activity['content']) ?>
                        &nbsp;
                        <a href="#" onclick="showHide('<?= $Count ?>'); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['honorless'] ?></a>
                    <?php endif ?>
                    </div>
                        </div>
                                </td>
                                <td class="feed_delete">
                                    &nbsp;
                                </td>
                            </tr>
                            <?php if ($Count != 5): ?><tr id="feed_divider_<?= $Activity['id'] ?>" class="divider">
                                <td colspan="3" class="outer-box-bg-as-border divider">&nbsp;</td>
                            </tr><?php endif ?>
                        <?php elseif ($Activity["type_name"] == "rating") : ?>
                            <tr id="feed_item_<?= $Activity['id'] ?>" valign="top">
                                <td class="feed_icon">
                                    <img class="icon-E" src="/img/pixel.gif">
                                </td>
                                <td>
                                    <div class="feed_title"><?= displayname($_PROFILE->Username) ?> <?= $LANGS['activitylike'] ?>
                                        <span style="white-space: nowrap;vertical-align: middle;"></span> <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    </div>
                                    </div>
                                    <div class="centerpiece">
                                        <div style="float:left; margin-right: 8px;"><a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><img style="width: 60px; height: 45px; border: 1px solid #999;" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Activity["id"].'.jpg')): ?>src="/u/thmp/<?= $Activity["id"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?>></a></div>
                                        <div>
                                        <a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><?= short_title($Activity['title'],24) ?></a>
                                    </div>
                                    <div style="width:210px">
                                <span id="feed_item_j_<?= $Count ?>_collapsed" style="display: block;"><?= short_title($Activity['content'],80) ?>&nbsp;
                    <?php if (mb_strlen((string) $Activity['content']) > 80): ?>
                        <a href="#" onclick="showHide('<?= $Count ?>'); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['dropdownmore'] ?></a>
                        </span>
                        <span id="feed_item_j_<?= $Count ?>_expanded" style="display:none">
            <?= nl2br((string) $Activity['content']) ?>
                        &nbsp;
                        <a href="#" onclick="showHide('<?= $Count ?>'); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['honorless'] ?></a>
                    <?php endif ?>
                    </div>
                        </div>
                                </td>
                                <td class="feed_delete">
                                    &nbsp;
                                </td>
                            </tr>
                            <?php if ($Count != 5): ?><tr id="feed_divider_<?= $Activity['id'] ?>" class="divider">
                                <td colspan="3" class="outer-box-bg-as-border divider">&nbsp;</td>
                            </tr><?php endif ?>
                        <?php elseif ($Activity["type_name"] == "uploaded") : ?>
                            <tr id="feed_item_<?= $Activity['id'] ?>" valign="top">
                                <td class="feed_icon">
                                    <img class="icon-U" src="/img/pixel.gif">
                                </td>
                                <td>
                                    <div class="feed_title"><?= displayname($_PROFILE->Username) ?> <?= $LANGS['activityupload'] ?> <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span></div>
                                    </div>
                                    <div class="centerpiece">
                                        <div style="float:left; margin-right: 8px;"><a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><img style="width: 60px; height: 45px; border: 1px solid #999;" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Activity["id"].'.jpg')): ?>src="/u/thmp/<?= $Activity["id"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?>></a></div>
                                        <div>
                                        <a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><?= short_title($Activity['title'],24) ?></a>
                                    </div>
                                    <div style="width:210px">
                                <span id="feed_item_j_<?= $Count ?>_collapsed" style="display: block;"><?= short_title($Activity['content'],80) ?>&nbsp;
                    <?php if (mb_strlen((string) $Activity['content']) > 80): ?>
                        <a href="#" onclick="showHide('<?= $Count ?>'); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['dropdownmore'] ?></a>
                        </span>
                        <span id="feed_item_j_<?= $Count ?>_expanded" style="display:none">
            <?= nl2br((string) $Activity['content']) ?>
                        &nbsp;
                        <a href="#" onclick="showHide('<?= $Count ?>'); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['honorless'] ?></a>
                    <?php endif ?>
                    </div>
                        </div>
                                </td>
                                <td class="feed_delete">
                                    &nbsp;
                                </td>
                            </tr>
                            <?php if ($Count != 5): ?><tr id="feed_divider_<?= $Activity['id'] ?>" class="divider">
                                <td colspan="3" class="outer-box-bg-as-border divider">&nbsp;</td>
                            </tr><?php endif ?>
                            <?php elseif ($Activity["type_name"] == "friend") : ?>
                                <tr id="feed_item_<?= $Count ?>" valign="top">
        <td class="feed_icon">
            <img class="icon-FRI" src="/img/pixel.gif">
        </td>
        <td>
            <div class="feed_title">

<?= displayname($_PROFILE->Username) ?> <?= $LANGS['activityfriend'] ?> <?php if ($Activity["content"] != $_PROFILE->Username) : ?><a href="/user/<?= $Activity["content"] ?>"><?= $Activity["content"] ?></a><?php else : ?><a href="/user/<?= $Activity["id"] ?>"><?= $Activity["id"] ?></a><?php endif ?>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
            </div>
        </td>
        <td class="feed_delete">
            &nbsp;

        </td>
    </tr>
    <?php if ($Count != 5): ?><tr id="feed_divider_<?= $Count ?>" class="divider">
                                <td colspan="3" class="outer-box-bg-as-border divider">&nbsp;</td>
                            </tr><?php endif ?>
                        <?php elseif ($Activity["type_name"] == "subscription") : ?>
                                <tr id="feed_item_<?= $Count ?>" valign="top">
        <td class="feed_icon">
            <img class="icon-S" src="/img/pixel.gif">
        </td>
        <td>
            <div class="feed_title">

<?= displayname($_PROFILE->Username) ?> <?= $LANGS['activitysubscription'] ?> <?php if ($Activity["content"] != $_PROFILE->Username) : ?><a href="/user/<?= $Activity["content"] ?>"><?= $Activity["content"] ?></a><?php else : ?><a href="/user/<?= $Activity["id"] ?>"><?= $Activity["id"] ?></a><?php endif ?>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
            </div>
        </td>
        <td class="feed_delete">
            &nbsp;

        </td>
    </tr>
    <?php if ($Count != 5): ?><tr id="feed_divider_<?= $Count ?>" class="divider">
                                <td colspan="3" class="outer-box-bg-as-border divider">&nbsp;</td>
                            </tr><?php endif ?>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php else : ?>
                    <div class="alignC" style="margin: 20px;"><?= $LANGS['norecentratings'] ?></div>
                <?php endif ?>
            </tbody></table>
        </div>

    </div>
    <div class="clear"></div>
</div>
<?php endif ?>