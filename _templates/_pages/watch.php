<?php use function PHP81_BC\strftime; ?>
<link rel="stylesheet" href="/css/watch.css">
<style>
<?php if ($_OWNER->Username == $_USER->Username || ($_USER->Is_Admin || $_USER->Is_Moderator)): ?>
    #page #masthead-container {
        border: 0;
    }
<?php endif ?>
<?php if (mb_strpos((string) $_VIDEO->Info['tags'], "bv:stretch=16:9")): ?>
    .vlPlayer2010 .vlScreen object, .vlPlayer2010 .vlScreen video {
    object-fit: fill;
}
<?php endif ?>
<?php if (mb_strpos((string) $_VIDEO->Info['tags'], "bv:crop=16:9")): ?>
    .vlPlayer2010 .vlScreen object, .vlPlayer2010 .vlScreen video {
    object-fit: cover;
}
<?php endif ?>
<?php if (mb_strpos((string) $_VIDEO->Info['tags'], "bv:stretch=4:3")): ?>
    .vlPlayer2010 .vlScreen object, .vlPlayer2010 .vlScreen video {
    transform: scaleX(0.75);
    object-fit: fill;
}
<?php endif ?>
</style>
<script src="/js/watch.js"></script>
<script>
    var video_url                   = "<?= $_VIDEO->Info['url'] ?>";
    var video_uploader              = "<?= $_VIDEO->Info['uploaded_by'] ?>";
    var langs_loading               = "<?= $LANGS['loading'] ?>";
    var langs_saving                = "<?= $LANGS['saving'] ?>";
    var langs_respondvideo          = "<?= $LANGS['respondvideo'] ?>";
    var langs_marked                = "<?= $LANGS['marked'] ?>";
    var langs_spamshow              = "<?= $LANGS['spamshow'] ?>";
    var langs_spamhide              = "<?= $LANGS['spamhide'] ?>";
    var langs_commentok             = "<?= $LANGS['commentok'] ?>";
    var langs_commenterror          = "<?= $LANGS['commenterror'] ?>";
    var langs_commentspammsg        = "<?= $LANGS['commentspammsg'] ?>";
    var langs_commentspammsg2       = "<?= $LANGS['commentspammsg2'] ?>";
    var langs_emptycomment          = "<?= $LANGS['emptycomment'] ?>";
    var langs_postcomment           = "<?= $LANGS['postcomment'] ?>";
    var langs_subscribe             = "<?= $LANGS['subscribe'] ?>";
    var langs_unsubscribe           = "<?= $LANGS['unsubscribe'] ?>";
    var langs_subscribetooltip      = "<?= $LANGS['subscribetooltip'] ?>";
    var langs_unsubscribetooltip    = "<?= $LANGS['unsubscribetooltip'] ?>";
    var langs_autoplayon            = "<?= $LANGS['autoplayon'] ?>";
    var langs_autoplayoff           = "<?= $LANGS['autoplayoff'] ?>";
    var langs_thisvideoispublic     = "<?= $LANGS['thisvideoispublic'] ?>";
    var langs_thisvideoisprivate    = "<?= $LANGS['thisvideoisprivate'] ?>";
    var langs_thisvideoisunlisted   = "<?= $LANGS['thisvideoisunlisted'] ?>";
    
    var langs_cat = [];
    <?php for ($i = 1; $i < 22; $i++): ?>
    langs_cat[<?= $i ?>]         = "<?= $LANGS['cat'.$i] ?>";
    <?php endfor ?>

    <?php if ($_USER->Is_Admin || $_USER->Is_Moderator) : ?>
    function feature_video(el) {
        if (el.innerHTML == "Feature") {
            el.innerHTML = "Unfeature";
        } else {
            el.innerHTML = "Feature";
        }
    }
    function mark_reupload_video(el) {
        if (el.innerHTML == "Mark as reupload") {
            el.innerHTML = "Unmark as reupload";
        } else {
            el.innerHTML = "Mark as reupload";
        }
    }
    <?php endif ?>

    function showActions(e) {
        for (i = 0; i < document.getElementsByClassName('current').length; i++) {
            document.getElementsByClassName('current')[0].classList.remove('current');
        }
        e.classList.add('current');
        <?php if (!($_OWNER->Username == $_USER->Username || ($_USER->Is_Admin || $_USER->Is_Moderator))): ?>
        if (e.getAttribute('data-author') == "<?= $_USER->Username ?>") {
            if (!document.getElementById("watch-comment-remove-link")) {
                document.getElementById("comments-actions-menu").innerHTML += '<li id="watch-comment-remove-link"><span class="yt-uix-button-menu-item" onclick="delete_comment(); return false;"><?= $LANGS['removetooltip'] ?></span></li>';
            }
        }
        else {
            if (document.getElementById("watch-comment-remove-link")) {
                document.getElementById("watch-comment-remove-link").outerHTML = '';
            }
        }
        <?php endif ?>
        if (e.getAttribute('user-score') == 1) {
            document.getElementById('watch-comment-vote-up').classList.remove('voted-down');
            document.getElementById('watch-comment-vote-down').classList.remove('voted-down');
            document.getElementById('watch-comment-vote-up').classList.add('voted-up');
            document.getElementById('watch-comment-vote-down').classList.add('voted-up');
        }
        else if (e.getAttribute('user-score') == 0) {
            document.getElementById('watch-comment-vote-up').classList.remove('voted-up');
            document.getElementById('watch-comment-vote-down').classList.remove('voted-up');
            document.getElementById('watch-comment-vote-up').classList.add('voted-down');
            document.getElementById('watch-comment-vote-down').classList.add('voted-down');
        }
        else {
            document.getElementById('watch-comment-vote-up').classList.remove('voted-up');
            document.getElementById('watch-comment-vote-down').classList.remove('voted-up');
            document.getElementById('watch-comment-vote-up').classList.remove('voted-down');
            document.getElementById('watch-comment-vote-down').classList.remove('voted-down');
        }
        var rect = e.getBoundingClientRect();
        if (!document.getElementsByClassName('edit-info')[0]) {
            var height = document.getElementById('masthead-container').offsetHeight;
        }
        else {
            var height = document.getElementById('masthead-container').offsetHeight + document.getElementsByClassName('edit-info')[0].offsetHeight;
        }
        var width = (document.body.clientWidth - 960) / 2;
        var long = document.getElementById('watch-comments-actions').offsetWidth;
        if (!document.getElementById("default-language-box")) {
            document.getElementById('watch-comments-actions').style.top = rect.top + scrollY - height + "px";
        }
        else {
            var eh = document.getElementById('default-language-box').offsetHeight;
            document.getElementById('watch-comments-actions').style.top = rect.top + scrollY - height - eh - 30 + "px";
        }
        document.getElementById('watch-comments-actions').style.left = 640 + width - long + "px";
    }
    function autoplay() {
        var st = document.getElementById('watch-next-list-autoplay').classList.contains('autoplay-on');
        if (st && !document.querySelector("#watch-next-list-body .video-list-item:last-of-type").classList.contains("hover")) {
            window.location.href = "/watch?v=<?php if (isset($_NXTVID)) echo $_NXTVID->URL ?>&pl=<?php if (isset($_GET['pl'])) echo $_GET['pl'] ?>"
        }
    }
