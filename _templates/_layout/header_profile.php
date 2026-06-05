  <script>
function showlanguagebox() {
  var y = document.getElementById("small-masthead-language-dropdown");
  if (y.style.display === "none") {
    y.style.display = "block";
  }
  else {
    y.style.display = "none";
  }
}
  </script>
  <table class="channelMastheadTable">
            <tbody><tr>
                <td width="104" valign="absmiddle">
                    <a href="/"><img id="smallMastheadLogo" src="/img/headerlogo.png" style="background-image: url(/img/bv09pride.png) !important;"></a>
                </td>            
                <td valign="absmiddle" nowrap="">
                    <div class="alignL padTlg padLsm">
                        <span id="small-masthead-language-link" class="basic-dropdown-link">
                    <div id="small-masthead-language-dropdown" class="dropdown wasblock" style="display: none;">
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=ca">Català</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=sr">Србски</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=de-DE">Deutsch</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=en-CA">English (Canada)</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=en-GB">English (UK)</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=en-US">English (US)</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=es-ES">Español (España)</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=es-MX">Español (México)</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=eo">Esperanto</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=fr-FR">Français</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=gl">Galego</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=hr">Hrvatski</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=pl">Polski</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=it">Italiano</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=ru">Pyccĸий</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=ro">Română</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=uk">Українська</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=ko">한국어</a></div>
                            <div><a href="/user/<?= $_PROFILE->Username ?>&hl=zh">中文</a></div>
                    </div>
                    <div class="dropdown-link">
                        <a href="javascript:void(0)" onclick="showlanguagebox();" class="masthead"><?= $LANGS['language'] ?><span style="font-size: 9px;">▼</span></a>
                    </div>
                </span>
                <div id="small-masthead-tabs">
                        <a href="/browse" class="masthead"><?= $LANGS['videos'] ?></a> | 
                        <a href="/channels" class="masthead"><?= $LANGS['channels'] ?></a> | 
                        <a href="/my_videos_upload" class="masthead"><?= $LANGS['upload'] ?></a>
                    </div>
                    </div>
                </td>
    
                <td class="alignR" valign="top">
                
    <div class="smallText" <?php if ($_USER->Logged_In) : ?>style="margin-top: -4px;"<?php endif ?>>
        <?php if (!$_USER->Logged_In) : ?>
            <b><a href="/signup" class="headerLink"><?= $LANGS['signup'] ?></a></b>
            |
            <a href="/my_account"  class="headerLink"><?= $LANGS['account'] ?></a>
            |
            <a href="/viewing_history" onclick="" class="headerLink"><?= $LANGS['history'] ?></a>
            |
            <a href="/help" class="headerLink"><?= $LANGS['help'] ?></a>
            |
            <a href="/login" class="headerLink"><?= $LANGS['login'] ?></a>
        <?php else : ?>
            <?php $Messages_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND seen = 0", true, [":USERNAME" => $_USER->Username])["amount"] ?>
     <span class="utility-item"><a href="/inbox" style="color: #666!important;" class="inbox_r">(<?= $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND seen = 0", true, [":USERNAME" => $_USER->Username])["amount"] ?>)</a><a class="img-general-messages" <?php if($Messages_Amount>0) : ?>id="r"<?php endif ?> href="/inbox" title="Inbox"></a></span>
            <style>.yt-menulink-menu a {padding: 6px 18px 6px 8px;display: block;}</style>
    <?php if ($_USER->Logged_In) : ?>
    <span class="utility-item" id="masthead-utility-menulink-long">
        <span class="yt-menulink yt-menulink-primary" id="" style="" onmouseenter="this.className += ' yt-menulink-primary-hover';" onmouseleave="this.className = this.className.replace(' yt-menulink-primary-hover', '');">
            <a class="yt-menulink-btn yt-button yt-button-primary"href="/user/<?= $_USER->Username ?>" onclick=""><?= displayname($_USER->Username) ?></a></a>
            <a class="yt-menulink-arr"></a>
            <span class="yt-menulink-menu">
                <span><a href="/my_account" style="color: #03c!important;"><?= $LANGS['account'] ?></a></span>
                <span><a href="/my_videos" style="color: #03c!important;"><?= $LANGS['myvideos'] ?></a></span>
                <span><a href="/my_favorites" style="color: #03c!important;"><?= $LANGS['favorites'] ?></a></span>
                <span><a href="/my_playlists" style="color: #03c!important;"><?= $LANGS['playlists'] ?></a></span>
            </span>
        </span>
    </span>
    <?php else : ?>
    <span class="utility-item">
        <a href="/signup" onclick=""><strong>Create Account</strong></a>
        <span class="utility-joiner">or</span>
        <a href="/login" onclick="">Sign In</a>
    </span>
    <?php endif ?>
            |
            <a href="/my_account" class="headerLink"><?= $LANGS['account'] ?></a>
            |
            <?php if ($_USER->Is_Moderator || $_USER->Is_Admin) : ?>
                <a href="/admin_panel" class="headerLink">Admin Panel</a>
                |
            <?php endif ?>
            <a href="/viewing_history" onclick="" class="headerLink"><?= $LANGS['history'] ?></a>
            |
            <a href="/help" class="headerLink"><?= $LANGS['help'] ?></a>
            |
            <a href="/logout" class="headerLink"><?= $LANGS['logout'] ?></a>
        <?php endif ?>
    </div>
    <div class="searchDiv" style="margin-top:3px;">
            <form autocomplete="off" name="searchForm" id="searchForm" method="get" action="/results">
            <input tabindex="1" type="text" name="search" maxlength="128" id="searchField" class="searchField" value="<?php if (isset($_GET["search"])) : ?><?= $_GET["search"] ?><?php endif ?>">
                     <select name="t" style="display:none">
                <option value="Search Videos"<?php if (isset($_GET["t"]) && $_GET["t"] == "Search Videos") : ?> selected<?php endif ?>>Videos</option>
                <option value="Search Users"<?php if (isset($_GET["t"]) && $_GET["t"] == "Search Users") : ?> selected<?php endif ?>>Members</option>
                <option value="Search Playlists"<?php if (isset($_GET["t"]) && $_GET["t"] == "Search Playlists") : ?> selected<?php endif ?>>Playlists</option>
            </select>
            <input type="submit" value="<?= $LANGS['search'] ?>">
    </form>
    </div>

                    </td>                                           
            </tr>
        </tbody></table>
        <div class="clear"></div>
  <div><img id="smallMastheadBottom" src="/img/pixel.gif"></div>
  <div><?php if (isset($_SESSION["notification_msg"])) { require_once "error_message.php"; } ?></div>
