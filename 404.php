<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";


$Featured_Videos            = new Videos($DB, $_USER);
$Featured_Videos->WHERE_P   = ["videos.featured" => 1];
$Featured_Videos->ORDER_BY  = "videos.uploaded_on DESC";
$Featured_Videos->LIMIT     = 4;
$Featured_Videos->get();

$Featured_Videos = $Featured_Videos->fix_values(true, true);

?>
<body>
    <title>404 Not Found</title>
    <base target="_top">
    <link rel="stylesheet" href="/css/main.css">
    <style type="text/css">
        #logo {
            display: block;
            float: left;
            width: 110px;
            height: 40px;
            margin: 0 10px 0 0;
            background: no-repeat url(/img/bv09logo.png) 0 0;
        }
        .box-title {
            height: 23px;
            padding: 6px 18px 0 10px;
            vertical-align: top;
            background-color: #D2E3FB;
            border: 1px solid #A1B4D9;
            font-size: 16px;
            font-weight: bold;
        }
        .title-text {
            vertical-align: top;
        }
        .box-data {
            padding: 4px 13px 0;
            border-left: 1px solid #A1B4D9;
            border-right: 1px solid #A1B4D9;
            border-bottom: 1px solid #A1B4D9;
        }
        #main-content {
            width: 650px;
            position: relative;
            margin: 0 auto;
        }
        #error-message {
            text-align: center;
            font-weight: bold;
            color: #666;
            background-color: #FFC;
            margin-top: 50px;
            padding: 12px 0;
            border: 1px solid #FFCC05;
        }
        #search-wrapper {
            margin-top: 10px;
            padding: 15px 20px;
            border: 1px solid #CCC;
        }
        #logo {
            padding-right: 20px;
            margin-right: 20px;
            border-right: 1px solid #CCC;
        }
        #search-box {
            font-size: 13px;
        }
        #search-box .search-term {
            width: 370px;
        }
        #links {
            text-align: center;
            margin-top: 10px;
        }
        #promoted-videos {
            margin-top: 20px;
        }
        #copynotice {
            margin: 20px 0;
            text-align: center;
            font-size: 11px;
        }
        #masthead-search div {
            background: #fff;
        }
        .homepage-sponsored-video {
            margin-bottom: 20px;
        }
        .box-data {
            border-radius: 0 0 5px 5px;
        }
    </style>
    <div id="main-content">
        <div id="error-message" class="yt-rounded">
            <?= $LANGS['404error'] ?>
        </div>
        <div id="search-wrapper" class="yt-rounded">
            <a href="/" title="BitView home">
                <img id="logo" class="master-sprite" src="/img/pixel.gif" alt="BitView home">
            </a>
            <div id="search-box">
                <form autocomplete="off" class="search-form" action="/results" method="get" name="searchForm" id="masthead-search" onsubmit="if (document.getElementById('masthead-search-term').value != '') { document['searchForm'].submit(); }; return false;;return false;">
                    <button type="button" class="search-button yt-uix-button" id="search-btn" onclick="if (document.getElementById('masthead-search-term').value != '') { document['searchForm'].submit(); }; return false;;return false;" tabindex="2"><span class="yt-uix-button-content"><?= $LANGS['search'] ?></span></button>
                    <div>
                        <input id="masthead-search-term" class="search-term" name="search" type="text" tabindex="1" onkeyup="" value="" maxlength="128" autocomplete="off">
                    </div>
                    <select name="t" style="display: none;">
                        <option value="Search All">All</option>
                        <option value="Search Videos">Videos</option>
                        <option value="Search Users">Members</option>
                        <option value="Search Playlists">Playlists</option>
                    </select>
                </form>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div id="links">
            <a href="/browse?t=2"><?= $LANGS['featured'] ?></a> |
            <a href="/charts"><?= $LANGS['mostviewedvideos'] ?></a>
        </div>
        <div id="promoted-videos">
            <div class="box-title yt-rounded-top">
                <span class="title-text"><?= $LANGS['featured'] ?></span>
            </div>
            <div class="box-data grid-view yt-rounded-bottom">
                <?php foreach ($Featured_Videos as $Video) : ?>
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
                                <div><span class="vlfrom">          <a href="/user/<?=$Video["uploaded_by"]?>"><?= displayname($Video["uploaded_by"]) ?></a></span></div>
                                <div class="clearL"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                <div class="clear"></div>
            </div>
            </div>
        </div>
        <div id="copynotice">
            © 2025 Bittoco
        </div>
    </div>
</body>
