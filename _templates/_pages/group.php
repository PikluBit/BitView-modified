<?php use function PHP81_BC\strftime; ?>
<style>
    .contentBox {
        border-radius: 0;
        padding:6px;
    }
    #groupName {
        font-weight: bold;
        font-size: 16px;
    }
    #groupLinks {
        margin: 6px 0px;
    }
    #groupCommonHeader {
        border-bottom: 1px dashed #999;
        padding-bottom: 12px;
        margin-bottom: 12px;
    }
    #groupOptionsDiv {
        float: right;
        margin-left: 10px;
        line-height: 15px;
    }
    .highlightBox {
        text-align: center;
        margin-top: 3px;
        font-size: 14px;
    }
    #groupFlagAsDiv {
    padding-top: 5px;
    }
    .mainForumTable {
        padding-top: 3px;
        padding-bottom: 3px;
    }
    .grid-view {
    margin-top: 4px;
    }
    #groupRecentVideosDiv {
        padding-top: 2px;
    }
    span[style="font-weight:bold;background-color:#FFF;padding:1px 4px 1px 4px;border:1px solid #999;margin-right:5px"]{
        border:0!important;
    }
    span[style="font-weight:bold;background-color:#CCC;padding:1px 4px 1px 4px;border:1px solid #999;margin-right:5px"]{
        border:0!important;
    }
    .vltitle {
        height: 28px;
        margin-top: 2px;
        overflow: hidden;
    }
</style>
<div id="mainContent">

        <div class="contentBox">
                <div id="groupCommonHeader">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr valign="top">
                <td width="130">
                    <div id="groupStillDiv">
                        <a href="/group?id=<?= $_GET["id"] ?>"><img src="<?= cache_bust("/u/grp/".$Group["id"].".jpg") ?>" class="vimg120" style="border: 3px double #999;"></a>
                    </div>
                </td>
                <td>
                    <div id="groupHeaderInfo" style="padding-left: 8px;">
                        <div id="groupName"><a href="/group?id=<?= $_GET["id"] ?>"><?= $Group["title"] ?></a></div>
                        <div id="groupLinks">
                                <a href="/group?id=<?= $Group["id"] ?>&action=videos"><?= $LANGS['groupvideos'] ?>: <?= $Video_Amount ?></a> | <a href="/group?id=<?= $Group["id"] ?>&action=members"><?= $LANGS['groupmembers'] ?>: <?= $Member_Amount ?></a> | <a href="/group?id=<?= $Group["id"] ?>"><?= $LANGS['discussions'] ?>: <?= $DB->execute("SELECT count(id) as amount FROM groups_topics WHERE group_id = :ID", true, [":ID" => $Group["id"]])["amount"] ?></a>

                        </div>
                        

                        <div id="groupDesc">
                        
                <span id="BeginvidDesc">
    <?= links(nl2br((string) $Group["description"])) ?>
    </span>
                        </div>
                    </div>
                </td>
                <td align="right" nowrap>
                    <div id="groupOptionsDiv" class="highlightBox">
                        <?php if ($_USER->Logged_In && !$Is_Member or $Owns_Group && !$Is_Member) : ?>
        <a href="/a/join_group?group=<?= $Group["id"] ?>"><?php if (!$Requested) : ?>
                                                                                        <?= $LANGS['jointhisgroup'] ?>
                                                                                    <?php else : ?>
                                                                                        <?= $LANGS['removerequest'] ?>
                                                                                    <?php endif ?></a><br>
                        <?php elseif ($_USER->Logged_In && $Is_Member or $Owns_Group && $Is_Member) : ?>
                        <a href="/a/join_group?group=<?= $Group["id"] ?>"><?= $LANGS['leavegroup'] ?></a><br>
            <?php endif ?>
            <?php if ($_USER->Logged_In && ($Owns_Group || $_USER->Is_Admin || $_USER->Is_Moderator)) : ?>
                                <div id="groupFlagAsDiv" class="smallText">
        <a href="/group_moderation?id=<?= $_GET["id"] ?>"><?= $LANGS['moderation'] ?></a>
        </div>
                            <?php endif ?>
                                                </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                </td>
            </tr>
        </table>
    </div>
<?php if (!isset($_GET["topic_id"]) && !isset($_GET["action"])) : ?>
                
    <div id="groupRecentVideosDiv">
        <h3><?= $LANGS['recentvideos'] ?>&nbsp;&nbsp;
            <span class="smallText" style="font-weight: normal;">
                <a href="/group?id=<?= $_GET["id"] ?>&action=videos"><?= $LANGS['viewallvideos'] ?></a><?php if ($_USER->Logged_In && $Is_Member) : ?> | <a href="/submit_group_video?id=<?= $_GET["id"] ?>"> <?= $LANGS['addvideo'] ?></a><?php endif ?>
            </span>
        </h3>