</script>
<?php if ($_OWNER->Username == $_USER->Username || ($_USER->Is_Admin || $_USER->Is_Moderator)): ?>
<div class="edit-info">
    <div class="edit-info-inside">
        <div id="edit-menu" class="">
        <div id="edit-status" class="hid">
                <div id="success-box" class="yt-alert yt-alert-info yt-rounded" style="margin:0;margin-bottom: 8px;">
                    <div class="yt-alert-icon-small" style="margin-top: 2px;"></div>
                    <div id="" class="yt-alert-content" style="margin: 4px 0 4px 16px;"><?= $LANGS['changessaved'] ?></div>
                    <div class="clear"></div>
                </div>
                </div>
        <?php if ($_OWNER->Username == $_USER->Username): ?>
        <button id="watch-embed" class="yt-uix-button yt-uix-tooltip" onclick="editVideoDetail();" type="button"><span class="yt-uix-button-content"><?= $LANGS['editvideodetail'] ?></span></button><span style="padding: 0 8px;color: #999;">|</span><a href="/my_videos_annotations?v=<?= $_VIDEO->URL ?>"><?= $LANGS['editannotations'] ?></a><span style="padding: 0 8px;color: #999;">|</span><a href="/insight?v=<?= $_VIDEO->URL ?>"><?= $LANGS['insightstats'] ?></a>
        <?php endif ?>
        <?php if ($_USER->Is_Admin || $_USER->Is_Moderator): ?>
        <span style="float: right;"><span style="padding-right: 8px;color: #999;">Admin Video Options:</span><a href="/admin_panel/?page=videos&ve=<?= $_VIDEO->URL ?>"><?= $LANGS['editvideo'] ?></a><span style="padding: 0 8px;color: #999;">|</span><a href="/a/mark_as_reupload?v=<?= $_VIDEO->URL ?>" target="_blank" onclick="mark_reupload_video(this)"><?php if (!$_VIDEO->Info["reupload"]) : ?>Mark as reupload<?php else : ?>Unmark as reupload<?php endif ?></a><span style="padding: 0 8px;color: #999;">|</span><a style="    display: inline-block;" href="/a/feature_video?v=<?= $_VIDEO->URL ?>" target="_blank" onclick="feature_video(this)"><?php if (!$_VIDEO->Info["featured"]) : ?>Feature<?php else : ?>Unfeature<?php endif ?></a></div>
        </span>
        <?php endif ?>
        </div>
        <div id="edit-menu-active" class="hid">
            <button id="watch-embed" class="yt-uix-button yt-uix-button-primary" onclick="saveVideoDetail();" type="button"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button> <?= $LANGS['or'] ?> <a href="#" onclick="cancelVideoDetail(); return false;"><?= $LANGS['editcancel'] ?></a>&nbsp;&nbsp;<button id="watch-embed" class="yt-uix-button yt-uix-tooltip" style="margin-left: 12px" onclick="toggleSettings();" type="button"><span class="yt-uix-button-content"><?= $LANGS['settings'] ?></span></button>
            <div id="edit-menu-settings" class="hid">
                <div class="information">
                <div class="broadcasttitle" onclick="showHideComments();"><?= $LANGS['statcomments'] ?></div>
                <div class="broadcastdiv" id="comments"><label style="position:relative;bottom:4px;right:4px"><input type="radio" name="edit-video-comments" id="edit-video-comments-1" value="1" style="position:relative;top:2px"<?php if ($_VIDEO->Info["e_comments"] == 1) : ?> checked<?php endif ?> /><?= $LANGS['allowcomments'] ?></label><br>
                <label style="position:relative;bottom:4px;right:4px"><input type="radio" name="edit-video-comments"  id="edit-video-comments-2" value="2" style="position:relative;top:2px"<?php if ($_VIDEO->Info["e_comments"] == 2) : ?> checked<?php endif ?> /><?= $LANGS['allowfriendcomments'] ?></label><br>
                <label style="position:relative;bottom:4px;right:4px"><input type="radio" name="edit-video-comments" id="edit-video-comments-0" value="0" style="position:relative;top:2px"<?php if ($_VIDEO->Info["e_comments"] == 0) : ?> checked<?php endif ?> /><?= $LANGS['disablecomments'] ?></label></div></div>
                <div class="information"><input type="checkbox" id="edit-ratings" <?php if ($_VIDEO->Info['e_ratings'] == 1): ?>checked<?php endif ?>>
                <label for="edit-ratings"><?= $LANGS['allowratingscheck'] ?></label></div>
                <div class="clear"></div>
        </div>
        </div>
    </div>
