<?php use function PHP81_BC\strftime; ?>
<style type="text/css">
h1 {
    margin: 0!important;
}
#list-pane {
    font-size: 12px;
}
#list-pane .subfolder.selected {
    background-color: #d6e1f5;
}

#list-pane .subfolder {
    padding: 3px 20px;
}
#list-pane .subfolder a {
    color: black;
    text-decoration: none;
}
#view-pane .pager {
    text-align: right;
}
.top-pager {
    float: right;
    margin-top: -22px;
}
#view-pane .splitter {
    padding-left: 7px;
    background-color: #fff;
}
#view-pane .settings {
    height: 20px;
    padding: 10px;
    background-color: #eaeaea;
}
.view #view-toggle {
    float: right;
}
#view-pane .settings .search input {
    margin-right: 10px;
}
#search-query-textbox {
    width: 400px;
}
.view #view-toggle .list img {
    background: transparent url(/img/mmimgs-vfl38740.gif) no-repeat scroll 0 -95px;
    height: 20px;
    width: 24px
}
.view #view-toggle .list-selected img {
    background: transparent url(/img/mmimgs-vfl38740.gif) no-repeat scroll 0 -115px;
    height: 20px;
    width: 24px
}
.view #view-toggle .expand img {
    background: transparent url(/img/mmimgs-vfl38740.gif) no-repeat scroll -24px -95px;
    height: 20px;
    width: 24px
}
.view #view-toggle .expand-selected img {
    background: transparent url(/img/mmimgs-vfl38740.gif) no-repeat scroll -24px -115px;
    height: 20px;
    width: 24px
}
.view #view-toggle .grid img {
    background: transparent url(/img/mmimgs-vfl38740.gif) no-repeat scroll -48px -95px;
    height: 20px;
    width: 24px
}
.view #view-toggle .grid-selected img {
    background: transparent url(/img/mmimgs-vfl38740.gif) no-repeat scroll -48px -115px;
    height: 20px;
    width: 24px
}
.search {
    text-align: left;
}
#view-pane .actions .actions-wrapper {
    height: 25px;
}
img.img-action-arrow {
    background: transparent url(/img/mmimgs-vfl38740.gif) no-repeat scroll 0 -10px;
    height: 14px;
    width: 14px;
}
#table .video-box {
    float: left;
    margin: 15px 0 0 0;
    padding: 10px 0 10px 10px;
    width: 150px;
}
#table .video .check-box {
    float: left;
}
#table .video .details {
    float: left;
    width: 120px;
}
.video-thumb {
    background-color: white;
    position: relative;
}