<div style="margin-top: 12px;">
                <table width="21" height="121" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td>
                            <table width="680" height="121" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td style="border-bottom:none;">
                                        <?php if ($Videos) : ?>
                                            <?php $Count = 0; ?>
                                            <?php $Count2 = 1; ?>
                                            <?php $Pages = ceil(count($Videos) / 5); ?>
                                            <?php foreach ($Videos as $Video) : ?>
                                                <?php
                                                if (file_exists($_SERVER["DOCUMENT_ROOT"]."/u/thmp/".$Video["url"].".jpg")) {
                                                    $Thumbnail = "/u/thmp/".$Video["url"].".jpg";
                                                } else {
                                                    $Thumbnail = "/img/nothump.png";
                                                }
                                                ?>
                                                <?php if ($Count == 0) : ?><div id="subsl<?= $Count2 ?>"<?php if ($Count2 != 1) : ?> style="display:none;"<?php endif ?>><?php endif ?>
                                                <div style="display:inline-block;width: 124px;word-spacing:0px;vertical-align: top;padding-right: 9px;position: relative;">
                                                    <?= load_thumbnail($Video['url']) ?>
                                                    <div class="vltitle">
                                                        <div class="vlshortTitle" style="font-weight:bold">
                                                            <a href="/watch?v=<?= $Video["url"] ?>" title="<?= $Video["title"] ?>"><?= short_title($Video["title"],40) ?></a> 
                                                        </div>
                                                    </div>
                                                    <div class="vlfacets" style="font-size: 11px;">
                                                        <span id="video-num-views" style="color:#666;margin:0"><?= get_time_ago($Video["uploaded_on"]) ?></span><br>
                                                                    <span id="video-num-views" style="color:#666;margin:0"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                                                                    <div><span class="vlfrom">          <a href="/user/<?=$Video["uploaded_by"]?>"><?= displayname($Video["uploaded_by"]) ?></a>
                                                    </span></div>
                                                                    <div class="clearL"></div>
                                                            </div>
                                                </div>
                                                <?php if ($Count == 4 && ($Count2) != $Pages) : ?></div><?php $Count2++ ?><?php endif ?>
                                                <?php $Count++ ?>
                                                <?php if ($Count == 5) { $Count = 0; } ?>
                                            <?php endforeach ?>
                                            <?php if ($Count2 == 4) : ?></div><?php endif ?>
                                        <?php else : ?>
                                            <div style="text-align:center; font-weight: bold; font-size: 14px;">
                                                <?= $LANGS['novideos'] ?>
                                            </div>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                </tbody></table>
                        </td>
                    </tr>
                    </tbody></table>
            </div>
    </div> <!-- end recentVideosDiv -->




    <div id="groupRecentTopicsDiv">
    <h3><?= $LANGS['discussions'] ?>
        &nbsp;<span style="font-size: 12px; font-weight: normal; color: #000;">(<?= $DB->execute("SELECT count(id) as amount FROM groups_topics WHERE group_id = :ID", true, [":ID" => $Group["id"]])["amount"] ?>)
        &nbsp; <span class="smallText label">
            <?php if (!$_USER->Logged_In) : ?><a href="/login"><?= $LANGS['login'] ?></a> <?= $LANGS['topostatopic'] ?><?php elseif (!$Is_Member) : ?><a href="/a/join_group?group=<?= $Group["id"] ?>"><?= $LANGS['jointhisgroup'] ?></a> <?= $LANGS['topostatopic'] ?><?php else : ?><a href="/create_discussion?id=<?= $Group["id"] ?>"><?= $LANGS['creatediscussion'] ?><?php endif ?></a>
        </span>
    </span>
    </h3>
                    <?php if ($Topics) : ?>
        <table cellpadding="3" cellspacing="0" width="100%">
            <tr>
                <td class="grayText smallText" width="50%"><?= $LANGS['topic'] ?></td>
                <td align="center" class="grayText smallText" width="20%"><?= $LANGS['author'] ?></td>
                <td align="center" class="grayText smallText" width="10%"><?= $LANGS['replies'] ?></td>
                <td align="center" class="grayText smallText" width="18%"><?= $LANGS['lastpost'] ?></td>
            </tr>
        <?php foreach ($Topics as $Topic) : ?>
            <?php
                                            $Posts = $DB->execute("SELECT count(id) as amount FROM groups_messages WHERE topic_id = :ID", true, [":ID" => $Topic["id"]])["amount"];
                                            $Last_Post = $DB->execute("SELECT submit_date FROM groups_messages WHERE topic_id = :ID ORDER BY submit_date DESC LIMIT 1", true, [":ID" => $Topic["id"]])["submit_date"];
                                        ?>
                <tr class="mainForumTable" style="padding-top:3px; padding-bottom:3px;" valign="top" bgcolor="#999999">

                                            <td bgcolor="#FFF" style="padding-left: 3px; padding-top:3px; padding-bottom:3px;">
                                                <a href="/group?id=<?= $_GET["id"] ?>&topic_id=<?= $Topic["id"] ?>"><?= $Topic["title"] ?></a>
                                            </td>
                                            <td align="center" bgcolor="#FFF" style=""><a href="/user/<?= $Topic["created_by"] ?>"><?= displayname($Topic["created_by"]) ?></a></td>
                                            <td align="center" bgcolor="#FFF" style=""><?= $Posts ?></td>
                                            <td align="center" bgcolor="#FFF" style="padding-left: 3px;padding-right: 3px;"><?= get_time_ago($Last_Post) ?></td>
                                        </tr>
                                    <?php endforeach ?>
                
            <tr bgcolor="#FFF">
                <td colspan="10">       <div class="pagingDiv">