</div>
<?php endif ?>
<div id="content" class="">
            <!-- begin contenttop section -->
    <?php if ($_OWNER->Username == $_USER->Username): ?>
    <div id="edit-info-title" class="hid">
        <input id="edit-video-title" value="<?= $_VIDEO->Info["title"] ?>">
    </div>
    <?php endif ?>
    <div id="watch-headline-container">
                <div id="watch-headline">

        <h1 id="watch-headline-title">
            <span title="<?= $_VIDEO->Info["title"] ?>">
                <?= $_VIDEO->Info["title"] ?>
            </span>
        </h1>
        <div id="watch-headline-user-info">
            <?php if (isset($_OWNER->Info) && $_OWNER->Info["is_partner"] && $_OWNER->Info["c_mbanner_image"]): ?>
                <a id="watch-userbanner" class="inline-block" href="/user/<?= $_VIDEO->Info["uploaded_by"] ?>"><strong><img src="<?= cache_bust($_OWNER->Info["c_mbanner_image"]) ?>" alt="<?= displayname($_VIDEO->Info["uploaded_by"]) ?>" title="<?= displayname($_VIDEO->Info["uploaded_by"]) ?>" width="170" height="25"></strong></a>
            <?php else: ?>
                <a id="watch-username" class="inline-block" href="/user/<?= $_VIDEO->Info["uploaded_by"] ?>"><strong><?= displayname($_VIDEO->Info["uploaded_by"]) ?></strong></a>
            <?php endif ?>
            <span id="watch-video-count" class="watch-expander yt-uix-expander yt-uix-expander-collapsed" onclick="moreFrom(this);">
                <span class="watch-expander-head yt-uix-expander-head yt-rounded">
                    <?php if (isset($_OWNER->Info['videos'])): ?>
                        <button class="yt-uix-expander-arrow" onclick="return false;"></button><?= str_replace("{n}", $_OWNER->Info["videos"], $LANGS['uservideoamount']) ?>
                    <?php else: ?>
                        <button class="yt-uix-expander-arrow" onclick="return false;"></button><?= str_replace("{n}", "null", $LANGS['uservideoamount']) ?>
                    <?php endif ?>
                </span>
            </span>
            <?php if(!$Subscribed) : ?>
                <button id="subscribeDiv" class="yt-uix-button yt-uix-tooltip" title="<?= $LANGS['subscribetooltip'] ?>" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" <?php if ($_USER->Logged_In && $_USER->Username != $_OWNER->Username && !$_OWNER->is_blocked($_USER)) : ?>href="javascript:void(0)" onclick="subscribe()"<?php elseif (!$_USER->Logged_In) : ?>href="javascript:void(0)" onclick="window.location.href = '/login'"<?php elseif ($_OWNER->is_blocked($_USER)): ?>href="#" onclick='alert("You can&#39;t subscribe to this channel because you are blocked!");return false;'<?php else : ?>href="javascript:void(0)" onclick="alert('<?= $LANGS['subyourself'] ?>')"<?php endif ?> type="button"><span class="yt-uix-button-content"><?= $LANGS['subscribe'] ?></span></button>
            <?php else : ?>
                <button id="unsubscribeDiv" class="yt-uix-button yt-uix-tooltip" title="<?= $LANGS['unsubscribetooltip'] ?>" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" onclick="subscribe()" type="button"><span class="yt-uix-button-content"><?= $LANGS['unsubscribe'] ?></span></button>
            <?php endif ?>
        </div>
        <div id="watch-more-from-user" class="collapsed">
            <div id="watch-channel-discoverbox" class="yt-rounded">
                <span id="watch-channel-loading"><?= $LANGS['loading'] ?></span>
            </div>
        </div>

    </div>

    </div>
    <!-- end contenttop section -->
    <div id="watch-video-container">
        <div id="watch-video" class=" ">
            <div id="watch-player" style="background: transparent; z-index: 1000;">
                <?php if (!isset($_COOKIE["html5_player"])) : ?>
                        <?php $_VIDEO->show_video(640, 360, true, $LANGS) ?>
                    <?php else : ?>
                <object width="640" height="385" class="fl flash-video"><param name="movie" value="/player.swf?video_id=<?= $_VIDEO->Info['file_url'] ?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" class="fl"></object>
                    <?php endif ?>
            </div>
            <!-- begin videoextra section -->
            <!-- end videoextra section -->
        </div>
    </div>
    <!-- begin contentbottom section -->
    <div id="watch-main-container">
        <div id="watch-main">
            <div id="watch-panel">
                <?php if ($_OWNER->Username == $_USER->Username): ?>
                <div id="video-status">
                <div id="info-box" class="yt-alert yt-alert-info yt-rounded" style="width: 630px;margin:0;margin-bottom: 8px;">
                    <div class="yt-alert-icon-small" style="margin-top: 2px;"></div>
                    <div id="" class="yt-alert-content" style="margin: 4px 0 4px 16px;"><?php if ($_VIDEO->Info['privacy'] == 1): ?><?= $LANGS['thisvideoispublic'] ?><?php elseif ($_VIDEO->Info['privacy'] == 3): ?><?= $LANGS['thisvideoisunlisted'] ?><?php else: ?><?= $LANGS['thisvideoisprivate'] ?><?php endif ?></div>
                    <div class="clear"></div>
                </div>
                <?php if ($_OWNER->Username == $_USER->Username): ?>
                    <div id="video-status-edit" class="hid">
                    <div id="info-box" class="yt-alert yt-alert-info yt-rounded" style="width: 630px;margin:0;margin-bottom: 8px;">
                        <div class="yt-alert-icon-small" style="margin-top: 2px;"></div>
                        <div id="" class="yt-alert-content" style="margin: 2px 0 3px 16px;"><?= $LANGS['thisvideois'] ?> <select name="select" id="edit-video-privacy">
                          <option value="1" <?php if ($_VIDEO->Info['privacy'] == 1): ?>selected<?php endif ?>><?= $LANGS['public'] ?></option>
                          <option value="3" <?php if ($_VIDEO->Info['privacy'] == 3): ?>selected<?php endif ?>><?= $LANGS['unlisted'] ?></option>
                          <option value="2" <?php if ($_VIDEO->Info['privacy'] == 2): ?>selected<?php endif ?>><?= $LANGS['private'] ?></option>
                        </select>.</div>
                        <div class="clear"></div>
                    </div>
                    </div>
                <?php endif?>
                </div>
                <?php endif ?>
                <div id="watch-actions">
                    <div id="watch-actions-more">
                        <span class="watch-view-count">
                          <strong><?= number_format_lang($_VIDEO->Info['views']) ?></strong>
                        </span>
                        <button title="<?= $LANGS['showvideostats'] ?>" type="button" id="watch-insight-button" class="yt-uix-tooltip reverse master-sprite yt-uix-button yt-uix-tooltip" role="button" onclick="toggleStats();" onmouseover="showTooltip(this);" onmouseout="hideTooltip(this);" aria-pressed="false" data-tooltip="<?= $LANGS['showvideostats'] ?>" title="<?= $LANGS['showvideostats'] ?>" data-tooltip-timer="4337"><img class="yt-uix-button-icon-watch-insight" src="/img/pixel.gif" alt=""> </button>
                    </div>
<div id="watch-actions-left">
<span class="yt-uix-button-group">
<?php if ($_VIDEO->Info['e_ratings'] != 0) : ?>
<?php if (!$_OWNER->is_blocked($_USER)): ?>
<button id="watch-like" class="<?php if ($Rated >= 3): ?>active <?php endif ?>master-sprite-new yt-uix-button yt-uix-tooltip start reverse" title="<?= $LANGS['liketooltip'] ?>" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" <?php if ($_USER->Logged_In): ?>onclick="like(); return false;"<?php else: ?>onclick="window.location.href = '/login'; return false;"<?php endif ?> type="button">
    <img class="yt-uix-button-icon-watch-like" src="/img/pixel.gif" alt="">
<span class="yt-uix-button-content"><?= $LANGS['like'] ?></span>
</button><button id="watch-unlike" class="<?php if ($Rated <= 2 && $Rated > 0): ?>active <?php endif ?>master-sprite-new yt-uix-button yt-uix-tooltip end reverse" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" title="<?= $LANGS['disliketooltip'] ?>" <?php if ($_USER->Logged_In): ?>onclick="dislike(); return false;"<?php else: ?>onclick="window.location.href = '/login'; return false;"<?php endif ?> type="button">
    <img class="yt-uix-button-icon-watch-unlike" src="/img/pixel.gif" alt="">
