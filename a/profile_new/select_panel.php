<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

if (!isset($_GET["panel"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["url"])) {
    header("location: /");
    exit();
}

$Panel = $_GET['panel'];
$URL = $_GET['url'];

$_VIDEO = new Video($_GET["url"],$DB);
$_VIDEO->get_info();

$Video_Comments = $_VIDEO->comments(true,1,20);

$Playlists = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME ORDER BY playlists.title ASC",false,[":USERNAME" => $_USER->Username]);

if ($_USER->Logged_In) { $Flagged = $_USER->has_flagged($_VIDEO); }
    else                   { $Flagged = false; }

?>
<?php if ($Panel == "info"): ?>
                    <div id="playnav-video-panel-inner" class="border-box-sizing">
            
                <div id="playnav-panel-info" class="scrollable">
                        <div id="playnav-curvideo-rating">
        

        <script language="javascript">


        document.getElementById('playnav-curvideo-rating').onmouseover = function() { hidediv('defaultRatingMessage'); showdiv('hoverMessage'); };
        document.getElementById('playnav-curvideo-rating').onmouseout = function() { showdiv('defaultRatingMessage'); hidediv('hoverMessage'); };
    
        </script>
        <?php $_PROFILE = new User($_VIDEO->Info['uploaded_by'],$DB);?>
        <?php if (!$_PROFILE->is_blocked($_USER)) : ?>
        <div id="channel-like-action">
            <div id="channel-like-buttons">
                <?php if ($_USER->Logged_In) { $Rated = $_USER->has_rated($_VIDEO); }
                        else { $Rated = false; } ?>
                <button id="watch-like" class="<?php if ($Rated >= 3): ?>active <?php endif ?>master-sprite-new yt-uix-button yt-uix-tooltip" title="<?= $LANGS['liketooltip'] ?>" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" <?php if ($_USER->Logged_In): ?>onclick="like(); return false;"<?php else: ?>onclick="window.location.href = '/login'; return false;"<?php endif ?> type="button">
                    <img class="yt-uix-button-icon-watch-like" src="/img/pixel.gif" alt="">
                <span class="yt-uix-button-content"><?= $LANGS['like'] ?></span>
                </button>
                <button id="watch-unlike" class="<?php if ($Rated <= 2 && $Rated > 0): ?>active <?php endif ?>master-sprite-new yt-uix-button yt-uix-tooltip" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" title="<?= $LANGS['disliketooltip'] ?>" <?php if ($_USER->Logged_In): ?>onclick="dislike(); return false;"<?php else: ?>onclick="window.location.href = '/login'; return false;"<?php endif ?> type="button">
                    <img class="yt-uix-button-icon-watch-unlike" src="/img/pixel.gif" alt="">
                </button>
            </div>
            <form method="post" action="" name="likeForm" class="hid">
                <input type="hidden" id="like_video_id" value="<?= $_VIDEO->URL ?>">
            </form>
        </div>
        <?php endif ?>
    </div>
        

    <div id="playnav-curvideo-title" class="inner-box-title">

        <span style="cursor:pointer;margin-right:7px" onclick="document.location.href='/watch?v=<?= $_VIDEO->Info["url"] ?>'" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
            <?= $_VIDEO->Info['title'] ?>
        </span>
    </div>
            
    
    <div id="playnav-curvideo-info-line">
        
        <?= $LANGS['from'] ?>: <span id="playnav-curvideo-channel-name"><a href="/user/<?= $_VIDEO->Info['uploaded_by'] ?>"><?= displayname($_VIDEO->Info['uploaded_by']) ?></a></span>&nbsp;|
        <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['longtimeformat'], time_machine(strtotime((string) $_VIDEO->Info["uploaded_on"]))); }
                    else {echo strftime($LANGS['longtimeformat'], strtotime((string) $_VIDEO->Info["uploaded_on"])); }  ?>&nbsp;|
        <span id="playnav-curvideo-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info["views"]) ?><?php else: ?><?= ($_VIDEO->Info["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
    </div>

    <div class="cb"></div>
    
    <div id="playnav-curvideo-description-container">
        <div id="playnav-curvideo-description"><?= short_title(nl2br((string) $_VIDEO->Info['description']), 100) ?>
            <div id="playnav-curvideo-description-more-holder">
                <div id="playnav-curvideo-description-more" class="inner-box-bg-color">
                    ...&nbsp;<a class="channel-cmd" href="javascript:;" onclick="playnav.toggleFullVideoDescription(true)">(more info)</a>&nbsp;&nbsp;
                </div>          
                <div class="cb"></div>          
            </div>
            <span id="playnav-curvideo-description-less">
                <a href="javascript:;" class="channel-cmd" onclick="playnav.toggleFullVideoDescription(false)">(less info)</a>
            </span>
        </div>
    </div>
    
    <a href="/watch?v=<?= $_VIDEO->Info["url"] ?>" id="playnav-watch-link" onclick="playnav.goToWatchPage()"><?= $LANGS['viewcomments'] ?></a>
    
    
    <div id="playnav-curvideo-controls">
    </div>
    
    <div class="cb"></div>
    
    <script>
        if (_gel('playnav-curvideo-description').offsetHeight > 28) {
            _gel('playnav-curvideo-description-more-holder').style.display = 'block';
        }
        
    </script>
    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_companion_ad.js"></script>

                </div>

                    <div id="playnav-panel-comments" class="hid"></div>

                <div id="playnav-panel-favorite" class="hid"></div>
                <div id="playnav-panel-share" class="hid scrollable"></div>
                <div id="playnav-panel-playlists" class="hid"></div>
                <div id="playnav-panel-flag" class="hid"></div>
            </div>
