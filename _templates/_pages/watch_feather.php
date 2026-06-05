<?php use function PHP81_BC\strftime; ?>
<script type="text/javascript" src="./js/watch.js"></script>
<style>
    .watch-player-div {
        margin: 0 auto;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-user-drag: none;
        outline: 0;
    }
    .vlPlayer2009:focus {
        outline: none;
    }
    #watch-this-vid-info {
        width: 640px;
        float: left;
    }
    #watch-channel-subscribe {
        float: right;
        width: 116px;
    }
    .vimg90 {
        width: 90px;
        height: 70px;
        border: 1px solid #999;
        border-left: 0;
    }
    .user-thumb-medium {
    border: 0;
    }
</style>
<script>
    <?php if (!$_USER->Logged_In) : ?>
    var isLoggedIn = false;
    <?php else: ?>
    var isLoggedIn = true;
    <?php endif ?>
    function show_ratingnli() {
        var ratingmessage = document.getElementById("defaultRatingMessage");
        var hoverMessage = document.getElementById("hoverMessage");
        ratingmessage.style.display = "none";
        hoverMessage.style.display = "block";
    }
    function hide_ratingnli() {
        var ratingmessage = document.getElementById("defaultRatingMessage");
        var hoverMessage = document.getElementById("hoverMessage");
        ratingmessage.style.display = "block";
        hoverMessage.style.display = "none";
    }
    function favorite_video() {
    var url = "/a/favorite_video?v=<?= $_VIDEO->URL ?>";
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                <?php if ($_USER->Logged_In and !$_USER->has_favorited($_VIDEO)) : ?>
                    alert('Video added to favorites');
                <?php elseif ($_USER->Logged_In and $_USER->has_favorited($_VIDEO)) : ?>
                    alert('Video removed from favorites');
            <?php endif ?>
            } else {
                showErrorMessage();
            }
        };
        xhr.onerror = function() {
            showErrorMessage();
        };
        xhr.send();
    }

    function flag_video() {
    var url = "/a/flag_video?v=<?= $_VIDEO->URL ?>";
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                    <?php if (!$Flagged) : ?>
                    alert('Flag added');
                    <?php else : ?>
                    alert('Flag removed');
                    <?php endif ?>
            } else {
                showErrorMessage();
            }
        };
        xhr.onerror = function() {
            showErrorMessage();
        };
        xhr.send();
    }

    function delete_comment(id) {
        var url = "/a/delete_video_comment?id="+id;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                document.getElementById("cid_"+id).outerHTML = "";
            } else {
                showErrorMessage();
            }
        };

        xhr.onerror = function() {
            showErrorMessage();
        };
        xhr.send();
    }
    function rate_video(rating) {
        var url = "/a/rate_video?stars=" + rating + "&v=<?= $_VIDEO->URL ?>";
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                // Sukces
                showSuccessMessage();
            } else {
                // Błąd
                showErrorMessage();
            }
        };
        xhr.onerror = function() {
            // Błąd sieciowy
            showErrorMessage();
        };
        xhr.send();
    }

    function subscribe() {
        var url = "/a/subscription_center?user=<?= $_OWNER->Username ?>";
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                changeSubscribeDiv();
            } else {
                // Błąd
                showErrorMessage();
            }
        };

        xhr.onerror = function() {
            // Błąd sieciowy
            showErrorMessage();
        };

        xhr.send();
    }

    function changeSubscribeDiv() {
    x = document.getElementById('subscribeDiv');
    xs = document.getElementById('subscribe-button');
    y = document.getElementById('unsubscribeDiv');
    ys = document.getElementById('unsubscribe-button');
    if (document.getElementById('subscribeDiv') && document.getElementById('subscribe-button')) {
        x.id = "unsubscribeDiv";
        xs.classList.add("unsubscribe");
        xs.id = "unsubscribe-button";
        xs.innerHTML = "<?= $LANGS['unsubscribe'] ?>"
    } else if (document.getElementById('unsubscribeDiv') && document.getElementById('unsubscribe-button')) {
        y.id = "subscribeDiv";
        ys.classList.remove("unsubscribe");
        ys.id = "subscribe-button";
        ys.innerHTML = "<?= $LANGS['subscribe'] ?>"
    }
    }

    function showSuccessMessage() {
	document.getElementById('ratings_text').innerHTML = "<?= $LANGS['thanksforrating'] ?>";
    }

    function showErrorMessage() {
        alert("Error, please try again.");
    }
</script>

