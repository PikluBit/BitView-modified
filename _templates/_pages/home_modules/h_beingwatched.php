<?php if (!$_USER->Logged_In or $_USER->Logged_In && $_USER->Info['h_beingwatched'] && $_USER->Info['h_feed'] == 0): ?>
    <div class="homepage-content-block being-watched" id="homepage-content-block-h_beingwatched">
    <div class="homepage-block-heading"><h1 id="hpVideoListHead" style="margin-right:5px"><a href="/browse"><?= $LANGS['beingwatched'] ?></a></h1>
    <?php if ($_USER->Logged_In): ?>
    <div class="feedmodule-updown">
            <span id="medit-POP" class="iyt-edit-link" onclick="open_option_box('POP')"><?= $LANGS['edit'] ?></span><span id="mup" class="up-button" onclick="move_up('h_beingwatched')"><img class="img-php-up-arrow" src="/img/pixel.gif"></span><span id="mdown" class="down-button" onclick="move_down('h_beingwatched')"><img class="img-php-down-arrow" src="/img/pixel.gif"></span><span id="mclose" onclick="close_module('h_beingwatched')"><img class="img-php-close-button" src="/img/pixel.gif"></span>
            </div>
    <?php else: ?>
    <div class="feedmodule-updown disabled">
            <span id="medit-POP" class="iyt-edit-link iyt-edit-link-gray"><?= $LANGS['edit'] ?></span><span id="mup" class="up-button"><img class="img-php-up-arrow" src="/img/pixel.gif"></span><span id="mdown" class="down-button"><img class="img-php-down-arrow" src="/img/pixel.gif"></span><span id="mclose"><img class="img-php-close-button" src="/img/pixel.gif"></span>
            </div>
    <?php endif ?></div>
    <div id="POP-options" class="opt-pane" style="">
        <div class="opt-box-top">
            <img class="homepage-sprite img-php-opt-box-caret" src="/img/pixel.gif">
        </div>
        <div class="opt-banner">
            <div class="opt-links">
                <div class="opt-edit"><?= $LANGS['homeediting'] ?>: <?= $LANGS['beingwatched'] ?></div>
                <div class="opt-close opt-close-button" onclick="open_option_box('POP')"><img class="img-php-close-button" src="/img/pixel.gif"></div>
                <div class="opt-close opt-close-text" onclick="open_option_box('POP')"><?= $LANGS['close'] ?></div>
                <div id="h_beingwatched-loading-msg" class="opt-loading-msg" style="display: none;">
                <?= $LANGS['saving'] ?>
                </div>
                <div id="h_beingwatched-loading-icn" class="opt-loading-icn" style="display: none;">
                    <img width="16" id="POP-loading-icn-image" src="/img/pixel.gif" image="/img/icn_loading_animated.gif">
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="opt-main">
            <div class="opt-divider">
                <table class="opt-tbl">
                <tbody><tr>
                        <td class="opt-name">
<?= $LANGS['homedisplay'] ?>:
                        </td>
                        <td class="opt-val opt-sel">
                            <div id="POP-options-SIN" class="opt-form-type-btns" <?php if ($Being_Watched_Style != 'list'): ?>style="display: none;"<?php endif ?>>
                                <img src="/img/pixel.gif" class="homepage-sprite btn-listview-on" title="<?= $LANGS['listview'] ?>" alt="<?= $LANGS['listview'] ?>"><img src="/img/pixel.gif" class="homepage-sprite btn-bigthumbview-off" style="display: inline;" onclick="change_layout('h_beingwatched', 'bigthumb')"><img src="/img/pixel.gif" class="homepage-sprite btn-gridview-off" title="<?= $LANGS['gridview'] ?>" alt="<?= $LANGS['gridview'] ?>" onclick="change_layout('h_beingwatched', 'grid')">
                            </div>
                            <div id="POP-options-BTH" class="opt-form-type-btns" <?php if ($Being_Watched_Style != 'bigthumb'): ?>style="display: none;"<?php endif ?>>
                                <img src="/img/pixel.gif" class="homepage-sprite btn-listview-off" title="<?= $LANGS['listview'] ?>" alt="<?= $LANGS['listview'] ?>" onclick="change_layout('h_beingwatched', 'list')"><img src="/img/pixel.gif" class="homepage-sprite btn-bigthumbview-on" style="display: inline;"><img src="/img/pixel.gif"  class="homepage-sprite btn-gridview-off" title="<?= $LANGS['gridview'] ?>" alt="<?= $LANGS['gridview'] ?>" onclick="change_layout('h_beingwatched', 'grid')">
                            </div>
                            <div id="POP-options-AGG" class="opt-form-type-btns" <?php if ($Being_Watched_Style != 'grid'): ?>style="display: none;"<?php endif ?>>
                                <img src="/img/pixel.gif" class="homepage-sprite btn-listview-off" title="<?= $LANGS['listview'] ?>" alt="<?= $LANGS['listview'] ?>" onclick="change_layout('h_beingwatched', 'list')"><img src="/img/pixel.gif" class="homepage-sprite btn-bigthumbview-off" onclick="change_layout('h_beingwatched', 'bigthumb')" style="display: inline;"><img src="/img/pixel.gif" class="homepage-sprite btn-gridview-on" title="<?= $LANGS['gridview'] ?>" alt="<?= $LANGS['gridview'] ?>">
                            </div>
                        </td>
                    <td class="opt-name">
