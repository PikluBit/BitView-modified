<style type="text/css">
.videoModifiers {
    padding: 5px 0px;
    border-bottom: 1px solid #ccc;
    text-align: center;
}
.videoModifiers div.first {
    border-left: 0px;
    padding: 0px 10px 0px 2px;
}
.videoModifiers div.subcategory {
    border-left: 1px solid #ccc;
    padding: 0px 10px;
    font-size: 11px;
    display: inline;
}
.videoModifiers .selected {
    font-weight: bold;
}
#nav-pane .header {
    height: 6.5px;
}
#dropdownarrow {
    height: 16px;
    width: 12px;
    margin-right: 6px;
    background: transparent url(/img/master-vfl87445.png) no-repeat scroll 0 -321px;
    vertical-align: middle;
}
.dropdown-title {
    cursor: pointer;
}
.dropdown-title:hover {
    color: #666;
}
.content {
    margin: 4px 0px;
    padding: 0 14px;
}
</style>
<div id="container">
<!-- left column - FOR ADS ONLY IF MY SUBS -->
<table class="column-table account" cellspacing="0" cellpadding="0">
        <tbody>
            <?php require_once "_templates/_layout/title_and_pagination.php" ?>
        <tr>
            <td class="tabs"><div id="list-pane">
                    <div class="folder"><a class="name" href="/my_account"><?= $LANGS['overview'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_account?page=about"><?= $LANGS['profilesetup'] ?></a></div>
                    <div class="folder selected"><a class="name" href="/my_account_modules"><?= $LANGS['customizehomepage'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_account?page=playback"><?= $LANGS['playbacksetup'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_account?page=email"><?= $LANGS['emailoptions'] ?></a></div>
                    <?php if ($_USER->Info['is_partner']): ?><div class="folder"><a class="name" href="/my_account?page=partner"><?= $LANGS['partnersettings'] ?></a></div><?php endif ?>
                    <div class="folder"><a class="name" href="/my_account?page=manageaccount"><?= $LANGS['manageaccount'] ?></a></div>
                </div>
            </td>
            <td class="column-divider"></td>
            <td id="account-page" class="page">
                <div id="video_grid" class="browseGridView marT10">
                        <form action="/my_profile_modules" method="post">
                    <div style="border-bottom: 1px solid #ccc;padding-bottom: 6px;margin-bottom: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" name="save_profile" value="<?= $LANGS['editsavechanges'] ?>"></div>
                    <div class="dropdown-title" id="customize-homepage"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['customizethehomepage'] ?></strong></div>
                    <div class="dropdown-description" id="customize-homepage" style="color: #666;padding: 4px 18px;"><?= $LANGS['customizehomepagedesc'] ?></div>
                    <div class="content" id="about-me-content">
                        <table border="0" cellpadding="5" cellspacing="0">
                            <tr>
                                <td align="middle"><input type="checkbox" name="subscriptions" id="subscriptions"<?php if ($_USER->Info["h_subscriptions"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="subscriptions"><?= $LANGS['subscriptions'] ?></label></td>
                            </tr>
                            <tr>
                                <td align="middle"><input type="checkbox" name="recommended" id="recommended"<?php if ($_USER->Info["h_recommended"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="recommended"><?= $LANGS['recommendedforyou'] ?></label></td>
                            </tr>
                            <tr>
                                <td align="middle"><input type="checkbox" name="activity" id="activity"<?php if ($_USER->Info["h_activity"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="activity"><?= $LANGS['friendactivity'] ?></label></td>
                            </tr>
                            <tr>
                                <td align="middle"><input type="checkbox" name="beingwatched" id="beingwatched"<?php if ($_USER->Info["h_beingwatched"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="beingwatched"><?= $LANGS['beingwatched'] ?></label></td>
                            </tr>
                            <tr>
                                <td align="middle"><input type="checkbox" name="featured" id="featured"<?php if ($_USER->Info["h_featured"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="featured"><?= $LANGS['featured'] ?></label></td>
                            </tr>
                            <tr>
                                <td align="middle"><input type="checkbox" name="mostpop" id="mostpop"<?php if ($_USER->Info["h_mostpop"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="mostpop"><?= $LANGS['mostpopular'] ?></label></td>
                            </tr>
                        </table>
                        <br><div><strong><?= $LANGS['displaypreferences'] ?></strong></div>
                        <div><input type="checkbox" name="feed" id="feed"<?php if ($_USER->Info["h_feed"] == 1) : ?> checked<?php endif ?>>
                                <label for="feed"><strong><?= $LANGS['thefeed'] ?></strong>: <?= $LANGS['thefeeddesc'] ?></label></div>
                        <br><div><strong><?= $LANGS['friendactivitytitle'] ?></strong></div>
                        <div class="dropdown-description" id="customize-homepage" style="color: #666; margin-bottom: 10px;"><?= $LANGS['friendactivitydesc'] ?></div>
                    </div>
                    <div style="border-top: 1px solid #ccc;padding-top: 6px;margin-top: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" name="save_profile" value="<?= $LANGS['editsavechanges'] ?>"></div>
                </form>
                    </div></td>
        </tr>
    </tbody></table>
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



<div class="clear"></div>
</div>