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
if (!isset($_GET["num"])) {
    header("location: /");
    exit();
}

$_USER->get_info();
$Module = $_GET['module'];
$Num = $_GET['num'] * 4;

if ($Module == "h_featured") {
    $DB->modify("UPDATE users SET h_featured_limit = :LIMIT WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":LIMIT" => $Num]);

    $Featured_Videos            = new Videos($DB, $_USER);
    $Featured_Videos->WHERE_P   = ["videos.featured" => 1];
    $Featured_Videos->ORDER_BY  = "videos.uploaded_on DESC";
    $Featured_Videos->LIMIT     = (int)$Num;
    $Featured_Videos->get();

    $Featured_Videos = $Featured_Videos->fix_values(true, true);

    $Videos_List = $Featured_Videos;
}
if ($Module == "h_subscriptions") {
    $DB->modify("UPDATE users SET h_subscriptions_limit = :LIMIT WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":LIMIT" => $Num]);

    $Subscriptions = new Videos($DB, $_USER);
    $Subscriptions->WHERE_C  = "AND subscriptions.subscriber = :USERNAME and privacy = 1";
    $Subscriptions->JOIN     = "INNER JOIN subscriptions ON subscriptions.subscription = videos.uploaded_by";
    $Subscriptions->ORDER_BY = "videos.uploaded_on DESC";
    $Subscriptions->Execute  = [":USERNAME" => $_USER->Username];
    $Subscriptions->LIMIT    = (int)$Num;
    $Subscriptions->get();
    if ($Subscriptions::$Videos) {
        $Subscriptions = $Subscriptions->fix_values(true, false);
    } else {
        $Subscriptions = [];
    }

    $Videos_List = $Subscriptions;
}
if ($Module == "h_recommended") {
    $DB->modify("UPDATE users SET h_recommended_limit = :LIMIT WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":LIMIT" => $Num]);

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
    $Recommended_Videos->SELECT     = "videos.*, (MATCH(tags) AGAINST (:TITLES)) as tag_relevance";
    $Recommended_Videos->WHERE_C    = " AND MATCH(videos.tags) AGAINST (:TITLES) AND videos.url NOT IN ($Watched_Videos)";
    $Recommended_Videos->Execute    = [":TITLES" => $All_Titles];
    $Recommended_Videos->ORDER_BY   = "tag_relevance DESC";
    $Recommended_Videos->LIMIT      = (int)$Num;
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
    $DB->modify("UPDATE users SET h_beingwatched_limit = :LIMIT WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":LIMIT" => $Num]);

    $Recently_Viewed            = new Videos($DB, $_USER);
    $Recently_Viewed->JOIN      = "INNER JOIN being_watched ON being_watched.url = videos.url";
    $Recently_Viewed->ORDER_BY  = "being_watched.submit_date DESC";
    $Recently_Viewed->LIMIT     = (int)$Num;
    $Recently_Viewed->SELECT   .= ", being_watched.submit_date";
    $Recently_Viewed->get();

    $Recently_Viewed = $Recently_Viewed->fix_values(true);

    $Videos_List = $Recently_Viewed;
}
?>
<div class="homepage-sub-block-contents" id="homepage-sub-block-contents-<?= $Module ?>">

<?php foreach ($Videos_List as $Video) : ?>
    <div class="homepage-sponsored-video marB0">
             <div class="videoIconWrapperOuter">
                <div class="videoIconWrapperInner">
                    <div class="vstill"><a href="<?= $Video["link"] ?>"><img src="<?= $Video["thumb"] ?>" class="vimg120"></a>
                        <?php if (!in_array($Video["url"], $_USER->QuickList)): ?>
                <div id="quicklist-icon-<?= $Video['url'] ?>" class="addtoQL90"><a id="add-to-quicklist-<?= $Video['url'] ?>" href="#" ql="<?= $Video['url'] ?>" title="Add Video to QuickList"><button class="master-sprite QLIconImg" title="" onclick="addToQuickList(this);return false;" onmouseover="mouseOverQuickAdd(this)" onmouseout="mouseOutQuickAdd(this)"></button></a><div id="quicklist-inlist-<?= $Video['url'] ?>" class="hid quicklist-inlist"><a href="/my_quicklist"><?= $LANGS['addedtoquicklist'] ?></a></div></div>
            <?php endif ?>
                    <div class="video-time">
                    <span id="video-run-time"><?= timestamp($Video["length"]) ?></span>
                    </div></div>
                    </div> 

                </div>
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