.video-thumb-220, .video-thumb-128, .video-thumb-120, .video-thumb-90, .video-thumb-50 {
    display: block;
    overflow: hidden;
    border: 3px double #999;
    padding: 0;
    border-radius: 0;
}
.video-thumb-120 {
    width: 120px;
    height: 72px;
}
.video-stats {
    width: auto;
    float: none !important;
}
.video-stats {
    margin: 10px 0 0 0;
    float: left;
}
#grid-view .video-stat {
    width: auto;
}
.video-stat span {
    color: #000;
}
.video-stat, .video-messages {
    height: 15px;
    width: 100%;
    overflow: hidden;
    margin-bottom: 5px;
    white-space: nowrap;
    color: #444;
}
#view-pane .footer {
    border: 0;
    border-top: 1px solid #999;
    font-size: 12px;
}
#view-pane .pager {
    text-align: right;
    width: 100%;
}
#view-pane .header .pager a, #view-pane .header .pager span, #view-pane .footer .pager a, #view-pane .footer .pager span {
    margin: 0 4px 0 4px;
}
#table #headings td {
    border-left: 1px solid #999;
    border-bottom: 1px solid #999;
    font-size: 11px;
    width: auto;
}
#table #headings td:first-of-type {
    font-size: 11px;
    width: 0;
}
.dropdown {
    display: block!important;
}
#addto-playlist-checklist {
    height: 100px;
    overflow: auto;
    border: 1px solid #999;
}
#messages {
    border-bottom: 1px solid #999;
}
.yt-message-panel {
    padding: 0 5px;
}
#table .video.even, #table .video-details.even {
    background-color: #f3f3f3;
}
#table .video .column-check {
    vertical-align: top;
}
#table .video td, #table .video-details td {
    padding: 10px 4px;
    vertical-align: middle;
}
.video-buttons-ext {
    margin: 5px 0 0 130px;
}
#expand-view .video-details .video-title {
    margin-bottom: 10px;
}
#table .video .clipper {
    width: 390px;
    overflow: hidden;
    text-overflow: ellipsis;
}
.video-details .video-title a {
    color: #03c;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
}
#expand-view .video-details .video-description-expanded, #list-view .video-details .video-description-expanded {
    line-height: 14px;
    padding: 0;
    margin: 0;
}
.video-details .video-stats {
    margin: 10px 0 0 0;
    width: 49%;
    float: left!important;
}
#table .video .column-title {
    width: 75%;
    white-space: nowrap;
    overflow: hidden;
}
#table .video .clipper {
    width: 390px;
    overflow: hidden;
    text-overflow: ellipsis;
}
#table .video .clipper a {
    white-space: nowrap;
}
#table .video .arrow {
    display: -moz-inline-box;
    display: inline-block;
    margin-right: 5px;
    vertical-align: text-bottom;
}
#table .video .arrow img {
    background: transparent url(/img/mmimgs-vfl38740.gif) no-repeat scroll -70px -15px;
    height: 15px;
    width: 15px;
}
#table .video.expanded .arrow img {
    background: transparent url(/img/mmimgs-vfl38740.gif) no-repeat scroll -85px -15px;
}
.my-videos-tiny-thumb {
    display: -moz-inline-box;
    display: inline-block;
    vertical-align: middle;
    margin-right: 5px;
}
.video-thumb-50 {
    width: 50px;
    height: 30px;
}
.video-thumb-50 img {
    margin-top: -5px;
}
#table .video-details .column-details {
    width: 100%;
    padding: 4px 4px 10px 35px;
}
.expanded .my-videos-tiny-thumb {
    display: none;
}
.vimg120 {
    width: 120px;
    height: auto;
    margin-top: -10px !important;
}
</style>
<script>
function dropdown2(e) {
    if (e.querySelector('.yt-uix-button-menu').classList.contains("hid") && document.activeElement == e) {
        e.querySelector('.yt-uix-button-menu').classList.remove("hid");
        e.classList.add('yt-uix-button-active');
        var rect = e.getBoundingClientRect();
        var width = (document.body.clientWidth - 960) / 2;
        var height = document.getElementById('masthead-container').offsetHeight;
        e.querySelector('.yt-uix-button-menu').style.left = rect.left - width + 5 + "px";
        if (!document.getElementById("default-language-box")) {
            e.querySelector('.yt-uix-button-menu').style.top = rect.top + scrollY - height + 15 + "px";
        }
        else {
            var eh = document.getElementById('default-language-box').offsetHeight;
            e.querySelector('.yt-uix-button-menu').style.top = rect.top + scrollY - height - eh - 15 + "px";
        }
    }
    else {
        e.classList.remove('yt-uix-button-active');
        e.querySelector('.yt-uix-button-menu').classList.add("hid");
    }
}
function checkAll(e) {
    var checkboxes = document.getElementsByClassName("video-checkbox");
    for (i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = e.checked;
    }
}
function checkVideo(e) {
    var checkboxes = document.getElementsByClassName("video-checkbox");
    var length_c = 0;
    for (i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) { length_c++; }
    }
    if (length_c > 0) {
        if (length_c == checkboxes.length) {
            document.getElementById('all-items-checkbox').checked = true;
        }
        else {
            document.getElementById('all-items-checkbox').checked = false;
        }
    }
    else { 
        document.getElementById('all-items-checkbox').checked = false;
    }
}
function openPL() {
    document.getElementById('dialog-addto-playlist').classList.toggle('hidden');
}
function addVideos() {
    document.getElementById('dialog-addto-playlist').classList.add('hidden');
    document.getElementById('dialog-addingto-playlist').classList.remove('hidden');
    var videos = [];
    var playlists = [];
    var checkboxes = document.getElementsByClassName("video-checkbox");
    var checkboxes_pl = document.getElementsByClassName("vm-playlist-search-template-checkbox");
    for (i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) { videos.push(checkboxes[i].value) }
    }
    for (i = 0; i < checkboxes_pl.length; i++) {
        if (checkboxes_pl[i].checked) { playlists.push(checkboxes_pl[i].value) }
    }
    if (videos.length > 0 && playlists.length > 0) {
        $.ajax({
            type: "POST",
            url: "/a/add_videos_to",
            data: {
                vid: videos.toString(),
                pl: playlists.toString()
            },
            success: function(output) {
                if (output.response == "success") {
                    document.getElementById('dialog-addingto-playlist').classList.add('hidden');
                    document.getElementById('yt-alert-content').innerHTML = "The video(s) have been added to your playlist(s).";
                    document.getElementById('messages').classList.remove('hidden');
                }
                else if (output.response == "login") {
                    window.location.href = "/login";
                }
                else {
                    alert("Something went wrong!");
                }
            }
        })
    }
    else {
        document.getElementById('dialog-addingto-playlist').classList.add('hidden');
    }
}
function favoriteVideos() {
    document.getElementById('dialog-addto-favorites').classList.remove('hidden');
    var videos = [];
    var checkboxes = document.getElementsByClassName("video-checkbox");
    for (i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) { videos.push(checkboxes[i].value) }
    }
    if (videos.length > 0) {
        $.ajax({
            type: "POST",
            url: "/a/add_videos_to",
            data: {
                vid: videos.toString(),
                pl: "favorites"
            },
            success: function(output) {
                if (output.response == "success") {
                    document.getElementById('dialog-addto-favorites').classList.add('hidden');
                    document.getElementById('yt-alert-content').innerHTML = "The video(s) have been added to Favorites.";
                    document.getElementById('messages').classList.remove('hidden');
                }
                else if (output.response == "login") {
                    window.location.href = "/login";
                }
                else {
                    alert("Something went wrong!");
                }
            }
        })
    }
    else {
        document.getElementById('dialog-addto-favorites').classList.add('hidden');
    }
}
function toggleVideoDetails(e) {
    document.getElementById('video-' + e).classList.toggle('expanded');
    document.getElementById('video-details-' + e).classList.toggle('hidden');
}
</script>
<!-- left column - FOR ADS ONLY IF MY SUBS -->
<div class="nav-header">
<h1>
    <span dir="ltr"><?= $LANGS['subscriptions'] ?></span>
