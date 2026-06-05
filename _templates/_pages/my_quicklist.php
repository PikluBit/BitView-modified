<style type="text/css">
.nav-header {
    float: left;
    width: 100%;
    background: #fff;
}
.video-time, .video-corner-text span {
    padding: 0 4px;
    font-weight: bold;
    font-size: 11px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    background-color: #000;
    color: #fff !important;
    height: 14px;
    line-height: 14px;
    -moz-opacity: 0.75;
    -webkit-opacity: 0.75;
    opacity: 0.75;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=75)";
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=75);
    display: -moz-inline-stack;
    display: inline-block;
    vertical-align: top;
    zoom: 1;
    float: right;
    margin-top: -14px;
    margin-right: 0;
}
#right-column {
    margin: 0;
}
#baseDiv {
    padding-bottom: 0;
}
.wrapper {
    background: url(/img/vm-border-vfl172330.gif) repeat-y 151px 0 transparent;
    overflow: hidden;
}
.vm-playlist-search-template-title {
    vertical-align: top;
}
#success-box {
    margin: 0 auto;
}
#messages {
    background: white;
}
ul,ol {
    list-style: none
}
h1,h2,h3,h4,h5,h6,pre,code {
    font-size: 1em
}
ul,ol,li,dl,dt,dd,h1,h2,h3,h4,h5,h6,pre,form,body,html,p,blockquote,fieldset {
    margin: 0;
    padding: 0
}
address {
    font-style: normal
}
</style>
<script>
    var confirm_msg = "<?= $LANGS['sureremovevideos'] ?>";
</script>
<script src="/js/my_videos.js"></script>
<div id="messages" class="yt-message-panel">
<div id="success-box" class="yt-alert yt-alert-success yt-rounded hid">
    <div class="yt-alert-icon master-sprite"></div>
    <div class="yt-alert-close" onclick="hideMsg(this);"><div class="yt-alert-close-icon master-sprite"></div></div>
    <div id="" class="yt-alert-content"><?= $LANGS['savedtoplaylist'] ?></div>
    <div class="clear"></div>
</div>
</div>
<!-- left column - FOR ADS ONLY IF MY SUBS -->
<div id="vm-title"><?= $LANGS['myvideos&playlists'] ?></div>
<div id="vm-layout-left">
    <ol class="vm-vertical-nav">
        <li><a class="" href="/viewing_history"><?= $LANGS['history'] ?></a></li>
        <li><a class="" href="/my_videos"><?= $LANGS['uploaded'] ?></a></li>
        <li><a class="" href="/my_liked_videos"><?= $LANGS['liked'] ?></a></li>
        <li><a class="" href="/my_favorites"><?= $LANGS['favorites'] ?></a></li>
        <li><a class="selected" href="/my_quicklist"><?= $LANGS['queue'] ?></a></li>
    </ol>
    <h3 style="border-bottom: 1px solid #ddd;padding-bottom: 4px;margin-left: 0;margin-bottom: 6px;">
<?= $LANGS['channelpl'] ?> <?php if ($_USER->Logged_In): ?> <button type="button" id="vm-new-playlist" onclick="showNewPlaylistDialog();return false;" class=" yt-uix-button yt-uix-button-short" data-button-menu-id="vm-dialog-new-playlist"><span class="yt-uix-button-content">+ <?= $LANGS['new'] ?></span></button><?php endif ?>
    </h3>
    <ol id="vm-playlist-list" class="vm-vertical-nav">
        <?php $Playlists = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME ORDER BY playlists.title ASC", false, [":USERNAME" => $_USER->Username]); ?>
        <?php if ($Playlists): ?>
        <?php foreach ($Playlists as $Playlist): ?>
        <li><a href="/my_playlist?id=<?= $Playlist['id'] ?>" dir="ltr"><?= $Playlist['title'] ?></a></li>
        <?php endforeach?>
        <?php else: ?>
            You have no playlists.
        <?php endif ?>
    </ol>
    <?php if ($_USER->Logged_In): ?>
    <div id="vm-dialog-new-playlist" class="vm-dialog hid">
        <div id="vm-new-playlist-notifs"></div>
            <p><?= $LANGS['newpltitle'] ?></p>
            <p>
                <input id="vm-new-playlist-title-field" type="text" maxlength="255">
            </p>
            <p><?= $LANGS['newpldesc'] ?></p>
            <p>
                <textarea id="vm-new-playlist-desc-field" rows="3"></textarea>
            </p>
            <p><?= $LANGS['newpltags'] ?></p>
            <p>
                <textarea id="vm-new-playlist-tags-field" rows="2" dir="ltr"></textarea>
            </p>
            <p>
                <button type="button" id="vm-new-playlist-save" onclick="createPlaylist();return false;" class=" yt-uix-button"><span class="yt-uix-button-content"><?= $LANGS['newplbutton'] ?></span></button>
                &nbsp; <a href="javascript:;" onclick="closeNewDropdown()"id="vm-new-playlist-cancel"><?= $LANGS['cancel'] ?></a>
            </p>
    </div>
    <?php endif ?>
    </div>
