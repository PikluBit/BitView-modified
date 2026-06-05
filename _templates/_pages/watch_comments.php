<?php use function PHP81_BC\strftime; ?>
<script>
function showActions(e) {
    for (i = 0; i < document.getElementsByClassName('current').length; i++) {
        document.getElementsByClassName('current')[0].classList.remove('current');
    }
    e.classList.add('current');
    if (e.getAttribute('user-score') == 1) {
        document.getElementById('watch-comment-vote-up').classList.remove('voted-down');
        document.getElementById('watch-comment-vote-down').classList.remove('voted-down');
        document.getElementById('watch-comment-vote-up').classList.add('voted-up');
        document.getElementById('watch-comment-vote-down').classList.add('voted-up');
    }
    else if (e.getAttribute('user-score') == 0) {
        document.getElementById('watch-comment-vote-up').classList.remove('voted-up');
        document.getElementById('watch-comment-vote-down').classList.remove('voted-up');
        document.getElementById('watch-comment-vote-up').classList.add('voted-down');
        document.getElementById('watch-comment-vote-down').classList.add('voted-down');
    }
    else {
        document.getElementById('watch-comment-vote-up').classList.remove('voted-up');
        document.getElementById('watch-comment-vote-down').classList.remove('voted-up');
        document.getElementById('watch-comment-vote-up').classList.remove('voted-down');
        document.getElementById('watch-comment-vote-down').classList.remove('voted-down');
    }
    var rect = e.getBoundingClientRect();
    var height = document.getElementById('masthead-container').offsetHeight;
    var width = (document.body.clientWidth - 960) / 2;
    var long = document.getElementById('watch-comments-actions').offsetWidth;
    if (!document.getElementById("default-language-box")) {
        document.getElementById('watch-comments-actions').style.top = rect.top + scrollY - height - 10 + "px";
    }
    else {
        var eh = document.getElementById('default-language-box').offsetHeight;
        document.getElementById('watch-comments-actions').style.top = rect.top + scrollY - height - eh - 30 + "px";
    }
    document.getElementById('watch-comments-actions').style.left = 640 - long + 6 + "px";
}
function hideActions() {
    for (i = 0; i < document.getElementsByClassName('current').length; i++) {
        document.getElementsByClassName('current')[0].classList.remove('current');
    }
    document.getElementById('watch-comments-actions').style.top = "-1000px";
    document.getElementById('watch-comments-actions').style.left = "-1000px";
}
function inputFocus(e) {
    document.getElementById('comments-post-form').classList.remove('input-collapsed');
    document.getElementById('comments-post-form').classList.add('input-expanded');
    document.getElementById('comments-post-form').classList.add('input-focused');
    document.getElementById('comments-attach-video').classList.remove('hid');
    if (e.value == "Respond to this video...") {
        e.value = "";
    }
}
function inputBlur(e) {
    document.getElementById('comments-post-form').classList.remove('input-focused');
}
function cancelPost(e) {
    document.getElementById('comments-post-form').classList.add('input-collapsed');
    document.getElementById('comments-post-form').classList.remove('input-expanded');
    document.getElementById('comments-post-form').classList.remove('input-focused');
    document.getElementById('comments-attach-video').classList.add('hid');
    document.getElementsByClassName('comments-textarea')[0].value = "Respond to this video...";
    document.getElementsByClassName('comments-post-count-textbox')[0].value = 500;
}
function chars_remaining(e) {
    let comment_content = e.value;
    let comment_length = comment_content.length;
    document.getElementsByClassName('comments-post-count-textbox')[0].value = 500 - comment_length;
}
function replyCom(e) {
    document.getElementById('watch-comments-actions').style.top = "-1000px";
    document.getElementById('watch-comments-actions').style.left = "-1000px";
    var username = document.getElementsByClassName('current')[0].getElementsByTagName('a')[0].href.substring(document.getElementsByClassName('current')[0].getElementsByTagName('a')[0].href.lastIndexOf('/') + 1);
    document.getElementById('comments-post-form').classList.remove('input-collapsed');
    document.getElementById('comments-post-form').classList.add('input-expanded');
    document.getElementById('comments-post-form').classList.add('input-focused');
    document.getElementById('comments-attach-video').classList.remove('hid');
    document.getElementsByClassName('comments-textarea')[0].value = "@" + username + " ";
}
function vote(e, s) {
    var id = document.getElementsByClassName('current')[0].getAttribute("data-id");
    if (s == 1) {
        document.getElementById('watch-comment-vote-up').classList.remove('voted-down');
        document.getElementById('watch-comment-vote-down').classList.remove('voted-down');
        document.getElementById('watch-comment-vote-up').classList.toggle('voted-up');
        document.getElementById('watch-comment-vote-down').classList.toggle('voted-up');
    }
    else {
        document.getElementById('watch-comment-vote-up').classList.remove('voted-up');
        document.getElementById('watch-comment-vote-down').classList.remove('voted-up');
        document.getElementById('watch-comment-vote-up').classList.toggle('voted-down');
        document.getElementById('watch-comment-vote-down').classList.toggle('voted-down');
    }
    if ((document.getElementById('watch-comment-vote-up').classList.contains('voted-up') && document.getElementById('watch-comment-vote-down').classList.contains('voted-up')) || (document.getElementById('watch-comment-vote-up').classList.contains('voted-down') && document.getElementById('watch-comment-vote-down').classList.contains('voted-down'))) {
            if (s == 1) {
                if (document.querySelector('.current[data-id="'+ id +'"]').getAttribute('user-score') != 0) {
                    document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) + 1);
                    document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) + 1);
                }
                else {
                    document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) + 2);
                    document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) + 2);
                }
            }
            else if (s == 0) {
                if (document.querySelector('.current[data-id="'+ id +'"]').getAttribute('user-score') != 1) {
                    document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) - 1);
                    document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) - 1);
                }
                else {
                    document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) - 2);
                    document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) - 2);
                }
            }
            document.querySelector('.current[data-id="'+ id +'"]').setAttribute('user-score', s);
            document.querySelector('[data-id="'+ id +'"]').setAttribute('user-score', s);
    }
    else {
            document.querySelector('.current[data-id="'+ id +'"]').setAttribute('user-score', 2);
            document.querySelector('[data-id="'+ id +'"]').setAttribute('user-score', 2);
            if (s == 1) {
                document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) - 1);
                document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) - 1);
            }
            else if (s == 0) {
                document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) + 1);
                document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) + 1);
            }
    }
    var url = "/a/rate_comment?id="+ id +"&like="+s;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
        } else {
            alert('Something went wrong!');
        }
    };

    xhr.onerror = function() {
        alert('Something went wrong!');
    };

    xhr.send();
}
function flagCom(e) {
    var id = document.getElementsByClassName('current')[0].getAttribute("data-id");
    if (document.querySelector('.current[data-id="'+ id +'"]').getAttribute("user-flag") == 0) {
        document.querySelector('.current[data-id="'+ id +'"] .content').innerHTML = "<i><?= $LANGS['marked'] ?></i> <a href='#' onclick='showSpam(this); return false;' rel='nofollow'><?= $LANGS['spamshow'] ?></a> <br class='spambr'><span class='hidden-comment'>"+ document.querySelector('.current[data-id="'+ id +'"] .content').innerHTML +"</span>";
        document.querySelector('.current[data-id="'+ id +'"]').setAttribute("user-flag", 1);
    }
    else {
        document.querySelector('.current[data-id="'+ id +'"] .content').innerHTML = document.querySelector('.current[data-id="'+ id +'"] .hidden-comment').innerHTML;
        document.querySelector('.current[data-id="'+ id +'"]').setAttribute("user-flag", 0);
    }
    var url = "/a/mark_as_spam?id="+id;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
        } else {
            alert('Something went wrong!');
        }
    };

    xhr.onerror = function() {
        alert('Something went wrong!');
    };

    xhr.send();
}
function post_comment(url) {
    var comment = document.getElementsByClassName("comments-textarea")[0].value;
    document.getElementsByClassName("watch-comments-post")[0].classList.add('yt-button-disabled');
    document.getElementsByClassName("watch-comments-post")[0].removeAttribute("onclick");
    document.getElementsByClassName("comments-textarea")[0].disabled = !0;
    if (comment.length > 0) {
        $.ajax({
            type: "POST",
            url: "/a/post_comment",
            data: {
                attach_url: url,
                comment_text: comment
            },
            success: function(output) {
                if (output.response == "success") {
                    document.getElementsByClassName("comments-post-result")[0].innerHTML = "<span style='color:green; font-weight:bold'>OK </span>";
                }
                else if (output.response == "spam") {
                    document.getElementsByClassName("comments-post-result")[0].innerHTML = "<span style='color:red; font-weight:bold'>Error </span>";
                    alert("<?= $LANGS['commentspammsg'] ?>");
                }
                else if (output.response == "spam2") {
                    document.getElementsByClassName("comments-post-result")[0].innerHTML = "<span style='color:red; font-weight:bold'>Error </span>";
                    alert("<?= $LANGS['commentspammsg2'] ?>");
                }
            }
        })
    } else {
        alert("<?= $LANGS['emptycomment'] ?>");
        document.getElementById("comment_submit").disabled = !1;
        document.getElementById("comment_text").disabled = !1;
        document.getElementById("comment_submit").value = "<?= $LANGS['postcomment'] ?>"
    }
    }
    function showSpam(e) {
        var dis = e.parentElement.getElementsByClassName('hidden-comment')[0].style.display;
        if (dis != "inline") {
            e.parentElement.getElementsByClassName('hidden-comment')[0].style.display = "inline";
            e.parentElement.getElementsByClassName('spambr')[0].style.display = "block";
            e.innerHTML = "<?= $LANGS['spamhide'] ?>";
        }
        else {
            e.parentElement.getElementsByClassName('hidden-comment')[0].style.display = "none";
            e.parentElement.getElementsByClassName('spambr')[0].style.display = "none";
            e.innerHTML = "<?= $LANGS['spamshow'] ?>";
        }
    }
    function delete_comment() {
        var id = document.getElementsByClassName('current')[0].getAttribute("data-id");
        document.querySelector('.current[data-id="'+ id +'"]').outerHTML = "";
        for (i = 0; i < document.querySelectorAll('[data-id="'+ id +'"]').length; i++) {
            document.querySelectorAll('[data-id="'+ id +'"]')[i].outerHTML = "";
        }
        var url = "/a/delete_video_comment?id="+id;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var num = document.getElementById('comment-amount');
                num.innerHTML = num.innerHTML - 1;
            } else {
                showErrorMessage();
            }
        };

        xhr.onerror = function() {
            showErrorMessage();
        };

        xhr.send();
    }
