<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/profile_style.php" ?>
<div id="baseDiv">
                <?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_profile.php" ?>
    
        <br>
        <!--Begin Page Container Table-->
<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_profile/main_links.php" ?>  
<div class="video-page" style="width: 958px;">
        <div class="BoxesInnerOpacity">
            <div class="headerRCBox"> <div class="content">  <div class="headerTitleEdit">
        
        <div class="headerTitleRight">
         <?php if(!$_USER->is_subscribed($_PROFILE)) : ?>
                <a <?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username) : ?>href="/a/subscription_center?user=<?= $_PROFILE->Username ?>"<?php elseif (!$_USER->Logged_In) : ?>href="javascript:void(0)" onclick="alert('<?= $LANGS['logintosub'] ?>')"<?php else : ?>href="/my_account"<?php endif ?> class="action-button" title="subscribe to <?= $_PROFILE->Username ?>'s videos"><?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username) : ?><?= $LANGS['subvideos1'] ?><?= displayname($_PROFILE->Username) ?><?= $LANGS['subvideos2'] ?><?php elseif (!$_USER->Logged_In) : ?><?= $LANGS['subvideos1'] ?><?= displayname($_PROFILE->Username) ?><?= $LANGS['subvideos2'] ?><?php endif ?></a>
        <?php else : ?>
                <a href="/a/subscription_center?user=<?= $_PROFILE->Username ?>" class="action-button" onclick=""><?= $LANGS['unsubscribe'] ?></a>
        <?php endif ?>
        </div>
        <span><?php if ($_GET["page"] == "videos") : ?><?= $LANGS['videos'] ?> (<?= $_PROFILE->Info["videos"] ?>)<?php elseif ($_GET["page"] == "pvideos") : ?><?= $LANGS['pvideos'] ?><?php else : ?><?= $LANGS['favorites'] ?> (<?= $_PROFILE->Info["favorites"] ?>)<?php endif ?></span>
    </div>
</div>
    </div>

        <div class="headerBoxOpacity"></div>
        </div>
        <div class="basicBoxes" style="width:942px;padding:8px;text-align:left;">
        <?php if ($Videos) : ?>
<div class="BoxesInnerOpacity">
        <?php if ($_GET["page"] == "videos" OR $_GET["page"] == "pvideos"): ?>
        <div style="padding:5px;">
        <div class="alignC floatL" style="margin: 5px 15px 5px 5px;">
                <?php if ($Type == "1"): ?><span id="videosRecentSpan"><?= $LANGS['videos'] ?></span><?php else: ?><a id="videosRecentLink" href="/user/<?= $_PROFILE->Info["username"] ?>&page=<?php if ($_GET["page"] == "videos"): ?>videos<?php elseif ($_GET["page"] == "pvideos"): ?>pvideos<?php endif?>&t=1&query=<?= $_GET["query"] ?>">Videos</a><?php endif ?>
            | 
                <?php if ($Type == "2"): ?><span id="videosViewedSpan"><?= $LANGS['mostviewed'] ?></span><?php else: ?><a id="videosViewedLink" href="/user/<?= $_PROFILE->Info["username"] ?>&page=<?php if ($_GET["page"] == "videos"): ?>videos<?php elseif ($_GET["page"] == "pvideos"): ?>pvideos<?php endif?>&t=2&query=<?= $_GET["query"] ?>"><?= $LANGS['mostviewed'] ?></a><?php endif ?>
                | 
                    <?php if ($Type == "3"): ?><span id="videosDiscussedSpan"><?= $LANGS['mostdiscussed'] ?></span><?php else: ?><a id="videosDiscussedLink" href="/user/<?= $_PROFILE->Info["username"] ?>&page=<?php if ($_GET["page"] == "videos"): ?>videos<?php elseif ($_GET["page"] == "pvideos"): ?>pvideos<?php endif?>&t=3&query=<?= $_GET["query"] ?>"><?= $LANGS['mostdiscussed'] ?></a><?php endif ?>
        </div>
        <?php if ($_GET["page"] == "videos"): ?>
        <div style="float:right;margin: 4px 4px 15px 5px">
                    <form action="/profile" method="GET" style="position:relative;bottom:1px">
                        <input type="hidden" name="user" value="<?= $_PROFILE->Username ?>">
                        <input type="hidden" name="page" value="videos">
                        <input type="text" maxlength="20" style="font-size:12px" name="query"<?php if (isset($_GET["query"])) : ?> value="<?= $_GET["query"] ?>"<?php endif ?>> <input style="font-size: 12px"type="submit" value="<?= $LANGS['search'] ?>">
                    </form>
                </div>
                <?php endif ?>
    </div>
