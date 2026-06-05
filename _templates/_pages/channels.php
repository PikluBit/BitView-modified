<style type="text/css">
.videoModifiers {
    background: #cccccc;
    border: 0;
    border-radius: 8px;
    height: 19px;
    float: right;
    width: 750px;
    padding: 7px 0px 6px 0px;
    border-bottom: 1px solid #ccc;
    text-align: left;
}
.videoModifiers .first {
    border-left: 0px;
    padding: 0px 10px 0px 2px;
}

.videoModifiers .subcategory {
    font-size: 14px;
    float: left;
    height: 25px;
    margin-top: -12px;
    padding: 13px 13px 0 13px;
    font-weight: bold;
}
.browse-categories-side .main-tabs-subcategory {
    padding-left: 31px;
}
.category-selected {
    padding-left: 21px!important;
}
</style>
<!-- user styles -->
<!-- left column - types of channel -->
<div id="side-column">
    <div class="browse-side-column">
        <ul class="browse-categories-side yt-rounded">
    <?php if ($_GET["type"] != 0) : ?>
            <li class="category browse-category-top-level first yt-rounded"><a class="hLink" href="/channels?<?php if (isset($_GET["order"])) : ?>order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?><?php if (isset($_GET["order"])): ?>&<?php else: ?>?<?php endif ?>date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?><?php if (isset($_GET["order"]) || isset($_GET["date"])): ?>&<?php else: ?>?<?php endif ?>gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['categories'] ?></a></li>
            <?php else : ?>
            <li class="category-selected browse-category-top-level first yt-rounded"><a class="hLink" href="/channels"><?= $LANGS['categories'] ?></a></li>
    <?php endif ?>


    <?php if (!isset($_GET["type"]) || $_GET["type"] == 0): ?>
            <?php foreach ($Video_Category as $ID => $Category) : ?>
                <li class="main-tabs-subcategory "><a href="/browse?category=<?= $ID ?><?php if (isset($_GET["t"])) : ?>&t=<?=$_GET["t"]?><?php endif ?><?php if (isset($_GET["d"])) : ?>&d=<?=$_GET["d"]?><?php endif ?>"><?= $Category ?></a></li>
            <?php endforeach ?>
    <?php endif ?>

            <?php if ($_GET["type"] != 1) : ?>
                <li class=""><a class="hLink" href="?type=1<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type1p'] ?></a></li>
            <?php else : ?>
                <li class="category-selected"><a class="hLink" href="?type=1<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type1p'] ?></a></li>
            <?php endif ?>

            <?php if ($_GET["type"] != 2) : ?>
                <li class=""><a class="hLink" href="?type=2<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type2p'] ?></a></li>
            <?php else : ?>
                <li class="category-selected"><a class="hLink" href="?type=2<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type2p'] ?></a></li>
            <?php endif ?>

            <?php if ($_GET["type"] != 3) : ?>
                <li class=""><a class="hLink" href="?type=3<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type3p'] ?></a></li>
            <?php else : ?>
                <li class="category-selected"><a class="hLink" href="?type=3<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type3p'] ?></a></li>
            <?php endif ?>

            <?php if ($_GET["type"] != 4) : ?>
                <li class=""><a class="hLink" href="?type=4<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type4p'] ?></a></li>
            <?php else : ?>
                <li class="category-selected"><a class="hLink" href="?type=4<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type4p'] ?></a></li>
            <?php endif ?>

            <?php if ($_GET["type"] != 5) : ?>
                <li class=""><a class="hLink" href="?type=5<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type5p'] ?></a></li>
            <?php else : ?>
                <li class="category-selected"><a class="hLink" href="?type=5<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type5p'] ?></a></li>
            <?php endif ?>

            <?php if ($_GET["type"] != 6) : ?>
                <li class=""><a class="hLink" href="?type=6<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type6p'] ?></a></li>
            <?php else : ?>
                <li class="category-selected"><a class="hLink" href="?type=6<?php if (isset($_GET["order"])) : ?>&order=<?=$_GET["order"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['type6p'] ?></a></li>
            <?php endif ?>
        </ul>
    </div>
</div>

<div id="body-column">
<div class="main-tab-layout-top-browse-tabs">
        <div class="browse-tab-modifiers yt-rounded">
            <div class="subcategory first yt-rounded"><a href="/browse"><?= $LANGS['videos'] ?></a></div>
            <div class="subcategory selected"><?= $LANGS['channels'] ?></div>
            <div class="clear"></div>
        </div>
    </div>    
