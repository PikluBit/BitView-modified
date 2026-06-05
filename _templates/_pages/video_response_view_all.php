<style>
.floatL .vimg120 {
    width: 120px;
    margin: 0!important;
}
#responses-videos-header {
    margin-top: 35px;
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px solid #ccc;
}
#responses-videos-header h2 {
    display: inline;
}
#responses-videos-header span {
    color: #666;
    margin-left: 10px;
}
#watch-channel-vids-div {
    border: 0;
    background: #fff;
    width: 350px;
    padding-bottom: 10px;
}
#watch-channel-stats {
    width: auto;
}
</style>
<div>
    <h1><?= $_VIDEO->Info['title'] ?></h1>
    <div class="floatL">
        <a href="/watch?v=<?= $_VIDEO->Info['url'] ?>"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$_VIDEO->Info['url'].'.jpg')): ?>src="/u/thmp/<?= $_VIDEO->Info['url'] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg120"></a>
    </div>
    <div id="responses-desc" class="floatL" style="margin-left: 6px">
        <a class="hLink bold" href="/watch?v=<?= $_VIDEO->Info['url'] ?>"><?= $_VIDEO->Info['title'] ?></a><br>
        <span class="bold"><?= timestamp($_VIDEO->Info['length']) ?></span><br>
        <div class="vdesc">
                <span dir="ltr" id="BeginvidDesc<?= $_VIDEO->Info['url'] ?>" class="" style=""><?= short_title($_VIDEO->Info['description'],100) ?></span>
        </div>
    </div>
    <div id="watch-channel-vids-div" class="watch-wrapper floatR">
        <div id="watch-channel-vids-top">
            <div id="watch-channel-icon" class="user-thumb-medium"><div>
                <a href="/user/<?= $_OWNER->Username ?>"><img src="<?= avatar($_OWNER->Username) ?>"></a>
            </div></div>
            <div id="watch-channel-stats">
                <span class="watch-channel-stat"><?= $LANGS['from'] ?>:</span> <a href="/user/<?= $_OWNER->Username ?>"><?= displayname($_OWNER->Username) ?></a><br>
                <span class="watch-channel-stat"><?= $LANGS['joined'] ?>:</span> <?= get_time_ago($_OWNER->Info['registration_date']) ?><br>
                <span class="watch-channel-stat"><?= $LANGS['cstatvideos'] ?>:</span> <span class="bold"><?= $_OWNER->Info['videos'] ?></span>
            </div>
            <div class="clear"></div>
        </div>  </div>
    <div class="clear"></div>
    <div id="responses-videos-header">
        <h2><?= $LANGS['responses'] ?></h2> <span>(<?= $Responses_Amount ?> <?= $LANGS['videoresponses'] ?>)</span>
        <div class="clear"></div>
    </div>
    <div class="browseGridView">
        <?php if ($Video_Responses) : ?>
        <?php $Count = 0 ?>
        <?php foreach ($Video_Responses as $Video) : ?>
        <?php $Count++ ?>
        <div class="vlcell">
        <!--miniaturka -->
        <?= load_thumbnail($Video["url"]) ?>
        <div class="vldescbox">
            <div class="vltitle">
                <div class="vlshortTitle">
                    <a href="<?= $Video["link"] ?>" title="<?= $Video["title"] ?>"><?= short_title($Video["title"],40) ?></a> 
                </div>
            </div>

            <div class="vldesc"> 
            </div>
        </div>
        <div class="vlfacets">
                <?php $Type = 1 ?>
                <span id="video-num-views"><?php if ($Type !== 4 and $Type !== 3): ?><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?><?php elseif ($Type == 4): ?><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["favorites"]) ?><?php else: ?><?= ($Video["favorites"]) ?><?php endif ?> <?= $LANGS['videofavorites'] ?><?php elseif ($Type == 3): ?><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["comments"]) ?><?php else: ?><?= ($Video["comments"]) ?><?php endif ?> <?= $LANGS['videocomments'] ?><?php endif ?><br></span>
                <div><span class="vlfrom">          <a href="<?= $Video["uploader_link"] ?>"><?= displayname($Video["uploaded_by"]) ?></a>
</span></div>
                <div class="clearL"></div>
        </div>
        <div class="vlclearaltl"></div>
    </div> 
        </div>
        <div class="vlclear"></div>
                    <?php endforeach ?>
        <?php else : ?>
        <p style="font-size:15px;color:#444;text-align:center;padding:22px 0 16px"><?= $LANGS['nomorevideos'] ?></p>
    <?php endif ?>
    </div>
</div>