</button>
<?php endif ?>
<?php else: ?>
<?= $LANGS['ratingsdisabled'] ?>
<?php endif ?>
</span>
<span class="yt-uix-button-group">
<button type="button" class="master-sprite start reverse yt-uix-button yt-uix-tooltip" id="yt-uix-button-<?= $_VIDEO->URL ?>" onclick="addToQueue(this);return false;" title="<?= $LANGS['addtoqueue'] ?>"onmouseover="showTooltip(this);" onmouseout="hideTooltip();" role="button"><img class="yt-uix-button-icon-addto" src="/img/pixel.gif" alt=""> <span class="yt-uix-button-content"><span class="addto-label"><?= $LANGS['addto'] ?></span></span></button><button id="watch-playlists-button" class="end yt-uix-button yt-uix-tooltip" title="<?= $LANGS['savetotooltip'] ?>" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" <?php if ($_USER->Logged_In): ?>onclick="dropdown(this); loadPlaylists(); return false;"<?php else: ?>onclick="window.location.href = '/login'; return false;"<?php endif ?> type="button">
<img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
<ul class="yt-uix-button-menu yt-uix-button-menu-text hid">
    <li><span class="yt-uix-button-menu-item" onclick="saveTo('favorites');return false;"><?= $LANGS['favorites'] ?></span></li>
    <li><span class="yt-uix-button-menu-item" id="loading-playlists" onclick="return false;"><i>Loading playlists...</i></span></li>
</button>
</span>
<button id="watch-share" class="master-sprite-new yt-uix-button yt-uix-tooltip" title="<?= $LANGS['sharetooltip'] ?>" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" onclick="shareVideo();" type="button">
<span class="yt-uix-button-content"><?= $LANGS['share'] ?></span>
</button>
<button id="watch-embed" class="yt-uix-button yt-uix-tooltip" onclick="embed();" title="<?= $LANGS['embedtooltip'] ?>" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" type="button">
    
<span class="yt-uix-button-content"><?= $LANGS['embed'] ?></span>
    
</button>
<button id="watch-flag" class="master-sprite-new yt-uix-button yt-uix-tooltip" title="<?= $LANGS['flagtooltip'] ?>" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" <?php if ($_USER->Logged_In): ?>onclick="flag(); return false;"<?php else: ?>onclick="window.location.href = '/login'; return false;"<?php endif ?> type="button">
    <img class="yt-uix-button-icon-watch-flag" src="/img/pixel.gif" alt="">
    
</button>
</div>

<div id="watch-actions-share" class="hid">
    <div class="watch-actions-share">
        <div class="close-button" onclick="hideDiv(this);"></div>
    <input class="watch-actions-share-input" type="text" value="http://www.bitview.net/watch?v=<?= $_VIDEO->Info["url"] ?>"><br>
    <button class="watch-share-button yt-uix-button" href="mailto:?subject=Check%20this%20video%20out%20--%20<?= $_VIDEO->Info['title'] ?>&body=http://www.bitview.net/watch?v=<?= $_VIDEO->Info["url"] ?>" type="button">
        <img class="yt-uix-button-icon-watch-share icn_share_promoted_email" src="/img/pixel.gif" alt="">
    <span class="yt-uix-button-content">Email</span>
    </button>
    <button class="watch-share-button yt-uix-button" onclick="window.open('https://www.facebook.com/sharer/sharer?u=http://www.bitview.net/watch?v=<?= $_VIDEO->Info["url"] ?>','','height=500,width=400'); return false;" type="button">
        <img class="yt-uix-button-icon-watch-share icn_share_promoted_facebook" src="/img/pixel.gif" alt="">
    <span class="yt-uix-button-content">Facebook</span> 
    </button>
    <?php $bwittertext = "Check this video out -- ".$_VIDEO->Info["title"]." http://www.bitview.net/watch?v=".$_VIDEO->Info["url"]; ?>
    <button type="button" class="watch-share-button yt-uix-button" onclick="window.open('http://blips.club/share?title=<?= urlencode($bwittertext) ?>','','height=500,width=600'); return false;"><img class="yt-uix-button-icon-watch-share icn_share_promoted_blips" src="/img/pixel.gif" alt=""> <span class="yt-uix-button-content">Blips</span></button>
    <button class="watch-share-button yt-uix-button" onclick="window.open('http://www.reddit.com/submit?url=http://www.bitview.net/watch?v=<?= $_VIDEO->Info["url"] ?>','','height=500,width=800'); return false;" type="button">
        <img class="yt-uix-button-icon-watch-share icn_share_promoted_reddit" src="/img/pixel.gif" alt="">
    <span class="yt-uix-button-content">reddit</span>
        
    </button>
    </div>
</div>

<div id="watch-actions-embed" class="hid"><?= $LANGS['loading'] ?></div>
<div id="watch-actions-flag" class="hid"><?= $LANGS['loading'] ?></div>
<div id="watch-actions-stats" class="hid"><?= $LANGS['loading'] ?></div>

