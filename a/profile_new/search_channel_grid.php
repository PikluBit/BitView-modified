<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!isset($_GET["query"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["username"])) {
    header("location: /");
    exit();
}

$Query = $_GET['query'];
$Search = '%'.$Query.'%';
$Profile = $_GET['username'];
$_PROFILE = new User($_GET["username"],$DB);
$_PROFILE->get_info();

$Videos = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND title LIKE :SEARCH AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC LIMIT 100",false,[":USERNAME" => $_PROFILE->Username, ":SEARCH" => $Search]);
?>
                    <div id="playnav-play-uploads-items" style="padding: 0;" class="inner-scrollbox">
    <?php if ($Videos): ?>
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
    </div>