</h1>
</div>
<div id="nav-pane">
    <div id="list-pane">
        <div class="subfolder<?php if (!isset($_GET['channel'])): ?> selected<?php endif ?>"><a class="name" href="/my_subscriptions<?php if (isset($_GET['dm'])): ?>?dm=<?= $_GET['dm'] ?><?php endif ?>"><?= $LANGS['newvideos'] ?></a></div>
    <?php if ($Subscriptions_List): ?>
    <?php foreach ($Subscriptions_List as $Subscription) : ?>
    <div dir="ltr" class="subfolder<?php if (isset($_GET['channel']) && $_GET['channel'] == $Subscription["username"]): ?> selected<?php endif ?>"><a class="name" href="/my_subscriptions?channel=<?= $Subscription["username"] ?><?php if (isset($_GET['dm'])): ?>&dm=<?= $_GET['dm'] ?><?php endif ?>"><?= displayname($Subscription["username"]) ?></a></div>
    <?php endforeach ?>
<?php endif ?>
    </div>
</div>
<div id="view-pane">
    <div class="splitter">
        <div class="view">
            <div class="settings">
                <div class="search">
                        <div id="view-toggle">
                        <a class="list<?php if (isset($_GET['dm']) && $_GET['dm'] == 0): ?>-selected<?php endif ?>" href="/my_subscriptions?dm=0<?php if (isset($_GET['channel'])): ?>&channel=<?= $_GET['channel'] ?><?php endif ?>"><img src="/img/pixel.gif" alt="List View"></a><a class="expand<?php if (isset($_GET['dm']) && $_GET['dm'] == 1 ): ?>-selected<?php endif ?>" href="/my_subscriptions?dm=1<?php if (isset($_GET['channel'])): ?>&channel=<?= $_GET['channel'] ?><?php endif ?>"><img src="/img/pixel.gif" alt="Expanded View"></a><a class="grid<?php if (isset($_GET['dm']) && $_GET['dm'] == 2): ?>-selected<?php endif ?>" href="/my_subscriptions?dm=2<?php if (isset($_GET['channel'])): ?>&channel=<?= $_GET['channel'] ?><?php endif ?>"><img src="/img/pixel.gif" alt="Grid View"></a></div>
                </div>
            </div>
            <div class="actions">
                <div class="actions-wrapper">
                    <img class="img-action-arrow" src="/img/pixel.gif" style="float: left; vertical-align: middle; margin-right: 5px; margin-top: 5px;">
                    <div class="action-button" id="button-addto" style="float: left;">
                        <button type="button" class=" yt-uix-button yt-uix-button-primary" onclick="dropdown2(this);return false;" onfocusout="dropdown2(this);return false;"><img class="yt-uix-button-icon-add" src="/img/pixel.gif" alt=""> <span class="yt-uix-button-content"><?= $LANGS['addto'] ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
                            <ul style="font-weight: normal" class="yt-uix-button-menu yt-uix-button-menu-primary hid"><li><span class=" yt-uix-button-menu-item" onclick="openPL();"><?= $LANGS['playlist'] ?></span></li><li><span class=" yt-uix-button-menu-item" onclick="favoriteVideos();"><?= $LANGS['favorites'] ?></span></li></ul></button>
                        <div class="dropdown">
                            <div id="menu-addto"></div>
                            <div class="dialog hidden" id="dialog-addto-playlist">
                                <form id="form-addto-playlist" class="dialog-body">
                                    <div id="messages-addto-playlist" class="yt-message-panel hidden"></div>
                                    <p class="line"><?= $LANGS['addselectedto'] ?></p>
                                    <p class="line title"><?= $LANGS['playlists'] ?></p>
                                    <p class="line"></p>
                                    <div id="addto-playlist-checklist">
                                        <ol>
                                            <?php $Playlists = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME ORDER BY playlists.title ASC", false, [":USERNAME" => $_USER->Username]); ?>
                                            <?php foreach ($Playlists as $Playlist): ?>
                                            <li id="vm-playlist-search-template">
                                                <label>
                                                    <span class="checkbox"><input class="vm-playlist-search-template-checkbox" value="<?= $Playlist['id'] ?>" type="checkbox"></span>
                                                    <span class="vm-playlist-search-template-title"><?= $Playlist['title'] ?></span>
                                                </label>
                                            </li>
                                            <?php endforeach?>
                                        </ol>
                                    </div>
                                    <p></p>
                                    <p class="line">
                                        <button type="button" id="button-addto-playlist" onclick="addVideos()" class=" yt-uix-button"><span class="yt-uix-button-content"><?= $LANGS['addtoplaylists'] ?></span></button>
                                        <?= $LANGS['or'] ?>
                                        <a href="#" onclick="openPL(); return false;"><?= $LANGS['editcancel'] ?></a>
                                    </p>
                                </form>
                            </div>
                            <div class="dialog hidden" id="dialog-addingto-playlist">
                                <div class="dialog-body">
                                    <span class="yt-loader">Adding videos to selected playlists...</span>
                                </div>
                            </div>
                            <div class="dialog hidden" id="dialog-addto-favorites">
                                <div class="dialog-body">
                                    <span class="yt-loader">Adding videos to favorites...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="messages" class="yt-message-panel hidden"><div id="success-box" style="width:auto" class="yt-alert yt-alert-success yt-rounded">
        <div class="yt-alert-icon master-sprite"></div>
        <div class="yt-alert-close" onclick="hide('success');"><div class="yt-alert-close-icon master-sprite"></div></div>
        <div id="yt-alert-content" class="yt-alert-content"></div><div class="clear"></div></div></div>
    <div id="grid-view">
    <table id="table">
    <?php if (!isset($_GET['dm']) || $_GET['dm'] == 0): ?>
        <tr id="headings">
            <td id="heading-check" class="first heading"><div><input id="all-items-checkbox" type="checkbox" onclick="checkAll(this);"></div></td>
                <td id="heading-title" class="sorted-desc"><div>
            <?= $LANGS['title'] ?>
    </div></td>

                <td id="heading-duration" class=""><div>
            <?= $LANGS['stattime'] ?>
    </div></td>

                <td id="heading-viewcount" class=""><div>
            <?= $LANGS['statviews'] ?>
    </div></td>

                    <td id="heading-username" class=""><div>
            <?= $LANGS['owner'] ?>
    </div></td>

        </tr>
    <?php else: ?>
    <thead>
    <tr id="headings">
        <td id="heading-check" class="first heading"><div><input id="all-items-checkbox" type="checkbox" onclick="checkAll(this);"></div></td>
        <td id="heading-filter" class="heading"><div>
        </div></td>
    </tr>
    </thead>
    <?php endif ?>
        <tbody id="videos">
        <?php if (isset($_GET['dm']) && $_GET['dm'] == 2 ): ?>
                    <tr><td colspan="2">
                    <?php foreach ($Subscriptions as $Video):?>
                    <div class="video video-box">
                        <div class="check-box">
                                <div style="float: left;">
                                    <input type="checkbox" class="video-checkbox" onclick="checkVideo(this);" value="<?= $Video['url'] ?>">
                                </div>
                        </div>
                        <div class="details">
                            <a href="/watch?v=<?= $Video['url'] ?>"><span class="video-thumb video-thumb-120 no-quicklist " id="video-thumb-<?= $Video['url'] ?>"><img src="<?= $Video['thumb'] ?>" class="vimg120" alt="<?= $Video['title'] ?>" title="<?= $Video['title'] ?>"></span></a>
                            <a href="/watch?v=<?= $Video['url'] ?>" class="title" style="display: block; color: #03c;"><?= $Video['title'] ?></a>
                            <div class="video-stats">
                                    <div class="video-stat"><span class="stat-date-added"><?= $LANGS['statadded'] ?>: <?= get_time_ago($Video['uploaded_on']) ?></span></div>
                                    <div class="video-stat"><span class="stat-views"><?= $LANGS['statviews'] ?>: <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?></span></div>
                                <div class="video-stat"><span class="stat-duration"><?= timestamp($Video["length"]) ?></span></div>
                                        <div class="video-stat" style="clear: both; width: 100%;"><span class="stat-username"><a href="/user/<?= $Video['uploaded_by'] ?>"><?= displayname($Video['uploaded_by']) ?></a></span></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                    </td></tr>   
        <?php elseif (isset($_GET['dm']) && $_GET['dm'] == 1): ?>
        <?php $Count = 0 ?>
        <?php foreach ($Subscriptions as $Video):?>
        <?php $Count++ ?>
        <tr id="video-<?= $Video['url'] ?>" class="video <?php if ($Count % 2 != 0): ?>even<?php else: ?>odd<?php endif ?>">
            <td class="column-check first"><input type="checkbox" class="video-checkbox" onclick="checkVideo(this);" value="<?= $Video['url'] ?>"></td>
            <td class="column-details">
            <div class="video-panel">
            <div class="video-details" style="margin: 0 0 10px 130px;">
                    <div class="video-image" style="position: absolute; margin-left: -130px;">
                        <a class="video-thumb-120 no-quicklist" href="/watch?v=<?= $Video['url'] ?>"><img title="Avatar Uncensored" src="<?= $Video['thumb'] ?>" class="vimg120 yt-uix-hovercard-target" alt="<?= $Video['title'] ?>"></a>

                    </div>
                    <div class="video-title">
                        <div class="clipper">
                            <a href="/watch?v=<?= $Video['url'] ?>"><?= $Video['title'] ?></a> <?php if ($Video['hd'] == 1): ?><img src="/img/hd_video_result_page_logo-vfl88394.png" width="18" height="15" style="vertical-align:sub"><?php endif ?>
                        </div>
                    </div>
                <p id="video-description-<?= $Video['url'] ?>" class="video-description-expanded"><span><?= short_title($Video['description'],100) ?></span></p>
                    <div class="video-stats">
        <div class="video-stat">
        <?= $LANGS['statadded'] ?>:
          <span class="stat-date-added"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['myvideostimeformat'], time_machine(strtotime((string) $Video["uploaded_on"]))); }
                    else {echo strftime($LANGS['myvideostimeformat'], strtotime((string) $Video["uploaded_on"])); }  ?></span>
      </div>
        <div class="video-stat">
        <?= $LANGS['stattime'] ?>:
          <span class="stat-duration"><?= timestamp($Video["length"]) ?></span>
      </div>
        <div class="video-stat">
        <?= $LANGS['owner'] ?>:
          <a href="/user/<?= $Video['uploaded_by'] ?>" class="stat-username"><?= displayname($Video['uploaded_by']) ?></a>
      </div>
        </div>
        <div class="video-stats">
        <div class="video-stat">
        <?= $LANGS['statviews'] ?>:
          <span class="stat-views"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?></span>
      </div>
        <div class="video-stat">
        <?= $LANGS['statcomments'] ?>:
          <a href="/comment_servlet?all_comments&v=<?= $Video['url'] ?>" class="stat-comments"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["comments"]) ?><?php else: ?><?= ($Video["comments"]) ?><?php endif ?></a>
      </div>
        </div>
        <div style="clear: both;"></div>
                    <div class="video-buttons">
                            <a class="yt-button" id="" style="padding: 4px 8px;" href="/watch?v=<?= $Video['url'] ?>"><span><?= $LANGS['play'] ?></span></a>
        </div>
            </div>
            <div class="video-buttons-ext">
            </div>
        </div>
        </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <?php $Count = 0 ?>
        <?php if ($Subscriptions): ?>
        <?php foreach ($Subscriptions as $Video):?>
        <?php $Count++ ?>
        <tr id="video-<?= $Video["url"] ?>" class="video <?php if ($Count % 2 != 0): ?>even<?php else: ?>odd<?php endif ?>">
            <td class="column-check first"><input type="checkbox" class="video-checkbox" onclick="checkVideo(this);" value="<?= $Video['url'] ?>"></td>
            <td class="column-title"><div class="clipper">
                <a class="arrow" href="#" onclick="toggleVideoDetails('<?= $Video["url"] ?>'); return false;">
                <img src="/img/pixel.gif"></a>
                    <span id="video-thumb-tiny-<?= $Video["url"] ?>" class="my-videos-tiny-thumb"><a class="video-thumb-50 no-quicklist" href="/watch?v=<?= $Video["url"] ?>"><img title="<?= $Video["title"] ?>" src="<?= $Video["thumb"] ?>" class="vimg50 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a></span>
                    <a href="/watch?v=<?= $Video["url"] ?>"><?= short_title($Video["title"],60) ?></a>
                </div>
            </td>
            <td class="column-duration"><?= timestamp($Video["length"]) ?></td>
            <td class="column-viewcount"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= $Video["views"] ?><?php endif ?></td>
            <td class="column-username"><a href="/user/<?= $Video['uploaded_by'] ?>"><?= displayname($Video['uploaded_by']) ?></a></td>
        </tr>
        <tr id="video-details-<?= $Video['url'] ?>" class="video-details hidden <?php if ($Count % 2 != 0): ?>even<?php else: ?>odd<?php endif ?>">
                            <td colspan="6" class="column-details">
                                        <div class="video-panel">
        <div class="video-details" style="margin: 0 0 10px 130px;">
                    <div class="video-image" style="position: absolute; margin-left: -130px;">
                        <a class="video-thumb-120 no-quicklist" href="/watch?v=<?= $Video['url'] ?>"><img title="Avatar Uncensored" src="<?= $Video['thumb'] ?>" class="vimg120 yt-uix-hovercard-target" alt="<?= $Video['title'] ?>"></a>

                    </div>
                <p id="video-description-<?= $Video['url'] ?>" class="video-description-expanded"><span><?= short_title($Video['description'],100) ?></span></p>
                    <div class="video-stats">
        <div class="video-stat">
        <?= $LANGS['statadded'] ?>:
          <span class="stat-date-added"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['myvideostimeformat'], time_machine(strtotime((string) $Video["uploaded_on"]))); }
                    else {echo strftime($LANGS['myvideostimeformat'], strtotime((string) $Video["uploaded_on"])); }  ?></span>
      </div>
        <div class="video-stat">
        <?= $LANGS['stattime'] ?>:
          <span class="stat-duration"><?= timestamp($Video["length"]) ?></span>
      </div>
        <div class="video-stat">
        <?= $LANGS['owner'] ?>:
          <a href="/user/<?= $Video['uploaded_by'] ?>" class="stat-username"><?= displayname($Video['uploaded_by']) ?></a>
      </div>
        </div>
        <div class="video-stats">
        <div class="video-stat">
        <?= $LANGS['statviews'] ?>:
          <span class="stat-views"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?></span>
      </div>
        <div class="video-stat">
        <?= $LANGS['statcomments'] ?>:
          <a href="/comment_servlet?all_comments&v=<?= $Video['url'] ?>" class="stat-comments"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["comments"]) ?><?php else: ?><?= ($Video["comments"]) ?><?php endif ?></a>
      </div>
        </div>
        <div style="clear: both;"></div>
                    <div class="video-buttons">
                            <a class="yt-button" id="" style="padding: 4px 8px;" href="/watch?v=<?= $Video['url'] ?>"><span><?= $LANGS['play'] ?></span></a>
        </div>
            </div>
        <div class="video-buttons-ext">
        </div>
    </div>
                            </td>
                        </tr>
        <?php endforeach ?>
        <?php endif ?>
        <?php endif ?>
        </tbody>
    </table>
</div>
            <div class="footer">
                <?php $_PAGINATION->new_show_pages_videos("") ?>
            </div>
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
<div class="clear"></div>