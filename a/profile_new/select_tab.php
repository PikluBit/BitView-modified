<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;

if (!isset($_GET["tab"])) {
    header("location: /");
    exit();
}

$Tab = $_GET['tab'];
$Profile = $_GET['username'];
$_PROFILE = new User($_GET["username"],$DB);
$_PROFILE->get_info();

if ($Tab != "all") {
$Limit = 10;
}
else {
$Limit = 3;
}

$Videos = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC LIMIT $Limit", false, [":USERNAME" => $_PROFILE->Username]);
$FavVideos = $DB->execute("SELECT * FROM videos RIGHT JOIN videos_favorites ON videos_favorites.url = videos.url WHERE videos_favorites.username = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos_favorites.submit_on DESC LIMIT $Limit", false, [":USERNAME" => $_PROFILE->Username]);
$Playlists = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME ORDER BY playlists.title ASC LIMIT 3",false,[":USERNAME" => $_PROFILE->Username]);
$Playlists_2 = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME ORDER BY playlists.title ASC",false,[":USERNAME" => $_PROFILE->Username]);
$Playlists_Amount = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME",false,[":USERNAME" => $_PROFILE->Username]);
$Playlists_Amount = count($Playlists_Amount);
$Videos_Page_Amount = $_PROFILE->Info["videos"] / 10;
if (is_float($Videos_Page_Amount)) { $Videos_Page_Amount = (int)$Videos_Page_Amount + 1; }
$Favorites_Page_Amount = $_PROFILE->Info["favorites"] / 10;
if (is_float($Favorites_Page_Amount)) { $Favorites_Page_Amount = (int)$Favorites_Page_Amount + 1; }

//ALSO GET ONE LATEST VIDEO
if ($_PROFILE->Info['videos'] >= 1 and empty($_PROFILE->Info['c_featured_video'])) {
    $LatVideo = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC LIMIT 1",false,[":USERNAME" => $_PROFILE->Username],false);
}
elseif ($_PROFILE->Info['videos'] == 0 and $_PROFILE->Info['favorites'] >= 1 and empty($_PROFILE->Info['c_featured_video'])) {
    $LatVideo = $DB->execute("SELECT * FROM videos RIGHT JOIN videos_favorites ON videos_favorites.url = videos.url WHERE videos_favorites.username = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos_favorites.submit_on DESC LIMIT 1",false,[":USERNAME" => $_PROFILE->Username],false);
}
elseif (!empty($_PROFILE->Info['c_featured_video'])) {
    $LatVideoURL = $_PROFILE->Info['c_featured_video'];
    $LatVideo = $DB->execute("SELECT * FROM videos WHERE url = :URL AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC LIMIT 1",false,[":URL" => $LatVideoURL],false);
}

