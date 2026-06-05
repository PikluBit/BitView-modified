<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
<div class="wrapper">
    <div style="float:left;width:27%;margin-right:1%">
        <div class="a_box" style="margin-bottom:55px">
            <div class="a_box_title">Pages</div>
            <form action="/admin_panel/?page=config" method="post" style="padding: 6px;">
                <div style="margin-bottom:4px"><label><input type="checkbox" name="signup"<?php if ($_CONFIG->Config["signup"]) : ?> checked<?php endif ?>> <span style="position:relative;bottom:2px">Sign Up</span></label></div>
                <div style="margin-bottom:4px"><label><input type="checkbox" name="signin"<?php if ($_CONFIG->Config["login"]) : ?> checked<?php endif ?>> <span style="position:relative;bottom:2px">Log In</span></label></div>
                <div style="margin-bottom:4px"><label><input type="checkbox" name="upload"<?php if ($_CONFIG->Config["upload"]) : ?> checked<?php endif ?>> <span style="position:relative;bottom:2px">Upload</span></label></div>
                <div style="margin-bottom:4px"><label><input type="checkbox" name="profiles"<?php if ($_CONFIG->Config["profiles"]) : ?> checked<?php endif ?>> <span style="position:relative;bottom:2px">Profiles</span></label></div>
                <div style="margin-bottom:4px"><label><input type="checkbox" name="videos"<?php if ($_CONFIG->Config["videos"]) : ?> checked<?php endif ?>> <span style="position:relative;bottom:2px">Videos</span></label></div>
                <div style="margin-bottom:4px"><label><input type="checkbox" name="ffmpeg_conversion"<?php if (isset($_CONFIG->Config["ffmpeg_conversion"]) ? $_CONFIG->Config["ffmpeg_conversion"] : true) : ?> checked<?php endif ?>> <span style="position:relative;bottom:2px">FFmpeg Video Conversion</span></label></div>
                <div style="margin-bottom:4px"><label><input type="checkbox" name="custom_thumbnails"<?php if (isset($_CONFIG->Config["custom_thumbnails"]) ? $_CONFIG->Config["custom_thumbnails"] : false) : ?> checked<?php endif ?>> <span style="position:relative;bottom:2px">Allow Custom Thumbnails (all users)</span></label></div>
                <div style="margin-top:7px"><input type="submit" name="save_pages" value="Save" class="yt-button" style="font-size:12px;padding:0.3888em 0.8333em"></div>
            </form>
        </div>
    </div>
    <div style="float:left;width:48%;">
        <div class="a_box" style="margin-bottom:38px">
            <div class="a_box_title">Layout Settings</div>
            <script>
                function changeLogo(e) {
                var logo = document.getElementById("bvlogo");
                    if (e.id == "normal") {
                        logo.src = "/img/bv09logo.png";
                    }
                    if (e.id == "halloween") {
                        logo.src = "/img/bitview_halloween.gif";
                    }
                    if (e.id == "christmas") {
                        logo.src = "/img/bv09xmas.png";
                    }
                    if (e.id == "birthday") {
                        logo.src = "/img/bv6.png";
                    }
                    if (e.id == "easter") {
                        logo.src = "/img/bitview_eggs.gif";
                    }
                    if (e.id == "pride") {
                        logo.src = "/img/bv09pride.png";
                    }
                    if (e.id == "summer") {
                        logo.src = "/img/bv09summer.png";
                    }
                }
            </script>
            <form action="/admin_panel/?page=config" method="post" style="padding: 6px">
                <div style="font-size:13px;font-weight:bold;margin-bottom:4px">Slogan:</div>
                <input type="text" name="slogan" maxlength="512" style="width:438px" value="<?= $DB->execute("SELECT value FROM config WHERE name = 'slogan_top'", true)["value"] ?? 'Express Yourself'; ?>">
                <div style="font-size:13px;font-weight:bold;margin-top:14px;margin-bottom:4px">Notice Box:</div>
                <textarea style="width:98.5%; font-family: arial, sans-serif" name="box_text" maxlength="512" rows="5"><?= $DB->execute("SELECT value FROM config WHERE name = 'box_text'", true)["value"] ?? 'Look here for important notices from BitView!'; ?></textarea>
                <div style="font-size:13px;font-weight:bold;margin-top:14px;margin-bottom:4px">Logo:</div>
                <div style="float:right"><?php $CheckLogo = $DB->execute("SELECT int_value FROM config WHERE name = 'logo'",true)["int_value"] ?? 0; ?>
            <?php if ($CheckLogo == 0) : ?>
                <a href="/" class="logo"><img id="bvlogo" src="/img/bv09logo.png" alt="BitView - Your Digital Video Repository" width="84" height="33" border="0"></a>
            <?php elseif($CheckLogo == 1) : ?>
                <a href="/" class="logo"><img id="bvlogo" src="/img/bitview_halloween.gif?10" alt="BitView - Happy Halloween" width="120" height="53" border="0"></a>
            <?php elseif($CheckLogo == 2) : ?>
                <a href="/" class="logo"><img id="bvlogo" src="/img/bv09xmas.png" alt="BitView - Happy Holidays" width="120" height="57"  border="0"></a>
            <?php elseif($CheckLogo == 3) : ?>
                <a href="/" class="logo"><img id="bvlogo" src="/img/bv6.png" alt="Happy Birthday, BitView!" width="132" height="63"  border="0"></a>
            <?php elseif($CheckLogo == 4) : ?>
                <a href="/" class="logo"><img id="bvlogo" src="/img/bitview_eggs.gif?20" alt="BitView - Happy Easter!" width="120" height="48"  border="0"></a>
            <?php elseif($CheckLogo == 5) : ?>
                <a href="/" class="logo"><img id="bvlogo" src="/img/bv09pride.png" alt="BitView - Happy Pride Month!" width="120" height="48"  border="0"></a>
            <?php elseif($CheckLogo == 6) : ?>
                <a href="/" class="logo"><img id="bvlogo" src="/img/bv09summer.png" alt="BitView - Happy Holidays!" width="120" height="48"  border="0"></a>
            <?php endif ?></div>
                <input type="radio" id="normal" onclick="changeLogo(this)" name="logo" value="0" <?php if($CheckLogo == 0) : ?>checked<?php endif ?>>
                <label for="normal">Normal</label><br>
                <input type="radio" id="halloween" onclick="changeLogo(this)" name="logo" value="1" <?php if($CheckLogo == 1) : ?>checked<?php endif ?>>
                <label for="halloween">Halloween</label><br>
                <input type="radio" id="christmas" onclick="changeLogo(this)" name="logo" value="2" <?php if($CheckLogo == 2) : ?>checked<?php endif ?>>
                <label for="christmas">Christmas</label><br>
                <input type="radio" id="birthday" onclick="changeLogo(this)" name="logo" value="3" <?php if($CheckLogo == 3) : ?>checked<?php endif ?>>
                <label for="birthday">Birthday</label><br>
                <input type="radio" id="easter" onclick="changeLogo(this)" name="logo" value="4" <?php if($CheckLogo == 4) : ?>checked<?php endif ?>>
                <label for="easter">Easter</label><br>
                <input type="radio" id="pride" onclick="changeLogo(this)" name="logo" value="5" <?php if($CheckLogo == 5) : ?>checked<?php endif ?>>
                <label for="pride">Pride</label><br>
                <input type="radio" id="summer" onclick="changeLogo(this)" name="logo" value="6" <?php if($CheckLogo == 6) : ?>checked<?php endif ?>>
                <label for="summer">Summer</label><br>
                <div style="margin-top:10px">
                    <input type="submit" value="Save" class="yt-button" style="font-size:12px;padding:0.3888em 0.8333em" name="save_text">
                </div>
            </form>
        </div>
    </div>
    <div style="clear:both"></div>
</div>