<?= $LANGS['homerows'] ?>:
                    </td>
                    <td class="opt-val">
                        <?php if ($Being_Watched_Style == 'grid'): ?>
                        <select id="h_beingwatched-options-num" name="POP-options-num" onchange="set_num_grid('h_beingwatched', this.value)">
                                <option value="1" <?php if ($Being_Watched_Limit / 4 == 1): ?>selected<?php endif ?>>1</option>
                                <option value="2" <?php if ($Being_Watched_Limit / 4 == 2): ?>selected<?php endif ?>>2</option>
                                <option value="3" <?php if ($Being_Watched_Limit / 4 == 3): ?>selected<?php endif ?>>3</option>
                        </select>
                        <?php endif ?>
                        <?php if ($Being_Watched_Style == 'list'): ?>
                        <select id="h_beingwatched-options-num" name="POP-options-num" onchange="set_num_list('h_beingwatched', this.value)">
                                <option value="1" <?php if ($Being_Watched_Limit == 1): ?>selected<?php endif ?>>1</option>
                                <option value="2" <?php if ($Being_Watched_Limit == 2): ?>selected<?php endif ?>>2</option>
                                <option value="3" <?php if ($Being_Watched_Limit == 3): ?>selected<?php endif ?>>3</option>
                                <option value="4" <?php if ($Being_Watched_Limit == 4): ?>selected<?php endif ?>>4</option>
                                <option value="5" <?php if ($Being_Watched_Limit == 5): ?>selected<?php endif ?>>5</option>
                                <option value="6" <?php if ($Being_Watched_Limit == 6): ?>selected<?php endif ?>>6</option>
                                <option value="7" <?php if ($Being_Watched_Limit == 7): ?>selected<?php endif ?>>7</option>
                                <option value="8" <?php if ($Being_Watched_Limit == 8): ?>selected<?php endif ?>>8</option>
                                <option value="9" <?php if ($Being_Watched_Limit == 9): ?>selected<?php endif ?>>9</option>
                                <option value="10" <?php if ($Being_Watched_Limit == 10): ?>selected<?php endif ?>>10</option>
                                <option value="11" <?php if ($Being_Watched_Limit == 11): ?>selected<?php endif ?>>11</option>
                                <option value="12" <?php if ($Being_Watched_Limit == 12): ?>selected<?php endif ?>>12</option>
                        </select>
                        <?php endif ?>
                    </td>
                </tr>
                </tbody></table>
            </div>
        </div>
    </div>
    <div class="homepage-sub-block-contents" id="homepage-sub-block-contents-h_beingwatched">
        <?php if ($Being_Watched_Style == "list"): ?>