<table class="browse-modifiers-extended" width="100%"><tbody><tr>
        <td class="browse-modifiers-extended-category" width="30%">
            <span class="browse-modifiers-extended-category-lbl" style="text-transform: capitalize;"><?= $LANGS['allcatin'] ?>:</span> <?php if ($_GET["type"] == 0) : ?>
        <?= $LANGS['allcat'] ?>
        <?php endif ?>
        
        <?php foreach ($Channel_Types as $ID => $Type) : ?>
        <?php if ($_GET["type"] == $ID && $_GET["type"] ==! 0) : ?> 
        <?= $Type ?>
        <?php endif ?>
        <?php endforeach ?>
        </td>
        <td class="browse-basic-modifiers" width="40%">
            <?php if (!isset($_GET["order"]) || $_GET["order"] != "subscribers"): ?>
                <div class="subcategory first ">
                            <a href="/channels?order=subscribers<?php if (isset($_GET["type"]) && $_GET["type"] != 0) : ?>&type=<?=$_GET["type"]?><?php endif ?><?php if (isset($_GET["date"])): ?>&date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['mostsubscribed'] ?></a>
                </div>
            <?php else: ?>
                <div class="subcategory first selected">
                        <span><?= $LANGS['mostsubscribed'] ?></span>
                </div>
            <?php endif ?>

            <?php if (isset($_GET["order"])) : ?>
                <div class="subcategory ">
                            <a href="/channels?<?php if (isset($_GET["type"])) : ?>type=<?=$_GET["type"]?><?php endif ?><?php if (isset($_GET["date"])): ?><?php if (isset($_GET["type"])): ?>&<?php else: ?>?<?php endif ?>date=<?=$_GET["date"]?><?php endif ?><?php if (isset($_GET["gl"])): ?><?php if (isset($_GET["type"]) || isset($_GET["date"])): ?>&<?php else: ?>?<?php endif ?>gl=<?=$_GET["gl"]?><?php endif ?>"><?= $LANGS['mostviewed'] ?></a>
                </div>
            <?php else: ?>
                <div class="subcategory  selected">
                        <span><?= $LANGS['mostviewed'] ?></span>
                </div>
            <?php endif ?>
            <div class="clear"></div>
        </td>
        <td class="time-slice-modifiers" width="30%">
<?php if (!isset($_GET['order'])): ?>
                    <span class="browse-modifiers-extended-category-lbl"><span class="browse-modifiers-extended-category-lbl"><?= $LANGS['when'] ?>:</span></span>
                    <button type="button" id="more-sub-modifiers-menulink" onclick="dropdown(this);return false;" onfocusout="dropdown(this);" class="yt-uix-button yt-uix-button-text"><span class="yt-uix-button-content"><?php if (!isset($_GET["date"]) || $_GET["date"] == "d"): ?><?= $LANGS['timetoday'] ?><?php elseif ($_GET["date"] == "w"): ?><?= $LANGS['timeweek'] ?><?php elseif ($_GET["date"] == "m" || !isset($_GET['date'])): ?><?= $LANGS['timemonth'] ?><?php else: ?><?= $LANGS['alltime'] ?><?php endif ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
                    <ul style="min-width: 53px;" class="yt-uix-button-menu yt-uix-button-menu-text hid">
                        <li><span href="/channels?date=d<?php if (isset($_GET["type"]) && $_GET["type"] != 0): ?>&type=<?=$_GET["type"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['timetoday'] ?></span></li>
                        <li><span href="/channels?date=w<?php if (isset($_GET["type"]) && $_GET["type"] != 0): ?>&type=<?=$_GET["type"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['timeweek'] ?></span></li>
                        <li><span href="/channels?date=m<?php if (isset($_GET["type"]) && $_GET["type"] != 0): ?>&type=<?=$_GET["type"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['timemonth'] ?></span></li>
                        <li><span href="/channels?date=a<?php if (isset($_GET["type"]) && $_GET["type"] != 0): ?>&type=<?=$_GET["type"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['alltime'] ?></span></li>
                    </button>
            <div class="clear"></div>
                    <?php else: ?>
                    <span class="browse-modifiers-extended-category-lbl"><span class="browse-modifiers-extended-category-lbl"><?= $LANGS['when'] ?>:</span></span>
                    <button type="button" id="more-sub-modifiers-menulink" onclick="dropdown(this);return false;" onfocusout="dropdown(this);" class="yt-uix-button yt-uix-button-text"><span class="yt-uix-button-content"><?php if (isset($_GET["date"]) && $_GET["date"] == "d"): ?><?= $LANGS['timetoday'] ?><?php elseif (isset($_GET["date"]) && $_GET["date"] == "w"): ?><?= $LANGS['timeweek'] ?><?php elseif (isset($_GET["date"]) && $_GET["date"] == "m" || !isset($_GET['date'])): ?><?= $LANGS['timemonth'] ?><?php else: ?><?= $LANGS['alltime'] ?><?php endif ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
                    <ul style="min-width: 53px;" class="yt-uix-button-menu yt-uix-button-menu-text hid">
                        <li><span href="/channels?order=subscribers&date=d<?php if ($_GET["type"] != 0): ?>&type=<?=$_GET["type"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['timetoday'] ?></span></li>
                        <li><span href="/channels?order=subscribers&date=w<?php if ($_GET["type"] != 0): ?>&type=<?=$_GET["type"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['timeweek'] ?></span></li>
                        <li><span href="/channels?order=subscribers&date=m<?php if ($_GET["type"] != 0): ?>&type=<?=$_GET["type"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['timemonth'] ?></span></li>
                        <li><span href="/channels?order=subscribers&date=a<?php if ($_GET["type"] != 0): ?>&type=<?=$_GET["type"]?><?php endif ?><?php if (isset($_GET["gl"])): ?>&gl=<?=$_GET["gl"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['alltime'] ?></span></li>
                    </button>
            <div class="clear"></div>
                    <?php endif ?>
        </td> 
    </tr></tbody></table>
