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

$Limit = ($Page - 1) * 24;

$Videos = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY $Order DESC LIMIT $Limit,24",false,[":USERNAME" => $_PROFILE->Username]);
$FavVideos = $DB->execute("SELECT * FROM videos RIGHT JOIN videos_favorites ON videos_favorites.url = videos.url WHERE videos_favorites.username = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY videos_favorites.submit_on DESC LIMIT $Limit,24",false,[":USERNAME" => $_PROFILE->Username]);
$Videos_Page_Amount = $_PROFILE->Info["videos"] / 24;
if (is_float($Videos_Page_Amount)) { $Videos_Page_Amount = (int)$Videos_Page_Amount + 1; }
$Favorites_Page_Amount = $_PROFILE->Info["favorites"] / 24;
if (is_float($Favorites_Page_Amount)) { $Favorites_Page_Amount = (int)$Favorites_Page_Amount + 1; }
?>
<?php if ($Tab == "uploads"): ?>
    <?php if ($Videos): ?>
        <?php $Count = 0; ?>
        <?php $VideoCount = 0 ?>
        <?php foreach ($Videos as $Video) : ?>
            <?php $Count++ ?>
            <?php $VideoCount++ ?>
                                    <div class="playnav-item playnav-video" id="playnav-video-<?= $VideoCount ?>-<?= $Video['url'] ?>" style="
        float: left;
        width: 144px;
        margin-bottom: 6px;
        height: 136px;
    " onclick="playVideo('uploads','<?= $VideoCount ?>','<?= $Video['url'] ?>');return false;">
                <div id="playnav-video-play-<?= $Video['url'] ?>-selector" class="selector"></div>
                <div class="content">
                    <div class="playnav-video-thumb link-as-border-color">
                        <a class="video-thumb-120 no-quicklist" href="#"><img title="<?= $Video["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg120 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
            
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
    <div style="clear:both"><?php if ($Videos_Page_Amount != $Page): ?><div class="alignC" id="show-more-<?= $Page + 1 ?>"><b><a href="#" onclick="loadVideos('uploads', <?= $Page + 1 ?>, '<?= $_PROFILE->Username ?>','<?= $_GET['order'] ?>');return false;">Show More</a></b></div><?php endif ?>
<?php endif ?>
<?php if ($Tab == "favorites"): ?>
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
                <div id="playnav-video-play-<?= $Video['url'] ?>-selector" class="selector"></div>
                <div class="content">
                    <div class="playnav-video-thumb link-as-border-color">
                        <a class="video-thumb-120 no-quicklist" href="#"><img title="<?= $Video["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg120 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
            
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
    <div style="clear:both"><?php if ($Favorites_Page_Amount != $Page): ?><div class="alignC" id="show-more-<?= $Page + 1 ?>"><b><a href="#" onclick="loadVideos('favorites', <?= $Page + 1 ?>, '<?= $_PROFILE->Username ?>','<?= $_GET['order'] ?>');return false;">Show More</a></b></div><?php endif ?>
<?php endif ?>