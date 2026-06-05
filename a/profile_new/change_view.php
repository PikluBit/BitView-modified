<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

if (!isset($_GET["view"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["channel"])) {
    header("location: /");
    exit();
}

$_PROFILE = new User($_GET["channel"],$DB);
$_PROFILE->get_info();

if ($_GET["info"] == "playnav-navbar-tab-uploads" or $_GET["info"] == "playnav-navbar-tab-favorites" or $_GET["info"] == "playnav-navbar-tab-playlists") {
    $Videos_Limit = 24;
    $Playlists_Limit = 24;
}
else {
    $Videos_Limit = 8;
    $Playlists_Limit = 6;
}

$Videos = new Videos($DB,$_PROFILE);
$Videos->WHERE_P    = ["videos.uploaded_by" => $_PROFILE->Username];
$Videos->ORDER_BY   = "videos.uploaded_on DESC";
$Videos->LIMIT      = $Videos_Limit;
$Videos->get();
if (isset($Videos) && $Videos::$Videos)             { $Videos = $Videos->fix_values(true,true); }
    else                                                { $Videos = false; }

$FavVideos                 = new Videos($DB,$_PROFILE);
$FavVideos->WHERE_P        = ["videos_favorites.username" => $_PROFILE->Username, "videos.status" => 2];
$FavVideos->ORDER_BY       = "videos_favorites.submit_on DESC";
$FavVideos->Private_Videos = true;
$FavVideos->Can_Watch      = true;
$FavVideos->LIMIT          = $Videos_Limit;
$FavVideos->JOIN           = "RIGHT JOIN videos_favorites ON videos_favorites.url = videos.url";
$FavVideos->get();
if (isset($FavVideos) && $FavVideos::$Videos)             { $FavVideos = $FavVideos->fix_values(true,true); }
    else                                                { $FavVideos = false; }

$Playlists = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME ORDER BY playlists.title ASC LIMIT $Playlists_Limit",false,[":USERNAME" => $_PROFILE->Username]);
$Playlists_Amount = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME",false,[":USERNAME" => $_PROFILE->Username]);
if ($DB->Row_Num != 0) {
    $Playlists_Amount = count($Playlists_Amount);
}
else {
    $Playlists_Amount = 0;
}
$Videos_Page_Amount = $_PROFILE->Info["videos"] / 24;
if (is_float($Videos_Page_Amount)) { $Videos_Page_Amount = (int)$Videos_Page_Amount; }
$Favorites_Page_Amount = $_PROFILE->Info["favorites"] / 24;
if (is_float($Favorites_Page_Amount)) { $Favorites_Page_Amount = (int)$Favorites_Page_Amount; }
?>
<div id="playnav-grid-content">
    <?php if ($_GET["info"] == "playnav-navbar-tab-all"): ?>
        <?php if ($_PROFILE->Info["c_videos_box"] != 0) : ?>
                            <div class="playnav-grid-uploads">
                                <div class="playnav-playlist-header" style="padding: 0;">
            <a href="javascript:;" style="text-decoration:none" onclick="selectTab('uploads','<?= $_PROFILE->Username ?>');return false;" class="title title-text-color">
                <span id="playnav-playlist-uploads-all-title" style="font-size: 13px;" class="title"><?= $LANGS['uploads'] ?></span>
                    (<?= $_PROFILE->Info["videos"] ?>)
            </a>
        
        
    </div>
    <?php if ($Videos): ?>
        <?php $Count = 0 ?>
        <?php foreach ($Videos as $Video) : ?>
            <?php $Count++ ?>
                                    <div class="playnav-item playnav-video selected playnav-item-selected" id="playnav-video-<?= $Count ?>-<?= $Video['url'] ?>" onclick="playVideo('uploads-all','<?= $Count ?>','<?= $Video['url'] ?>');return false;">
                <div id="playnav-video-play-<?= $Video['url'] ?>-selector"></div>
                <div class="content">
                    <div class="playnav-video-thumb link-as-border-color">
                        <a class="video-thumb-90 no-quicklist" href="#"><img title="<?= $Video["title"] ?>" src="<?= $Video["thumb"] ?>" class="vimg90 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
            
                    </div>
                    <div class="playnav-video-info">
                        <a href="#" class="playnav-item-title ellipsis"><span class="video-title-<?= $Video['url'] ?>"><?= $Video["title"] ?></span></a>
                        <div class="metadata video-meta-<?= $Video['url'] ?>"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>  -  <?= get_time_ago($Video["uploaded_on"]) ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
    </div>
<?php endif ?>
<?php if ($_PROFILE->Info["c_favorites_box"] != 0) : ?>
    <div class="playnav-grid-favorites">
                                <div class="playnav-playlist-header" style="padding: 0;">
            <a href="javascript:;" style="text-decoration:none" onclick="selectTab('favorites','<?= $_PROFILE->Username ?>');return false;" class="title title-text-color">
                <span id="playnav-playlist-favorites-all-title" style="font-size: 13px;" class="title"><?= $LANGS['favorites'] ?></span>
                    (<?= $_PROFILE->Info["favorites"] ?>)
            </a>
        
        
    </div>
    <?php if ($FavVideos): ?>
        <?php $Count = 0 ?>
        <?php foreach ($FavVideos as $Video) : ?>
            <?php $Count++ ?>
                                    <div class="playnav-item playnav-video selected playnav-item-selected" id="playnav-video-<?= $Count ?>-<?= $Video['url'] ?>" onclick="playVideo('favorites-all','<?= $Count ?>','<?= $Video['url'] ?>');return false;">
                <div id="playnav-video-play-<?= $Video['url'] ?>-selector"></div>
                <div class="content">
                    <div class="playnav-video-thumb link-as-border-color">
                        <a class="video-thumb-90 no-quicklist" href="#"><img title="<?= $Video["title"] ?>" src="<?= $Video["thumb"] ?>" class="vimg90 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
            
                    </div>
                    <div class="playnav-video-info">
                        <a href="#" class="playnav-item-title ellipsis"><span class="video-title-<?= $Video['url'] ?>"><?= $Video["title"] ?></span></a>
                        <div class="metadata video-meta-<?= $Video['url'] ?>"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>  -  <?= get_time_ago($Video["uploaded_on"]) ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
    </div>
<?php endif ?>
    <?php if ($_PROFILE->Info["c_playlists_box"] != 0) : ?>
    <div class="playnav-grid-playlists">
                                <div class="playnav-playlist-header" style="padding: 0;">
            <a href="javascript:;" style="text-decoration:none" onclick="selectTab('playlists','<?= $_PROFILE->Username ?>');return false;" class="title title-text-color">
                <span id="playnav-playlist-playlists-all-title" style="font-size: 13px;" class="title"><?= $LANGS['playlists'] ?></span>
                    (<?= $Playlists_Amount ?>)
            </a>
        
        
    </div>
    <?php if ($Playlists): ?>
        <?php $Count = 0 ?>
        <?php foreach ($Playlists as $Playlist) : ?>
            <?php $Count++ ?>
            <?php
                        $Videos = $DB->execute("SELECT url FROM playlists_videos WHERE playlist_id = :ID ORDER BY position ASC",false,array(":ID" => $Playlist["id"]));
                        if ($Videos) {
                            if (isset($Videos[0])) {
                                $Video1 = $Videos[0]["url"];
                            }
                        } else {
                            $Video1 = false;
                            $Video2 = false;
                            $Video3 = false;
                        }

                    ?>
            <div id="playnav-video-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>" class="playnav-item playnav-playlist">
            <div style="display:none" class="encryptedVideoId"><?= $Playlist['id'] ?></div>
            <div id="playnav-video-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>-selector"></div>
            <div class="content">
                <div class="vCluster120WideEntry"><div class="vCluster120WrapperOuter"><div class="vCluster120WrapperInner"><a id="video-url" onclick="selectView('play','<?= $_PROFILE->Username ?>');open_playlist('playlists','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" href="/view_playlist?id=<?= $Playlist["id"] ?>" rel="nofollow"><img title="<?= $Playlist["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video1.'.jpg')): ?>src="/u/thmp/<?= $Video1 ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimgCluster120" alt="<?= $Playlist["title"] ?>"></a><div class="video-corner-text"><span><?= $DB->execute("SELECT count(url) as amount FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["amount"] ?> <?= $LANGS['plvideoamount'] ?></span></div></div></div></div>
                <div class="playnav-video-info">
                    <a href="/view_playlist?id=<?= $Playlist['id'] ?>" class="playnav-item-title ellipsis" onclick="selectView('play','<?= $_PROFILE->Username ?>');open_playlist('playlists-all','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" id="playnav-video-title-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>"><span><?= $Playlist['title'] ?></span></a>
                    <div class="metadata">
                            <span class="playnav-video-username"><?= get_time_ago($Playlist["submit_date"])  ?></span>
                    </div>
                    
                    <div style="display:none" id="playnav-video-play-playlists-all-<?= $Count ?>"><?= $Playlist['id'] ?></div>                  
                </div>
            </div>
        </div>
        <?php endforeach ?>
    <?php endif ?>
    </div>
    <?php endif ?>
<?php endif ?>
<?php if ($_GET["info"] == "playnav-navbar-tab-uploads"): ?>
    <div style="margin-bottom: 16px;padding: 4px 10px 10px 10px;height: 23px;border-bottom: 1px solid;">
    <div class="search-box" style="margin-bottom: 8px;float: left;">
        <input type="text" id="upload_search_query-grid" class="box-outline-color" style="width:200px;border-width:1px;border-style:solid;padding: 1px" onkeypress="if (event.keyCode == 13) { searchChannel('upload_search_query-grid','<?= $_PROFILE->Username ?>'); }">
        &nbsp;
            <a class="yt-button" style="height: 21px;vertical-align: middle;line-height: 21px;" href="javascript:;" onclick="searchChannel('upload_search_query-play','<?= $_PROFILE->Username ?>');return false"><span><?= $LANGS['searchuploads'] ?></span></a>
    </div>

                <div style="display:none" id="uploads-sort">date</div>
    <div class="sorters" style="float: right;vertical-align: middle;margin-top: 4px;">
        <a style="" href="javascript:;" onmousedown="sortVideos('date','<?= $_PROFILE->Username ?>')"><?= $LANGS['sortdateadded'] ?></a>
        |
        <a style="" href="javascript:;" onmousedown="sortVideos('popularity','<?= $_PROFILE->Username ?>')"><?= $LANGS['mostviewed'] ?></a>
        |
        <a style="" href="javascript:;" onmousedown="sortVideos('rating','<?= $_PROFILE->Username ?>')"><?= $LANGS['toprated'] ?></a>        
    </div>
    <div style="clear: both;"></div>
</div>
<div class="scrollbox-body" style="height: 536px; zoom: 1;">
                <div class="outer-scrollbox" <?php if ($Videos_Page_Amount > 1): ?>onscroll="loadVideos('uploads', 2, '<?= $_PROFILE->Username ?>', 'date');"<?php endif?>>
                    <div id="playnav-play-uploads-items" class="inner-scrollbox">
    <?php if ($Videos) : ?>
    <?php $Count = 0; ?>
    <?php $VideoCount = 0; ?>
        <?php foreach ($Videos as $Video) : ?>
            <?php $Count++ ?>
            <?php $VideoCount++ ?>
                                    <div class="playnav-item playnav-video" id="playnav-video-<?= $VideoCount ?>-<?= $Video['url'] ?>" style="
        float: left;
        width: 144px;
        margin-bottom: 6px;
        height: 136px;
    " onclick="playVideo('uploads','<?= $VideoCount ?>','<?= $Video['url'] ?>');return false;">
                <div id="playnav-video-play-<?= $Video['url'] ?>-selector"></div>
                <div class="content">
                    <div class="playnav-video-thumb link-as-border-color">
                        <a class="video-thumb-120 no-quicklist" href="#"><img title="<?= $Video["title"] ?>" src="<?= $Video["thumb"] ?>" class="vimg120 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
            
                    </div>
                    <div style="clear:both;"></div>
                    <div class="playnav-video-info" style="width: 122px;margin-top: 4px;">
                        <a href="#" class="playnav-item-title ellipsis"><span class="video-title-<?= $Video['url'] ?>" style="font-size: 12px;display: block;height: 28px;"><?= $Video["title"] ?></span></a>
                        <div class="metadata video-meta-<?= $Video['url'] ?>"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?><br><?= get_time_ago($Video["uploaded_on"]) ?></div>
                    </div>
                </div>
            </div><?php if ($Count == 6) : ?>
                        <br>
                        <?php $Count = 0 ?>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
                </div><div style="clear:both"></div><?php if ($Videos_Page_Amount > 1): ?><div class="alignC" id="show-more-2"><b><a href="#" onclick="loadVideos('uploads', 2, '<?= $_PROFILE->Username ?>', 'date');return false;">Show More</a></b></div><?php endif ?></div></div>
<?php endif ?>
<?php if ($_GET["info"] == "playnav-navbar-tab-favorites"): ?>
    <div class="scrollbox-body" style="height: 596px; zoom: 1;">
                <div class="outer-scrollbox" <?php if ($Favorites_Page_Amount > 1): ?>onscroll="loadVideos('favorites', 2, '<?= $_PROFILE->Username ?>', 'date');"<?php endif ?>>
                    <div id="playnav-play-favorites-items" class="inner-scrollbox">
    <?php if ($FavVideos): ?>
        <?php $Count = 0; ?>
        <?php $VideoCount = 0 ?>
        <?php foreach ($FavVideos as $Video) : ?>
            <?php $Count++ ?>
            <?php $VideoCount++ ?>
                                    <div class="playnav-item playnav-video" id="playnav-video-<?= $VideoCount ?>-<?= $Video['url'] ?>" style="
        float: left;
        width: 144px;
        margin-bottom: 6px;
        height: 136px;
    " onclick="playVideo('uploads','<?= $VideoCount ?>','<?= $Video['url'] ?>');return false;">
                <div id="playnav-video-play-<?= $Video['url'] ?>-selector"></div>
                <div class="content">
                    <div class="playnav-video-thumb link-as-border-color">
                        <a class="video-thumb-120 no-quicklist" href="#"><img title="<?= $Video["title"] ?>" src="<?= $Video["thumb"] ?>" class="vimg120 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
            
                    </div>
                    <div style="clear:both;"></div>
                    <div class="playnav-video-info" style="width: 122px;margin-top: 4px;">
                        <a href="#" class="playnav-item-title ellipsis"><span class="video-title-<?= $Video['url'] ?>" style="font-size: 12px;display: block;height: 28px;"><?= $Video["title"] ?></span></a>
                        <div class="metadata video-meta-<?= $Video['url'] ?>"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?><br><?= get_time_ago($Video["uploaded_on"]) ?></div>
                    </div>
                </div>
            </div><?php if ($Count == 6) : ?>
                        <br>
                        <?php $Count = 0 ?>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
                </div><div style="clear:both"></div><?php if ($Favorites_Page_Amount > 1): ?><div class="alignC" id="show-more-2"><b><a href="#" onclick="loadVideos('favorites', 2, '<?= $_PROFILE->Username ?>', 'date');return false;">Show More</a></b></div><?php endif ?></div></div>
<?php endif ?>
<?php if ($_GET["info"] == "playnav-navbar-tab-playlists"): ?>
    <?php if ($Playlists): ?>
        <?php $Count = 0; ?>
        <?php foreach ($Playlists as $Playlist) : ?>
            <?php $Count++ ?>
            <?php
                        $Videos = $DB->execute("SELECT url FROM playlists_videos WHERE playlist_id = :ID ORDER BY position ASC",false,array(":ID" => $Playlist["id"]));
                        if ($Videos) {
                            if (isset($Videos[0])) {
                                $Video1 = $Videos[0]["url"];
                            }
                        } else {
                            $Video1 = false;
                            $Video2 = false;
                            $Video3 = false;
                        }

                    ?>
            <div id="playnav-video-play-playlists-<?= $Count ?>-<?= $Playlist['id'] ?>" class="playnav-item playnav-playlist" style="float: left;width:144px;height: 140px;">
            <div style="display:none" class="encryptedVideoId"><?= $Playlist['id'] ?></div>
            <div id="playnav-video-play-playlists-<?= $Count ?>-<?= $Playlist['id'] ?>-selector"></div>
            <div class="content">
                <div class="vCluster120WideEntry"><div class="vCluster120WrapperOuter"><div class="vCluster120WrapperInner"><a id="video-url" onclick="selectView('play','<?= $_PROFILE->Username ?>');open_playlist('playlists','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" href="/view_playlist?id=<?= $Playlist["id"] ?>" rel="nofollow"><img title="<?= $Playlist["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video1.'.jpg')): ?>src="/u/thmp/<?= $Video1 ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimgCluster120" alt="<?= $Playlist["title"] ?>"></a><div class="video-corner-text"><span><?= $DB->execute("SELECT count(url) as amount FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["amount"] ?> <?= $LANGS['plvideoamount'] ?></span></div></div></div></div>
                <div style="clear:both;"></div>
                <div class="playnav-video-info" style="width: 120px;margin-top: 4px;">
                    <a href="/view_playlist?id=<?= $Playlist['id'] ?>" class="playnav-item-title ellipsis" style="height: 28px;" onclick="selectView('play','<?= $_PROFILE->Username ?>');open_playlist('playlists','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" id="playnav-video-title-play-playlists-<?= $Count ?>-<?= $Playlist['id'] ?>"><span><?= $Playlist['title'] ?></span></a>
                    <div class="metadata">
                            <span class="playnav-video-username"><?= get_time_ago($Playlist["submit_date"])  ?></span>
                            <br>
                            <a href="/view_playlist?id=<?= $Playlist['id'] ?>"><?= $LANGS['moreinfo'] ?></a>
                    </div>
                    
                    <div style="display:none" id="playnav-video-play-playlists-<?= $Count ?>"><?= $Playlist['id'] ?></div>                  
                </div>
            </div>
        </div>
        <?php endforeach ?>
    <?php endif ?>
<?php endif ?>