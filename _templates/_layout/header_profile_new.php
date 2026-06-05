<script>
function show_english() {
  var x = document.getElementById("default-language-english");
  var y = document.getElementById("default-language-english-show-link");
  var z = document.getElementById("default-language-english-hide-link");
  if (x.style.display === "block") {
    x.style.display = "none";
    y.style.display = "block";
    z.style.display = "none";
  } else {
    x.style.display = "block";
    y.style.display = "none";
    z.style.display = "block";
  }
}
document.onkeyup = function (e) {
    if (document.activeElement.id == "masthead-search-term") {
    if (e.which != 40 && e.which != 38) {
        var query = document.getElementById('masthead-search-term').value;
        $.ajax({
            url: "/a/autocomplete?query="+query,
            success: function(html){
                if(html && query.length > 0){
                    if ($(".autoComplete").length == 0) {
                        $("body").append(html);
                    }
                    else {
                        $(".autoComplete").replaceWith(html);
                    }
                } else {
                    $(".autoComplete").remove();
                }
                if ($(".autoComplete")) {
                    $(".autoComplete").css('left',$('#masthead-search').position().left);
                    $(".autoComplete").css('width',$('#masthead-search div').width());
                }
            }
        });
    }
    var current = $('.completeQuery.selected');
    
    if (e.which == 40) {
        if ($('.completeQuery.selected').length == 0) {
            $('.completeQuery').eq(0).addClass('selected');
            document.getElementById('masthead-search-term').value = $('.completeQuery.selected').html().replace("<b>","").replace("</b>","");
        }
        else {
            var index = $('.completeQuery.selected').index();
            if ($('.completeQuery.selected').next().html() == '<?= $LANGS['close'] ?>') {
                index = 0;
            }
            $('.completeQuery').removeClass('selected');
            $('.completeQuery').eq(index+1).addClass('selected');
            document.getElementById('masthead-search-term').value = $('.completeQuery.selected').html().replace("<b>","").replace("</b>","");
        }
        e.preventDefault();
    }
    if (e.which == 38) {
        if ($('.completeQuery.selected').length == 0) {
            $('.completeQuery').eq(0).addClass('selected');
            document.getElementById('masthead-search-term').value = $('.completeQuery.selected').html().replace("<b>","").replace("</b>","");
        }
        else {
            var index = $('.completeQuery.selected').index();
            $('.completeQuery').removeClass('selected');
            $('.completeQuery').eq(index-1).addClass('selected');
            document.getElementById('masthead-search-term').value = $('.completeQuery.selected').html().replace("<b>","").replace("</b>","");
        }
        e.preventDefault();
    }
    }
} 
function openMenu(e) {
    if (document.getElementsByClassName('yt-uix-button-menu')[0].style.display != "block") {
        if (e != undefined) {
            document.getElementsByClassName('yt-uix-button-menu')[0].style.display = "block";
            document.getElementsByClassName('flip')[0].classList.add("yt-uix-button-active");
            document.getElementsByClassName('yt-uix-button-menu')[0].style.right = ((window.innerWidth - 960) / 2) + document.getElementsByClassName('end')[0].offsetWidth - 1 + "px";
        }
    }
    else {
        document.getElementsByClassName('yt-uix-button-menu')[0].style.display = "none";
        document.getElementsByClassName('flip')[0].classList.remove("yt-uix-button-active");
    }
}
document.addEventListener("click", function (e) {
  if (!e.target.classList.contains("yt-uix-button-menu-item") && !e.target.classList.contains("yt-uix-button-content") && !e.target.classList.contains("flip") && document.getElementsByClassName('yt-uix-button-menu')[0].style.display == "block") {
    openMenu();
  }
});
function clickSearch(query) {
    document.getElementById('masthead-search-term').value = query;
    $('#masthead-search #search-btn').click();
}
function dropdown(e) {
    e.focus();
    if (e.querySelector('.yt-uix-button-menu-text').classList.contains("hid") && document.activeElement == e) {
        e.querySelector('.yt-uix-button-menu-text').classList.remove("hid");
        e.classList.add('yt-uix-button-active');
        var rect = e.getBoundingClientRect();
        var width = (document.body.clientWidth - 960) / 2;
        var height = document.getElementById('masthead-container').offsetHeight;
        e.querySelector('.yt-uix-button-menu-text').style.left = rect.left - width + 5 + "px";
        if (!document.getElementById("default-language-box")) {
            e.querySelector('.yt-uix-button-menu-text').style.top = rect.top - height + 14 + "px";
        }
        else {
            var eh = document.getElementById('default-language-box').offsetHeight;
            e.querySelector('.yt-uix-button-menu-text').style.top = rect.top - height - eh - 6 + "px";
        }
    }
    else {
        e.classList.remove('yt-uix-button-active');
        e.querySelector('.yt-uix-button-menu-text').classList.add("hid");
    }
}
</script>
<script type="text/javascript" src="/js/konami.js?30"></script>
<?php if (isset($_GET["mail"])) : // EASTER EGG?>
    <style>
        body {
            background-image: url(/img/mail.gif);
            content: 'mail' !important;
        }
        #masthead .nav-item .content {
            content: 'mail' !important;
        }
    </style>
