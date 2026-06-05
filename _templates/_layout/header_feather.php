<div id="masthead-container">
        <div id="masthead">
            <a href="/">
                <a href="/" class="logo"><img src="/img/bv09logo.png" alt="BitView - Your Digital Video Repository" width="84" height="33" border="0"></a>
            </a>
            <div id="masthead-search">
                <form autocomplete="off" name="searchForm" id="searchForm" method="GET" action="/results">
                    <input tabindex="1" type="text" name="search" maxlength="128" id="searchField" value="<?php if (isset($_GET["search"])) : ?><?= $_GET["search"] ?><?php endif ?>">
                    <select name="t">
                        <option value="Search Videos"<?php if (isset($_GET["t"]) && $_GET["t"] == "Search Videos") : ?> selected<?php endif ?>>Videos</option>
                        <option value="Search Users"<?php if (isset($_GET["t"]) && $_GET["t"] == "Search Users") : ?> selected<?php endif ?>>Members</option>
                        <option value="Search Playlists"<?php if (isset($_GET["t"]) && $_GET["t"] == "Search Playlists") : ?> selected<?php endif ?>>Playlists</option>
                    </select>
                    <input class="yt-button yt-button-primary" type="submit" value="<?=$LANGS['search']?>">
                </form>
            </div>
            <div id="masthead-utility" class="util-a1">
<div id="masthead-utility">
    <?php if ($_USER->Logged_In) : ?>
    <?php else : ?>
    <?php endif ?>
</div>
            </div>
            <div id="masthead-nav-user">
                <?php if (!$_USER->Logged_In): ?><a href="/login"><?= $LANGS['login'] ?></a> <?= $LANGS['or'] ?> <a href="/signup"><?= $LANGS['signup'] ?></a>
                <?php else:?><div style="text-align: left;float: left;font-size: 12px;"><a style="font-size: 14px;" href="/user/<?= $_USER->Username ?>"><?= displayname($_USER->Username) ?></a><br><span style="font-weight: normal;color: #999;"><a href="/my_account"><?= $LANGS['account'] ?></a> | <a href="/logout"><?= $LANGS['logout'] ?></a></span></div><?php endif ?>
                <a class="yt-button yt-button-urgent yt-upload-feather" id="" style="margin-left: 16px;" href="/my_videos_upload"><span><?=$LANGS['upload']?></span></a>
            </div>
            <div id="masthead-end"></div>
        </div>
    </div>
<?php if (isset($_SESSION["notification_msg"])) { require_once "error_message.php"; } // else { echo '<div class="confirmBox" style="background-color: #cfeeb2 !important">BitView will be undergoing scheduled maintenance, starting 7:00 pm PDT.</div>'; } ?>
<?php if (!isset($_COOKIE["lang"]) and !str_starts_with((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], "en-US") and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5).".lang.php") or !isset($_COOKIE["lang"]) and substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) != "en-US" and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php")) : ?>
<div id="default-language-box">
        <div id="default-language-top">
            <div id="default-language-translated">
                    <p class="errorParagraph"><strong><?= $LANGS['welcometobitview'] ?></strong> </p>
                    
                    <p class="errorParagraph"><strong><?= $LANGS['languagesuggestion'] ?></strong>  <?= $LANGS['language'] ?></p>
                    
                    <p class="errorParagraph"><?= $LANGS['languagesuggestiondesc1'] ?></p>
                    
                    <p class="errorParagraph"><?= $LANGS['languagesuggestiondesc2'] ?></p>
                <div style="padding-left: 350px;">
                    <div style="width: 250px;">
                        <a href="/?hl=<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5).".lang.php")) : ?><?= substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) ?><?php else : ?><?= substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) ?><?php endif ?>" class="action-button">
                            <span class="action-button-text"><?= $LANGS['accept'] ?></span>
                        </a>
                            <a href="/?hl=en-US" class="edit-button">
                            <span class="yt-button" style="padding: 4.5px 10px;font-size: 12px;font-weight: bold;margin: 0 6px;"><?= $LANGS['cancel'] ?></span>
                        </a> 
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div id="default-language-english" style="display: none;">
                <br>
                    <p class="errorParagraph"><strong>Welcome to BitView!</strong> </p>
                    
                    <p class="errorParagraph"><strong>Suggested Language (we have set your preference to this):</strong> <?= $LANGS['languageenglish'] ?></p>
                    
                    <p class="errorParagraph">To change your language preference, please use the language selector in the footer (end of the page).</p>
                    
                    <p class="errorParagraph">Click "OK" to accept this setting, or click "Cancel" to view the site in English.</p>
                <div style="padding-left: 350px;">
                    <div style="width: 250px;">
                        <a href="/?hl=<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5).".lang.php")) : ?><?= substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) ?><?php else : ?><?= substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) ?><?php endif ?>" class="action-button">
                            <span class="action-button-text">OK</span>
                        </a>
                            <a href="/?hl=en-US" class="edit-button">
                            <span class="yt-button" style="padding: 4.5px 10px;font-size: 12px;font-weight: bold;margin: 0 6px;">Cancel</span>
                        </a> 
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
                <div id="default-language-english-show-link" class="floatR">
                    <a href="#" class="noul small" onclick="show_english()">Show message in English</a>
                </div>
                <div id="default-language-english-hide-link" class="floatR" style="display: none;">
                    <a href="#" class="noul small" onclick="show_english()">Hide message in English</a>
                </div>
            <div class="clear"></div>
        </div>
    </div>
<?php endif ?>