<?php if ($_USER->Info['h_feed'] == 0): ?>
        <div class="homepage-content-block" id="homepage-content-block-h_spotlight">
        <div class="homepage-block-heading">Spotlight: <?= $Spotlight['title'] ?></div>
        <div class="homepage-sub-block-contents" id="homepage-sub-block-contents-h_spotlight">
            <div class="feedmodule-feditor" style="margin-bottom: 6px;padding-left: 0;">
            <div class="feedmodule-feditor-img user-thumb-large" style="margin-right: 10px"><div>
                <a href="/user/<?= $Spotlight['username'] ?>"><img src="<?= avatar($Spotlight['username']) ?>" alt=""></a>
            </div></div>
            <div class="guest-editor-with-comment">
                <div class="guest-editor-profile-link"><a href="/user/<?= $Spotlight['username'] ?>"><?= displayname($Spotlight['username']) ?></a></div>
                <div class="guest-editor-comment"><?= $Spotlight['description'] ?></div>
            </div>
            <div class="spacer">&nbsp;</div>
        </div>
        <?php foreach ($Vids as $Video) : ?>
    <div class="homepage-sponsored-video marB0">
                <?= load_thumbnail($Video['url']) ?>
                <div class="vtitle">
                    <a href="<?= $Video["link"] ?>" name="<?= mb_substr((string) $Video["title"],0,128) ?>"><?= mb_substr((string) $Video["title"],0,128) ?></a>
                </div>
                <div class="vfacets" style="margin-bottom: 0px;">
                    <div class="dg" style="cursor: pointer;" onclick="location.href='';"></div>
                    <div class="vlfacets">
                        <div class="video-date-added" style="color:#666;margin:0"><?= get_time_ago($Video["uploaded_on"]) ?></div>
                <span id="video-num-views" style="color:#666;margin:0"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                <div><span class="vlfrom">          <a href="/user/<?=$Video["uploaded_by"]?>"><?= displayname($Video["uploaded_by"]) ?></a>
</span></div>
                <div class="clearL"></div>
        </div>
                </div>
            </div>
<?php endforeach ?>
        <div class="clearL" style="height: 1px;"></div>
        </div>
    </div>
<?php endif ?>