<?php elseif (isset($_GET["wtfmode"])) : // ANOTHER EASTER EGG?>
<style>
    body {
    -webkit-transform: rotateX( 180deg );
    -moz-transform: rotateX( 180deg );
    -o-transform: rotateX( 180deg );
    transform: rotateX( 180deg );
    }
</style>
<?php endif ?>
<style>
    .completeQuery {
        white-space: nowrap;
        overflow: hidden;
        font-size: 13px;
        padding-left: 3px;
        cursor: default;
        height: 17px;
        line-height: 17px;
    }
    .completeQuery.hover {
        background-color: #36c;
        color: white;
    }
    .completeQuery.selected {
        background-color: #36c;
        color: white;
    }
</style>
<div id="page">
                <div id="masthead-container">
            <div id="masthead" class="">
                        <a href="/" title="BitView home">   
            <?php $CheckLogo = $DB->execute("SELECT int_value FROM config WHERE name = 'logo'",true,[],false)["int_value"] ?? 0; ?>
            <img id="logo" class="master-sprite" src="/img/pixel.gif" <?php if ($CheckLogo == 0) : ?>
                alt="BitView home"
            <?php elseif($CheckLogo == 1) : ?>
                style="background-image: url(/img/bitview_halloween.gif?20);" alt="BitView - Happy Halloween"
            <?php elseif($CheckLogo == 2) : ?>
                style="background-image: url(/img/bv09xmas.png);" alt="BitView - Happy Holidays"
            <?php elseif($CheckLogo == 3) : ?>
                style="background-image: url(/img/bitview_3rdbirthday.gif);" alt="Happy Birthday, BitView!"
            <?php elseif($CheckLogo == 4) : ?>
                style="background-image: url(/img/bitview_eggs.gif?20);" alt="BitView - Happy Easter!"
            <?php elseif($CheckLogo == 5) : ?>
                style="background-image: url(/img/bv09pride.png);" alt="BitView - Happy Pride Month!"
            <?php elseif($CheckLogo == 6) : ?>
                style="background-image: url(/img/bv09summer.png);" alt="BitView - Happy Holidays!"
            <?php endif ?>>
        </a>
    <div id="masthead-utility" class="<?php if ($_USER->Logged_In) : ?>connected<?php endif ?>">
        <a href="/browse" <?php if ($_PAGE["Page_Type"] == "browse"): ?>class="selected"<?php endif ?>><?= $LANGS['browse'] ?></a><a href="/my_videos_upload" class="split<?php if ($_PAGE["Page_Type"] == "upload"): ?> selected<?php endif ?>"><?= $LANGS['upload'] ?></a>
        <?php if (!$_USER->Logged_In) : ?>
        <a class="start" href="/signup"><?= $LANGS['signup'] ?></a><a class="end" href="/login"><?= $LANGS['login'] ?></a>
        <?php else: ?>
            <button type="button" class="flip yt-uix-button yt-uix-button-text" onclick="openMenu(this);return false;"><span class="yt-uix-button-content"><?= displayname($_USER->Username) ?></span>                 <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt=""></button><?php if ($_USER->Is_Admin || $_USER->Is_Moderator) : ?><a href="/admin_panel">Admin Panel</a><?php endif ?><a class="end" href="/logout"><?= $LANGS['logout'] ?></a>
        <?php endif ?>
    </div>
    <form autocomplete="off" class="search-form" action="/results" method="get" name="searchForm" class="search-form" id="masthead-search" onsubmit="if (document.getElementById('masthead-search-term').value != '') { document['searchForm'].submit(); }; return false;;return false;">
        <button type="button" class="search-button yt-uix-button" id="search-btn" onclick="if (document.getElementById('masthead-search-term').value != '') { document['searchForm'].submit(); }; return false;;return false;" tabindex="2"><span class="yt-uix-button-content"><?= $LANGS['search'] ?></span></button>
        <div>
            <input id="masthead-search-term" class="search-term" name="search" type="text" tabindex="1" onkeyup="" value="<?php if (isset($_GET["search"]) && basename((string) $_SERVER["SCRIPT_FILENAME"]) != "my_videos.php" && basename((string) $_SERVER["SCRIPT_FILENAME"]) != "admin_panel.php") : ?><?= $_GET["search"] ?><?php endif ?>" maxlength="128" autocomplete="off">
        </div>
        <select name="t" style="display: none;">
            <option value="Search All"<?php if (isset($_GET["t"]) && $_GET["t"] == "Search All") : ?> selected<?php endif ?>>All</option>
            <option value="Search Videos"<?php if (isset($_GET["t"]) && $_GET["t"] == "Search Videos") : ?> selected<?php endif ?>>Videos</option>
            <option value="Search Users"<?php if (isset($_GET["t"]) && $_GET["t"] == "Search Users") : ?> selected<?php endif ?>>Members</option>
            <option value="Search Playlists"<?php if (isset($_GET["t"]) && $_GET["t"] == "Search Playlists") : ?> selected<?php endif ?>>Playlists</option>
        </select>
    </form>
            </div>
        </div>
        </div>
        <?php if ($_USER->Logged_In) : ?>
            <?php $Messages_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND seen = 0", true, [":USERNAME" => $_USER->Username])["amount"] ?>
        <div style="display:none;" onclick="" class="yt-uix-button-menu yt-uix-button-menu-text">    <table>
                <tbody><tr>
                    <td><a class="yt-uix-button-menu-item" href="/user/<?= $_USER->Username ?>"><?= $LANGS['mychannel'] ?></a></td>
                    <td><a class="yt-uix-button-menu-item" href="/my_subscriptions"><?= $LANGS['subscriptions'] ?></a></td>
                </tr>
                <tr>
                    <td><a class="yt-uix-button-menu-item" href="/inbox"><?= $LANGS['inbox'] ?><?php if($Messages_Amount>0) : ?> (<?= $Messages_Amount ?>)<?php endif ?></a></td>
                    <td><a class="yt-uix-button-menu-item" href="/my_videos"><?= $LANGS['myvideos'] ?></a></td>
                </tr>
                <tr>
                    <td><a class="yt-uix-button-menu-item" href="/my_account"><?= $LANGS['account'] ?></a></td>
                    <td><a class="yt-uix-button-menu-item" href="/my_favorites"><?= $LANGS['favorites'] ?></a></td>
                </tr>
            </tbody></table>
        </div>
        <?php endif ?>
<?php if (isset($_SESSION["notification_msg"])) { require_once "error_message.php"; } // else { echo '<div class="confirmBox" style="background-color: #cfeeb2 !important">BitView will be undergoing scheduled maintenance, starting 7:00 pm PDT.</div>'; } ?>