<div id="vm-layout-right">
        <div id="vm-page-subheader">
        <h3>
            <?= $LANGS['queue'] ?>
        </h3>
    </div>

            <div id="vm-general-notifs"></div>
    <div id="vm-video-actions-bar" class="goog-scrollfloater">
        <div id="vm-video-actions-inner">
        <input type="checkbox" id="vm-video-select-all" onchange="checkAll(this);">
            <button type="button" id="vm-playlist-copy-to" onclick="openAddTo();return false;" class=" yt-uix-button" data-button-menu-id="vm-videos-copyto-dialog" disabled=""><span class="yt-uix-button-content"><?= $LANGS['addto'] ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt=""></button>
            <div id="vm-videos-copyto-dialog" class="vm-dialog hid">
                <ol>
                    <li id="vm-playlist-search-template">
                        <label>
                            <span class="checkbox"><input class="vm-playlist-search-template-checkbox" value="favorites" type="checkbox"></span>
                            <span class="vm-playlist-search-template-title"><?= $LANGS['favorites'] ?></span>
                        </label>
                    </li>
                    <?php foreach ($Playlists as $Playlist): ?>
                    <li id="vm-playlist-search-template">
                        <label>
                            <span class="checkbox"><input class="vm-playlist-search-template-checkbox" value="<?= $Playlist['id'] ?>" type="checkbox"></span>
                            <span class="vm-playlist-search-template-title"><?= $Playlist['title'] ?></span>
                        </label>
                    </li>
                    <?php endforeach?>
                </ol>
                <button type="button" id="vm-playlist-copy-to-submit" onclick="addVideos();return false;" class=" yt-uix-button"><span class="yt-uix-button-content"><?= $LANGS['addvideos'] ?></span></button>
                <a href="javascript:;" onclick="openAddTo();" id="vm-videos-copyto-cancel"><?= $LANGS['cancel'] ?></a>
            </div>
            <?php 
            if (count($_USER->QuickList) > 0) {
                $FirstQL = count($_USER->QuickList) - 1;
            } 
            else {
                $FirstQL = 0;
            }
             ?>
            <button type="button" id="vm-quicklist-play" href="/watch?v=<?= $_USER->QuickList[$FirstQL] ?? '' ?>" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button"><span class="yt-uix-button-content"><?= $LANGS['playqueue'] ?></span></button>
            <button type="button" id="vm-quicklist-clear" href="?clear=1" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button"><span class="yt-uix-button-content"><?= $LANGS['clearqueue'] ?></span></button>
        &nbsp;
        <span id="vm-num-videos-shown"><?= $_PAGINATION->Total ?></span> <?php if ($_PAGINATION->Total != 1) { echo $LANGS['plvideoamount']; } else { echo $LANGS['plvideoamountsingular']; } ?>
            
    <span class="vm-separator">|</span> <?= $LANGS['sortby'] ?>:

    
    
    
    <button type="button" id="vm-sort-btn" onclick="dropdown(this);return false;" onfocusout="dropdown(this);" class=" yt-uix-button yt-uix-button-text"><span class="yt-uix-button-content"><?= $SortBy ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt=""><ul style="min-width: 65px; left: 650.227px; top: 259.469px;" class="yt-uix-button-menu yt-uix-button-menu-text hid"><li><span href="?sf=added" id="vm-sort-newest" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['sortnewest'] ?></span></li><li><span href="?sf=added-old" id="vm-sort-oldest" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['sortoldest'] ?></span></li><li><span href="?sf=viewcount" id="vm-sort-viewed" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['sortmostviewed'] ?></span></li><li><span href="?sf=duration-l" id="vm-sort-longest" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['sortlongest'] ?></span></li><li><span href="?sf=duration-s" id="vm-sort-shortest" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['sortshortest'] ?></span></li><li><span href="?sf=title-az" id="vm-sort-az" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['sortaz'] ?></span></li><li><span href="?sf=title-za" id="vm-sort-za" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['sortza'] ?></span></li></ul></button>

        </div>
        <div id="vm-floater-shadow" class="hid" style="display: none;"></div>
    </div>

            <div id="vm-video-list-container">
                <ol id="vm-playlist-video-list-ol" class="vm-video-list">
        <?php if (isset($Videos) && $Videos) : ?>
        <?php foreach ($Videos as $Video) : ?>
        <li id="vm-video-<?= $Video['url'] ?>" class="">
            <div class="vm-video-metrics">
                        <dl>
            <?php $Responses_Amount = (int)$DB->execute("SELECT count(id) as total FROM videos_responses WHERE basevid_id = :URL AND is_added = 1",true,[":URL" => $Video['url']])["total"];
                $Likes = $Video["3stars"] + $Video["4stars"] + $Video["5stars"];
                $Dislikes = $Video["1stars"] + $Video["2stars"];
            ?>
            <dt><?= $LANGS['statviews'] ?>:</dt>
            <dd><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?></dd>
            <dt><?= $LANGS['statcomments'] ?>:</dt>
            <dd><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["comments"]) ?><?php else: ?><?= ($Video["comments"]) ?><?php endif ?></dd>
            <dt><?= $LANGS['statresponses'] ?>:</dt>
            <dd><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Responses_Amount) ?><?php else: ?><?= ($Responses_Amount) ?><?php endif ?></dd>
        <dt><img class="vm-sprite vm-video-rating vm-likes" src="/img/pixel.gif"></dt>
        <dd class="vm-likes-dd"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Likes) ?><?php else: ?><?= ($Likes) ?><?php endif ?> <span class="vm-separator">|</span></dd>
        <dt><img class="vm-sprite vm-video-rating vm-dislikes" src="/img/pixel.gif"></dt>
        <dd><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Dislikes) ?><?php else: ?><?= ($Dislikes) ?><?php endif ?></dd>
    </dl>

            </div>
            <input type="checkbox" class="video-checkbox" onchange="checkVideo(this)" value="<?= $Video['url'] ?>">
                
