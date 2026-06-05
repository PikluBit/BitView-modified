<link rel="stylesheet" href="/css/home.css">
<script>
    var langs_loading = '<?= $LANGS['loading'] ?>';
</script>
<script src="/js/home.js"></script>

<?php if (isset($Strikes) && $Strikes) : ?>
    <?php foreach ($Strikes as $Strike) : ?>
        <div class="confirmBox" style="background-color: #ffaeae !important; text-align: left; padding: 12px;">
            <h2>ATTENTION</h2>
            <p>We have recieved copyright complaint(s) regarding material you posted, as follows:</p>
            <ol>
                <ul>
                    <li>from <?= $Strike["copyright_holder"] ?> about <?= $Strike["title"] ?> - <?= $Strike["for_user"] ?></li>
                </ul>
            </ol>
            <p>Please Note: <b>Accounts Determined to be repeat infringers will be terminated</b>. Please delete any videos for which you do not own the necessary rights, and refrain from uploading infringing videos.</p>
            <p>For your reference, a copy of this message has been sent to you via email and can also be located in your Account Warnings page.</p>
            <button onclick="location.href='/?understand=<?= $Strike["url"] ?>';">I Acknowledge</button>
        </div>
    <?php endforeach ?>
<?php endif ?>
<div id="homepage-main-content">
    <?php if (!$_USER->Logged_In): ?>
    <div id="iyt-login-suggest-box">
        <div class="yt-alert yt-alert-promo yt-rounded">
            <div class="yt-alert-content">
                <div class="signup-promo-message"><?= $LANGS['jointitle'] ?></div>
                <div id="signup-promo-links">
                    <button href="/signup" type="button" class="yt-uix-button" onclick=";window.location.href=this.getAttribute('href');return false;"><span class="yt-uix-button-content"><?= $LANGS['signup'] ?> ›</span></button>
                    <span class="signup-promo-have-account"><?= $LANGS['joindesc'] ?> </span>
                    <a href="/login"><?= $LANGS['login'] ?></a>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
    <?php if ($_USER->Logged_In && $_USER->Info['h_feed'] != 1 && (!isset($_COOKIE['feed_forget']) || isset($_COOKIE['feed_forget']) && $_COOKIE['feed_forget'] != 1)): ?>
    <div id="iyt-login-suggest-box" style="margin-bottom: 10px;">
        <div class="yt-alert yt-alert-promo yt-rounded">
            <div class="yt-alert-content">
                <div style="float:left">
                <div class="signup-promo-message" style="font-size: 1.33333em;margin: 0;"><?= $LANGS['newhomepagetitle'] ?></div>
                <div class="signup-promo-message" style="font-size: 1em;font-weight: normal;margin: 0;"><?= $LANGS['newhomepagedesc'] ?></div>
                </div>
                <div id="signup-promo-links">
                    <button href="/a/change_homepage" type="button" style="float:right;font-size: 1em;height: 2.5em;margin: 0.13333333em 0em;" class="yt-uix-button" onclick=";window.location.href=this.getAttribute('href');return false;"><span class="yt-uix-button-content"><?= $LANGS['newhomepagebutton'] ?></span></button>
                </div>
            </div>
            <span id="hp-close" style="position: absolute;top: 0;right: 0;margin: 6px;cursor:pointer"onclick="forgetFeed()"><img class="img-php-close-button" src="/img/pixel.gif"></span>
        </div>
    </div>
    <?php endif ?>
    <?php if ($_USER->Logged_In && $_USER->Info['h_feed'] != 1): ?><div style="margin-bottom: 10px;padding: 0 6px;font-size: 13px;"><a href="/my_account#modules"><img id="moduleimg" src="/img/pixel.gif"><?= $LANGS['modules'] ?></a></div><?php elseif ($_USER->Logged_In && $_USER->Info['h_feed'] == 1): ?><div style="margin-bottom: 10px;font-size: 13px;"><?= $LANGS['newhomepagewelcome'] ?><a href="/a/change_homepage?b=1" style="float: right;font-size: 11px;line-height: 18px;"><?= $LANGS['newhomepageback'] ?></a></div><?php endif ?>
    <?php
    $_USER->Info['h_featured'] = 0; // DISABLE featured module on center, now on right!
    $_USER->Info['h_spotlight'] = 0; // DISABLE spotlight module on center, now on right!
    ?>
    <?php if ($_USER->Logged_In) : ?>
        <?php foreach ($Modules as $Module): ?>
            <?php require_once "_templates/_pages/home_modules/".$Module.".php" ?>
            <?php require_once "_templates/_pages/home_modules/h_feed.php" ?>
        <?php endforeach ?>
    <?php else: ?>
        <?php require_once "_templates/_pages/home_modules/h_recommended.php" ?>
        <?php require_once "_templates/_pages/home_modules/h_mostpop.php" ?>
    <?php endif ?>