<div class="clearR"></div>
                </div>
                <div id="watch-info" class="yt-rounded">
                    <?php if ($_OWNER->Username == $_USER->Username): ?>
                    <div id="video-info-edit" class="hid">
                        <?= $LANGS['desc'] ?>:<br>
                        <textarea id="video-info-description" style="font-family: Arial,sans-serif;width: 470px;resize: vertical;" maxlength="2048" cols="68" rows="3"><?= $_VIDEO->Info['description'] ?></textarea><br>
                        <?= $LANGS['category'] ?>:<br>
                        <select id="video-info-category" style="margin-bottom: 4px;">
                            <?php foreach ($Video_Category as $ID => $Category) : ?>
                                <option value="<?= $ID ?>"<?php if ($ID == $_VIDEO->Info["category"]) : ?> selected<?php endif ?>><?= $Category ?></option>
                            <?php endforeach ?>
                        </select><br>
                        <?= $LANGS['tags'] ?>:<br>
                        <textarea id="video-info-tags" style="font-family: Arial,sans-serif;width: 470px;resize: vertical;" maxlength="128" cols="68" rows="3"><?= $_VIDEO->Info['tags'] ?></textarea><br>
                    </div>
                    <?php endif ?>
                            <div id="watch-views" class="watch-expander yt-uix-expander yt-uix-expander-collapsed">
    </div>

        <div id="watch-description" class="watch-expander yt-uix-expander yt-uix-expander-animated yt-uix-expander-collapsed">
        <div class="watch-expander-head yt-uix-expander-head yt-rounded" onclick="toggleDescription();">
            <button class="yt-uix-expander-arrow" onclick="return false;"></button>
            <span class="watch-expander-head-content">
                    <a class="watch-description-username" href="/user/<?= $_VIDEO->Info['uploaded_by'] ?>" onclick="event.stopPropagation();"><strong><?= displayname($_VIDEO->Info['uploaded_by']) ?></strong></a>
    <span class="watch-description-separator" style="    margin: 0 0.75em;color: #ccc;">|</span>
    <span class="watch-video-date"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['videotimeformat'], time_machine(strtotime((string) $_VIDEO->Info["uploaded_on"]))); }
                    else {echo strftime($LANGS['videotimeformat'], strtotime((string) $_VIDEO->Info["uploaded_on"])); }  ?></span><span class="watch-description-separator" style="    margin: 0 0.75em;color: #ccc;">|</span><span class="watch-likes-dislikes">
                        <?= str_replace("{l}","<span class='likes'>".number_format_lang($Likes)."</span>",str_replace("{d}","<span class='dislikes'>".number_format_lang($Dislikes)."</span>",$LANGS['likeratiotooltip'])) ?>
      </span>
                <div><?php if (!empty($_VIDEO->Info["description"])) : ?>
                        <?= (nl2br((string) $_VIDEO->Info["description"])) ?>
                    <?php else : ?>
                        <i><?= $LANGS['nodesc'] ?></i>
                    <?php endif ?></div>
            </span>
        </div>
        <div class="watch-expander-body yt-uix-expander-body">
            <div id="watch-description-body">
                <div class="watch-info-description-head">
                    <a class="watch-description-username" href="/user/<?= $_VIDEO->Info['uploaded_by'] ?>" onclick="event.stopPropagation();"><strong><?= displayname($_VIDEO->Info['uploaded_by']) ?></strong></a>
    <span class="watch-description-separator" style="    margin: 0 0.75em;color: #ccc;">|</span>
    <span class="watch-video-date"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['videotimeformat'], time_machine(strtotime((string) $_VIDEO->Info["uploaded_on"]))); }
                    else {echo strftime($LANGS['videotimeformat'], strtotime((string) $_VIDEO->Info["uploaded_on"])); }  ?></span><span class="watch-description-separator" style="    margin: 0 0.75em;color: #ccc;">|</span><span class="watch-likes-dislikes">
                        <?= str_replace("{l}","<span class='likes'>".number_format_lang($Likes)."</span>",str_replace("{d}","<span class='dislikes'>".number_format_lang($Dislikes)."</span>",$LANGS['likeratiotooltip'])) ?>
                    </span>
                </div>
                <div id="video-desc"><?php if (!empty($_VIDEO->Info["description"])) : ?>
                        <?= make_user_clickable(make_links_clickable(nl2br((string) $_VIDEO->Info["description"]))) ?>
                    <?php else : ?>
                        <i><?= $LANGS['nodesc'] ?></i>
                    <?php endif ?></div>
            
                <div id="watch-category">
                    <span><?= $LANGS['category'] ?>:</span>
                    <a href="/browse?category=<?= $_VIDEO->Info["category"] ?>"><?= $Video_Category[$_VIDEO->Info["category"]] ?></a>
                </div>

                <div id="watch-tags">
                    <span><?= $LANGS['tags'] ?>:</span>
                    <div>
                            <?php $Tag_Amount = count(explode(",", (string) $_VIDEO->Info["tags"]));
                            $Count = 0; ?>
                            <?php if($_VIDEO->Info["tags"]) : ?>
                                <?php foreach (explode(",", (string) $_VIDEO->Info["tags"]) as $Tag) : ?>
                                    <?php $Count++ ?>
                                    <a href="/results?search=<?= urlencode($Tag) ?>&t=Search+Videos"><?= $Tag ?></a><?php if ($Count != $Tag_Amount) : ?>&nbsp;<?php endif ?>
                                <?php endforeach ?>
                            <?php else : ?>
                                <i>No Tags...</i>
                            <?php endif ?>
                    </div>
                </div>
                <br>

                <div class="clearR"></div>
            </div>
        </div>
    </div>

    
    <div id="watch-stats-container"><?= $LANGS['loading'] ?></div>

    <div class="clearR"></div>

                </div>
<div id="watch-actions-area-container" class="collapsed">
    <div id="watch-actions-area" class="yt-rounded"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?= $LANGS['loading'] ?>
    </font></font></div>
</div>
<div id="watch-actions-close" class="hid">
    <div class="close"><img src="/img/pixel.gif" class="master-sprite close-button" onclick="hideDiv(this);"></div>
</div>
<div id="watch-discussion">

<?php if ($_VIDEO->Info['e_comments'] == 1 or $_VIDEO->Info['e_comments'] == 2 and $_USER->is_friends_with($_OWNER) == true or $_VIDEO->Info['e_comments'] == 2 and $_USER->Username == $_OWNER->Username) :?>
        <ul id="watch-comments-core" data-type="highlights" onmouseleave="hideActions();">
<?php if ($Highest_Rated): ?>
                            <li>
                <div class="comment-highlight-section-header" onmouseover="hideActions();">
<?= $LANGS['highestratedcomments'] ?>
                </div>
            </li>
        <?php foreach ($Highest_Rated as $Comment): ?>
        <?php $Comment_Score = $Comment['likes'] - $Comment['dislikes'];?>
        <?php $User_Vote = $DB->execute("SELECT rating FROM comment_votes WHERE id = :ID and by_user = :USERNAME", true, [":ID" => $Comment['id'], ":USERNAME" => $_USER->Username]); if (!isset($User_Vote['rating'])) {$User_Vote['rating'] = 2;} ?>
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
<?php $Response = $DB->execute("SELECT * FROM videos_responses INNER JOIN videos ON videos.url = videos_responses.basevid_id WHERE vid_id = :URL and is_added = 1 ORDER BY videos.views DESC LIMIT 1",true,[":URL" => $_VIDEO->URL]); ?>
<?php if ($Video_Responses || $Response): ?>
<div class="comments-section">
            <li>
                <div class="comment-highlight-section-header" onmouseover="hideActions();">
<?= $LANGS['responses'] ?>
                    <a href="/video_response_view_all?v=<?= $_VIDEO->URL ?>" class="comment-highlight-see-all"><?= $LANGS['seeall'] ?></a>
                </div>
            </li>
    <?php if($Response) : ?>
        <div class="comments-section-description">This is a video response to <a href="/watch?v=<?= $Response["basevid_id"] ?>"><?= $Response["title"] ?></a></div>
    <?php endif ?>
                <?php foreach ($Video_Responses as $Video): ?>
    <li class="video-list-item "><a class="video-list-item-link" href="/watch?v=<?= $Video['url'] ?>">    
<span class="video-thumb video-thumb-94" id="video-thumb-<?= $Video['url'] ?>">
                <span class="img">
                <img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg94" alt="<?= $Video['title'] ?>" title="<?= $Video['title'] ?>"></span>
                <span class="video-time"><?= timestamp($Video["length"]) ?></span><?php if (!in_array($Video["url"], $_USER->QuickList)): ?>
                <span class="video-actions"><button type="button" class=" yt-uix-button yt-uix-button-short" id="yt-uix-button-short-<?= $Video['url'] ?>" onclick="addToQuickList(this);return false;"><span class="yt-uix-button-content"><strong>+</strong></span></button></span>
                <span class="video-in-quicklist"><?= $LANGS['addedtoqueue'] ?></span>
            <?php endif ?></span>
            <span class="title" title="<?= $Video['title'] ?>"><?= $Video['title'] ?></span><span class="stat"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span><span class="stat"><?= displayname($Video['uploaded_by']) ?></span></a></li>
        <?php endforeach ?>