<?php endif ?>
                                        
            
                
                    <table cellpadding="0" cellspacing="5" border="0" width="100%">
                    <tbody>
                    <?php $Count = 0; ?>
        <tr valign="top">
        <?php foreach ($Videos as $Video) : ?>
        <?php $Count++ ?>
        <td width="20%">
        <div class="video-entry">



            <div class="v120WideEntry"><div class="v120WrapperOuter"><div class="v120WrapperInner"><a href="<?= $Video["link"] ?>" rel="nofollow"><img title="<?= $Video["title"] ?>" src="<?= $Video["thumb"] ?>" class="vimg120" alt="<?= $Video["title"] ?>"></a><div class="video-time"><span id="video-run-time"><?= timestamp($Video["length"]) ?></span></div>
</div></div></div>

        <div class="video-main-content">


            <div class="video-title ">
                <div class="video-title">
                    <a href="<?= $Video["link"] ?>" title="<?= $Video["title"] ?>" rel="nofollow"><?= $Video["title"] ?></a>
                </div>
            </div>
            <div class="video-facets">

                    <span id="video-average-rating-SFfkDAqMPF8" class="video-rating-list video-rating-with-caps">
                                    

    <div>
    </div>


                    </span>

                        <span id="video-added-time" class="video-date-added"><?= get_time_ago($Video["uploaded_on"]) ?></span>

                    <span id="video-num-views" class="video-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>

                    <span class="video-username"><a id="video-from-username-SFfkDAqMPF8" class="hLink" href="<?= $Video["uploader_link"] ?>"><?= displayname($Video["uploaded_by"]) ?></a></span>

                    <span id="video-average-rating-SFfkDAqMPF8" class="video-rating-grid video-rating-with-caps">
                                    

    <div>

    
<div class="video-ratings"><?php show_ratings($Video,"12px","12px") ?></div>



    </div>


                    </span>


            </div>  

        </div>  
        <div class="video-clear-list-left"></div>



    </div>  
</td>
<?php if ($Count == 5) : ?>
        
    </tr>
    <tr valign="top">
        <?php $Count = 0 ?>
                    <?php endif ?>
                    <?php endforeach ?>
    </tbody></table>
    <br>

            </div>

            <div class="basicBoxesOpacity"></div>
        </div>
        <div class="footerBox">
                    <div class="pagingDiv">
                        <?php $_PAGINATION->new_show_pages_videos("user=".$_PROFILE->Info["username"]."&page=".$_GET["page"]."&t=".$Type."&query=".urlencode((string) $_GET["query"])) ?>
        
        </div>

        </div>

    </div>
                <?php else : ?>
            <?php if ($_GET["page"] !== "pvideos" || ($_USER->Logged_In && $_USER->Username === $_PROFILE->Username) || ($_USER->Logged_In && $Friend_Status == 1)) : ?>
                <div style="font-size:15px;color:#<?= $_PROFILE->Info["c_normal_font"] ?>;text-align:center;padding:5px 5px 35px">
                <div style="text-align:right;margin: 4px 4px 15px 5px">
                    <form action="/profile" method="GET" style="position:relative;bottom:1px">
                        <input type="hidden" name="user" value="<?= $_PROFILE->Username ?>">
                        <input type="hidden" name="page" value="videos">
                        <input type="text" maxlength="20" style="font-size:12px" name="query"<?php if (isset($_GET["query"])) : ?> value="<?= $_GET["query"] ?>"<?php endif ?>> <input style="font-size: 12px"type="submit" value="<?= $LANGS['search'] ?>">
                    </form>
                </div><div><?= $LANGS['novideos'] ?></div></div>
                <div class="basicBoxesOpacity"></div>
        </div>
            <?php else : ?>
                <div style="font-size:15px;color:#<?= $_PROFILE->Info["c_normal_font"] ?>;text-align:center;padding:22px 0 29px"><?= $LANGS['pvideosallow'] ?></div>
                <div class="basicBoxesOpacity"></div>
        </div>
            <?php endif ?>
        <?php endif ?>


        
        
        
        <div style="visibility:hidden">
        <img src="" border="0" width="1" height="1">
        </div>
    </div>
    </div>
