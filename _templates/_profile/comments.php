<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/profile_style.php" ?>
<style>
</style>
<div id="baseDiv">
                <?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_profile.php" ?>
        <br>
        <!--Begin Page Container Table-->
<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_profile/main_links.php" ?>  
<div style="width: 960px; text-align: left;">
    <div id="mainContent">  
        <div class="headerBox" style="width:948px;height:16px">
            <div class="BoxesInnerOpacity">
            <div class="headerTitleEdit" style="line-height: 14px;"><?= $LANGS['channelcomments'] ?> (<span id="comment-amount"><?= $_PROFILE->Info["channel_comments"] ?></span>)</div>
            <div class="headerBoxOpacity"></div>
            </div>
        </div>
        <div id="commentsBoxFull" class="basicBoxes" style="width:958px">
            <div class="BoxesInnerOpacity">
            <table border="0" width="100%" class="commentsTableFull" style="border-spacing: 0;padding: 0 5px;">
                            
        <tbody>
        <?php if ($Comments) : ?>
        <?php foreach ($Comments as $Comment) : ?>
        <tr class="commentsTableFull" id="cc_<?= $Comment["id"] ?>">
        <td valign="top" width="60" align="left" style="padding-bottom:15px">
            <a href="/user/<?= $Comment["by_user"] ?>"><img src="<?= avatar($Comment["by_user"]) ?>" width="90" class="vimg90"></a>
        </td>
        <td valign="top" align="left" style="padding-bottom:15px">
            <div class="comment-top" style="padding-bottom: 5px;"><a href="/user/<?= $Comment["by_user"] ?>" style="font-weight: bold;"><?= displayname($Comment["by_user"]) ?></a>
<span class="labels">(<?= get_time_ago($Comment["submit_date"]) ?>)</span> <?php if ($_USER->Logged_In && ($_USER->Is_Admin || $_USER->Is_Moderator || $_USER->Username == $_PROFILE->Username || $_USER->Username == $Comment["by_user"])) : ?><span class="labels"> <a style="float:right" href="javascript:void(0)" onclick="delete_channel_comment(<?= $Comment["id"] ?>)"><?= $LANGS['delete'] ?></a></span><?php endif ?>
<?php if ($_USER->Logged_In) : ?>
                            <script>
                                function delete_channel_comment(id) {
                                    var url = "/a/delete_channel_comment?id="+id;
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('GET', url, true);

                                    xhr.onload = function() {
                                        if (xhr.status >= 200 && xhr.status < 400) {
                                            document.getElementById("cc_"+id).outerHTML = "";
                                            changeCommentAmount();
                                        } else {
                                            showErrorMessage();
                                        }
                                    };

                                    xhr.onerror = function() {
                                        showErrorMessage();
                                    };

                                    xhr.send();
                                }
                                function changeCommentAmount() {
                                    var x = document.getElementById('comment-amount');
                                    x.innerHTML = x.innerHTML - 1;
                                }
                            </script>
                        <?php endif ?>
                <span>
                    </span>
            </div>
                <?= nl2br((string) $Comment["content"]) ?>
        </td>
        </tr>
        <?php endforeach ?>
        <?php else : ?>
            <div style="font-size:15px;color:#<?= $_PROFILE->Info["c_normal_font"] ?>;text-align:center;padding:22px 0 29px">No Comments Found :(</div>
        <?php endif ?>
        <?php if ($Comments) : ?>
                <tr class="commentsTableNBFull">
                    <td colspan="4" align="left" class="buttonPost" style="padding-right: 5px; padding-left: 5px; padding-top: 4px;border-bottom:none!important">

                    <div>
                    <center><a href="/user/<?= $_PROFILE->Username ?>&page=post_comment" style="font-size:11px"><?= $LANGS['addcomment'] ?></a></center>
                            <div class="pagingDiv">
                             <?php $_PAGINATION->new_show_pages_videos("user=$_PROFILE->Username&page=comments") ?>
        </div>

                    </div>

                    </td>
                </tr>
            <?php endif ?>
                
            </tbody></table>
            <div class="basicBoxesOpacity"></div>
            </div>
        </div>
    </div>
</div>
</div>