<div class="clearL"></div>
</div>
<?php endif ?>
<?php if (isset($Video_Comments)): ?>
                    <li>
                <div class="comment-highlight-section-header" onmouseover="hideActions();">
<?= $LANGS['allcomments'] ?> (<span id="comment-amount"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info['comments']) ?><?php else: ?><?= ($_VIDEO->Info['comments']) ?><?php endif ?></span>)
                    <a class="comment-highlight-see-all" href="/comment_servlet?all_comments&v=<?= $_VIDEO->URL ?>"><?= $LANGS['seeall'] ?></a>
                </div>
            </li>
        <?php if (!$_USER->Logged_In): ?>
<div id="comments-post" onmouseover="hideActions();">
<textarea class="comments-textarea" style="height: 40px;overflow: hidden;color: #ccc;margin: 1px 0;padding: 3px 2px;width: 460px;border: 1px solid #666;display: block;margin-bottom: 5px;clear: left;" onfocus="_addclass(_gel('comments-post-form'), 'input-focused');" onblur="_removeclass(_gel('comments-post-form'), 'input-focused');"><?= $LANGS['respondvideo'] ?></textarea>
<div id="comments-post-form-alert" class="yt-alert yt-alert-warn yt-rounded">
        <div class="yt-alert-icon master-sprite"></div>
        <div id="" class="yt-alert-content" style="font-weight: bold;">
                    <a href="/login">Sign In</a> or <a href="/signup">Sign Up</a> now to post a comment!

        </div>
        <div class="clear"></div>
    </div>
</div>
<?php else: ?>
<?php if ($_VIDEO->Info['e_comments'] == 1 or $_VIDEO->Info['e_comments'] == 2 and $_USER->is_friends_with($_OWNER) == true or $_VIDEO->Info['e_comments'] == 2 and $_USER->Username == $_OWNER->Username) :?>
<?php if (!$_OWNER->is_blocked($_USER)): ?>
<div id="comments-post" onmouseover="hideActions();">
                <form id="comments-post-form" class="input-collapsed" onsubmit="return false;" method="post" action="" data-comment-type="V">
                    <input type="hidden" value="" name="form_id">
                    <input type="hidden" name="video_id" value="<?= $_VIDEO->URL ?>">
                    <input type="hidden" name="return_ajax" value="true">
                    <textarea class="comments-textarea" oninput="chars_remaining(this)" name="comment" onfocus="inputFocus(this)" onblur="inputBlur(this)"><?= $LANGS['respondvideo'] ?></textarea>
                    <span class="comments-post-count"><input type="textbox" class="comments-post-count-textbox" value="500"> <?= $LANGS['charactersremaining'] ?></span>
                    <div class="comments-post-area">
                        <span class="comments-post-result"></span><a href="#" onclick="cancelPost(this); return false;"><?= $LANGS['cancel'] ?></a> <?= $LANGS['or'] ?> <button type="button" class="watch-comments-post yt-uix-button" onclick="post_comment('<?= $_VIDEO->URL ?>')"><span class="yt-uix-button-content" style="font-size: 12px;"><?= $LANGS['post'] ?></span></button>
                    </div>
                    <div class="clearR"></div>
                </form>
                    <div id="comments-attach-video" class="hid">
        <a href="/video_response_upload?v=<?= $_VIDEO->URL ?>" class="noul"><img id="comments-attach-video-icon" class="master-sprite" src="/img/pixel.gif" alt="<?= $LANGS['attachavideo'] ?>"></a><a href="/video_response_upload?v=<?= $_VIDEO->URL ?>"><?= $LANGS['attachavideo'] ?></a>
    </div>

    </div>
<?php else: ?>
    You can't comment on this video because the uploader has blocked you.
<?php endif ?>
<?php endif ?>
<?php endif ?>
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
    <?php else: ?>
        <div class="comment-highlight-section-header" onmouseover="hideActions();">
<?= $LANGS['allcomments'] ?> (<span id="comment-amount"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info['comments']) ?><?php else: ?><?= ($_VIDEO->Info['comments']) ?><?php endif ?></span>)
                    <a class="comment-highlight-see-all" href="/comment_servlet?all_comments&v=<?= $_VIDEO->URL ?>"><?= $LANGS['seeall'] ?></a>
                </div>
        <?php if (!$_USER->Logged_In): ?>
<div id="comments-post" onmouseover="hideActions();">
<textarea class="comments-textarea" style="height: 40px;overflow: hidden;color: #ccc;margin: 1px 0;padding: 3px 2px;width: 460px;border: 1px solid #666;display: block;margin-bottom: 5px;clear: left;" onfocus="_addclass(_gel('comments-post-form'), 'input-focused');" onblur="_removeclass(_gel('comments-post-form'), 'input-focused');"><?= $LANGS['respondvideo'] ?></textarea>
<div id="comments-post-form-alert" class="yt-alert yt-alert-warn yt-rounded">
        <div class="yt-alert-icon master-sprite"></div>
        <div id="" class="yt-alert-content" style="font-weight: bold;">
                    <a href="/login">Sign In</a> or <a href="/signup">Sign Up</a> now to post a comment!

        </div>
        <div class="clear"></div>
    </div>
</div>
<?php else: ?>
<?php if ($_VIDEO->Info['e_comments'] == 1 or $_VIDEO->Info['e_comments'] == 2 and $_USER->is_friends_with($_OWNER) == true or $_VIDEO->Info['e_comments'] == 2 and $_USER->Username == $_OWNER->Username) :?>
<?php if (!$_OWNER->is_blocked($_USER)): ?>
<div id="comments-post" onmouseover="hideActions();">
                <form id="comments-post-form" class="input-collapsed" onsubmit="return false;" method="post" action="" data-comment-type="V">
                    <input type="hidden" value="" name="form_id">
                    <input type="hidden" name="video_id" value="<?= $_VIDEO->URL ?>">
                    <input type="hidden" name="return_ajax" value="true">
                    <textarea class="comments-textarea" oninput="chars_remaining(this)" name="comment" onfocus="inputFocus(this)" onblur="inputBlur(this)"><?= $LANGS['respondvideo'] ?></textarea>
                    <span class="comments-post-count"><input type="textbox" class="comments-post-count-textbox" value="500"> <?= $LANGS['charactersremaining'] ?></span>
                    <div class="comments-post-area">
                        <span class="comments-post-result"></span><a href="#" onclick="cancelPost(this); return false;"><?= $LANGS['cancel'] ?></a> <?= $LANGS['or'] ?> <button type="button" class="watch-comments-post yt-uix-button" onclick="post_comment('<?= $_VIDEO->URL ?>')"><span class="yt-uix-button-content" style="font-size: 12px;"><?= $LANGS['post'] ?></span></button>
                    </div>
                    <div class="clearR"></div>
                </form>
                    <div id="comments-attach-video" class="hid">
        <a href="/video_response_upload?v=<?= $_VIDEO->URL ?>" class="noul"><img id="comments-attach-video-icon" class="master-sprite" src="/img/pixel.gif" alt="<?= $LANGS['attachavideo'] ?>"></a><a href="/video_response_upload?v=<?= $_VIDEO->URL ?>"><?= $LANGS['attachavideo'] ?></a>
    </div>

    </div>