<script>
    function vidres_change(num) {
        if (num != 0 && num != 5 && document.getElementById("vidressl"+num)) {
            document.getElementById("vidressl1").style.display = "none";
            if (document.getElementById("vidressl2")) {
                document.getElementById("vidressl2").style.display = "none";
            }

            if (document.getElementById("vidressl3")) {
                document.getElementById("vidressl3").style.display = "none";
            }
            if (document.getElementById("vidressl4")) {
                document.getElementById("vidressl4").style.display = "none";
            }

            document.getElementById("vidresarr").setAttribute("onClick","vidres_change("+(num - 1)+")");
            document.getElementById("vidresarr2").setAttribute("onClick","vidres_change("+(num + 1)+")");
            document.getElementById("vidressl"+num).style.display = "block";
        }
    }
</script>
<div id="watch-vid-title">
    <span><?= $_VIDEO->Info["title"] ?></span>
    <span id="watch-view-count" style="float:right;font-weight: normal;">
                    <b>
                    <?php if($_VIDEO->Info["url"] == "0MRdwLZ7fiM") : // easter egg?>
                        301
                    <?php else : ?>
                        <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info["views"]) ?><?php else: ?><?= ($_VIDEO->Info["views"]) ?><?php endif ?>
                    <?php endif ?>
                </b>
                    <?= $LANGS['videoviews'] ?>
                    </span>
</div>
<!-- Left side of the watch page where the video player is !-->
<div id="watch-this-vid">
    <div id="watch-player-div" <?php if (!isset($_COOKIE["html5_player"])) : ?>style="width: 640px; height: 360px;"<?php else : ?>style="width: 640px; height: 385px;"<?php endif ?>>
        <!-- Video Player !-->
        <?php if (!isset($_COOKIE["html5_player"])) : ?>
            <?php $_VIDEO->show_video(640, 360, true, $LANGS) ?>
        <?php else : ?>
                        <?if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protocol = 'https://';
}
else {
  $protocol = 'http://';
}?>
            <object width="640" height="385" class="fl flash-video"><param name="movie" value="/player.swf?video_id=<?= $_VIDEO->Info['file_url'] ?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" class="fl"></object>
        <?php endif ?>
    </div>
</div>