</script>
<style>
#watch-discussion {
    width: 640px;
}
</style>
<div id="baseDiv">
	<div id="search-settings-clr" class="hid"></div> 
	<div> 
		<div style="float: left; padding-right: 10px;">
			<a href="/watch?v=<?= $_VIDEO->Info["url"] ?>"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$_VIDEO->Info["url"].'.jpg')): ?>src="/u/thmp/<?= $_VIDEO->Info["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90"></a>&nbsp;
		</div>
		<div class="vtitle">
			<span class="xlargeText"><a href="/watch?v=<?= $_VIDEO->Info["url"] ?>"><?= $_VIDEO->Info["title"] ?></a></span>
			<div class="runtime" style="position: absolute;"><?= timestamp($_VIDEO->Info["length"]) ?></div>
		</div>
		<div class="vfacets">
			<span class="grayText"><?= $LANGS['statadded'] ?>:</span>
			<?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['videotimeformat'], time_machine(strtotime((string) $_VIDEO->Info["uploaded_on"]))); }
                    else {echo strftime($LANGS['videotimeformat'], strtotime((string) $_VIDEO->Info["uploaded_on"])); }  ?><br>
			<span class="grayText"><?= $LANGS['from'] ?>:</span>
			<a href="profile?user=<?= $_VIDEO->Info["uploaded_by"] ?>"><?= displayname($_VIDEO->Info["uploaded_by"]) ?></a><br>
			<span class="grayText"><?= $LANGS['statviews'] ?>:</span>
			<?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info["views"]) ?><?php else: ?><?= ($_VIDEO->Info["views"]) ?><?php endif ?><br>
		</div>
	</div>
	<div id="watch-discussion"> 
		<?php if ($_VIDEO->Info['e_comments'] == 1 or $_VIDEO->Info['e_comments'] == 2 and $_USER->is_friends_with($_OWNER) == true or $_VIDEO->Info['e_comments'] == 2 and $_USER->Username == $_OWNER->Username) :?>
	<?php if (isset($Video_Comments)): ?>
	<ul>
	<li>
                <div class="comment-highlight-section-header" onmouseover="hideActions();">
