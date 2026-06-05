<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

$Videos_URL = array_slice(explode(",",(string) ($_GET['u'] ?? '')), 0, 4);
$Videos = [];

if (isset($Videos_URL[0]) && mb_strpos($Videos_URL[0], '&')) {
    $Playlist_Link = mb_substr($Videos_URL[0], strpos($Videos_URL[0], '&'));
    $Videos_URL[0] = mb_str_replace($Playlist_Link, "", $Videos_URL[0]);
}

foreach($Videos_URL as $URL) {
    $Video = new Video($URL,$DB);
    if ($Video->exists()) {
        $Video->get_info();
        $Video->check_info();
        $Videos[] = $Video;
    }
}
?>
<?php if ($Videos): ?>
<div class="vlUpNext">
    Up next<br>
    <div class="vlUpNextButton" onclick="window.location='watch?v=<?= $Videos[0]->URL ?><?php if (isset($Playlist_Link)): ?><?= $Playlist_Link ?><?php endif ?>'">
        <div class="vlUpNextThumb">
            <span class="thumbnail">
                <img style="margin-top: -8px;width: 100%;" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Videos[0]->URL.'.jpg')): ?>src="/u/thmp/<?= $Videos[0]->URL ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> alt="<?= $Videos[0]->Info['title'] ?>" title="<?= $Videos[0]->Info['title'] ?>">
                <span class="timestamp_v"><?= timestamp($Videos[0]->Info['length']) ?></span>
            </span>
        </div>
        <div class="vlUpNextInfo">
            <div class="vlUpNextInfoCont">
                <div class="vlUpNextInfoTitle"><?= $Videos[0]->Info['title'] ?></div>
                <div class="vlUpNextInfoFrom">From: <?= displayname($Videos[0]->Info['uploaded_by']) ?></div>
                <div class="vlUpNextInfoViews">Views: <?= number_format_lang($Videos[0]->Info['views']) ?></div>
                <?php if (isset($_GET['featured']) && $_GET['featured'] == "true"): ?><div class="vlUpNextInfoFeatured"><?= $LANGS['featuredvideo'] ?></div><?php endif?>
            </div>
        </div>
        <div style="clear:both"></div>
    </div>
</div>
<div style="clear: both;"></div>
<?php if (count($Videos) > 1): ?>
<div class="vlSuggestions">
    <?php foreach (array_slice($Videos, 1) as $Video): ?>
    <div class="vlSuggestionsButton" onclick="window.location='watch?v=<?= $Video->URL ?>'">
        <div class="vlSuggestionsThumb">
            <span class="thumbnail">
                <img style="margin-top: -8px;width: 100%;" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video->URL.'.jpg')): ?>src="/u/thmp/<?= $Video->URL ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> alt="<?= $Video->Info['title'] ?>" title="<?= $Video->Info['title'] ?>">
                <span class="timestamp_v"><?= timestamp($Video->Info['length']) ?></span>
            </span>
        </div>
        <div class="vlSuggestionsInfo">
            <div class="vlSuggestionsInfoCont">
                <div class="vlSuggestionsInfoTitle"><?= $Video->Info['title'] ?></div>
            </div>
        </div>
        <div style="clear:both"></div>
    </div>
    <?php endforeach ?>
</div>
<?php endif ?>
<?php endif ?>