<div id="watch-other-vids">
    <div id="watch-channel-brand-div">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Vlare_Main -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-8433080377364721"
             data-ad-slot="6350738097"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <div class="alignC xsmallText grayText padT3">Advertisement</div>
    </div>
    <div id="watch-channel-vids-div" class="watch-wrapper">
        <div id="watch-channel-vids-top">
            <div id="watch-channel-icon" class="user-thumb-medium">
                <a href="/user/<?= $_VIDEO->Info["uploaded_by"] ?>" onmousedown=""><img src="<?= avatar($_VIDEO->Info["uploaded_by"]) ?>" <?php if ($_OWNER->Info["is_avatar_video"] == 1) : ?>class="avatarvideo"<?php endif ?> alt="Channel Icon"></a>
            </div>
            <div id="watch-channel-stats">
                <a href="/user/<?= $_VIDEO->Info["uploaded_by"] ?>"><?= displayname($_VIDEO->Info["uploaded_by"]) ?></a>
            </div>
            <div id="watch-channel-subscribe">
                <?php if(!$Subscribed) : ?>
                    <div id="subscribeDiv" class="watch-channel-subscribe">
                        <a <?php if ($_USER->Logged_In && $_USER->Username != $_OWNER->Username) : ?>href="javascript:void(0)" onclick="subscribe()"<?php elseif (!$_USER->Logged_In) : ?>href="javascript:void(0)" onclick="showloginbox()"<?php else : ?>href="javascript:void(0)" onclick="alert('<?= $LANGS['subyourself'] ?>')"<?php endif ?> class="action-button" title="subscribe to <?= $_OWNER->Username ?>'s videos">
                            <span class="action-button-text" id="subscribe-button"><?= $LANGS['subscribe'] ?></span>
                        </a>
                    </div>
                <?php else : ?>
                    <div id="unsubscribeDiv" class="watch-channel-subscribe">
                        <a href="javascript:void(0)" onclick="subscribe()" class="action-button">
                            <span class="action-button-text unsubscribe" id="unsubscribe-button"><?= $LANGS['unsubscribe'] ?></span>
                        </a>
                    </div>
                <?php endif ?>
            </div>
            <div class="clear"></div>
        </div>
        <?php if (!$_USER->Logged_In) : ?>
            <div id="subscribeLoginInvite" style="border: 1px solid rgb(153, 153, 153); padding: 5px; background-color: rgb(255, 255, 255); margin: 8px 5px 0px; display: none;" class="">
                <div style="border: 1px solid rgb(204, 204, 204); padding: 4px; background: #eee; text-align: center;">
                    <strong><?= $LANGS['logintosubbox'] ?></strong><br>

                    <?= $LANGS['signinnow'] ?>

                </div>
            </div>
        <?php endif ?>
        <div id="watch-video-details" class="expand-panel">
            <div id="watch-video-details-inner">
                <div class="watch-video-added"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['videotimeformat'], time_machine(strtotime((string) $_VIDEO->Info["uploaded_on"]))); }
                    else {echo strftime($LANGS['videotimeformat'], strtotime((string) $_VIDEO->Info["uploaded_on"])); }  ?></div><br>
                <div class="expand-content" id="expand-content-desc">
                <div class="watch-video-desc">
				<span style="word-wrap: break-word !important;"><?php if (!empty($_VIDEO->Info["description"])) : ?>
                        <?= make_user_clickable(make_links_clickable(nl2br((string) $_VIDEO->Info["description"]))) ?>
                    <?php else : ?>
                        <i><?= $LANGS['nodesc'] ?></i>
                    <?php endif ?></span>
                    </div>
                </div>

                <div id="watch-embed-div">
                    <div id="watch-url-div">
                            <label for="watch-url-field">URL:</label>
                            <input name="video_link" id="watch-url-field" type="text" value="http://www.bitview.net/watch?v=<?= $_VIDEO->Info["url"] ?>">
                    </div>
                    <form action="" name="embedForm" id="embedForm">
                        <label for="embed_code"><?= $LANGS['embed'] ?>:</label>
                        <input id="embed_code" name="embed_code" type="text" value='<iframe id="embedplayer" src="http://www.bitview.net/embed?v=<?= $_VIDEO->Info["url"] ?>" width="448" height="382" allowfullscreen scrolling="off" frameborder="0"></iframe>'>
                    </form>
                </div>
            </div>
            <div id="watch-attributions-div">
            </div>
        </div>
    </div>
    <div class="watch-wrapper">
    </div>
        <div id="watch-related-videos-panel" class="watch-wrapper expand-panel expanded">
            <h2 style="margin: 12px 0;"><?= $LANGS['relatedvideos'] ?></h2>
            <div class="watch-body expand-content" id="watch_related" style="display: block;">
                <div id="watch-related-vids-body" class="watch-discoverbox-list-view">
                    <div class="watch-discoverbox" style="height:auto" onscroll="performDelayLoad('related')">
                        <?php if($Related_Videos) : ?>
                            <?php $Count = 0 ?>
                            <?php foreach ($Related_Videos as $Video) : ?>
                                <?php $Count++ ?>
                                <div class="watch-discoverbox-entry" <?php if ($Count % 2) :?>style="background: #eee;"<?php else :?>style="background: #e0e0e0;"<?php endif ?>>
                                    <div class="watch-discoverbox-thumb">
                                        <div class="v90WrapperOuter"><div class="v90WrapperInner"><a href="<?= $Video["link"] ?><?php if (isset($_GET["pl"])) : ?>&pl=<?= $Playlist["id"] ?><?php endif ?>" rel="nofollow"><img title="<?= $Video["title"] ?>" src="<?= $Video["thumb"] ?>" class="vimg90" alt="title"></a><div class="video-time"><span id="video-run-time"><?= timestamp($Video["length"]) ?></span></div></div></div>
                                    </div>
                                    <div class="watch-discoverbox-facets">
                                        <div class="vtitle"><a class="hLink" href="<?= $Video["link"] ?><?php if (isset($_GET["pl"])) : ?>&pl=<?= $Playlist["id"] ?><?php endif ?>"><?= $Video["title"] ?></a></div>
                                        <div style="font-size:11px">
                                            <div class="viewCount"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></div>
                                            <a href="profile?user=<?= $Video["uploaded_by"] ?>" class="hLink"><?= displayname($Video["uploaded_by"]) ?></a></span>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php else : ?>
                            <div class="alignC padT5 padB10">
                                <span><?= $LANGS['novideosfound'] ?></span>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="clearL"></div>
        </div>