<?php endif ?>
<?php if ($Panel == "comments"): ?>
<div id="playnav-video-panel-inner" class="border-box-sizing">
                                
<div id="playnav-panel-comments" class=""><h2><?= $LANGS['statcomments'] ?> (<?= $_VIDEO->Info["comments"] ?>)</h2>
<div class="playnav_comments">
<?php foreach ($Video_Comments as $Comment): ?>
<div class="watch-comment-entry">
    <div class="watch-comment-head">
        <div class="watch-comment-info">
            <a class="watch-comment-auth" href="/user/<?= $Comment['by_user'] ?>" rel="nofollow"><?= displayname($Comment['by_user']) ?></a>
            <span class="watch-comment-time"> (<?= get_time_ago($Comment['submit_on']) ?>) </span>
        </div>
        <div class="clearL"></div>
    </div>
    <div>
        <div class="watch-comment-body">
            <div>
                <?= make_user_clickable(make_links_clickable(nl2br((string) $Comment["content"]))) ?>
            </div>
        </div>
        <div></div>
    </div>
</div>
<?php endforeach ?>
</div>
<a href="/watch?v=<?= $_VIDEO->Info["url"] ?>" id="playnav-watch-link" onclick="playnav.goToWatchPage()"><?= $LANGS['seeallcommentsandresponses'] ?></a>
</div>
<div id="playnav-comment-post">
            <?php $_PROFILE = new User($_VIDEO->Info['uploaded_by'],$DB);?>
            <?php if ($_USER->Logged_In && !$_PROFILE->is_blocked($_USER)) : ?>
                <form action="/watch?v=<?= $_VIDEO->Info["url"] ?>" method="post" style="margin:0 0 1em 0;     width: 362px;">
                    <h2><?= $LANGS['commentonthisvideo'] ?></h2>
                    <textarea cols="36" rows="6" id="comment_text" name="comment_text" maxlength="500" oninput="chars_remaining()"></textarea><br />
                    <input style="margin-top: 5px" type="button" onclick="post_comment('<?= $_VIDEO->Info["url"] ?>')" name="comment_submit" id="comment_submit" value="<?= $LANGS['postcomment'] ?>" /><span class="charcount">&nbsp;<span id="char-counter">500</span></span>
                </form>
            <?php elseif ($_PROFILE->is_blocked($_USER)):?>
                <div>
                    You can't comment on this video because the uploader has blocked you.
                </div>
            <?php elseif (!$_USER->Logged_In) : ?>
                <h2><?= $LANGS['commentlogin'] ?></h2>
                <div>
                    <?= $LANGS['commentlogindesc'] ?>
                </div>
            <?php endif ?>
        </div>
