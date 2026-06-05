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
$Page_Amount = $_PROFILE->Info["videos"] / 10;
if (is_float($Page_Amount)) { $Page_Amount = (int)$Page_Amount + 1; }

?>
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
                                </div>         
                    </div>