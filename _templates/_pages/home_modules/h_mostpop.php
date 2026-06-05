<?php if (!$_USER->Logged_In or $_USER->Logged_In && $_USER->Info['h_mostpop'] && $_USER->Info['h_feed'] == 0): ?>
<div class="homepage-content-block most-popular" id="homepage-content-block-h_mostpop">
        <div class="homepage-block-heading"><h1 id="hpVideoListHead" style="margin-right:5px;"><a href="/browse"><?= $LANGS['mostpopular'] ?></a></h1>
        <?php if ($_USER->Logged_In): ?>
        <div class="feedmodule-updown">
            <span id="mup" class="up-button" onclick="move_up('h_mostpop')"><img class="img-php-up-arrow" src="/img/pixel.gif"></span><span id="mdown" class="down-button" onclick="move_down('h_mostpop')"><img class="img-php-down-arrow" src="/img/pixel.gif"></span><span id="mclose" onclick="close_module('h_mostpop')"><img class="img-php-close-button" src="/img/pixel.gif"></span>
            </div>
            <?php else: ?>
    <div class="feedmodule-updown disabled">
            <span id="mup" class="up-button"><img class="img-php-up-arrow" src="/img/pixel.gif"></span><span id="mdown" class="down-button"><img class="img-php-down-arrow" src="/img/pixel.gif"></span><span id="mclose"><img class="img-php-close-button" src="/img/pixel.gif"></span>
            </div>
        <?php endif ?></div>
        <div class="homepage-block-contents" style="margin-top: 10px;padding-left: 0;height: 560px;">
            <div class="most-popular-block">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <?php if ($MostPop[$i]): ?>
                        <?php 
                        if ($i == 0) { $cat = 'cat4';  }
                        if ($i == 1) { $cat = 'cat9';  }
                        if ($i == 2) { $cat = 'cat21'; }
                        if ($i == 3) { $cat = 'cat16'; }
                        ?>
                        <?php foreach ($MostPop[$i] as $Video) : ?> <!-- start video -->
                            <div class="mp-title"><a href="/browse<?php if ($i != 4): ?>?category=<?= $cat ?>&d=2<?php endif ?>"><?php if ($i != 4): ?><?= $LANGS[$cat] ?><?php else: ?><?= $LANGS['mostviewed'] ?><?php endif ?></a></div>
                            <div class="feeditem-bigthumb mp yt-uix-hovercard">
                                <div style="font-size: 12px;" class="floatL">
                                    <div class="feedmodule-thumbnail">
                                        <?= load_thumbnail($Video['url']) ?>
                                    </div>
                                </div>
                                <div class="feedmodule-singleform-info">
                                    <div class="video-title">
                                    <a href="/watch?v=<?= $Video["url"] ?>" name="<?= mb_substr((string) $Video["title"],0,128) ?>"><?= mb_substr((string) $Video["title"],0,128) ?></a></div>
                                    <span id="video-num-views" style="color:#666;margin:0"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                                    <div><nobr><a href="/user/<?=$Video["uploaded_by"]?>"><?= displayname($Video["uploaded_by"]) ?></a></nobr></div>
                                </div>
                                <div class="spacer">&nbsp;</div>
                            </div>
                        <?php endforeach ?>    <!-- end video -->
                    <?php endif ?>
                <?php endfor ?>
            </div>
            <div class="most-popular-block">
                <?php for ($i = 5; $i < 10; $i++): ?>
                    <?php if ($MostPop[$i]): ?>
                        <?php 
                        if ($i == 5) { $cat = 'cat10'; }
                        if ($i == 6) { $cat = 'cat1';  }
                        if ($i == 7) { $cat = 'cat17'; }
                        if ($i == 8) { $cat = 'cat20'; }
                        ?>
                        <?php foreach ($MostPop[$i] as $Video) : ?> <!-- start video -->

                            <div class="mp-title"><a href="/browse<?php if ($i != 9): ?>?category=<?= $cat ?>&d=2<?php else: ?>?t=4<?php endif ?>"><?php if ($i != 9): ?><?= $LANGS[$cat] ?><?php else: ?><?= $LANGS['topfavorited'] ?><?php endif ?></a></div>
                            <div class="feeditem-bigthumb mp yt-uix-hovercard">
                                <div style="font-size: 12px;" class="floatL">
                                    <div class="feedmodule-thumbnail">
                                        <?= load_thumbnail($Video['url']) ?>
                                    </div>
                                </div>
                                <div class="feedmodule-singleform-info">
                                    <div class="video-title">
                                    <a href="/watch?v=<?= $Video["url"] ?>" name="<?= mb_substr((string) $Video["title"],0,128) ?>"><?= mb_substr((string) $Video["title"],0,128) ?></a></div>
                                    <span id="video-num-views" style="color:#666;margin:0"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                                    <div><nobr><a href="/user/<?=$Video["uploaded_by"]?>"><?= displayname($Video["uploaded_by"]) ?></a></nobr></div>
                                </div>
                                <div class="spacer">&nbsp;</div>
                            </div>
                        <?php endforeach ?>    <!-- end video -->
                    <?php endif ?>
                <?php endfor ?>
            </div>
        </div>
    </div>
<?php endif ?>