<?php else: ?>
    You can't comment on this video because the uploader has blocked you.
<?php endif ?>
<?php endif ?>
<?php endif ?>
    <?php endif ?>
    <?php else: ?>
        <?= $LANGS['commentsdisabled'] ?>
    <?php endif ?>
            <div id="watch-comments-actions" class="" style="top: -1000px; left: -1000px;">
            <button id="watch-comment-vote-up" class="master-sprite-new yt-uix-button yt-uix-tooltip" title="<?= $LANGS['voteuptooltip'] ?>" onclick="vote(this,1); return false;" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" type="button">
                <img class="yt-uix-button-icon-watch-comment-vote-up" src="/img/pixel.gif" alt="">
            </button>
            <button id="watch-comment-vote-down" class="master-sprite-new yt-uix-button yt-uix-tooltip" title="<?= $LANGS['votedowntooltip'] ?>" onclick="vote(this,0); return false;" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" type="button">
                <img class="yt-uix-button-icon-watch-comment-vote-down" src="/img/pixel.gif" alt="">
            </button>
            <span class="yt-uix-button-group">
                <button class="master-sprite-new yt-uix-button start" onclick="replyCom(this); return false;" type="button">
                    <img class="yt-uix-button-icon-watch-comment-reply" src="/img/pixel.gif" alt="">
                    <span class="yt-uix-button-content"><?= $LANGS['reply'] ?></span>
                </button><button type="button" class="end yt-uix-button" onclick="commentsDropdown(this); return false;" data-button-menu-id="comments-actions-menu" role="button" aria-pressed="false" aria-expanded="false"> 
                    <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
                    <ul class="yt-uix-button-menu yt-uix-button-menu-text hid" id="comments-actions-menu" style="left: 0px; top: 14px;">
                    <li><span class="yt-uix-button-menu-item" onclick="flagCom(this); return false;"><?= $LANGS['flagspamtooltip'] ?></span></li>
                    <li id="watch-comment-remove-link"><span class="yt-uix-button-menu-item" onclick="delete_comment(); return false;"><?= $LANGS['removetooltip'] ?></span></li>
                    </ul></button>
            </span>
        </div>
        </ul>
        <div id="watch-comments-loading" class="hid"><?= $LANGS['loading'] ?></div>
                </div>
        </div>
<div id="watch-sidebar" class="yt-rounded-top ">
    <?php if (isset($_GET['pl'])): ?>
<div class="watch-active-list yt-uix-expander yt-uix-expander-animated watch-module watch-module-expandable  <?php if ($PLCount != $Current_Position): ?>yt-uix-expander-collapsed<?php endif ?> " id="watch-next-list">
    <h3 class="yt-uix-expander-head watch-module-head" <?php if ($PLCount != $Current_Position): ?>onclick="openPlaylistMenu();"<?php endif?>>
        <button class="yt-uix-expander-arrow master-sprite" onclick="return false;"></button>
        <span class="watch-module-expanded-title-wrapper"><span class="watch-module-expanded-title">
                <?= $Playlist["title"] ?>
        </span></span>
        <span class="watch-module-collapsed-title"><?= str_replace("{n}",$Playlist["title"],$LANGS['nextin']) ?></span>
    </h3>
    <div class="yt-uix-expander-body watch-module-body">
        <div id="watch-next-list-body-collapsed" class="watch-active-list-body-collapsed">
                <?php if (isset($_NXTVID)): ?>
                <ul class="serial-next-video video-list">
    <li class="video-list-item "><a class="video-list-item-link" href="watch?v=<?= $_NXTVID->URL ?>&pl=<?= $_GET['pl'] ?>">
    <span class="video-thumb ux-thumb-54" id="video-thumb-<?= $_NXTVID->URL ?>"><span class="img"><img src="<?= $Next_Video['thumb'] ?>" title="<?= $_NXTVID->Info['title'] ?>"></span>
    </span>
    <span class="title " title="<?= $_NXTVID->Info['title'] ?>"><?= $_NXTVID->Info['title'] ?></span><span class="stat alt">
    <?= str_replace("{n2}",$PLCount,str_replace("{n1}",$Next_Video_Pos,$LANGS['playlistposition'])) ?></span><span class="stat"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_NXTVID->Info["views"]) ?><?php else: ?><?= ($_NXTVID->Info["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span></a></li>
                    </ul>
                    <?php endif ?>
        </div>
        <div id="watch-next-list-body" class="watch-active-list-body">
            <ul class="video-list">
                <?php foreach ($Playlist_Videos as $PlVideo) : ?>
                <li class="video-list-item<?php if ($PlVideo['position'] == $Current_Position): ?> hover<?php endif ?>"><a class="video-list-item-link" href="watch?v=<?= $PlVideo["url"] ?>&pl=<?= $_GET['pl'] ?>">
                <span class="video-thumb ux-thumb-54" id="video-thumb-<?= $PlVideo["url"] ?>"><span class="img"><img src="<?= $PlVideo['thumb'] ?>" title="<?= $PlVideo['title'] ?>"></span>
                </span>
                <span class="title " title="<?= $PlVideo['title'] ?>"><?= $PlVideo['title'] ?></span><span class="stat alt">
                <?php $_PLVIDEO = new Video($PlVideo['url'], $DB); ?>
                <?= str_replace("{n2}",$PLCount,str_replace("{n1}",$PlVideo['position'],$LANGS['playlistposition'])) ?></span><?php if ($_USER->can_watch_video($_PLVIDEO)): ?><span class="stat"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($PlVideo['views']) ?><?php else: ?><?= ($PlVideo['views']) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span><?php endif ?></a></li>
                <?php endforeach?>
            </ul>
        </div>
        <div class="watch-next-list-actions"><span class="yt-uix-button-group"><button type="button" class="reverse start yt-uix-button" onclick="openOptions(this);return false;"><span class="yt-uix-button-content"><?= $LANGS['options'] ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt=""><ul style="display:none;" class="yt-uix-button-menu" onmouseover="toggleHov(this);" onmouseout="toggleHov(this);"><li><span class="yt-uix-button-menu-item" onclick="window.location.href = '/view_playlist?id=<?= $_GET['pl'] ?>';"><?= $LANGS['openplaylist'] ?></span></li></ul></button><button type="button" class="master-sprite end autoplay-<?php if (isset($_COOKIE['autoplay']) && $_COOKIE['autoplay'] == true): ?>on<?php else:?>off<?php endif?> yt-uix-button" onclick="toggleAutoplay(this);return false;" id="watch-next-list-autoplay"><img class="yt-uix-button-icon-autoplay" src="/img/pixel.gif" alt=""> <span class="yt-uix-button-content"><?php if (isset($_COOKIE['autoplay']) && $_COOKIE['autoplay'] == true): ?><?= $LANGS['autoplayon'] ?><?php else:?><?= $LANGS['autoplayoff'] ?><?php endif?></span></button></span></div>
    </div>
</div>
<?php endif ?>
<?php if ($_USER->QuickList): ?>
<div class="watch-passive-list yt-uix-expander yt-uix-expander-animated yt-uix-expander-collapsed watch-module watch-module-expandable" id="watch-passive-QL">
    <h3 class="yt-uix-expander-head watch-module-head yt-rounded-top yt-rounded-bottom" onclick="toggleQL();">
        <button class="yt-uix-expander-arrow" onclick="return false;"></button>
<?= $LANGS['queue'] ?> (<span id="watch-passive-QL-count"><?= count($_USER->QuickList) ?></span>)
    </h3>
    <div class="yt-uix-expander-body watch-module-body yt-rounded-bottom">
        <div id="watch-passive-QL-body" class="watch-module-body-inner">
            <ul class="video-list">
                <?php $Videos_Array = sql_IN_fix($_USER->QuickList);
                    $Videos = new Videos($DB, $_USER);
                    $Videos->WHERE_C = "AND videos.url IN ($Videos_Array)";
                    $Videos->ORDER_BY = "field(videos.url,$Videos_Array) DESC";
                    $Videos->Private_Videos = true;
                    $Videos->STATUS         = 3;
                    $Videos->get();
                    if ($Videos::$Videos) {
                        $Videos = $Videos->fix_values(true, true);
                    } else {
                        $Videos = [];
                    }?>
                <?php $Count = 0 ?>
                <?php foreach ($Videos as $PlVideo): ?>
                <li class="video-list-item"><a class="video-list-item-link" style="margin-left: 6px;" href="watch?v=<?= $PlVideo["url"] ?>&pl=<?php if (isset($_GET['pl'])) echo $_GET['pl'] ?>">
                <span class="video-thumb ux-thumb-54" id="video-thumb-<?= $PlVideo["url"] ?>"><span class="img"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$PlVideo["url"].'.jpg')): ?>src="/u/thmp/<?= $PlVideo["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> title="<?= $PlVideo['title'] ?>"></span>
                </span>
                <span class="title " title="<?= $PlVideo['title'] ?>"><?= $PlVideo['title'] ?></span><span class="stat"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($PlVideo['views']) ?><?php else: ?><?= ($PlVideo['views']) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span></a></li>
                <?php endforeach?>
            </ul>
        </div>
            <div id="watch-next-list-actions"><span class="yt-uix-button-group"><button id="watch-next-list-options" class="reverse start yt-uix-button" onclick="openOptions(this); return false;" data-button-menu-ignore-group="true" type="button">