</div>
<?php endif ?>
<?php if ($Panel == "favorite"): ?>
<?php if ($_USER->Logged_In and !$_USER->has_favorited($_VIDEO)) : ?>
<script>
favorite_video('<?= $URL ?>');
</script>
<?php endif ?>
<div id="playnav-video-panel-inner" class="border-box-sizing">
    <div id="playnav-panel-favorite" class="" <?php if ($_USER->Logged_In): ?>style="color: black;"<?php endif?>>
        <?php if ($_USER->Logged_In): ?>
        <div class="favorite-panel">
            <div id="favorite-saving" <?php if ($_USER->Logged_In and !$_USER->has_favorited($_VIDEO)) : ?><?php else: ?>style="display: none"<?php endif ?>>
                <p><?= $LANGS['saving'] ?></p>
            </div>
            <div id="favorite-added" <?php if ($_USER->Logged_In and $_USER->has_favorited($_VIDEO)) : ?><?php else: ?>style="display: none"<?php endif ?>>
                <p><?= $LANGS['favadded'] ?> (<a href="#" onclick="undo_favorite('<?= $URL ?>');return false;"><?= $LANGS['undo'] ?></a>)</p>
            </div>
            <div id="favorite-remove" style="display: none;">
                <p><?= $LANGS['favremoved'] ?></a> (<a href="#" onclick="favorite_video('<?= $URL ?>');return false;"><?= $LANGS['undo'] ?></a>)</p>
            </div>
        </div>
        <?php else: ?>
    <center><h3><?= $LANGS['logintofav'] ?></h3></center>
    <?php endif ?>
    </div>
</div>
<?php endif ?>
<?php if ($Panel == "share"): ?>
<div id="playnav-video-panel-inner" class="border-box-sizing">
<div id="playnav-panel-share">
    <div class="inner-box-colors" style="font-size:12px">
    <b><a href="http://www.reddit.com/submit?url=http://www.bitview.net/watch?v=<?= $URL ?>" target="_blank" onclick="">Reddit</a></b>&emsp;
    <b><a href="https://www.facebook.com/sharer/sharer?u=http://www.bitview.net/watch?v=<?= $URL ?>" target="_blank" onclick="">Facebook</a></b>&emsp;
    <?php $bwittertext = "Check this video out -- ".$_VIDEO->Info["title"]." http://www.bitview.net/watch?v=".$URL; ?>
    <b><a href="https://blips.club/share?title=<?= urlencode($bwittertext) ?>" target="_blank" onclick="">Blips</a></b>&emsp;
    <div class="spacer">&nbsp;</div>
    <div class="scrollbox-separator">
    <div class="outer-box-bg-as-border"></div>
    </div>
    <b><?= $LANGS['pastethislink'] ?>: </b><input name="video_link" id="watch-url-field" type="text" value="http://www.bitview.net/watch?v=<?= $URL ?>" style="width: 250px;" readonly="">
    </div>
</div>
</div>
<?php endif ?>
<?php if ($Panel == "playlists"): ?>
<div id="playnav-video-panel-inner" class="border-box-sizing">
<div id="playnav-panel-playlists">
    <?php if ($_USER->Logged_In): ?>
    <div>
        <h2 style="padding-bottom: 4px;"><?= $LANGS['selectplaylist'] ?>:</h2>
    <select name="playlists" id="select_playlist" size="7" style="width: 200px;">
        <?php foreach ($Playlists as $Playlist): ?>
        <option value="<?= $Playlist['id'] ?>"> <?= $Playlist['title'] ?> </option>
        <?php endforeach ?>
    </select>
    <button class="yt-button yt-button-primary" onclick="addVideoToPlaylist('<?= $URL ?>')" ><?= $LANGS['addtoplaylist'] ?></button>
    <div id="video-added-to-playlist" style="display: none;float: right;background: #94ff94;padding: 6px 12px;color: black;opacity: .75;">Video added to playlist</div>
    </div>
<?php else: ?>
    <center><h3><?= $LANGS['logintopl'] ?></h3></center>
<?php endif ?>
</div>
</div>
<?php endif ?>
<?php if ($Panel == "flag"): ?>
<div id="playnav-video-panel-inner" class="border-box-sizing">
<div id="playnav-panel-flag">
<div id="inappropriateVidDiv" class="watch-more-action"><h3 style="text-align: center;"><a href="<?php if (!$_USER->Logged_In) : ?>/login<?php else : ?>/a/flag_video?v=<?= $_VIDEO->Info["url"] ?><?php endif ?>" onclick="flag_video(this)" <?php if ($_USER->Logged_In) : ?>target="_blank"<?php endif ?>><?php if (!$Flagged) : ?><?= $LANGS['flagthisvid'] ?><?php else : ?><?= $LANGS['removeflag'] ?><?php endif ?></a></h3>
                <i style="text-align: center; font-size: 12px !important;"><?= $LANGS['flagnote'] ?></i>
            </div>
</div>
</div>
<?php endif ?>