?>
<?php if ($Tab == "all"): ?>
<div id="playnav-play-content" style="height: 595px;">  
                <div class="playnav-playlist-holder" id="playnav-play-playlist-all-holder">
                                        
    <div id="playnav-play-all-scrollbox" class="scrollbox-wrapper inner-box-colors">
        <div class="scrollbox-content playnav-playlist-all">
            
            <div class="scrollbox-body" style="height: 585px; zoom: 1;">
                <div class="outer-scrollbox">
                    <div id="playnav-play-all-items" class="inner-scrollbox">
        <?php if ($_PROFILE->Info["c_videos_box"] != 0) : ?>               
        <input type="hidden" id="playnav-playlist-uploads-count" value="<?= $_PROFILE->Info["videos"] ?>">
            <div class="playnav-playlist-header">
            <a href="javascript:;" style="text-decoration:none" onclick="selectTab('uploads','<?= $_PROFILE->Username ?>');return false;" class="title title-text-color">
                <span id="playnav-playlist-uploads-all-title" class="title"><?= $LANGS['uploads'] ?></span>
                    (<?= $_PROFILE->Info["videos"] ?>)
            </a>
        
        
    </div>
    <?php $Count = 0 ?>
    <?php foreach ($Videos as $Video) : ?>
        <?php $Count++ ?>
        <div id="playnav-video-play-uploads-all-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video <?php if (isset($LatVideo) && ($LatVideo[0]['url'] ?? '') == $Video['url']): ?>playnav-item-selected<?php endif?>">
        <div style="display:none" class="encryptedVideoId"><?= $Video['url'] ?></div>

        <div id="playnav-video-play-uploads-all-<?= $Count ?>-<?= $Video['url'] ?>-selector" class="selector"></div>
        <div class="content">
            <div class="playnav-video-thumb link-as-border-color">
                <a class="video-thumb-90 no-quicklist" href="/watch?v=<?= $Video['url'] ?>" onclick="playVideo('uploads-all','<?= $Count ?>','<?= $Video['url'] ?>');return false;"><img title="<?= $Video["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
            </div>
            <div class="playnav-video-info">
                <a href="/watch?v=<?= $Video['url'] ?>" class="playnav-item-title ellipsis" onclick="playVideo('uploads-all','<?= $Count ?>','<?= $Video['url'] ?>');return false;" id="playnav-video-title-play-uploads-all-<?= $Count ?>-<?= $Video['url'] ?>"><span><?= $Video["title"] ?></span></a>
                <div class="metadata">
                        <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>  -  <?= get_time_ago($Video["uploaded_on"]) ?>   
                </div>
                <div style="display:none" id="playnav-video-play-uploads-all-<?= $Count ?>"><?= $Video['url'] ?></div>  
            </div>
        </div>
    </div>
    <?php endforeach ?>
        <div class="playnav-play-column-all">
                <div class="playnav-more"><a class="channel-cmd" href="javascript:;" onclick="selectTab('uploads','<?= $_PROFILE->Username ?>');return false;"><?= $LANGS['seeall'] ?></a></div>
        </div>
        <div class="spacer">&nbsp;</div>
            <div class="scrollbox-separator">
        <div class="outer-box-bg-as-border"></div>
    </div>
<?php endif ?>
    <?php if ($_PROFILE->Info["c_favorites_box"] != 0) : ?>
        <input type="hidden" id="playnav-playlist-favorites-count" value="<?= $_PROFILE->Info["favorites"] ?>">
            <div class="playnav-playlist-header">
            <a href="javascript:;" style="text-decoration:none" onclick="selectTab('favorites','<?= $_PROFILE->Username ?>');return false;" class="title title-text-color">
                <span id="playnav-playlist-favorites-all-title" class="title"><?= $LANGS['favorites'] ?></span>
                    (<?= $_PROFILE->Info["favorites"] ?>)
            </a>
    </div>
    <?php $Count = 0 ?>
    <?php foreach ($FavVideos as $Video) : ?>
        <?php $Count++ ?>
        <div id="playnav-video-play-favorites-all-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video">
        <div style="display:none" class="encryptedVideoId"><?= $Video['url'] ?></div>
        <div id="playnav-video-play-favorites-all-<?= $Count ?>-<?= $Video['url'] ?>-selector" class="selector"></div>
        <div class="content">
            <div class="playnav-video-thumb link-as-border-color">
                <a class="video-thumb-90 no-quicklist" href="/watch?v=<?= $Video['url'] ?>" onclick="playVideo('favorites-all','<?= $Count ?>','<?= $Video['url'] ?>');return false;"><img title="<?= $Video['title'] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90 yt-uix-hovercard-target" alt="<?= $Video['title'] ?>"></a>
            </div>
            <div class="playnav-video-info">
                <a href="/watch?v=<?= $Video['url'] ?>" class="playnav-item-title ellipsis" onclick="playVideo('favorites-all','<?= $Count ?>','<?= $Video['url'] ?>');return false;" id="playnav-video-title-play-favorites-all-<?= $Count ?>-<?= $Video['url'] ?>"><span><?= $Video['title'] ?></span></a>
                <div class="metadata">
                        <span class="playnav-video-username"><a title="Play video" href="/user/<?= $Video['uploaded_by'] ?>"><?= short_title(displayname($Video['uploaded_by']),12) ?></a></span>  -  <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>
                </div>
                
                <div style="display:none" id="playnav-video-play-favorites-all-<?= $Count ?>"><?= $Video['url'] ?></div>                    
            </div>
        </div>
    </div>
    <?php endforeach ?>


        <div class="playnav-play-column-all">
                <div class="playnav-more"><a class="channel-cmd" href="javascript:;" onclick="selectTab('favorites','<?= $_PROFILE->Username ?>'); return false;"><?= $LANGS['seeall'] ?></a></div>
        </div>
        <div class="spacer">&nbsp;</div>

            <div class="scrollbox-separator">
        <div class="outer-box-bg-as-border"></div>
    </div>
