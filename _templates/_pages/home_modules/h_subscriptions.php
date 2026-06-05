<?php if ($_USER->Logged_In && $_USER->Info['h_subscriptions'] == 1 && $_USER->Info['h_feed'] == 0) : ?>
        <div class="homepage-content-block" id="homepage-content-block-h_subscriptions">
        <div class="homepage-block-heading"><a href="/my_subscriptions"><?= $LANGS['subscriptions'] ?></a>
            <div class="feedmodule-updown">
            <span id="medit-SUB" class="iyt-edit-link" onclick="open_option_box('SUB')"><?= $LANGS['edit'] ?></span><span id="mup" class="up-button" onclick="move_up('h_subscriptions')"><img class="img-php-up-arrow" src="/img/pixel.gif"></span><span id="mdown" class="down-button" onclick="move_down('h_subscriptions')"><img class="img-php-down-arrow" src="/img/pixel.gif"></span><span id="mclose" onclick="close_module('h_subscriptions')"><img class="img-php-close-button" src="/img/pixel.gif"></span>
            </div>
            </div>
        <div id="SUB-options" class="opt-pane" style="">
        <div class="opt-box-top">
            <img class="homepage-sprite img-php-opt-box-caret" src="/img/pixel.gif">
        </div>
        <div class="opt-banner">
            <div class="opt-links">
                <div class="opt-edit"><?= $LANGS['homeediting'] ?>: <?= $LANGS['subscriptions'] ?></div>
                <div class="opt-close opt-close-button" onclick="open_option_box('SUB')"><img class="img-php-close-button" src="/img/pixel.gif"></div>
                <div class="opt-close opt-close-text" onclick="open_option_box('SUB')"><?= $LANGS['close'] ?></div>
                <div id="h_subscriptions-loading-msg" class="opt-loading-msg" style="display: none;">
                <?= $LANGS['saving'] ?>
                </div>
                <div id="h_subscriptions-loading-icn" class="opt-loading-icn" style="display: none;">
                    <img width="16" id="SUB-loading-icn-image" src="/img/pixel.gif" image="/img/icn_loading_animated.gif">
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
                            <div id="SUB-options-SIN" class="opt-form-type-btns" <?php if ($Sub_Style != 'list'): ?>style="display: none;"<?php endif ?>>
                                <img src="/img/pixel.gif" class="homepage-sprite btn-listview-on" title="<?= $LANGS['listview'] ?>" alt="<?= $LANGS['listview'] ?>"><img src="/img/pixel.gif" class="homepage-sprite btn-bigthumbview-off" onclick="change_layout('h_subscriptions', 'list')"><img src="/img/pixel.gif" class="homepage-sprite btn-gridview-off" title="<?= $LANGS['gridview'] ?>" alt="<?= $LANGS['gridview'] ?>" onclick="change_layout('h_subscriptions', 'grid')">
                            </div>
                            <div id="SUB-options-BTH" class="opt-form-type-btns" <?php if ($Sub_Style != 'bigthumb'): ?>style="display: none;"<?php endif ?>>
                                <img src="/img/pixel.gif" class="homepage-sprite btn-listview-off" title="<?= $LANGS['listview'] ?>" alt="<?= $LANGS['listview'] ?>" onclick="change_layout('h_subscriptions', 'list')"><img src="/img/pixel.gif" class="homepage-sprite btn-bigthumbview-on"><img src="/img/pixel.gif" class="homepage-sprite btn-gridview-off" title="<?= $LANGS['gridview'] ?>" alt="<?= $LANGS['gridview'] ?>" onclick="change_layout('h_subscriptions', 'grid')">
                            </div>
                            <div id="SUB-options-AGG" class="opt-form-type-btns" <?php if ($Sub_Style != 'grid'): ?>style="display: none;"<?php endif ?>>
                                <img src="/img/pixel.gif" class="homepage-sprite btn-listview-off" title="<?= $LANGS['listview'] ?>" alt="<?= $LANGS['listview'] ?>" onclick="change_layout('h_subscriptions', 'list')"><img src="/img/pixel.gif" class="homepage-sprite btn-bigthumbview-off" onclick="change_layout('h_subscriptions', 'grid')"><img src="/img/pixel.gif" class="homepage-sprite btn-gridview-on" title="<?= $LANGS['gridview'] ?>" alt="<?= $LANGS['gridview'] ?>">
                            </div>
                        </td>
                    <td class="opt-name">
<?= $LANGS['homerows'] ?>:
                    </td>
                    <td class="opt-val">
                        <?php if ($Sub_Style == 'grid'): ?>
                        <select id="h_subscriptions-options-num" name="SUB-options-num" onchange="set_num_grid('h_subscriptions', this.value)">
                                <option value="1" <?php if ($Sub_Limit / 4 == 1): ?>selected<?php endif ?>>1</option>
                                <option value="2" <?php if ($Sub_Limit / 4 == 2): ?>selected<?php endif ?>>2</option>
                                <option value="3" <?php if ($Sub_Limit / 4 == 3): ?>selected<?php endif ?>>3</option>
                        </select>
                        <?php endif ?>
                        <?php if ($Sub_Style == 'list'): ?>
                        <select id="h_subscriptions-options-num" name="SUB-options-num" onchange="set_num_list('h_subscriptions', this.value)">
                                <option value="1" <?php if ($Sub_Limit == 1): ?>selected<?php endif ?>>1</option>
                                <option value="2" <?php if ($Sub_Limit == 2): ?>selected<?php endif ?>>2</option>
                                <option value="3" <?php if ($Sub_Limit == 3): ?>selected<?php endif ?>>3</option>
                                <option value="4" <?php if ($Sub_Limit == 4): ?>selected<?php endif ?>>4</option>
                                <option value="5" <?php if ($Sub_Limit == 5): ?>selected<?php endif ?>>5</option>
                                <option value="6" <?php if ($Sub_Limit == 6): ?>selected<?php endif ?>>6</option>
                                <option value="7" <?php if ($Sub_Limit == 7): ?>selected<?php endif ?>>7</option>
                                <option value="8" <?php if ($Sub_Limit == 8): ?>selected<?php endif ?>>8</option>
                                <option value="9" <?php if ($Sub_Limit == 9): ?>selected<?php endif ?>>9</option>
                                <option value="10" <?php if ($Sub_Limit == 10): ?>selected<?php endif ?>>10</option>
                                <option value="11" <?php if ($Sub_Limit == 11): ?>selected<?php endif ?>>11</option>
                                <option value="12" <?php if ($Sub_Limit == 12): ?>selected<?php endif ?>>12</option>
                        </select>
                        <?php endif ?>
                    </td>
                </tr>
                </tbody></table>
            </div>
        </div>
    </div>
        <div class="homepage-sub-block-contents" id="homepage-sub-block-contents-h_subscriptions">
        <?php if (isset($Subscriptions) && $Subscriptions): ?>
            <?php $Count = 0; ?>
  <?php if ($Sub_Style == "list"): ?>
<?php foreach ($Subscriptions as $Video) : ?>
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
<?php elseif ($Sub_Style == "grid"): ?>
    <?php foreach ($Subscriptions as $Video) : ?>
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
<?php endif ?>
    <?php else: ?>
        <strong><?= $LANGS['homenosubscriptions'] ?></strong><br>
        <span style="color: #666;margin-bottom: 5px;display: inline-block;"><?= $LANGS['homenosubscriptionsdesc'] ?></span>
        <?php endif ?>
        <div class="clearL" style="height: 1px;"></div>
        </div>
    </div>
<?php endif ?>