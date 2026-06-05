<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!isset($_GET["user"]) || !isset($_GET["url"])) {
    header("location: /");
    exit();
}

$Username = $_GET["user"];
$URL = $_GET["url"];

$More_From = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USER AND status = 2 AND privacy = 1 AND is_deleted IS NULL AND url != :URL ORDER BY videos.uploaded_on DESC LIMIT 24",false,[':USER' => $Username, ':URL' => $URL]);

$Video_Count = $DB->execute("SELECT count(*) as amount FROM videos WHERE uploaded_by = ? AND status = 2 AND privacy = 1 AND is_deleted IS NULL",true,[$Username])['amount'];

$Pages = ceil($Video_Count / 6);

?>
<style>
.yt-uix-carousel-slide .ux-thumb-128, .yt-uix-carousel-slide .ux-thumb-128 .img {
    width: 128px;
    height: 72px;
}
</style>
<div id="watch-channel-discoverbox" class="yt-rounded" data-carousel-slide-selected="1">
    <div class="yt-uix-carousel">
    <button class="yt-uix-button yt-uix-carousel-prev" onclick="carousel('prev');return false;">
        <img class="yt-uix-carousel-prev-arrow" src="/img/pixel.gif" title="Previous" />
    </button>
    <button class="yt-uix-button yt-uix-carousel-next" onclick="carousel('next');return false;">
        <img class="yt-uix-carousel-next-arrow" src="/img/pixel.gif" title="Next" />
    </button>
    <a href="/user/<?= $_GET["user"] ?>" style="font-size: 13px;font-weight: bold;line-height: 26px;"><?= $LANGS['morevideos'] ?></a>
    <?php if ($Pages >= 4): ?>
    <button class="yt-uix-button yt-uix-carousel-nums" onclick="carousel('4');return false;">4</button>
    <?php endif?>
    <?php if ($Pages >= 3): ?>
    <button class="yt-uix-button yt-uix-carousel-nums" onclick="carousel('3');return false;">3</button>
    <?php endif?>
    <?php if ($Pages >= 2): ?>
    <button class="yt-uix-button yt-uix-carousel-nums" onclick="carousel('2');return false;">2</button>
    <?php endif?>
    <?php if ($Pages >= 1): ?>
    <button class="yt-uix-button yt-uix-carousel-nums" onclick="carousel('1');return false;">1</button>
    <?php endif?>
    <div class="yt-uix-carousel-body">
        <div class="yt-uix-carousel-slide yt-uix-carousel-slides" style="left: 0px">
        <div class="video-grid">
            <ul class="video-list">
            <?php if ($More_From): ?>
                <?php foreach ($More_From as $Video): ?>
                    <li class="video-list-item"> 
                    <?= load_thumbnail($Video['url']) ?>
                    <div class="vtitle" style="float: left;">
                        <a href="/watch?v=<?= $Video["url"] ?>" name="<?= mb_substr((string) $Video["title"],0,128) ?>"><?= mb_substr((string) $Video["title"],0,128) ?></a>
                    </div>
                    <div style="clear:both"></div>
                    <div class="vfacets" style="margin-bottom: 0px;float: left;">
                        <div class="dg" style="cursor: pointer;" onclick="location.href='';"></div>
                        <div class="vlfacets">
                            <div class="video-date-added" style="color:#666;margin:0"><?= get_time_ago($Video["uploaded_on"]) ?></div>
                            <span id="video-num-views" style="color:#666;margin:0"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                            <div><span class="vlfrom">          <a href="/user/<?=$Video["uploaded_by"]?>"><?= displayname($Video["uploaded_by"]) ?></a>
                            </span></div>
                            <div class="clearL"></div>
                        </div>
                    </div>
                    </li>
                <?php endforeach ?>
            <?php endif ?>
            </ol>
        </div>
        </div>
        <div class="yt-uix-carousel-slides-shade-left"></div>
        <div class="yt-uix-carousel-slides-shade-right"></div>
    </div>
    </div>
</div>