<?php endif ?>
    <?php if ($_PROFILE->Info["c_playlists_box"] != 0) : ?>
    <input type="hidden" id="playnav-playlist-playlists-count" value="<?= $Playlists_Amount ?>">
            <div class="playnav-playlist-header">
            <a href="javascript:;" style="text-decoration:none" onclick="selectTab('playlists','<?= $_PROFILE->Username ?>');return false;" class="title title-text-color">
                <span id="playnav-playlist-playlists-all-title" class="title"><?= $LANGS['playlists'] ?></span>
                    (<?= $Playlists_Amount ?>)
            </a>
    </div>
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
        <div id="playnav-video-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>-selector" class="selector"></div>
        <div class="content">
            <div class="vCluster120WideEntry"><div class="vCluster120WrapperOuter"><div class="vCluster120WrapperInner"><a id="video-url" onclick="open_playlist('playlists','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" href="/view_playlist?id=<?= $Playlist["id"] ?>" onclick="open_playlist('playlists','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" rel="nofollow"><img title="<?= $Playlist["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video1.'.jpg')): ?>src="/u/thmp/<?= $Video1 ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimgCluster120" alt="<?= $Playlist["title"] ?>"></a><div class="video-corner-text"><span><?= $DB->execute("SELECT count(url) as amount FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["amount"] ?> <?= $LANGS['plvideoamount'] ?></span></div></div></div></div>
            <div class="playnav-video-info">
                <a href="/view_playlist?id=<?= $Playlist['id'] ?>" class="playnav-item-title ellipsis" onclick="open_playlist('playlists-all','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" id="playnav-video-title-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>"><span><?= $Playlist['title'] ?></span></a>
                <div class="metadata">
                        <span class="playnav-video-username"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['longtimeformat'], time_machine(strtotime((string) $Playlist["submit_date"]))); }
                    else {echo strftime($LANGS['longtimeformat'], strtotime((string) $Playlist["submit_date"])); }  ?></span>
                    <br>
                    <a href="/view_playlist?id=<?= $Playlist['id'] ?>"><?= $LANGS['moreinfo'] ?></a>
                </div>
                <div style="display:none" id="playnav-video-play-playlists-all-<?= $Count ?>"><?= $Playlist['id'] ?></div>                  
            </div>
        </div>
    </div>
    <?php endforeach ?>
        <div class="playnav-play-column-all">
                <div class="playnav-more"><a class="channel-cmd" href="javascript:;" onclick="selectTab('playlists','<?= $_PROFILE->Username ?>'); return false;"><?= $LANGS['seeall'] ?></a></div>
        </div>
    <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
        </div>