<?= $_PAGINATION->show_pages("id=".$_GET["id"]) ?>

        </div>


                </td>
            </tr>
        <?php else: ?>
            <div style="padding-left: 1px;">
                <table width="21" height="121" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td>
                            <table width="680" height="121" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td style="border-bottom:none;">
                                                                                    <div style="text-align:center; font-weight: bold; font-size: 14px;">
                                                <?= $LANGS['nodiscussions'] ?>
                                            </div>
                                                                            </td>
                                </tr>
                                </tbody></table>
                        </td>
                    </tr>
                    </tbody></table>
            </div>
            <?php endif ?>
    
        </table>
        

    
    </div> <!-- end recentTopicsDiv -->

    <div id="groupMembersDiv">
    <h3><?= $LANGS['groupmembers'] ?>
        &nbsp;<span style="font-size: 12px; font-weight: normal; color: #000;">(<?= $Member_Amount ?>)
        &nbsp; <span class="smallText label"><a href="/group?id=<?= $_GET["id"] ?>&action=members" style="font-weight:normal"><?= $LANGS['viewallmembers'] ?></a></span>
    </span>
    </h3>
        <table width="625" height="121" style="background-color: #FFFFFF" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td style="border-bottom:none;">
                                        <?php $Count = 0; ?>
                                        <?php $Count2 = 1; ?>
                                        <?php $Pages = ceil(count($Members) / 5); ?>
                                        <?php foreach ($Members as $Member) : ?>
                                            <?php if ($Count == 0) : ?><div id="vil<?= $Count2 ?>"<?php if ($Count2 != 1) : ?> style="display:none"<?php endif ?>><?php endif ?>
                                            <div class="videobarthumbnail_block2" id="div_recent_friends_0" style="position:relative;bottom:6px">
                                                <center>
                                                    <a href="/user/<?= $Member["member"] ?>"><img src="<?= avatar($Member["member"]) ?>" width="60" height="60" style="border: 3px double #999; margin-bottom: 5px;"></a><br>
                                                    <a href="/user/<?= $Member["member"] ?>" style="font-size:11px"><?= displayname($Member["member"]) ?></a>
                                            </div>
                                            <?php if ($Count == 4 && ($Count2) != $Pages) : ?></div><?php $Count2++ ?><?php endif ?>
                                            <?php $Count++ ?>
                                            <?php if ($Count == 5) { $Count = 0; } ?>
                                        <?php endforeach ?>
                <?php if ($Count2 == 4) : ?></div><?php endif ?>
                                    </td>
                                </tr>
                                </tbody></table>

    
    </div> <!-- end membersDiv -->

    <div id="groupAboutGroupDiv">
        <h3><?= $LANGS['about'] ?></h3>
        <div class="smallText">
            <span class="grayText"><?= $LANGS['category'] ?>:</span>
        <a href="/groups?c=<?= $Group["categories"] ?>"> <?= $Group_Category[$Group["categories"]] ?></a>


<br>
            <span class="grayText"><?= $LANGS['owner'] ?>:</span>
            <a href="/user/<?= $Group["created_by"] ?>"><?= displayname($Group["created_by"]) ?></a><br>
            <span class="grayText"><?= $LANGS['groupcreated'] ?>:</span>
            <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['longtimeformat'], time_machine(strtotime((string) $Group["creation_date"]))); }
                    else {echo strftime($LANGS['longtimeformat'], strtotime((string) $Group["creation_date"])); }  ?>