<?= $LANGS['allcomments'] ?> (<span id="comment-amount"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info['comments']) ?><?php else: ?><?= ($_VIDEO->Info['comments']) ?><?php endif ?></span>)
                </div>
            </li>
         </ul>
         <?php if (!$_USER->Logged_In): ?>
<div id="comments-post">
<textarea class="comments-textarea" style="height: 40px;overflow: hidden;color: #ccc;margin: 1px 0;padding: 3px 2px;width: 460px;border: 1px solid #666;display: block;margin-bottom: 5px;clear: left;" onfocus="_addclass(_gel('comments-post-form'), 'input-focused');" onblur="_removeclass(_gel('comments-post-form'), 'input-focused');">Respond to this video...</textarea>
<div id="comments-post-form-alert" class="yt-alert yt-alert-warn yt-rounded">
        <div class="yt-alert-icon master-sprite"></div>
        <div id="" class="yt-alert-content" style="font-weight: bold;">
                    <a href="/login">Sign In</a> or <a href="/signup">Sign Up</a> now to post a comment!

        </div>
        <div class="clear"></div>
    </div>
</div>
<?php else: ?>
<?php if ($_VIDEO->Info['e_comments'] == 1 or $_VIDEO->Info['e_comments'] == 2 and $_USER->is_friends_with($_OWNER) == true or $_VIDEO->Info['e_comments'] == 2 and $_USER->Username == $_OWNER->Username) :?>
<div id="comments-post">
                <form id="comments-post-form" class="input-collapsed" onsubmit="return false;" method="post" action="" data-comment-type="V">
                    <input type="hidden" value="" name="form_id">
                    <input type="hidden" name="video_id" value="<?= $_VIDEO->URL ?>">
                    <input type="hidden" name="return_ajax" value="true">
                    <textarea class="comments-textarea" oninput="chars_remaining(this)" name="comment" onfocus="inputFocus(this)" onblur="inputBlur(this)">Respond to this video...</textarea>
                    <span class="comments-post-count"><input type="textbox" class="comments-post-count-textbox" value="500"> characters remaining</span>
                    <div class="comments-post-area">
                        <span class="comments-post-result"></span><a href="#" onclick="cancelPost(this); return false;">Cancel</a> or <button type="button" class="watch-comments-post yt-uix-button" onclick="post_comment('<?= $_VIDEO->URL ?>')"><span class="yt-uix-button-content" style="font-size: 12px;">Post</span></button>
                    </div>
                    <div class="clearR"></div>
                </form>
                    <div id="comments-attach-video" class="hid">
        <a href="/video_response_upload?v=<?= $_VIDEO->URL ?>" class="noul"><img id="comments-attach-video-icon" class="master-sprite" src="/img/pixel.gif" alt="Attach a video"></a><a href="/video_response_upload?v=<?= $_VIDEO->URL ?>">Attach a video</a>
    </div>

    </div>