</div>

<!--START CHANNEL COLUMN-->
<div id="body-column">
 <div id="browseMain">
        <div id="video_grid" class="membersGridView">
        <div class="padB5">
        </div>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
    <?php $Count = 0; ?>
        <tr valign="top">
        <?php if ($Users) : ?>
        <?php foreach ($Users as $User) : ?>
        <?php if (!isset($_GET["date"])) {
            $Views = $User['video_views_month'];
            $Subs = $User['subscribers_month'];
        } elseif($_GET["date"] == "d") {
            $Views = $User['video_views_day'];
            $Subs = $User['subscribers_day'];
        } elseif($_GET["date"] == "w") {
            $Views = $User['video_views_week'];
            $Subs = $User['subscribers_week'];

        } elseif($_GET["date"] == "m") {
            $Views = $User['video_views_month'];
            $Subs = $User['subscribers_month'];
        } elseif($_GET["date"] == "a") {
            $Views = $User['video_views'];
            $Subs = $User['subscribers'];
        } 
        ?>
        <?php $Count++ ?>
        <td>
        <div class="memberContainer">
            <div class="memberBoxList">
                <div class="user-thumb-large">
                    <a href="/user/<?= $User["username"] ?>" style="z-index: 50000;position: relative;"><img src="<?= avatar($User["username"]) ?>" <?php if ($User["is_avatar_video"] == 1) : ?>class="avatarvideo"<?php endif ?> alt="<?= $User["username"] ?>"></a>
                </div>
            </div>
            <div class="vldescbox">
                <div class="vltitle">
                    <a href="/user/<?= $User["username"] ?>"><?= displayname($User["username"]) ?></a>
                </div>
            </div>
            <div class="vlclearalt"></div>
            <div class="memberBoxGrid">
                <div class="user-thumb-large">
                    <a href="/user/<?= $User["username"] ?>" style="z-index: 50000;position: relative;"><img src="<?= avatar($User["username"]) ?>" <?php if ($User["is_avatar_video"] == 1) : ?>class="avatarvideo"<?php endif ?> alt="<?= $User["username"] ?>"></a>
                </div>
            </div>
            <span class="vlfacets">
                <div class="memberBoxTypeContainer"></div>
                    <div class="memberStat"><span class="channel-video-count"><?= $User["videos"] ?><span class="channel-text-break-grid"></span> <?= $LANGS['cstatvideos'] ?></span></div>
                    <div class="memberStat" <?php if (isset($_GET["order"]) && $_GET["order"] == "subscribers") : ?>style="display:none"<?php endif ?>><span class="channel-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Views) ?><?php else: ?><?= ($Views) ?><?php endif ?><span class="channel-text-break-grid"></span> <?= $LANGS['cstatviews'] ?></span></div>
                    <div class="memberStat"<?php if (!isset($_GET["order"])) : ?>style="display:none"<?php endif ?>><span class="channel-sub-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Subs) ?><?php else: ?><?= ($Subs) ?><?php endif ?><span class="channel-text-break-grid"></span> <?= $LANGS['cstatsubs'] ?></span></div>
            </span>
        </div> 

<?php unset($Avatar) ?>
 <?php if ($Count == 5) : ?>
 </td>
    </tr>
<tr valign="top">
    <?php $Count = 0 ?>
                    <?php endif ?>
                    <?php endforeach ?>
                    <?php else : ?>
        <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 16px"><?= $LANGS['nochannels'] ?></div>
    <?php endif ?>
    </tr>
    </tbody></table>
        
    <div class="searchFooterBox">       <div class="pagingDiv" style="text-align: right;">
     <?php $_PAGINATION->new_show_pages_videos($Order.$ChType.$Date) ?>
        </div>
</div>
        </div>
    </div>
    </div> <!-- end browseMain -->
<div class="clear"></div>
<!-- END VIDEO COLUMN -->
<!-- START AD COLUMN RIGHT -->
<div id="right-column">
    
    <div id="sideAd" z-index="10" style="width: auto; height: auto;">       
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- bitviewside -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:120px;height:240px;margin:10px 0"
                 data-ad-client="ca-pub-8433080377364721"
                 data-ad-slot="9813736805"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>


</div>
<div class="clear"></div>