<span class="yt-uix-button-content"><?= $LANGS['options'] ?></span>
<img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
        <ul class=" yt-uix-button-menu" style="display: none">
                <li><span class="yt-uix-button-menu-item" onclick="window.location.href = '/my_quicklist'"><?= $LANGS['openplaylist'] ?></span></li>
                <li><span class="yt-uix-button-menu-item" onclick="window.location.href = '/my_quicklist?clear=1'"><?= $LANGS['clear'] ?></span></li>
        </ul>
</button></span></div></div>
</div>
<?php endif ?>
    <div class="watch-module">
        <div class="watch-module-body">
            <h4 class="first"><?= $LANGS['suggestions'] ?></h4>
            <ul id="watch-related">
                <?php foreach ($Featured_Video as $Video): ?>
                <li class="video-list-item  watch-ppv-vid"><a class="video-list-item-link" href="/watch?v=<?= $Video['url'] ?>">  
                <span class="video-thumb video-thumb-94" id="video-thumb-<?= $Video['url'] ?>">
                <span class="img">
                <img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg94" alt="<?= $Video['title'] ?>" title="<?= $Video['title'] ?>"></span>
                <span class="video-time"><?= timestamp($Video["length"]) ?></span><?php if (!in_array($Video["url"], $_USER->QuickList)): ?>
                <span class="video-actions"><button type="button" class=" yt-uix-button yt-uix-button-short" id="yt-uix-button-short-<?= $Video['url'] ?>" onclick="addToQuickList(this);return false;"><span class="yt-uix-button-content"><strong>+</strong></span></button></span>
                <span class="video-in-quicklist"><?= $LANGS['addedtoqueue'] ?></span>
            <?php endif ?></span>
<span class="title" title="<?= $Video['title'] ?>"><?= $Video['title'] ?></span><span class="stat"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span><span class="stat alt"><?= $LANGS['feedfeatured'] ?></span><span class="stat"><?= displayname($Video['uploaded_by']) ?></span></a></li>
                        <?php endforeach ?>
        <?php foreach ($Related_Videos as $Video): ?>
    <li class="video-list-item "><a class="video-list-item-link" href="/watch?v=<?= $Video['url'] ?>">    
<span class="video-thumb video-thumb-94" id="video-thumb-<?= $Video['url'] ?>">
                <span class="img">
                <img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg94" alt="<?= $Video['title'] ?>" title="<?= $Video['title'] ?>"></span>
                <span class="video-time"><?= timestamp($Video["length"]) ?></span><?php if (!in_array($Video["url"], $_USER->QuickList)): ?>
                <span class="video-actions"><button type="button" class=" yt-uix-button yt-uix-button-short" id="yt-uix-button-short-<?= $Video['url'] ?>" onclick="addToQuickList(this);return false;"><span class="yt-uix-button-content"><strong>+</strong></span></button></span>
                <span class="video-in-quicklist"><?= $LANGS['addedtoqueue'] ?></span>
            <?php endif ?></span>
            <span class="title" title="<?= $Video['title'] ?>"><?= $Video['title'] ?></span><span class="stat"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span><span class="stat"><?= displayname($Video['uploaded_by']) ?></span></a></li>
        <?php endforeach ?>
            </ul>
        </div>
    </div>

            </div>
            <div class="clear"></div>
        </div>
        <div id="yt-uix-tooltip-tip" class="yt-uix-tooltip-tip yt-uix-tooltip-tip-visible" style="left: 0; top: 0;"><div class="yt-uix-tooltip-tip-body"><div class="yt-uix-tooltip-tip-content"></div></div><div class="yt-uix-tooltip-tip-arrow"></div></div>
    </div>
    <!-- end contentbottom section -->
    </div>