</div>
<div id="homepage-side-content" style="white-space: normal;">
    <div class="homepage-side-content-block">
    <?php if ($Spotlight): ?>
    <div class="homepage-side-block">
        <h2>Spotlight Videos</h2>
        <h3><?= htmlspecialchars((string) $Spotlight['title']) ?></h3>
        <div class="feedmodule-feditor">
        <div class="guest-editor-with-comment">
            <div class="guest-editor-comment"><?= htmlspecialchars((string) $Spotlight['description']) ?></div>
          <div class="guest-editor-profile-link">Presented by: <a href="/user/<?= $Spotlight['username'] ?>"><?= displayname($Spotlight['username']) ?></a>
          </div>
      </div>
      <div class="spacer">&nbsp;</div>
        </div>
        <div id="hp-sidebar-FEA">
            <ul id="sidebar-videos-FEA" class="video-list">
                <?php foreach ($Spotlight_Videos as $Video): ?>
                    <li class="video-list-item">
                        <a class="video-list-item-link" href="/watch?v=<?= $Video['url'] ?>">  
                            <span class="video-thumb video-thumb-94" id="video-thumb-<?= $Video['url'] ?>">
                                <span class="img">
                                <img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg94" alt="<?= $Video['title'] ?>" title="<?= $Video['title'] ?>"></span>
                                <span class="video-time"><?= timestamp($Video["length"]) ?></span><?php if (!in_array($Video["url"], $_USER->QuickList)): ?>
                                <span class="video-actions"><button type="button" class=" yt-uix-button yt-uix-button-short" id="yt-uix-button-short-<?= $Video['url'] ?>" onclick="addToQuickList(this);return false;"><span class="yt-uix-button-content"><strong>+</strong></span></button></span>
                                <span class="video-in-quicklist"><?= $LANGS['addedtoqueue'] ?></span><?php endif ?>
                            </span>
                            <span class="title" title="<?= $Video['title'] ?>"><?= $Video['title'] ?></span><span class="stat"><?= displayname($Video['uploaded_by']) ?></span><span class="stat"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <?php endif ?>
    <div class="homepage-side-block">
      <h2><?= $LANGS["featured"] ?></h2>
        <div id="hp-sidebar-ASO">
            <ul id="sidebar-videos-ASO" class="video-list">
                <?php foreach ($Featured_Videos as $Video): ?>
                    <li class="video-list-item">
                        <a class="video-list-item-link" href="/watch?v=<?= $Video['url'] ?>">  
                            <span class="video-thumb video-thumb-94" id="video-thumb-<?= $Video['url'] ?>">
                                <span class="img">
                                <img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg94" alt="<?= $Video['title'] ?>" title="<?= $Video['title'] ?>"></span>
                                <span class="video-time"><?= timestamp($Video["length"]) ?></span><?php if (!in_array($Video["url"], $_USER->QuickList)): ?>
                                <span class="video-actions"><button type="button" class=" yt-uix-button yt-uix-button-short" id="yt-uix-button-short-<?= $Video['url'] ?>" onclick="addToQuickList(this);return false;"><span class="yt-uix-button-content"><strong>+</strong></span></button></span>
                                <span class="video-in-quicklist"><?= $LANGS['addedtoqueue'] ?></span><?php endif ?>
                            </span>
                            <span class="title" title="<?= $Video['title'] ?>"><?= $Video['title'] ?></span><span class="stat"><?= displayname($Video['uploaded_by']) ?></span><span class="stat"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <?php if ($_USER->Logged_In) : ?>
        <div class="homepage-side-block">
            <h2><?= $LANGS['inbox'] ?></h2>
            <?php 
            $Notifications_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND (is_notification = 1 or type = 2 or type = 4 or type = 5) AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
            $Sh_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 1 AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
            $Res_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 3 AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
            ?>
            <div class="module-item-wrapper yt-rounded feedmodule-border-gray" id="statmodules_inbox-content">
                <div class="statModule-item-line">
                    <div class="statModule-item-text">
                        <a href="/inbox"><?= $Messages ?> <?php if ($Messages != 1) : ?><?= $LANGS['messages'] ?><?php else: ?><?= $LANGS['message'] ?><?php endif ?></a>
                    </div>
                </div>
                <div class="statModule-item-line">
                    <div class="statModule-item-text">
                        <a href="/inbox?v=s"><?= $Sh_Amount ?> <?php if ($Sh_Amount != 1) : ?><?= $LANGS['sharedwithyou'] ?><?php else: ?><?= $LANGS['sharedwithyousingular'] ?><?php endif ?></a>
                    </div>
                </div>
                <div class="statModule-item-line">
                    <div class="statModule-item-text">
                        <a href="/inbox?v=c"><?= $Notifications_Amount ?> <?php if ($Notifications_Amount != 1) : ?><?= $LANGS['comments'] ?><?php else: ?><?= $LANGS['comment'] ?><?php endif ?></a>
                    </div>
                </div>
                <div class="statModule-item-line">
                    <div class="statModule-item-text">
                        <a href="/address_book?v=fi"><?= $Requests ?> <?php if ($Requests != 1) : ?><?= $LANGS['friendinvites'] ?><?php else: ?><?= $LANGS['friendinvite'] ?><?php endif ?></a>
                    </div>
                </div>
                <div class="statModule-item-line">
                    <div class="statModule-item-text">
                        <a href="/inbox?v=r"><?= $Res_Amount ?> <?php if ($Res_Amount != 1) : ?><?= $LANGS['videoresponses'] ?><?php else: ?><?= $LANGS['videoresponse'] ?><?php endif ?></a>
                    </div>
                </div>
            </div>
            <div class="hpLoginForgot smallText">
                <p align="right" class="marT0 marB0"><a href="/send_message"><?= $LANGS['sendmessage'] ?></a></p>
                <p align="center" class="marT0 marB0">
            </div>
            <div class="bottomBorderDotted"></div>
        </div>
    <?php endif ?>
    <?php if ($Blog_Posts) : ?>
        <?php if (isset($_GET["umaru"])) : ?>
        <style> 
            body, #masthead {
                background-color: #FF8C19 !important;
            }
        </style>
        <div class="homepage-side-block">
            <div class="homepage-whats-new-content">
                <h2><?= $LANGS['whatsnew'] ?></h2>

                <div class="homepage-whatsnew-entry">
                    <div class="homepage-whatsnew-image"><a href="/user/vistafan12"><img src="https://cdn.discordapp.com/attachments/719655452048359474/744691301903237140/image0.jpg" border="0" width="30" height="37"></a></div>
                    <div class="homepage-whatsnew-desc">
                        <b><a href="/user/vistafan12">I love Umaru-chan</a></b><br>NGL she's so hot. She also looks so fucking perfect. I love her.
                    </div>
                </div>
                <div class="clear"></div>

                <div class="alignR padT5">
                        <a href="/blog" style="color:#CC6600"><?= $LANGS['readmore'] ?></a>
                </div>
                <div style="font-size: 1px; height: 1px;"><br></div>
            </div>
        </div>
        <?php else : ?>
            <div class="homepage-side-block">
            <div class="homepage-whats-new-content">
                <h2><?= $LANGS['whatsnew'] ?></h2>
                <?php foreach ($Blog_Posts as $Blog_Post) : ?>
                    <div class="homepage-whatsnew-entry">
                        <div class="homepage-whatsnew-desc">
                            <b><a href="/blog#<?= $Blog_Post['id'] ?>"><?= $Blog_Post["title"] ?></a></b>
                                <?= strip_tags((string) short_title($Blog_Post["content"], 100)) ?></div>
                    </div>
                <?php endforeach ?></div>
        <div class="clear"></div>

                <div class="alignR padT5">
                        <a href="/blog"><?= $LANGS['readmore'] ?></a>
                </div>
                <div style="font-size: 1px; height: 1px;"><br></div>
            </div>
        </div>
        <?php endif ?>
    <?php endif ?>
    <div class="clear"></div>
    <div class="clear"></div>

    <div class="clear"></div>
    <div class="homepage-side-block" id="homepage-chrome-side-promo">
        <div id="side-announcement-box">
            <div id="info-box" class="yt-alert yt-alert-info yt-rounded" style="width: 290px;margin:15px 0 0 0;">
                <div class="yt-alert-icon"></div>
                <div class="yt-alert-content"><?= htmlspecialchars_decode(nl2br((string) $Box_MSG['value'])) ?></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="homepage-side-block">
        <a href="https://blips.club/"><div id="bvMobAdimageContainer" style="width: 300px !important;"></div></a>
    </div>
    <div style="width:120;margin:0 auto;text-align:center">
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
    <div class="clear"></div>
    </div> <!-- end homepage-content-block -->
</div>
<div class="clear"></div>
<div class="clear"></div>
