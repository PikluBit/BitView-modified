<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["module"] AND $_GET["num"]
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (!isset($_GET["module"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["style"])) {
    header("location: /");
    exit();
}

$_USER->get_info();
$Module = $_GET['module'];
$Style = $_GET['style'];

if ($Style == "grid") {
    if ($Module == "h_subscriptions") {
        $Number = $_USER->Info['h_subscriptions_limit'] / 4;
        if (is_float($Number)) { $Number = (int)$Number + 1; }
        $Limit = $Number * 4;
        $_USER->Info['h_subscriptions_limit'] = $Limit;
        $DB->modify("UPDATE users SET h_subscriptions_limit = :LIMIT WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":LIMIT" => $Limit]);
        $DB->modify("UPDATE users SET h_subscriptions_style = 'grid' WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
    }
    if ($Module == "h_featured") {
        $Number = $_USER->Info['h_featured_limit'] / 4;
        if (is_float($Number)) { $Number = (int)$Number + 1; }
        $Limit = $Number * 4;
        $_USER->Info['h_featured_limit'] = $Limit;
        $DB->modify("UPDATE users SET h_featured_limit = :LIMIT WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":LIMIT" => $Limit]);
        $DB->modify("UPDATE users SET h_featured_style = 'grid' WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
    }
    if ($Module == "h_recommended") {
        $Number = $_USER->Info['h_recommended_limit'] / 4;
        if (is_float($Number)) { $Number = (int)$Number + 1; }
        $Limit = $Number * 4;
        $_USER->Info['h_recommended_limit'] = $Limit;
        $DB->modify("UPDATE users SET h_recommended_limit = :LIMIT WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":LIMIT" => $Limit]);
        $DB->modify("UPDATE users SET h_recommended_style = 'grid' WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
    }
    if ($Module == "h_beingwatched") {
        $Number = $_USER->Info['h_beingwatched_limit'] / 4;
        if (is_float($Number)) { $Number = (int)$Number + 1; }
        $Limit = $Number * 4;
        $_USER->Info['h_beingwatched_limit'] = $Limit;
        $DB->modify("UPDATE users SET h_beingwatched_limit = :LIMIT WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":LIMIT" => $Limit]);
        $DB->modify("UPDATE users SET h_beingwatched_style = 'grid' WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
    }
}
if ($Style == "list") {
    if ($Module == "h_subscriptions") {
        $DB->modify("UPDATE users SET h_subscriptions_style = 'list' WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
    }
    if ($Module == "h_featured") {
        $DB->modify("UPDATE users SET h_featured_style = 'list' WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
    }
    if ($Module == "h_recommended") {
        $DB->modify("UPDATE users SET h_recommended_style = 'list' WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
    }
    if ($Module == "h_beingwatched") {
        $DB->modify("UPDATE users SET h_beingwatched_style = 'list' WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
    }
}
if ($Style == "bigthumb") {
    if ($Module == "h_beingwatched") {
        $DB->modify("UPDATE users SET h_beingwatched_style = 'bigthumb' WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
    }
}

if ($Module == "h_featured") {
    $Featured_Videos            = new Videos($DB, $_USER);
    $Featured_Videos->WHERE_P   = ["videos.featured" => 1];
    $Featured_Videos->ORDER_BY  = "videos.uploaded_on DESC";
    $Featured_Videos->LIMIT     = (int)$_USER->Info['h_featured_limit'];
    $Featured_Videos->get();

    $Featured_Videos = $Featured_Videos->fix_values(true, true);

    $Videos_List = $Featured_Videos;
}
if ($Module == "h_subscriptions") {
    $Subscriptions = new Videos($DB, $_USER);
    $Subscriptions->WHERE_C = "AND subscriptions.subscriber = :USERNAME and privacy = 1";
    $Subscriptions->JOIN    = "INNER JOIN subscriptions ON subscriptions.subscription = videos.uploaded_by";
    $Subscriptions->ORDER_BY = "videos.uploaded_on DESC";
    $Subscriptions->Execute = [":USERNAME" => $_USER->Username];
    $Subscriptions->LIMIT = (int)$_USER->Info['h_subscriptions_limit'];
    $Subscriptions->get();
    if ($Subscriptions::$Videos) {
        $Subscriptions = $Subscriptions->fix_values(true, false);
    } else {
        $Subscriptions = [];
    }

    $Videos_List = $Subscriptions;
}
if ($Module == "h_recommended") {
        $Watched_Videos = array_slice($_USER->Watched_Videos, -6);
        $Watched_Videos = sql_IN_fix($Watched_Videos);
        $Watched_Videos_Titles = $DB->execute("SELECT title FROM videos WHERE url IN ($Watched_Videos) ORDER BY FIELD(url,$Watched_Videos)");
        shuffle($Watched_Videos_Titles);
        $All_Titles = "";

        foreach ($Watched_Videos_Titles as $Watched_Title) {
            $All_Titles .= $Watched_Title["title"]." ";
        }

        $All_Titles = array_filter(explode(" ", $All_Titles));
        $New_All_Titles = [];

        foreach ($All_Titles as $Title) {
            if (!in_array($Title, $Watched_Videos_Titles) && ctype_alnum($Title) && !is_numeric($Title) && mb_strlen($Title) >= 3) {
                $New_All_Titles[] = mb_strtolower($Title);
            }
        }

        $All_Titles = array_count_values($New_All_Titles);
        asort($All_Titles);
        $All_Titles = array_slice($All_Titles, -6);

        $New_All_Titles = "";
        $Count = 0;
        $Amount = count($All_Titles);

        foreach ($All_Titles as $value => $key) {
            $Count++;
            if ($Count !== $Amount) {
                $New_All_Titles .= $value . " ";
            }
        }

        $All_Titles = $New_All_Titles;
        $All_Titles;
        $Recommended_Videos = new Videos($DB,$_USER);
        $Recommended_Videos->SELECT    = "videos.*, (MATCH(tags) AGAINST (:TITLES)) as tag_relevance";
        $Recommended_Videos->WHERE_C    = " AND MATCH(videos.tags) AGAINST (:TITLES) AND videos.url NOT IN ($Watched_Videos)";
        $Recommended_Videos->Execute    = [":TITLES" => $All_Titles];
        $Recommended_Videos->ORDER_BY   = "tag_relevance DESC";
        $Recommended_Videos->LIMIT       = (int)$_USER->Info['h_recommended_limit'];
        $Recommended_Videos->get();
        $Recommended_Amount = $Recommended_Videos::$Amount;

        if ($Recommended_Videos::$Videos) {
            $Recommended_Videos = $Recommended_Videos->fix_values(true,true);
        } else {
            $Recommended_Videos = [];
        }

    $Videos_List = $Recommended_Videos;
}
if ($Module == "h_beingwatched") {
    if ($Style == "bigthumb") {
        $BWLimit = 4;
    }
    else {
        $BWLimit = $_USER->Info['h_beingwatched_limit'];
    }
    $Recently_Viewed            = new Videos($DB, $_USER);
    $Recently_Viewed->JOIN      = "INNER JOIN being_watched ON being_watched.url = videos.url";
    $Recently_Viewed->ORDER_BY  = "being_watched.submit_date DESC";
    $Recently_Viewed->LIMIT     = (int)$BWLimit;
    $Recently_Viewed->SELECT   .= ", being_watched.submit_date";
    $Recently_Viewed->get();

    $Recently_Viewed = $Recently_Viewed->fix_values(true);

    $Videos_List = $Recently_Viewed;
}
?>
<div class="homepage-sub-block-contents" id="homepage-sub-block-contents-<?= $Module ?>">
<?php if ($Style == "list"): ?>
<?php foreach ($Videos_List as $Video) : ?>
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
<?php elseif ($Style == "grid"): ?>
    <?php foreach ($Videos_List as $Video) : ?>
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
<?php elseif ($Style == "bigthumb"): ?>
    <style>#homepage-sub-block-contents-h_beingwatched {height: 275px}</style>
    <?php foreach ($Videos_List as $key => $Video) : ?>
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
                                    <div class="feedmodule-thumbnail"><?= load_thumbnail($Video['url']) ?></div>
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