<a href="/watch?v=<?= $Video['url'] ?>" class="video-thumb ux-thumb-94" id="video-thumb-<?= $Video['url'] ?>"><span class="img"><img src="<?= $Video['thumb'] ?>" onclick="ieThumbEvent(event, this); " title="<?= $Video['title'] ?>"></span><span class="video-time"><?= timestamp($Video["length"]) ?></span></a>
            <div class="vm-video-title">
                    <a href="/watch?v=<?= $Video['url'] ?>"><?= short_title($Video['title'],64) ?></a>
                    <?php if ($Video['hd']): ?>
                    <img class="vm-video-badge" src="/img/hd_video_result_page_logo-vfl88394.png">
                    <?php endif ?>
            </div>
            <span class="vm-video-info"><?= get_time_ago($Video['uploaded_on']) ?><span class="vm-separator">|</span><span class="vm-video-desc"><?= short_title($Video['description'],64) ?></span>
            </span>
            <span class="vm-video-info">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>
            </span>
        </li>
    <?php endforeach ?>
    <?php else: ?>
        <div id="vm-playlist-no-videos"><?= $LANGS['novideoswerefound'] ?></div>
    <?php endif ?>
            </ol>
    </div>

            <div id="vm-pagination">
        <div class="yt-uix-pager">
            <?php if (!isset($_GET['sf'])): ?>
                <?php $_PAGINATION->new_show_pages_videos("") ?>
            <?php else: ?>
                <?php $_PAGINATION->new_show_pages_videos( "sf=".$_GET['sf'] ) ?>
            <?php endif ?>
        </div>
    </div>
  </div>
<!-- START AD COLUMN RIGHT -->
<div id="right-column">
    <div id="sideAd" z-index="10" style="width: auto; height: auto;">       
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- bitviewside -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:120px;height:240px;margin:10px 0"
                 data-ad-client="ca-pub-8433080377364721"
                 data-ad-slot="9813736805"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>