<?php foreach ($Recently_Viewed as $Video) : ?>
        <div class="feed-item" id="feed-item">
                                    <div class="video-entry" style="padding: 6px 5px;">
                                        <?= load_thumbnail($Video['url']) ?>
                                        <div class="video-main-content" id="video-main-content" style="width: 458px;padding-left: 12px;">
                                            <div class="video-title video-title-results">
                                                <div class="video-long-title">
                                                    <a id="video-long-title" href="/watch?v=<?= $Video["url"] ?>" title="<?= mb_substr((string) $Video["title"],0,128) ?>" rel="nofollow"><?= mb_substr((string) $Video["title"],0,128) ?></a> <?php if ($Video['hd'] == 1): ?><a href="/watch?v=<?= $Video["url"] ?>"><img src="/img/pixel.gif" class="hd-video-logo"></a><?php endif ?>
                                                </div>
                                            </div>
                            
                                            <div id="video-description" class="video-description">
                                                <?php if($Video["description"]) : ?>
                            <?= short_title($Video["description"],150) ?>
                            <?php else : ?><?= $LANGS['nodesc'] ?><?php endif ?>
                                            </div>
                            
                                            <div class="vlfacets">
                                                <span id="video-added-time" class="video-date-added"><?= get_time_ago($Video["uploaded_on"]) ?></span>
                                                <span id="video-num-views" class="video-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                                                <span class="video-username"><a id="video-from-username" class="hLink" href="/user/<?=$Video["uploaded_by"]?>"><?= displayname($Video["uploaded_by"]) ?></a></span>
                                            </div>
                                        <div class="video-clear-list-left"></div>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach ?>
<?php elseif ($Being_Watched_Style == "grid"): ?>
    <?php foreach ($Recently_Viewed as $Video) : ?>
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
<?php elseif ($Being_Watched_Style == "bigthumb"): ?>
    <style>#homepage-sub-block-contents-h_beingwatched {height: 293px}</style>
        <?php foreach ($Recently_Viewed as $key => $Video) : ?>
            <?php if ($key == 0) : ?>
        <div class="feeditem-bigthumb super-large-video yt-uix-hovercard ">
                                <div style="font-size: 12px;" class="floatL">
                                    <div class="feedmodule-thumbnail">
                                        <div class="v220WideEntry">
                                            <div class="v220WrapperOuter">
                                                <div class="v220WrapperInner">
                                                    <a class="video-thumb-link" href="<?= $Video["link"] ?>" rel="nofollow"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'_m.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>_m.jpg"<?php elseif (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg220 yt-uix-hovercard-target"></a><?php if (!in_array($Video["url"], $_USER->QuickList)): ?>
                
                <span class="video-actions"><button type="button" class=" yt-uix-button yt-uix-button-short" id="yt-uix-button-short-<?= $Video['url'] ?>" onclick="addToQuickList(this);return false;"><span class="yt-uix-button-content"><strong>+</strong></span></button></span>
                <span class="video-in-quicklist"><?= $LANGS['addedtoqueue'] ?></span>
            <?php endif ?><span class="video-time"><?= timestamp($Video["length"]) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="feedmodule-singleform-info">
                                    <div class="video-title">
                                    <a href="<?= $Video["link"] ?>" name="<?= mb_substr((string) $Video["title"],0,128) ?>"><?= mb_substr((string) $Video["title"],0,128) ?></a></div>
                                    <div id="video-num-views" style="color:#666;margin:0"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></div>
                                    <div><nobr><a href="/user/<?=$Video["uploaded_by"]?>"><?= displayname($Video["uploaded_by"]) ?></a></nobr></div>
                                <div class="spacer">&nbsp;</div>
                            </div>
                        </div>
        <?php else : ?>
            <div class="feeditem-bigthumb normal-size-video yt-uix-hovercard">
                                <div style="font-size: 12px;" class="floatL">
                                    <div class="feedmodule-thumbnail">
                                        <?= load_thumbnail($Video['url']) ?>
                                    </div>
                                </div>
                                <div class="feedmodule-singleform-info">
                                    <div class="video-title">
                                    <a href="<?= $Video["link"] ?>" name="<?= mb_substr((string) $Video["title"],0,128) ?>"><?= mb_substr((string) $Video["title"],0,128) ?></a></div>
                                    <span id="video-num-views" style="color:#666;margin:0"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                                    <div><nobr><a href="/user/<?=$Video["uploaded_by"]?>"><?= displayname($Video["uploaded_by"]) ?></a></nobr></div>
                                </div>
                                <div class="spacer">&nbsp;</div>
                            </div>
        <?php endif ?>
            <?php endforeach ?>
            <?php endif ?>
        <div class="clearL" style="height: 1px;"></div>
        </div>
    </div>
<?php endif?>