<br>
<span class="grayText"><?= $LANGS['grouptype'] ?>:</span>
            <?php if ($Group["instant_join"] == 1) : ?><?= $LANGS['instantjoin'] ?><?php else : ?><?= $LANGS['approvalrequired'] ?><?php endif ?>
<br>
            <span class="grayText"><?= $LANGS['groupurl'] ?>:</span>
            <a href="/group?id=<?= $Group["id"] ?>">https://www.bitview.net/group?id=<?= $Group["id"] ?></a>
    
            <br/>
        </div>
    </div> <!-- end aboutGroupDiv -->
<?php elseif (isset($_GET["topic_id"])) : ?>
    <div id="groupDiscussionDiv">
    <h3><?= $Topic["title"] ?>
        &nbsp; <span class="smallText label"><?php if ($_USER->Logged_In && ($_USER->Is_Admin || $_USER->Is_Moderator || $Owns_Group)) : ?>
                                    <a href="/a/delete_discussion?id=<?= $_GET["topic_id"] ?>"><?= $LANGS['deletediscussion'] ?></a>
                                    <?php endif ?></span>
    </span>
    </h3><div style="margin-left: 10px; margin-right: 10px;background:white;border-top:0;box-sizing:border-box;padding:5px">
                    <?php foreach ($Topic_Messages as $Message) : ?>
                        <div style="border-bottom: 1px dashed #999;padding-bottom:5px;margin-bottom:5px;overflow:hidden">
                            <div style="width:10%;float:left;padding-right:5px;text-align:center">
                                <img src="<?= avatar($Message["by_user"]) ?>" width="60" height="60" style="border: 3px double #999; margin-bottom:3px;"><br />
                                <a href="/user/<?= $Message["by_user"] ?>"><?= displayname($Message["by_user"]) ?></a>
                            </div>
                            <div style="padding-left:10px;min-height:75px;position:relative;float: left;width:85%;padding-bottom:0">
                                <?= links(nl2br((string) $Message["message"])) ?>
                                <div style="color:gray;font-size:10px;position:absolute;left:10px;bottom:0"><?= get_time_ago($Message["submit_date"]) ?><?php if ($_USER->Logged_In && $First_Message != $Message["id"] && ($Owns_Group || $_USER->Username == $Message["by_user"] || $_USER->Is_Admin || $_USER->Is_Moderator)) : ?> | <a href="/a/delete_message?id=<?= $Message["id"] ?>"><?= $LANGS['delete'] ?></a><?php endif ?></div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <div>
                        <?= $MESSAGE_PAGINATION->show_pages("id=".$_GET["id"]."&topic_id=".$_GET["topic_id"]) ?>
                    </div>
                    <?php if ($_USER->Logged_In && $Is_Member) : ?>
                    <div style="margin-top:10px">
                        <form action="/a/post_reply" method="POST">
                            <div style="font-weight:bold;margin-bottom:3px"><?= $LANGS['postreply'] ?>:</div>
                            <textarea maxlength="5000" name="reply" style="width:99%" rows="4"></textarea>
                            <input type="hidden" name="topic_id" value="<?= $Topic["id"] ?>">
                            <input type="submit" style="margin-top:3px" name="post_reply" value="<?= $LANGS['post'] ?>">
                        </form>
                    </div>
                    <?php endif ?>
                </div>
    
    </div>
<?php elseif ($_GET["action"] == "members") : ?>
    <div id="groupMembersDiv">
    <h3><?= $LANGS['groupmembers'] ?>&nbsp;<span style="font-size: 12px; font-weight: normal; color: #000;">(<?= $Member_Amount ?>)
    </span>
    </h3>
        <table width="680" height="121" style="background-color: #FFFFFF" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td style="border-bottom:none;">
                                        <?php $Count = 0; ?>
                                        <?php $Count2 = 1; ?>
                                        <?php foreach ($Members as $Member) : ?>
                                            <?php if ($Count == 0) : ?><div id="vil<?= $Count2 ?>"<?php if ($Count2 != 1) : ?> style="display:none"<?php endif ?>><?php endif ?>
                                            <div class="videobarthumbnail_block2" id="div_recent_friends_0" style="position:relative;bottom:6px">
                                                <center>
                                                    <a href="/user/<?= $Member["member"] ?>"><img src="<?= avatar($Member["member"]) ?>" width="60" height="60" style="border: 3px double #999; margin-bottom: 5px;"></a><br>
                                                    <a href="/user/<?= $Member["member"] ?>" style="font-size:12px;white-space: nowrap;"><?= displayname($Member["member"]) ?></a>
                                                    <?php if ($_USER->Logged_In && $Owns_Group && $Member["accepted"] == 0) : ?><br /><a href="/a/accept_member?user=<?= $Member["member"] ?>&id=<?= $_GET["id"] ?>" style="font-size:11px"><?= $LANGS['accept'] ?></a><br /><a href="/a/decline_member?user=<?= $Member["member"] ?>&id=<?= $_GET["id"] ?>" style="position:relative;top:3px;font-size:11px"><?= $LANGS['decline'] ?></a><?php endif ?>
                                            </div>
                                            <?php if ($Count == 4 && ($Count2) != $Pages) : ?></div><?php $Count2++ ?><?php endif ?>
                                            <?php $Count++ ?>
                                        <?php endforeach ?>
                <?php if ($Count2 == 4) : ?></div><?php endif ?>
                                    </td>
                                </tr>
                                </tbody></table>

    
    </div>
