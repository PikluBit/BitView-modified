<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!isset($_GET["tab"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["page"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["username"])) {
    header("location: /");
    exit();
}

$Tab = $_GET['tab'];
$Page = is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$Order = 'videos.uploaded_on';
if ($_GET['order'] == "popularity") {
    $Order = 'videos.views';
} elseif ($_GET['order'] == "rating") {
    $Order = 'videos.5stars';
}
$Profile = $_GET['username'];
$_PROFILE = new User($_GET["username"],$DB);
$_PROFILE->get_info();

$Limit = ($Page - 1) * 10;

$Videos = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY $Order DESC LIMIT $Limit,10", false, [":USERNAME" => $_PROFILE->Username]);
$FavVideos = $DB->execute("SELECT * FROM videos RIGHT JOIN videos_favorites ON videos_favorites.url = videos.url WHERE videos_favorites.username = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY videos_favorites.submit_on DESC LIMIT $Limit,10", false, [":USERNAME" => $_PROFILE->Username]);
$Videos_Page_Amount = $_PROFILE->Info["videos"] / 10;
if (is_float($Videos_Page_Amount)) { $Videos_Page_Amount = (int)$Videos_Page_Amount + 1; }
$Favorites_Page_Amount = $_PROFILE->Info["favorites"] / 10;
if (is_float($Favorites_Page_Amount)) { $Favorites_Page_Amount = (int)$Favorites_Page_Amount + 1; }
?>
<?php if ($Tab == "uploads"): ?>
                    <div id="playnav-play-uploads-items" style="padding: 0;" class="inner-scrollbox">
                                <div id="playnav-play-uploads-page-0" class="scrollbox-page loaded videos-rows-12" style="visibility: visible;">
    <?php if ($Videos): ?>
        <?php $Count = 0; ?>
        <?php foreach ($Videos as $Video) : ?>
            <?php $Count++ ?>
            <div id="playnav-video-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video <?php if ($LatVideo[0]['url'] == $Video['url']): ?>playnav-item-selected<?php endif?>">
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
    <?php if ($Videos_Page_Amount != $Page): ?><div class="alignC" id="show-more-<?= $Page + 1 ?>"><b><a href="#" onclick="loadVideos('uploads', <?= $Page + 1 ?>, '<?= $_PROFILE->Username ?>','<?= $_GET['order'] ?>');return false;">Show More</a></b></div><?php endif ?>
                                </div>         
                    </div>
<?php endif ?>
<?php if ($Tab == "favorites"): ?>
                    <div id="playnav-play-uploads-items" style="padding: 0;" class="inner-scrollbox">
                                <div id="playnav-play-uploads-page-0" class="scrollbox-page loaded videos-rows-12" style="visibility: visible;">
    <?php if ($FavVideos) : ?>
        <?php $Count = 0 ?>
        <?php foreach ($FavVideos as $Video) : ?>
            <?php $Count++ ?>
            <div id="playnav-video-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video <?php if ($LatVideo[0]['url'] == $Video['url']): ?>playnav-item-selected<?php endif?>">
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
    <?php if ($Favorites_Page_Amount != $Page): ?><div class="alignC" id="show-more-<?= $Page + 1 ?>"><b><a href="#" onclick="loadVideos('favorites', <?= $Page + 1 ?>, '<?= $_PROFILE->Username ?>','<?= $_GET['order'] ?>');return false;">Show More</a></b></div><?php endif ?>
                                </div>         
                    </div>
<?php endif ?>