<?php endif ?>
<?php endif ?>
        <ul id="recent-comments" style="margin:0">
        <?php foreach ($Video_Comments as $Comment): ?>
        <?php $User_Vote = $DB->execute("SELECT rating FROM comment_votes WHERE id = :ID and by_user = :USERNAME", true, [":ID" => $Comment['id'], ":USERNAME" => $_USER->Username]); if (!isset($User_Vote['rating'])) {$User_Vote['rating'] = 2;} ?>
        <?php $Comment_Score = $Comment['likes'] - $Comment['dislikes'];?>
        <?php $User_Has_Marked = $DB->execute("SELECT * FROM videos_spam WHERE id = :ID and by_user = :USERNAME", true, [":ID" => $Comment['id'], ":USERNAME" => $_USER->Username]); if ($User_Has_Marked) { $User_Has_Marked = 1; } else { $User_Has_Marked = 0; } ?>
        <li data-id="<?= $Comment['id'] ?>" data-score="<?= $Comment_Score ?>" user-flag="<?= $User_Has_Marked ?>" user-score="<?= $User_Vote['rating'] ?>" data-author="<?= displayname($Comment['by_user']) ?>" onmouseover="showActions(this);" class="">
        <div class="wrapper">
            <div class="metadata">
            <div><a href="/user/<?= $Comment['by_user'] ?>" class="comment-author "><?= displayname($Comment['by_user']) ?></a></div>
            <div class="time"><?= get_time_ago($Comment["submit_on"]) ?></div>
            </div>
                <?php if ($Comment['spam'] < 2 && $User_Has_Marked != 1) : ?>
                <div class="content"><?= make_user_clickable(make_links_clickable(nl2br((string) $Comment["content"]))) ?></div>
                <?php endif ?>
                <?php if ($Comment['spam'] > 1 || $User_Has_Marked == 1): ?>
                <div class="content"><i><?= $LANGS['marked'] ?></i> <a href="#" onclick="showSpam(this); return false;" rel="nofollow"><?= $LANGS['spamshow'] ?></a> <br class="spambr"><span class="hidden-comment"><?= make_user_clickable(make_links_clickable(nl2br((string) $Comment["content"]))) ?></span></div>
                <?php endif ?>
                </div>
            </li>
        <?php endforeach ?>
        <li class="watch-comments-pagination">
        </li>
        </ul>
    <?php else: ?>
        <?= $LANGS['nocomments'] ?>
    <?php endif ?>
    <?php else: ?>
        <?= $LANGS['commentsdisabled'] ?>
    <?php endif ?>
	</div>