<?php elseif ($_GET["action"] == "videos") : ?>
<div id="groupRecentVideosDiv">
        <h3><?= $LANGS['recentvideos'] ?>&nbsp;&nbsp;<span style="font-size: 12px; font-weight: normal; color: #000;">(<?= $Video_Amount ?>)</span>&nbsp;&nbsp;
            <span class="smallText" style="font-weight: normal;">
                <?php if ($_USER->Logged_In && $Is_Member) : ?><a href="/submit_group_video?id=<?= $_GET["id"] ?>"> <?= $LANGS['addvideo'] ?></a><?php endif ?>
            </span>
        </h3>
<div style="margin-top: 12px;">
                <table width="21" height="121" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td>
                            <table width="680" height="121" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td style="border-bottom:none;">
                                        <?php if ($Videos) : ?>
                                            <?php $Count = 0; ?>
                                            <?php $Count2 = 1; ?>
                                            <?php foreach ($Videos as $Video) : ?>
                                                <?php
                                                if (file_exists($_SERVER["DOCUMENT_ROOT"]."/u/thmp/".$Video["url"].".jpg")) {
                                                    $Thumbnail = "/u/thmp/".$Video["url"].".jpg";
                                                } else {
                                                    $Thumbnail = "/img/nothump.png";
                                                }
                                                ?>
                                                <?php if ($Count == 0) : ?><div id="subsl<?= $Count2 ?>"<?php if ($Count2 != 1) : ?> style="display:none"<?php endif ?>><?php endif ?>
                                                <div style="display:inline-block;width: 124px;word-spacing:0px;vertical-align: top;padding-right: 9px;margin-bottom: 12px;position: relative;">
                                                    <div class="v120WideEntry" style="margin-bottom: 2px;">
                                                <?= load_thumbnail($Video['url']) ?>
                                            </div>
            <div class="vltitle">
                <div class="vlshortTitle" style="font-weight:bold">
                    <a href="/watch?v=<?= $Video["url"] ?>" title="<?= $Video["title"] ?>"><?= short_title($Video["title"],40) ?></a> 
                </div>
            </div>

<div class="vlfacets" style="font-size: 11px;">
    <span id="video-num-views" style="color:#666;margin:0"><?= get_time_ago($Video["uploaded_on"]) ?></span><br>
                <span id="video-num-views" style="color:#666;margin:0"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                <div><span class="vlfrom">          <a href="/user/<?=$Video["uploaded_by"]?>"><?= displayname($Video["uploaded_by"]) ?></a>
                    <div class="accept"><?php if ($_USER->Logged_In && $Owns_Group && $Video["accepted"] == 0) : ?><a href="/a/accept_video?url=<?= $Video["url"] ?>&id=<?= $_GET["id"] ?>" style="font-size:11px"><?= $LANGS['accept'] ?></a><?php endif ?></div>
</span></div>
                <div class="clearL"></div>
        </div>
                                                </div>
                                                <?php if ($Count == 4 && ($Count2) != $Pages) : ?></div><?php $Count2++ ?><?php endif ?>
                                                <?php $Count++ ?>
                                            <?php endforeach ?>
                                            <?php if ($Count2 == 4) : ?></div><?php endif ?>
                                        <?php else : ?>
                                            <div style="text-align:center; font-weight: bold; font-size: 14px;">
                                                <?= $LANGS['novideos'] ?>
                                            </div>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                </tbody></table>
                        </td>
                    </tr>
                    </tbody></table>
            </div>
    </div> <!-- end recentVideosDiv -->
<?php endif ?>
        </div> <!-- end contentBox -->
    </div> <!-- end mainContent -->