<?php endif ?>
<?php if ($Tab == "uploads"): ?>
<div id="playnav-play-content" style="height: 595px;">  
                <div class="playnav-playlist-holder" id="playnav-play-playlist-uploads-holder">        
    <div id="playnav-play-uploads-scrollbox" class="scrollbox-wrapper inner-box-colors">
            <input type="hidden" id="playnav-playlist-uploads-count" value="90">
        <div class="scrollbox-content playnav-playlist-non-all">
                <div class="scrollbox-header">
        <div class="playnav-playlist-header">
            
    <div class="search-box">
        <input type="text" id="upload_search_query-play" class="box-outline-color" style="width:120px;border-width:1px;border-style:solid;padding: 1px" onkeypress="if (event.keyCode == 13) { searchChannel('upload_search_query-play','<?= $_PROFILE->Username ?>'); }">
        &nbsp;
            <a class="yt-button" id="" style="height: 21px;vertical-align: middle;line-height: 21px;" href="javascript:;" onclick="searchChannel('upload_search_query-play','<?= $_PROFILE->Username ?>');return false"><span><?= $LANGS['search'] ?></span></a>
    </div>

                <div style="display:none" id="uploads-sort">date</div>
    <div class="sorters">
        
    
        <a style="" href="javascript:;" onmousedown="sortVideos('date','<?= $_PROFILE->Username ?>')"><?= $LANGS['sortdateadded'] ?></a>
    

        |
        
    
        <a style="" href="javascript:;" onmousedown="sortVideos('popularity','<?= $_PROFILE->Username ?>')"><?= $LANGS['mostviewed'] ?></a>
    

        |
        
    
        <a style="" href="javascript:;" onmousedown="sortVideos('rating','<?= $_PROFILE->Username ?>')"><?= $LANGS['toprated'] ?></a>
    
 
         
    </div>

            <div class="spacer">&nbsp;</div>

        </div>
            <div class="scrollbox-separator">
        <div class="outer-box-bg-as-border"></div>
    </div>

    </div>

            <div class="scrollbox-body" style="height: 507px; zoom: 1;">
                <div class="outer-scrollbox" onscroll="loadVideos('uploads', 2, '<?= $_PROFILE->Username ?>', 'date');">
                    <div id="playnav-play-uploads-items" class="inner-scrollbox">
                                <div id="playnav-play-uploads-page-0" class="scrollbox-page loaded videos-rows-12" style="visibility: visible;">
    <?php if ($Videos) : ?>
        <?php $Count = 0 ?>
        <?php foreach ($Videos as $Video) : ?>
            <?php $Count++ ?>
            <div id="playnav-video-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video <?php if (isset($LatVideo) && ($LatVideo[0]['url'] ?? '') == $Video['url']): ?>playnav-item-selected<?php endif?>">
            <div style="display:none" class="encryptedVideoId"><?= $Video['url'] ?></div>

            <div id="playnav-video-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>-selector" class="selector"></div>
            <div class="content">
                <div class="playnav-video-thumb link-as-border-color">
                    <a class="video-thumb-90 no-quicklist" href="/watch?v=<?= $Video['url'] ?>" onclick="playVideo('uploads','<?= $Count ?>','<?= $Video['url'] ?>');return false;"><img title="<?= $Video["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
                </div>
                <div class="playnav-video-info">
                    <a href="/watch?v=<?= $Video['url'] ?>" class="playnav-item-title ellipsis" onclick="playVideo('uploads','<?= $Count ?>','<?= $Video['url'] ?>');return false;" id="playnav-video-title-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>"><span><?= $Video["title"] ?></span></a>
                    <div class="metadata">
                            <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>  -  <?= get_time_ago($Video["uploaded_on"]) ?>   
                    </div>
                    <div style="display:none" id="playnav-video-play-uploads-<?= $Count ?>"><?= $Video['url'] ?></div>  
                </div>
            </div>
        </div>
        <?php endforeach ?>
    <?php endif ?>
    <?php if ($Videos_Page_Amount > 1): ?><div class="alignC" id="show-more-2"><b><a href="#" onclick="loadVideos('uploads', 2, '<?= $_PROFILE->Username ?>', 'date');return false;">Show More</a></b></div><?php endif ?>
                                </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
        </div>