</div>
<div id="watch-comments-actions" class="" style="top: -1000px; left: -1000px;">
            <button class="master-sprite-new yt-uix-button" onclick="replyCom(this); return false;" type="button">
    <img class="yt-uix-button-icon-watch-comment-reply" src="/img/pixel.gif" alt="">
<span class="yt-uix-button-content"><?= $LANGS['reply'] ?></span>
    
</button>           <button id="watch-comment-vote-up" class="master-sprite-new yt-uix-button yt-uix-tooltip" title="Vote Up" onclick="vote(this,1); return false;" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" type="button">
    <img class="yt-uix-button-icon-watch-comment-vote-up" src="/img/pixel.gif" alt="">
    
</button>           <button id="watch-comment-vote-down" class="master-sprite-new yt-uix-button yt-uix-tooltip" title="Vote Down" onclick="vote(this,0); return false;" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" type="button">
    <img class="yt-uix-button-icon-watch-comment-vote-down" src="/img/pixel.gif" alt="">
    
</button>           <button class="master-sprite-new yt-uix-button yt-uix-tooltip" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" title="Flag for spam" onclick="flagCom(this); return false;" type="button">
    <img class="yt-uix-button-icon-watch-comment-flag" src="/img/pixel.gif" alt="">
</button>
<?php if ($_USER->Logged_In && (($_USER->Is_Admin || $_USER->Is_Moderator) || ($_USER->Username == $_VIDEO->Info["uploaded_by"]) || ($_USER->Username == $Video_Comment["by_user"]) )) : ?>
    <button id="watch-comment-remove-link" class="master-sprite-new yt-uix-button yt-uix-tooltip" title="Remove" onclick="delete_comment(); return false;" type="button" onmouseover="showTooltip(this);" onmouseout="hideTooltip();">
    <img class="yt-uix-button-icon-watch-comment-remove" src="/img/pixel.gif" alt="">
    
</button><?php endif ?>       </div>