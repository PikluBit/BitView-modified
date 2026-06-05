<?php
if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $bvlink = "https";
} else {
    $bvlink = "http";
}
if (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "watch.php" || basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_videos_annotations.php") {
    $AutoPlay = "true";
    $Expand = 1;
} 
elseif (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "profile.php") {
    $_PROFILE = new User($_GET['user'],$this->DB);
    $_PROFILE->get_info();
    if ($_PROFILE->Info['c_autoplay'] == 1) {
        $AutoPlay = "true";
    }
    else {
        $AutoPlay = "false";
    }
    $Expand = 0;
}
else {
    $AutoPlay = "false";
    $Expand = 0;
}

if ($this->Info["status"] == 2) {
    $Add_Height = 58;
} else {
    $Add_Height = 10;
}
?>
<!--<div style="width:<?= $Width ?>px;height:<?= $Height ?>px" class="videocontainer" id="video_height" oncontextmenu="return false;">-->
    <?php if ($this->Info["status"] == 2) : ?>
        <script type="text/javascript">function v_play(){player.ended||player.paused?(player.play(),document.getElementById("left").style.backgroundImage="url('/img/ply0.png')"):(player.pause(),document.getElementById("left").style.backgroundImage="url('/img/ply1.png')")}function v_mute(){player.muted?(document.getElementById("right").style.backgroundImage="url('/img/vol1.png')",player.muted=!1):(document.getElementById("right").style.backgroundImage="url('/img/vol0.png')",player.muted=!0)}</script>
    <?php endif ?>
    <?php if ($this->Info["status"] == 2) : ?>
                <script src="/player/main19.js?33"></script>
                <script src="/player/jquery.js?23"></script>
                <script id="heightAdjust">
                        if (!window.videoInfo)
                            var videoInfo = {};

                        function adjustHeight(n) {
                            var height;
                            var par = $("#heightAdjust").parent();
                            if (par[0].style.height) {
                                height = par.height();
                                par.height(height + n);
                            }
                        }

                        // Easier way of setting cookies
                        function setCookie(name, value) {
                            var CookieDate = new Date;
                            CookieDate.setFullYear(CookieDate.getFullYear() + 10);
                            document.cookie = name + '=' + value + '; expires=' + CookieDate.toGMTString() + '; path=/';
                        }

                        // Easier way of getting cookies
                        function getCookie(cname) {
                            var name = cname + "=";
                            var decodedCookie = decodeURIComponent(document.cookie);
                            var ca = decodedCookie.split(';');
                            for (var i = 0; i < ca.length; i++) {
                                var c = ca[i];
                                while (c.charAt(0) == ' ') {
                                    c = c.substring(1);
                                }
                                if (c.indexOf(name) == 0) {
                                    return c.substring(name.length, c.length);
                                }
                            }
                            return "";
                        }

                        function getTimeHash() {
                            var h = 0;
                            var st = 0;

                            if ((h = window.location.href.indexOf("#t=")) >= 0) {
                                st = window.location.href.substr(h + 3);
                                return parseInt(st);
                            }

                            return 0;
                        }

                        <?php if (isset($_GET['bt']) && isset($_GET['bg'])): ?>var vlpColors = "<?= $_GET['bt'] ?>,<?= $_GET['bg'] ?>";<?php elseif (isset($_COOKIE['dark'])) : ?>var vlpColors = "teal,black";<?php else : ?>var vlpColors = "teal,white";<?php endif ?>
                        vlpColors = vlpColors.split(",");

                        var viValues = {
                            variable: "vlp",
                            src: "/videos/<?= $this->Info["file_url"] ?>.mp4",
                            hdsrc: "/videos/<?= $this->Info["file_url"] ?>.720.mp4",
                            img: <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$this->Info["url"].'_m.jpg')): ?>"/u/thmp/<?= $this->Info["url"] ?>_m.jpg"<?php elseif (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$this->Info["url"].'.jpg')): ?>"/u/thmp/<?= $this->Info["url"] ?>.jpg"<?php else: ?>"/img/nothump.png"<?php endif ?>,
                            url: "<?= $this->Info["url"] ?>",
                            duration: <?=($this->Info["length"] > 0 ? $this->Info["length"] : 1)?>,
                            autoplay: <?=$AutoPlay?>,
                            skin: "2010",
                            btcolor: vlpColors[0],
                            bgcolor: vlpColors[1],
                            adjust: true,
                            start: getTimeHash()
                        };

                        for (var i in viValues) {
                            if (videoInfo[i] === void (0)) {
                                videoInfo[i] = viValues[i];
                            }
                        }
                        </script>
                        <!-- BitView HTML5/Flash Player - vistafan12 was here -->
                        <div class="vlPlayer">
                            <script>
                            var video_url = '<?= $this->Info["url"] ?>';
                            var annotations = <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/ann/'.$this->Info["url"].'.xml')): ?>true<?php else: ?>false<?php endif?>;
                            /* Languages for tooltips */
                            var fullscreen_text = "<?= $LANGS['fullscreen'] ?>";
                            var expand_text = "<?= $LANGS['expand'] ?>";
                            var shrink_text = "<?= $LANGS['shrink'] ?>";
                            var popout_text = "<?= $LANGS['popout'] ?>";
                            var mute_text = "<?= $LANGS['mute'] ?>";
                            var unmute_text = "<?= $LANGS['unmute'] ?>";
                            window[videoInfo.variable] = new VLPlayer({
                                id: videoInfo.id,
                                src: videoInfo.src,
                                hdsrc: <?php if ($this->Info['hd'] == 1) :?>videoInfo.hdsrc<?php else : ?>null<?php endif?>,
                                preview: videoInfo.img,
                                videoUrl: "/watch.php?v=" + videoInfo.url,
                                duration: videoInfo.duration,
                                autoplay: videoInfo.autoplay,
                                skin: "/player/skins/" + videoInfo.skin,
                                adjust: videoInfo.adjust,
                                btcolor: videoInfo.btcolor,
                                bgcolor: videoInfo.bgcolor,
                                start: videoInfo.start,
                                expand: <?= $Expand ?>,
                                annotations: <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/ann/'.$this->Info["url"].'.xml')): ?>true<?php else: ?>false<?php endif?>,
                                complete: videoInfo.complete,
                                ended: videoInfo.ended
                            });

                            $(window).on('hashchange', function() {
                                var t = getTimeHash();
                                vlp.play();
                                vlp.seek(t);
                                $(window).scrollTop(0);
                            });
                            </script>
                            <script src="/player/annotations.js?22"></script>
                        </div>
                    <Br>
               
       <!-- </div>-->
    <?php else : ?>
        <div id="watch-player-unavailable">
          <div id="watch-player-unavailable-message">
            <div id="watch-player-unavailable-icon-container">
              <img src="/img/converting.png">
            </div>
            <div id="watch-player-unavailable-message-container">
                <div><?= $LANGS['videoprocessing'] ?></div>
                  <div class="watch-unavailable-submessage"><?= $LANGS['checkinafewminutes'] ?></div>
            </div>
          </div>
        </div>
    <?php endif ?>

<script>
function test() {
    window.open("/embed.php?v=<?= $this->Info["url"] ?>&wt=0", "_blank", "toolbar=yes,scrollbars=no,resizable=yes,top=255,left=255,width=640,height=480");
}
</script>