<?php endif ?>
<?php if ($Tab == "favorites"): ?>
<div id="playnav-play-content" style="height: 595px;">  
                <div class="playnav-playlist-holder" id="playnav-play-playlist-favorites-holder">        
    <div id="playnav-play-favorites-scrollbox" class="scrollbox-wrapper inner-box-colors">
            <input type="hidden" id="playnav-playlist-favorites-count" value="90">
        <div class="scrollbox-content playnav-playlist-non-all">
            <div class="scrollbox-body" style="height: 585px; zoom: 1;">
                <div class="outer-scrollbox" onscroll="loadVideos('favorites', 2, '<?= $_PROFILE->Username ?>', 'date');">
                    <div id="playnav-play-favorites-items" class="inner-scrollbox">
                                <div id="playnav-play-favorites-page-0" class="scrollbox-page loaded videos-rows-12" style="visibility: visible;">
    <?php if ($FavVideos): ?>    
        <?php $Count = 0 ?>
        <?php foreach ($FavVideos as $Video) : ?>
            <?php $Count++ ?>
            <div id="playnav-video-play-favorites-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video <?php if (isset($LatVideo) && ($LatVideo[0]['url'] ?? '') == $Video['url']): ?>playnav-item-selected<?php endif?>">
            <div style="display:none" class="encryptedVideoId"><?= $Video['url'] ?></div>

            <div id="playnav-video-play-favorites-<?= $Count ?>-<?= $Video['url'] ?>-selector" class="selector"></div>
            <div class="content">
                <div class="playnav-video-thumb link-as-border-color">
                    <a class="video-thumb-90 no-quicklist" href="/watch?v=<?= $Video['url'] ?>" onclick="playVideo('favorites','<?= $Count ?>','<?= $Video['url'] ?>');return false;"><img title="<?= $Video["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
                </div>
                <div class="playnav-video-info">
                    <a href="/watch?v=<?= $Video['url'] ?>" class="playnav-item-title ellipsis" onclick="playVideo('favorites','<?= $Count ?>','<?= $Video['url'] ?>');return false;" id="playnav-video-title-play-favorites-<?= $Count ?>-<?= $Video['url'] ?>"><span><?= $Video["title"] ?></span></a>
                    <div class="metadata">
                            <span class="playnav-video-username"><a title="Play video" href="/user/<?= $Video['uploaded_by'] ?>"><?= short_title(displayname($Video['uploaded_by']),12) ?></a></span>  -  <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>
                    </div>
                    <div style="display:none" id="playnav-video-play-favorites-<?= $Count ?>"><?= $Video['url'] ?></div>  
                </div>
            </div>
        </div>
        <?php endforeach ?>
    <?php endif ?>
    <?php if ($Favorites_Page_Amount > 1): ?><div class="alignC" id="show-more-2"><b><a href="#" onclick="loadVideos('favorites', 2, '<?= $_PROFILE->Username ?>', 'date');return false;">Show More</a></b></div><?php endif ?>
                                </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
        </div>
<?php endif ?>
<?php if ($Tab == "playlists"): ?>
<div id="playnav-play-content" style="height: 595px;">  
                <div class="playnav-playlist-holder" id="playnav-play-playlist-favorites-holder">        
    <div id="playnav-play-favorites-scrollbox" class="scrollbox-wrapper inner-box-colors">
            <input type="hidden" id="playnav-playlist-favorites-count" value="90">
        <div class="scrollbox-content playnav-playlist-non-all">
            <div class="scrollbox-body" style="height: 585px; zoom: 1;">
                <div class="outer-scrollbox">
                    <div id="playnav-play-favorites-items" class="inner-scrollbox">
                                <div id="playnav-play-favorites-page-0" class="scrollbox-page loaded videos-rows-12" style="visibility: visible;">
    <?php if ($Playlists_2) : ?>
        <?php $Count = 0 ?>
        <?php foreach ($Playlists_2 as $Playlist) : ?>
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
            <div id="playnav-video-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>-selector" class="selector"></div>
            <div class="content">
                <div class="vCluster120WideEntry"><div class="vCluster120WrapperOuter"><div class="vCluster120WrapperInner"><a id="video-url" onclick="open_playlist('playlists','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" href="/view_playlist?id=<?= $Playlist["id"] ?>" rel="nofollow"><img title="<?= $Playlist["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video1.'.jpg')): ?>src="/u/thmp/<?= $Video1 ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimgCluster120" alt="<?= $Playlist["title"] ?>"></a><div class="video-corner-text"><span><?= $DB->execute("SELECT count(url) as amount FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["amount"] ?> <?= $LANGS['plvideoamount'] ?></span></div></div></div></div>
                <div class="playnav-video-info">
                    <a href="/view_playlist?id=<?= $Playlist['id'] ?>" class="playnav-item-title ellipsis" onclick="open_playlist('playlists','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" id="playnav-video-title-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>"><span><?= $Playlist['title'] ?></span></a>
                    <div class="metadata">
                            <span class="playnav-video-username"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                        if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['longtimeformat'], time_machine(strtotime((string) $Playlist["submit_date"]))); }
                        else {echo strftime($LANGS['longtimeformat'], strtotime((string) $Playlist["submit_date"])); }  ?></span>
                        <br>
                        <a href="/view_playlist?id=<?= $Playlist['id'] ?>"><?= $LANGS['moreinfo'] ?></a>
                    </div>
                    <div style="display:none" id="playnav-video-play-playlists-all-<?= $Count ?>"><?= $Playlist['id'] ?></div>                  
                </div>
            </div>
        </div>
        <?php endforeach ?>
    <?php endif ?>
                                </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
        </div>
<?php endif ?>