</div> <!-- TU SIĘ KOŃCZY KURWA !-->
<div id="watch-this-vid-info">
    <div id="watch-ratings-views">
        <!-- nwm jak zrobić ocenianie ja to pieprze !-->
        <div id="watch-rating-div">
            <div id="ratingWrapper">
			<span id="rateStars">
		<?php if (!$_USER->Logged_In or $_VIDEO->Info['e_ratings'] == 0) : ?>
            <span id="ratingMessage"><div id="defaultRatingMessage" style="display: block;" class="wasblock"><span id="ratings_text" class="smallText"><?= $LANGS['ratingsdisabled'] ?> (disable Feather mode to rate or login)</span></span>
        <?php endif ?>
							</span>
                <?php if (!$_USER->Logged_In) : ?>
                    <span id="ratingMessage"><div id="defaultRatingMessage" style="display: block;" class="wasblock"><span id="ratings_text" class="smallText"><?= $LANGS['ratingsdisabled'] ?>  (disable Feather mode to rate or login) </span></span>
                <?php elseif ($_VIDEO->Info['e_ratings'] == 0) : ?>
                    <span id="ratingMessage"><div id="defaultRatingMessage" style="display: block;" class="wasblock"><span id="ratings_text" class="smallText"><?= $LANGS['ratingsdisabled'] ?> (disable Feather mode to rate or login)</span></span>
                <?php elseif ($_VIDEO->Info['e_ratings'] == 1) : ?>
                    <span id="ratingMessage"><div id="defaultRatingMessage" style="display: block;" class="wasblock"><span id="ratings_text" class="smallText"><?= $LANGS['ratingsdisabled'] ?> (disable Feather mode to rate or login)</span></span>
                <?php endif ?>
            </div>
            <!-- do glosowania !-->
        </div>
    </div>
    <div id="watch-views-div">
        <div class="floatR">
			<span id="watch-tab-favorite" onclick="<?php if ($_USER->Logged_In): ?>favorite_video();<?php else: ?>alert('Log in to add favorites');<?php endif ?>">
                <a id="watch-action-favorite-link" href="" class="watch-action-link" onclick="return false;">
                    <img id="watch-action-favorite" src="/img/pixel.gif" alt="Favorite">
                    <span class="watch-action-text"><?= $LANGS['favorite'] ?></span>
                    <button class="watch-tab-arrow" title=""></button>
                </a>
            </span>
            <span id="watch-tab-flag" onclick="<?php if ($_USER->Logged_In): ?>flag_video();<?php else: ?>alert('Log in to flag a video');<?php endif ?>" title="Report video as inappropriate">
                <a id="watch-action-flag-link" href="" class="watch-action-link" onclick="return false">
                    <img id="watch-action-flag" src="/img/pixel.gif" alt="Report video as inappropriate">
                    <span class="watch-action-text"><?= $LANGS['flag'] ?></span>
                    <button class="watch-tab-arrow" title=""></button>

                </a>
            </span>
        </div>
        <div class="clear"></div>
    </div>

    <div class="clear"></div>
</div>

<?php if ($_VIDEO->Info['e_comments'] == 1 or $_VIDEO->Info['e_comments'] == 2 and $_USER->is_friends_with($_OWNER) == true or $_VIDEO->Info['e_comments'] == 2 and $_USER->Username == $_OWNER->Username) :?>
<div class="expand-panel expanded small-expand-panel">
    <h2 style="margin-bottom: 10px;"><?= $LANGS['textcomments'] ?></h2>
    <div class="expand-content" id="expand-content-comm">
        <div id="div_main_comment2"></div>
        <div id="recent_comments">
            <?php if ($_VIDEO->Info["comments"] > 0 && $Video_Comments) : ?>
                <?php foreach ($Video_Comments as $Video_Comment) : ?>
                    <div id="cid_<?= $Video_Comment["id"] ?>" class="watch-comment-entry">
                        <div class="watch-comment-head">
                            <div class="watch-comment-info">
                                <a class="watch-comment-auth" href="/user/<?= $Video_Comment["by_user"] ?>" rel="nofollow"><?= displayname($Video_Comment["by_user"]) ?></a>
                                <span class="watch-comment-time"> (<?= get_time_ago($Video_Comment["submit_on"]) ?>) </span>
                            </div>
                            <div class="clearL"></div>
                        </div>
                        <div id="comment_body_commentid">
                            <div class="watch-comment-body">
                                <?= make_user_clickable(make_links_clickable(nl2br((string) $Video_Comment["content"]))) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <div style="text-align:center;padding:20px 0 10px"><?= $LANGS['nocomments'] ?></div>
            <?php endif ?>
        </div> <!-- end recent_comments -->
    </div>
</div>
<?php else : ?>
<div class="expand-panel expanded small-expand-panel"><strong><?= $LANGS['commentsdisabled'] ?></strong></div>
<?php endif ?>
</div>
</div> <!-- koniec lewej strony !-->
<!-- POCZĄTEK PRAWEJ STRONY !-->
<div class="clear"></div>
