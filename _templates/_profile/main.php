<?php
include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/profile_style.php";
use function PHP81_BC\strftime;
?>
<script>
function showloginbox() {
  var y = document.getElementById("subscribeLoginInvite");
  if (y.style.display === "none") {
    y.style.display = "block";
  }
}
function showhideshare() {
  var y = document.getElementById("sharing_opt");
  if (y.style.display === "block") {
    y.style.display = "none";
  }
  else {
    y.style.display = "block";
  }
}
function showhidehonors() {
  var x = document.getElementById("BeginvidDeschonors");
  var xx = document.getElementById("MorevidDeschonors");
  var y = document.getElementById("RemainvidDeschonors");
  var yy = document.getElementById("LessvidDeschonors");
  if (x.style.display === "block") {
    x.style.display = "none";
    xx.style.display = "none";
    y.style.display = "block";
    yy.style.display = "block";
  }
  else {
    x.style.display = "block";
    xx.style.display = "block";
    y.style.display = "none";
    yy.style.display = "none";
  }
}
function subscribe() {
        var url = "/a/subscription_center?user=<?= $_PROFILE->Username ?>";

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

    function showHide1() {
      var x = document.getElementById("feed_item_j_1_collapsed");
      var y = document.getElementById("feed_item_j_1_expanded");
      if (x.style.display === "block") {
        x.style.display = "none";
        y.style.display = "block";
      }
      else {
        x.style.display = "block";
        y.style.display = "none";
      }
    }

    function showHide2() {
      var x = document.getElementById("feed_item_j_2_collapsed");
      var y = document.getElementById("feed_item_j_2_expanded");
      if (x.style.display === "block") {
        x.style.display = "none";
        y.style.display = "block";
      }
      else {
        x.style.display = "block";
        y.style.display = "none";
      }
    }

    function showHide3() {
      var x = document.getElementById("feed_item_j_3_collapsed");
      var y = document.getElementById("feed_item_j_3_expanded");
      if (x.style.display === "block") {
        x.style.display = "none";
        y.style.display = "block";
      }
      else {
        x.style.display = "block";
        y.style.display = "none";
      }
    }

    function showHide4() {
      var x = document.getElementById("feed_item_j_4_collapsed");
      var y = document.getElementById("feed_item_j_4_expanded");
      if (x.style.display === "block") {
        x.style.display = "none";
        y.style.display = "block";
      }
      else {
        x.style.display = "block";
        y.style.display = "none";
      }
    }

    function showHide5() {
      var x = document.getElementById("feed_item_j_5_collapsed");
      var y = document.getElementById("feed_item_j_5_expanded");
      if (x.style.display === "block") {
        x.style.display = "none";
        y.style.display = "block";
      }
      else {
        x.style.display = "block";
        y.style.display = "none";
      }
    }

    function change_comments_page(channel,page) {
            document.getElementById("loading-div").style.display = "block";
            $.ajax({
                url: "/a/channel_comment_pages.php?channel=" + channel + "&page=" + page,
                success: function(html){
                    if(html){
                        $("#commentsBoxRight").replaceWith(html);
                    } else {
                        alert("Something went wrong!");
                    }
                }
            });
    }
</script>
<div id="baseDiv">
                <?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_profile.php" ?>
    
        <br>
       <!--Begin Page Container Table-->
<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_profile/main_links.php" ?>  

<div class="channelContainer">
<div class="channelLeftColumn">
    <!--Begin Left Column-->        
        <!--Begin Profile Box-->
        <div class="headerBox" id="highlight"><div class="BoxesInnerOpacity">      <div class="headerTitleEdit">
            <div class="headerTitleRight">
                    <div>
                        <?php if(!$Is_Subscribed) : ?>
                            <div id="subscribeDiv">
                                <a <?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username) : ?>href="javascript:void(0)" onclick="subscribe()"<?php elseif (!$_USER->Logged_In) : ?>href="javascript:void(0)" onclick="showloginbox()"<?php else : ?>href="/my_account"<?php endif ?> class="action-button" title="subscribe to <?= $_PROFILE->Username ?>'s videos">
                                    <span class="action-button-text" id="subscribe-button"><?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username) : ?><?= $LANGS['subscribe'] ?><?php elseif (!$_USER->Logged_In) : ?><?= $LANGS['subscribe'] ?><?php else : ?><?= $LANGS['editchannel'] ?><?php endif ?></span>
                                </a>
                            </div> 
                        <?php else : ?>
                            <div id="unsubscribeDiv">
                                <a href="javascript:void(0)" onclick="subscribe()" class="action-button">
                                    <span class="action-button-text unsubscribe" id="unsubscribe-button"><b><?= $LANGS['unsubscribe'] ?></b></span>
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
            </div>
            <div class="headerTitleLeft">
                    <span><?php if($_PROFILE->Info["i_name"] == null) : ?><?= $LANGS['chpretitle'] ?><?= displayname($_PROFILE->Username) ?><?= $LANGS['chposttitle'] ?><?php else : ?><?= $_PROFILE->Info["i_name"] ?><?php endif ?></span>
            </div>
        </div>
</div><div class="headerBoxOpacity" id="highlight"></div></div>
        <div id="pBox" class="highlightBoxes profileLeftCol">
        <div class="BoxesInnerOpacity padLsm padTsm padBsm padRsm">
            <?php if (!$_USER->Logged_In) : ?>
            <div id="subscribeLoginInvite" style="border: 1px solid rgb(153, 153, 153); padding: 5px; background-color: rgb(255, 255, 255);color:#000; margin: 0 0 5px; display: none;" class="">
                <div style="border: 1px solid rgb(204, 204, 204); padding: 4px; background: #eee; text-align: center;">
            <strong><?= $LANGS['logintosubbox'] ?></strong><br>

            <?= $LANGS['signinnow'] ?>

    </div>  
        </div><?php endif ?>
        <div>
                <div class="floatL">
                    <div class="user-thumb-xlarge">
                        <img src="<?= avatar($_PROFILE->Username) ?> " <?php if ($_PROFILE->Info["is_avatar_video"] == 1) : ?>class="avatarvideo"<?php endif ?> alt="<?= $_PROFILE->Username ?>">
                    </div>
                            <center>
                            <?php if ($_PROFILE->Info["type"] <= 6) : ?>
                            <div class="marT3"><img src="/<?= $_CONFIG::$ChannelIMGType[$_PROFILE->Info["type"]] ?>" alt="<?= $_CONFIG::$ChannelType[$_PROFILE->Info["type"]] ?>" width="90" height="18"></div>
                            <?php endif ?>
                            </center>
                </div>
                <div style="float:left;margin-left:5px;width:180px;">
                    <div class="largeTitles"><b><?= displayname($_PROFILE->Username) ?></b></div>
                    <div class="padT3">
                        <?php if ($_PROFILE->Info["type"] <= 6) : ?>
                        <div class="padB3"><?= $LANGS['type'] ?>: <?= $Channel_Type[$_PROFILE->Info["type"]] ?></div>
                        <?php endif ?>
                        <div class="smallText"><?= $LANGS['joined'] ?>: <b>
                            <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['videotimeformat'], time_machine(strtotime((string) $_PROFILE->Info["registration_date"]))); }
                    else {echo strftime($LANGS['videotimeformat'], strtotime((string) $_PROFILE->Info["registration_date"])); }  ?>
                            </b></div>
                        <?php if ($_PROFILE->Info["last_login"] != "0000-00-00 00:00:00") : ?>
                        <div class="smallText"><?= $LANGS['lastlogin'] ?>: <b><?= get_time_ago($_PROFILE->Info["last_login"]) ?></b></div>
                        <?php endif ?>
                        <div class="smallText"><?= $LANGS['videoswatched'] ?>: <b><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["videos_watched"]) ?><?php else: ?><?= ($_PROFILE->Info["videos_watched"]) ?><?php endif ?></b></div>
                        <div class="smallText"><?= $LANGS['channelsubscribers'] ?>: <b><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["subscribers"]) ?><?php else: ?><?= ($_PROFILE->Info["subscribers"]) ?><?php endif ?></b></div>
                        <div class="smallText"><?= $LANGS['channelviews'] ?>: <b><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["profile_views"]) ?><?php else: ?><?= ($_PROFILE->Info["profile_views"]) ?><?php endif ?></b></div>
                       
                    </div>
                </div>
                <div style="clear:both"></div>
            </div>
            <?php if ($_PROFILE->Info["s_age"] == 1) : ?>
                <br>
                    <span class="smallText"><?= $LANGS['age'] ?>:</span> <b><?= ageCalculator($_PROFILE->Info["i_age"]) ?></b><br>
            <?php endif ?>
            <?php if (!empty($_PROFILE->Info["i_about"])) : ?>
            <div style="padding: 6px 0px 8px 0px;">
            <?= nl2br((string) $_PROFILE->Info["i_about"]) ?>
            </div>
            <?php endif ?>
            <div class="padT5 profileAssets">
                <?php if ($_PROFILE->Info["i_gender"] != 0) : ?>
                    <span class="smallText"><?= $LANGS['gender'] ?>:</span> <b> <?php if ($_PROFILE->Info["i_gender"] == 1) : ?><?= $LANGS['male'] ?><?php else : ?><?= $LANGS['female'] ?><?php endif ?></b>
                <br>
                <?php endif ?>
                <?php if($_PROFILE->Info["i_country"] != null) : ?>
                <span class="smallText"><?= $LANGS['country'] ?>:</span> <b><?= $Channel_Country[$_PROFILE->Info["i_country"]] ?></b>
                <br>
                <?php endif ?>
                <?php if (!empty($_PROFILE->Info["i_hobbies"])) : ?>
                <span class="smallText"><?= $LANGS['hobbies'] ?>: </span> <b><?= $_PROFILE->Info["i_hobbies"] ?></b>
                <br>
                <?php endif ?>

                <?php if (!empty($_PROFILE->Info["i_movies"])) : ?>
                <span class="smallText"><?= $LANGS['movies'] ?>: </span> <b><?= $_PROFILE->Info["i_movies"] ?></b>
                <br>
                <?php endif ?>


                <?php if (!empty($_PROFILE->Info["i_music"])) : ?>
                <span class="smallText"><?= $LANGS['music'] ?>: </span> <b><?= $_PROFILE->Info["i_music"] ?></b>
                <br>
                <?php endif ?>

                <?php if (!empty($_PROFILE->Info["i_books"])) : ?>
                <span class="smallText"><?= $LANGS['books'] ?>: </span> <b><?= $_PROFILE->Info["i_books"] ?></b>
                <br>
                <?php endif ?>

                <!-- <span class="smallText">Country:</span> <b>United Sex of My Hamster</b>
                <br> -->

                <?php if ($_PROFILE->Info["i_relationship"] != 0) : ?>
                <span class="smallText"><?= $LANGS['status'] ?>:</span> <b><?php if ($_PROFILE->Info["i_relationship"] == 1 and $_PROFILE->Info["i_gender"] == 1) : ?><?= $LANGS['single_m'] ?><?php elseif ($_PROFILE->Info["i_relationship"] == 1 and $_PROFILE->Info["i_gender"] == 2) : ?><?= $LANGS['single_f'] ?><?php elseif ($_PROFILE->Info["i_relationship"] == 2 and $_PROFILE->Info["i_gender"] == 1) : ?><?= $LANGS['taken_m'] ?><?php elseif ($_PROFILE->Info["i_relationship"] == 2 and $_PROFILE->Info["i_gender"] == 2) : ?><?= $LANGS['taken_f'] ?><?php elseif ($_PROFILE->Info["i_relationship"] == 3 and $_PROFILE->Info["i_gender"] == 1) : ?><?= $LANGS['married_m'] ?><?php elseif ($_PROFILE->Info["i_relationship"] == 3 and $_PROFILE->Info["i_gender"] == 2) : ?><?= $LANGS['married_f'] ?><?php endif ?></b>
                <br>
                <?php endif ?>

                <?php if (!empty($_PROFILE->Info["i_website"])) : ?>
                <span class="smallText"><?= $LANGS['website'] ?>:</span> <b><a href="<?= $_PROFILE->Info["i_website"] ?>" name="" rel="nofollow"><?= $_PROFILE->Info["i_website"] ?></a></b>
                <br>
                <?php endif ?>

                <?php if (($_USER->Is_Admin || $_USER->Is_Moderator) && ($_PROFILE->Username != "vistafan12" && $_PROFILE->Username != "BitView") ) : ?>
                <span class="smallText">Manage: </span> <b><a href="/admin_panel/?page=users&ue=<?= $_PROFILE->Username ?>" name="" rel="nofollow">Edit User</a></b>
                <br>
                <?php endif ?>

            </div>
            
                                
<?php if ($Honor_Count > 1): ?>
    <span style="display:none"><?= $Honor_Count ?></span>
    <div class="padT10">
                <table cellspacing="0" cellpadding="0"><tbody><tr>
                    <td width="20" valign="top"><img src="/img/icn_award_17x24-vfl10931.gif" border="0"></td>
                    <td valign="top">
    <span id="BeginvidDeschonors" style="display:block">
                <?php $Count == 0; ?>
                <?php if ($Sub_Ranking <= 50): ?><a href="/channels">#<?= $Sub_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>)</a><br><?php $Count ++; ?><?php endif ?>

                <?php if ($Sub_Category_Ranking <= 50): ?><a href="/channels?type=<?= $_PROFILE->Info["type"] ?>">#<?= $Sub_Category_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>) - <?= $Honor_Type[$_PROFILE->Info["type"]] ?></a><br><?php $Count ++; ?><?php endif ?>

                <?php if ($_PROFILE->Info["is_partner"] and $Sub_Partner_Ranking <= 50): ?>
                <a href="/channels">#<?= $Sub_Partner_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>) - Partners</a><br><?php $Count ++; ?>
                <?php endif ?>

                <?php if ($Views_Ranking <= 50 and $Count < 3): ?><a href="/channels?order=views">#<?= $Views_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>)</a><br><?php $Count ++; ?><?php endif ?>

                <?php if ($Views_Category_Ranking <= 50 and $Count < 3): ?><a href="/channels?order=views&type=<?= $_PROFILE->Info["type"] ?>">#<?= $Views_Category_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>) - <?= $Honor_Type[$_PROFILE->Info["type"]] ?></a><br><?php $Count ++; ?><?php endif ?>

                <?php if ($_PROFILE->Info["is_partner"] and $Views_Partner_Ranking <= 50 and $Count < 3): ?>
                <a href="/channels?order=views">#<?= $Views_Partner_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>) - Partners</a><br><?php $Count ++; ?>
                <?php endif ?>
    </span>
    <span id="RemainvidDeschonors" style="display:none">
                <?php if ($Sub_Ranking <= 50): ?><a href="/channels">#<?= $Sub_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>)</a><br><?php endif ?>

                <?php if ($Sub_Category_Ranking <= 50): ?><a href="/channels?type=<?= $_PROFILE->Info["type"] ?>">#<?= $Sub_Category_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>) - <?= $Honor_Type[$_PROFILE->Info["type"]] ?></a><br><?php endif ?>

                <?php if ($_PROFILE->Info["is_partner"] and $Sub_Partner_Ranking <= 50): ?>
                <a href="/channels">#<?= $Sub_Partner_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>) - Partners</a><br>
                <?php endif ?>

                <?php if ($Views_Ranking <= 50): ?><a href="/channels?order=views">#<?= $Views_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>)</a><br><?php endif ?>

                <?php if ($Views_Category_Ranking <= 50): ?><a href="/channels?order=views&type=<?= $_PROFILE->Info["type"] ?>">#<?= $Views_Category_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>) - <?= $Honor_Type[$_PROFILE->Info["type"]] ?></a><br><?php endif ?>

                <?php if ($_PROFILE->Info["is_partner"] and $Views_Partner_Ranking <= 50): ?>
                <a href="/channels?order=views">#<?= $Views_Partner_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>) - Partners</a><br>
                <?php endif ?>
    </span>
    <?php if ($Honor_Count > 3): ?>
    <span id="MorevidDeschonors" style="display: block">(<a href="#" class="eLink" style="border-bottom: 1px dotted;text-decoration: none;" onclick="showhidehonors(); return false;"><?= $LANGS['dropdownmore'] ?></a>)</span>
    <span id="LessvidDeschonors" style="display: none">(<a href="#" class="eLink" style="border-bottom: 1px dotted;text-decoration: none;" onclick="showhidehonors(); return false;"><?= $LANGS['honorless'] ?></a>)</span>
<?php endif ?>
</td>
                </tr></tbody></table>
            </div>
<?php endif ?>
                    
        </div>
        <div class="highlightBoxesOpacity"></div>
              <div style="color:#<?= $_PROFILE->Info['c_header_font'] ?>!important"class="flaggingText"><a href="/help"><?= $LANGS['report'] ?></a> <?= $LANGS['pfpviolation'] ?></div>
    </div> <!-- end pBox-->
<?php if($_PROFILE->Info["is_partner"] AND $_PROFILE->Info["c_sideimage"]): ?>
<div class="partnerBanner">
<?php if($_PROFILE->Info["sideimage_link"]): ?>
<a href="<?= $_PROFILE->Info["sideimage_link"] ?>">
<img src="<?= cache_bust($_PROFILE->Info["c_sideimage"]) ?>" width="300" height="250">
</a>
<?php else: ?>
<img src="<?= cache_bust($_PROFILE->Info["c_sideimage"]) ?>" width="300" height="250">
<?php endif ?>
</div>
<?php endif ?>
        <div class="headerBox">     
            <div class="BoxesInnerOpacity">
            <div class="headerTitle"><?= $LANGS['connectwith'] ?> <?= displayname($_PROFILE->Username) ?></div>            
            </div>
        <div class="headerBoxOpacity"></div>
        </div>
        <div class="basicBoxes profileLeftCol" style="margin-bottom:15px;">
            <div class="BoxesInnerOpacity">
            <table width="100%" cellspacing="0" cellpadding="3" border="0">
            <tbody><tr>
                <td width="110" valign="middle" align="right">
                    <div class="user-thumb-partner">
                        <img src="<?= avatar($_PROFILE->Username) ?>" <?php if ($_PROFILE->Info["is_avatar_video"] == 1) : ?>class="avatarvideo"<?php endif ?> border="0">  
                    </div>
                </td>
                <td valign="top" align="left">
                    <table class="actionsTable">
                        <tbody><tr class="actionsTable">
                            <td class="actionsTable">
                                <div class="smallText">
                                <a id="aProfileSendMsg" <?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username) : ?> href="/send_message?to=<?= $_PROFILE->Username ?>" <?php else : ?>href="javascript:void(0)" onclick="<?if($_USER->Username == $_PROFILE->Username) :?>alert('<?= $LANGS['messagetoyourself'] ?>')<?else :?>alert('<?= $LANGS['logintomessage'] ?>')<?endif?>"<?php endif ?>><img src="/img/pixel.gif" id="profileSendMsg" class="icnProperties" alt="<?= $LANGS['profilesendmessage'] ?>"><?= $LANGS['profilesendmessage'] ?></a>
                                </div>
                                <div class="smallText">
                                    <a id="aProfileAddComment" <?php if ($_USER->Logged_In) : ?>href="<?= $_PROFILE->Username ?>&page=post_comment" <?php else : ?>href="javascript:void(0)" onclick="alert('<?= $LANGS['logintocommentchannel'] ?>')"<?php endif ?>><img src="/img/pixel.gif" id="profileAddComment" class="icnProperties" alt="<?= $LANGS['addcomment'] ?>"><?= $LANGS['addcomment'] ?></a>
                                </div>

                                <div class="smallText">
                                    <a id="aProfileFwdMember" style="color: #<?= $_PROFILE->Info["c_link_color"] ?>; cursor: pointer" onclick="showhideshare();"><img src="/img/pixel.gif" id="profileFwdMember" class="icnProperties" alt="Share Channel"><?= $LANGS['sharechannel'] ?></a>
                                </div>
                                <div class="smallText">
                                </div>
                                <div class="smallText">
                                    <?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username) : ?>
                                    <?php if (!isset($Friend_Status) || $Friend_Status === false) : ?>
                                    <a id="aProfileAddFriend" href="/my_friends_invite?user=<?= $_PROFILE->Username ?>"><img src="/img/pixel.gif" id="profileAddFriend" class="icnProperties" alt="<?= $LANGS['addfriend'] ?>"><?= $LANGS['addfriend'] ?></a>
                                    <?php elseif ($Friend_Status == 0) : ?>
                                    <a id="aProfileRemoveFriend" href="/my_friends_invite?retract=<?= $Friend_ID ?>"><img src="/img/pixel.gif" id="profileRemoveFriend" class="icnProperties" alt="<?= $LANGS['retractinvite'] ?>"><?= $LANGS['retractinvite'] ?></a>
                                    <?php else : ?>
                                    <a id="aProfileRemoveFriend" href="/my_friends?remove=<?= $_PROFILE->Username?>"><img src="/img/pixel.gif" id="profileRemoveFriend" class="icnProperties" alt="<?= $LANGS['removefriend'] ?>"><?= $LANGS['removefriend'] ?></a>
                                    <?php endif ?>
                                    <?php elseif (!$_USER->Logged_In) : ?>
                                    <a id="aProfileAddFriend" href="javascript:void(0)" onclick="alert('<?= $LANGS['logintofriend'] ?>')"><img src="/img/pixel.gif" id="profileAddFriend" class="icnProperties" alt="<?= $LANGS['addfriend'] ?>"><?= $LANGS['addfriend'] ?></a>
                                    <?php else : ?>
                                    <a id="aProfileAddFriend" href="javascript:void(0)" onclick="alert('<?= $LANGS['notfriendyourself'] ?>')"><img src="/img/pixel.gif" id="profileAddFriend" class="icnProperties" alt="<?= $LANGS['addfriend'] ?>"><?= $LANGS['addfriend'] ?></a>
                                    <?php endif ?> 
                                </div>
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="marB3 alignC"><a href="/user/<?= $_PROFILE->Username ?>">http://www.bitview.net/user/<?= $_PROFILE->Username ?></a></div>
                    <div class="share-box" id="sharing_opt" style="display: none;">
                                <div class="box-title" style="float: left">
                                    <div class="title-text"><?= $LANGS['sharingoptions'] ?></div>
                                    <div class="close-link hand" onclick="showhideshare();"> (<?= $LANGS['close'] ?>) </div>
                                </div>
                                <div style="padding: 0 5px;"><?= $LANGS['sharingoptionsdesc'] ?></div>
                                <div style="padding: 15px 5px 0 5px;"><?= $LANGS['sharingoptions1'] ?>
                    <form name="urlForm">
                    <input name="video_link" type="text" value="http://www.bitview.net/user/<?= $_PROFILE->Username ?>" class="vidURLField" onclick="javascript:document.urlForm.video_link.focus();document.urlForm.video_link.select();" readonly="true" size="35" style="width:255px">
                    </form>
                                </div>
                                <div style="padding: 15px 0 5px 5px;">
                                <?= $LANGS['sharingoptions2'] ?>
                                <a href="mailto:/?subject=You%20have%20received%20a%BitView%20channel%21&amp;body=http%3A//www.bitview.net/user/<?= $_PROFILE->Username ?>"><?= $LANGS['clicktosend'] ?></a>
                                </div>
                            </div>
                    <div class="igoogleEmbed" style="margin-bottom: 2px;">
        <div style="margin-top: 12px;"><?= $LANGS['channelembed'] ?>:</div>
        <form action="" name="embedForm" id="embedForm">
        <input id="embed_code" name="embed_code" type="text" value='<iframe frameborder="0" scrolling="no" src="http://www.bitview.net/embeds/videos?user=<?= $_PROFILE->Username ?>" width="400" height="460"></iframe>' onclick="javascript:document.embedForm.embed_code.focus();document.embedForm.embed_code.select();" readonly=""></div>
    </form>
    </div>
                </td>                                               
            </tr>
            </tbody></table>
            </div>
            <div class="basicBoxesOpacity"></div>
        </div>



<?php if ($_PROFILE->Info["c_ratings_box"] != 0) : ?>
        <div class="headerBox">
            <div class="BoxesInnerOpacity">
                    <div class="headerTitle"><?= $LANGS['recentratings'] ?></div>
            </div>
            <div class="headerBoxOpacity"></div>
        </div>
        <div class="basicBoxes profileLeftCol" style="margin-bottom:15px;">
        <div class="BoxesInnerOpacity" style="padding: 5px;">
        <table id="feed_table">
        <tbody>
            <?php if (count($Recent_Activity) > 0) : ?>
                    <?php $Amount = count($Recent_Activity) ?>
                    <?php $Count = 0 ?>
                    <?php foreach ($Recent_Activity as $Activity) : ?>
                        <?php $Count++ ?>
                        <?php if ($Activity["type_name"] == "comment") : ?>
                            <tr id="feed_item_<?= $Activity['id'] ?>" valign="top">
                                <td class="feed_icon">
                                    <img class="icon-C" src="/img/pixel.gif">
                                </td>
                                <td>
                                    <div class="feed_title"><?= displayname($_PROFILE->Username) ?> <?= $LANGS['activitycomment'] ?> <a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><?= $Activity['title'] ?></a>
                                    <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    </div>
                                    <div class="centerpiece">
                                        <div style="float:left; margin-right: 8px;"><a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><img style="width: 60px; height: 45px; border: 1px solid #999;"<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Activity["id"].'.jpg')): ?>src="/u/thmp/<?= $Activity["id"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?>></a></div>
                                            <div>
                                <span id="feed_item_j_<?= $Count ?>_collapsed" style="display: block;"><i>"<?= short_title($Activity['content'],80) ?>"</i>&nbsp;
                    <?php if (mb_strlen((string) $Activity['content']) > 80): ?>
                        <a href="#" onclick="showHide<?= $Count ?>(); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['dropdownmore'] ?></a>
                        </span>
                        <span id="feed_item_j_<?= $Count ?>_expanded" style="display:none">
            <i>"<?= nl2br((string) $Activity['content']) ?>"</i>
                        &nbsp;
                        <a href="#" onclick="showHide<?= $Count ?>(); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['honorless'] ?></a>
                    <?php endif ?>
                    </div>

                                    </div>
                                </td>
                                <td class="feed_delete">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr id="feed_divider_<?= $Activity['id'] ?>" class="divider">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                        <?php elseif ($Activity["type_name"] == "bulletin") : ?>
                            <tr id="feed_item_<?= $Activity['id'] ?>" valign="top">
                                <td class="feed_icon">
                                    <img class="icon-BUL" src="/img/pixel.gif">
                                </td>
                                <td>
                                    <div class="feed_title"><a href="/user/<?= $_PROFILE->Username ?>&page=bulletin&id=<?= $Activity['id'] ?>" rel="nofollow"><?= $Activity['title'] ?></a>
                                    <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    </div>
                                    <div class="centerpiece">
                                    <div>
                                <span id="feed_item_j_<?= $Count ?>_collapsed" style="display: block;"><?= short_title($Activity['content'],80) ?>&nbsp;
                    <?php if (mb_strlen((string) $Activity['content']) > 80): ?>
                        <a href="#" onclick="showHide<?= $Count ?>(); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['dropdownmore'] ?></a>
                        </span>
                        <span id="feed_item_j_<?= $Count ?>_expanded" style="display:none">
            <?= nl2br((string) $Activity['content']) ?>
                        &nbsp;
                        <a href="#" onclick="showHide<?= $Count ?>(); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['honorless'] ?></a>
                    <?php endif ?>
                    </div>
                        </div>
                                </td>
                                <td class="feed_delete">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr id="feed_divider_<?= $Activity['id'] ?>" class="divider">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                        <?php elseif ($Activity["type_name"] == "favorite") : ?>
                            <tr id="feed_item_<?= $Activity['id'] ?>" valign="top">
                                <td class="feed_icon">
                                    <img class="icon-F" src="/img/pixel.gif">
                                </td>
                                <td>
                                    <div class="feed_title"><?= displayname($_PROFILE->Username) ?> <?= $LANGS['activityfavorite'] ?></div>
                                    <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    </div>
                                    <div class="centerpiece">
                                        <div style="float:left; margin-right: 8px;"><a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><img style="width: 60px; height: 45px; border: 1px solid #999;" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Activity["id"].'.jpg')): ?>src="/u/thmp/<?= $Activity["id"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?>></a></div>
                                        <div>
                                        <a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><?= short_title($Activity['title'],24) ?></a>
                                    </div>
                                    <div>
                                <span id="feed_item_j_<?= $Count ?>_collapsed" style="display: block;"><?= short_title($Activity['content'],80) ?>&nbsp;
                    <?php if (mb_strlen((string) $Activity['content']) > 80): ?>
                        <a href="#" onclick="showHide<?= $Count ?>(); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['dropdownmore'] ?></a>
                        </span>
                        <span id="feed_item_j_<?= $Count ?>_expanded" style="display:none">
            <?= nl2br((string) $Activity['content']) ?>
                        &nbsp;
                        <a href="#" onclick="showHide<?= $Count ?>(); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['honorless'] ?></a>
                    <?php endif ?>
                    </div>
                        </div>
                                </td>
                                <td class="feed_delete">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr id="feed_divider_<?= $Activity['id'] ?>" class="divider">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                        <?php elseif ($Activity["type_name"] == "rating") : ?>
                            <tr id="feed_item_<?= $Activity['id'] ?>" valign="top">
                                <td class="feed_icon">
                                    <img class="icon-E" src="/img/pixel.gif">
                                </td>
                                <td>
                                    <div class="feed_title"><?= displayname($_PROFILE->Username) ?> <?= $LANGS['activityrating'] ?> 
                                        <span style="white-space: nowrap;vertical-align: middle;"><span class="video-ratings" style="display: inline-block;margin: 0;padding: 2px 4px 0px 2px;height: 14px;"><?= show_ratings($Activity["rating"],"12px","12px") ?></span></span>
                                    </div>
                                    <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    </div>
                                    <div class="centerpiece">
                                        <div style="float:left; margin-right: 8px;"><a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><img style="width: 60px; height: 45px; border: 1px solid #999;" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Activity["id"].'.jpg')): ?>src="/u/thmp/<?= $Activity["id"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?>></a></div>
                                        <div>
                                        <a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><?= short_title($Activity['title'],24) ?></a>
                                    </div>
                                    <div>
                                <span id="feed_item_j_<?= $Count ?>_collapsed" style="display: block;"><?= short_title($Activity['content'],80) ?>&nbsp;
                    <?php if (mb_strlen((string) $Activity['content']) > 80): ?>
                        <a href="#" onclick="showHide<?= $Count ?>(); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['dropdownmore'] ?></a>
                        </span>
                        <span id="feed_item_j_<?= $Count ?>_expanded" style="display:none">
            <?= nl2br((string) $Activity['content']) ?>
                        &nbsp;
                        <a href="#" onclick="showHide<?= $Count ?>(); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['honorless'] ?></a>
                    <?php endif ?>
                    </div>
                        </div>
                                </td>
                                <td class="feed_delete">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr id="feed_divider_<?= $Activity['id'] ?>" class="divider">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                        <?php elseif ($Activity["type_name"] == "uploaded") : ?>
                            <tr id="feed_item_<?= $Activity['id'] ?>" valign="top">
                                <td class="feed_icon">
                                    <img class="icon-U" src="/img/pixel.gif">
                                </td>
                                <td>
                                    <div class="feed_title"><?= displayname($_PROFILE->Username) ?> <?= $LANGS['activityupload'] ?></div>
                                    <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    </div>
                                    <div class="centerpiece">
                                        <div style="float:left; margin-right: 8px;"><a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><img style="width: 60px; height: 45px; border: 1px solid #999;" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Activity["id"].'.jpg')): ?>src="/u/thmp/<?= $Activity["id"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?>></a></div>
                                        <div>
                                        <a href="/watch?v=<?= $Activity['id'] ?>" rel="nofollow"><?= short_title($Activity['title'],24) ?></a>
                                    </div>
                                    <div>
                                <span id="feed_item_j_<?= $Count ?>_collapsed" style="display: block;"><?= short_title($Activity['content'],80) ?>&nbsp;
                    <?php if (mb_strlen((string) $Activity['content']) > 80): ?>
                        <a href="#" onclick="showHide<?= $Count ?>(); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['dropdownmore'] ?></a>
                        </span>
                        <span id="feed_item_j_<?= $Count ?>_expanded" style="display:none">
            <?= nl2br((string) $Activity['content']) ?>
                        &nbsp;
                        <a href="#" onclick="showHide<?= $Count ?>(); return false;" style="font-size: 10px;border-bottom: 1px dotted #<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration: none;" class="eLink"><?= $LANGS['honorless'] ?></a>
                    <?php endif ?>
                    </div>
                        </div>
                                </td>
                                <td class="feed_delete">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr id="feed_divider_<?= $Activity['id'] ?>" class="divider">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <?php elseif ($Activity["type_name"] == "friend") : ?>
                                <tr id="feed_item_<?= $Count ?>" valign="top">
        <td class="feed_icon">
            <img class="icon-FRI" src="/img/pixel.gif">
        </td>
        <td>
            <div class="feed_title">

<?= displayname($_PROFILE->Username) ?> <?= $LANGS['activityfriend'] ?> <?php if ($Activity["content"] != $_PROFILE->Username) : ?><a href="/user/<?= $Activity["content"] ?>"><?= $Activity["content"] ?></a><?php else : ?><a href="/user/<?= $Activity["id"] ?>"><?= $Activity["id"] ?></a><?php endif ?>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
            </div>
        </td>
        <td class="feed_delete">
            &nbsp;

        </td>
    </tr>
    <tr id="feed_divider_<?= $Count ?>" class="divider">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                        <?php elseif ($Activity["type_name"] == "subscription") : ?>
                                <tr id="feed_item_<?= $Count ?>" valign="top">
        <td class="feed_icon">
            <img class="icon-S" src="/img/pixel.gif">
        </td>
        <td>
            <div class="feed_title">

<?= displayname($_PROFILE->Username) ?> <?= $LANGS['activitysubscription'] ?> <?php if ($Activity["content"] != $_PROFILE->Username) : ?><a href="/user/<?= $Activity["content"] ?>"><?= $Activity["content"] ?></a><?php else : ?><a href="/user/<?= $Activity["id"] ?>"><?= $Activity["id"] ?></a><?php endif ?>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
            </div>
        </td>
        <td class="feed_delete">
            &nbsp;

        </td>
    </tr>
    <tr id="feed_divider_<?= $Count ?>" class="divider">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php else : ?>
                    <div class="alignC" style="margin: 20px;"><?= $LANGS['norecentratings'] ?></div>
                <?php endif ?>
            </tbody></table>
            <div class="basicBoxesOpacity"></div>
        </tbody>
    </table>
        </div>
        </div>

<?php endif ?>

        <?php if ($_PROFILE->Info["c_subscriptions_box"] != 0) : ?>
            <div class="headerBox"><div class="boxesInnerOpacity">
            <div class="headerTitle"><span><?= $LANGS['subscriptions'] ?> (<a href="/user/<?= $_PROFILE->Username ?>&page=subscriptions" class="headersSmall"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["subscriptions"]) ?><?php else: ?><?= ($_PROFILE->Info["subscriptions"]) ?><?php endif ?></a>)</span></div>                      
</div><div class="headerBoxOpacity"></div></div>
            <div id="channelsBox" class="basicBoxes profileLeftCol">
                <div class="BoxesInnerOpacity">
                <?php if ($Users_Subscriptions_Main > 0) : ?>
                <table width="100%" border="0" align="center">
                <tbody>
                    <?php $Count = 0; ?>
                    <tr>
                    <?php foreach ($Users_Subscriptions_Main as $User) : ?>
                    <?php $Count++ ?>
                    <td width="33%" align="center">                 
                    <div class="marB5">
                        <div class="user-thumb-large">
                            <a href="/user/<?= $User["username"] ?>"><img src="<?= avatar($User["username"]) ?>"></a>
                        </div>
                                <a href="/user/<?= $User["username"] ?>"><?= displayname($User["username"]) ?></a>

                    </div>
                    </td>
                    <?php unset($Avatar) ?>
                    <?php if ($Count == 3) : ?>
                    </tr>
                    <?php $Count = 0 ?>
                    <?php endif ?>
                    <?php endforeach ?>
                    </tr>
                <tr>
                    <td colspan="3">
                        <div style="text-align:right;margin:3px;font-weight: bold;"><a style="font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif" href="/user/<?= $_PROFILE->Username ?>&page=subscriptions"><?= $LANGS['seeall'] ?></a></div>
                    </td>
                </tr>
            </tbody></table>
            <?php else : ?>
                <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 29px"><?= $LANGS['nosubscriptions'] ?></div>
            <?php endif ?>
            <div style="clear:both"></div>
            </div>
            <div class="basicBoxesOpacity"></div>
            </div>

<?php endif ?>

<?php if ($_PROFILE->Info["c_subscribers_box"] != 0) : ?>
            <div class="headerBox"><div class="boxesInnerOpacity">              
            <div class="headerTitle">
                    <span><?= $LANGS['channelsubscribers'] ?> (<a href="/user/<?= $_PROFILE->Username ?>&page=subscribers" class="headersSmall"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["subscribers"]) ?><?php else: ?><?= ($_PROFILE->Info["subscribers"]) ?><?php endif ?></a>)</span>
            </div></div>
<div class="headerBoxOpacity"></div></div>
            <div id="channelsBox" class="basicBoxes profileLeftCol">
                <div class="BoxesInnerOpacity">
                    <?php if ($Users_Subscribers_Main > 0) : ?>
                    <table width="100%" border="0" align="center">
                            <tbody>
                            <?php $Count = 0; ?>
                            <tr>
                            <?php foreach ($Users_Subscribers_Main as $User) : ?>
                            <?php $Count++ ?>
                            <td width="33%" align="center">
                                <div class="marB5">
                                    <div class="user-thumb-large">
                                        <a href="/user/<?= $User["username"] ?>"><img src="<?= avatar($User["username"]) ?>"></a>
                                    </div>
                                    <a href="/user/<?= $User["username"] ?>"><?= displayname($User["username"]) ?></a>
                                </div>
                            </td>
                            <?php unset($Avatar) ?>
                            <?php if ($Count == 3) : ?>
                            </tr>
                            <?php $Count = 0 ?>
                            <?php endif ?>
                            <?php endforeach ?>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div style="text-align:right;margin:3px;font-weight: bold;"><a style="font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif" href="/user/<?= $_PROFILE->Username ?>&page=subscribers"><?= $LANGS['seeall'] ?></a></div>
                            </td>
                        </tr>
                    </tbody></table>
                <?php else : ?>
                    <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 29px"><?= $LANGS['nosubscribers'] ?></div>
                <?php endif ?>
                    <div style="clear:both"></div>
                </div>
                <div class="basicBoxesOpacity"></div>
            </div>
    <?php endif ?>
<?php if ($_PROFILE->Info["c_friends_box"] != 0) : ?>
            <div class="headerBox"><div class="boxesInnerOpacity">              
            <div class="headerTitle">
                    <span><?= $LANGS['friends'] ?> (<a href="/user/<?= $_PROFILE->Username ?>&page=friends" class="headersSmall"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["friends"]) ?><?php else: ?><?= ($_PROFILE->Info["friends"]) ?><?php endif ?></a>)</span>
            </div></div>
<div class="headerBoxOpacity"></div></div>
            <div id="channelsBox" class="basicBoxes profileLeftCol">
                <div class="BoxesInnerOpacity">
                    <?php if ($Users_Friends_Main > 0) : ?>
                    <table width="100%" border="0" align="center">
                            <tbody>
                            <?php $Count = 0; ?>
                            <tr>
                            <?php foreach ($Users_Friends_Main as $User) : ?>
                            <?php $Count++ ?>
                            <td width="33%" align="center">
                                <div class="marB5">
                                    <div class="user-thumb-large">
                                        <a href="/user/<?= $User["username"] ?>"><img src="<?= avatar($User["username"]) ?>"></a>
                                    </div>
                                    <a href="/user/<?= $User["username"] ?>"><?= displayname($User["username"]) ?></a>
                                </div>
                            </td>
                            <?php unset($Avatar) ?>
                            <?php if ($Count == 3) : ?>
                            </tr>
                            <?php $Count = 0 ?>
                            <?php endif ?>
                            <?php endforeach ?>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div style="text-align:right;margin:3px;font-weight: bold;"><a style="font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif" href="/user/<?= $_PROFILE->Username ?>&page=friends"><?= $LANGS['seeall'] ?></a></div>
                            </td>
                        </tr>
                    </tbody></table>
                <?php else : ?>
                    <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 29px"><?= $LANGS['nofriends'] ?></div>
                <?php endif ?>
                    <div style="clear:both"></div>
                </div>
                <div class="basicBoxesOpacity"></div>
            </div>
    <?php endif ?>
    <?php if ($_PROFILE->Info["c_bulletins_box"] != 0) : ?>
    <!--Begin Bulletin Board Box-->
            <div class="headerBox"><div class="boxesInnerOpacity">          <div class="headerTitle">
                <span><?= $LANGS['bulletins'] ?> (<a href="/user/<?= $_PROFILE->Username ?>&page=bulletins" class="headersSmall"><?= $Bulletin_Amount ?></a>)</span>
                <?php if (!$_USER->Logged_In || $_USER->Username != $_PROFILE->Username) : ?>
                <?php else : ?>
                <div style="float: right; padding-right: 5px"><a id="write-bulletin" href="/user/<?= $_USER->Username ?>&page=write_bulletin" class="edit"><?= $LANGS['writebulletin'] ?></a></div>
                <?php endif ?>
            </div>                      
</div><div class="headerBoxOpacity"></div></div>
            <div id="bulletinBox" class="basicBoxes profileLeftCol">
                <div class="BoxesInnerOpacity">
                <table class="bulletinTable" width="300">
                    <tbody>
                    <?php if ($Bulletins) : ?>
                    <tr class="bulletinTable">
                        <td class="firstCol"><strong><?= $LANGS['from'] ?></strong></td>
                        <td><strong><?= $LANGS['bulletin'] ?></strong></td>
                    </tr> 
                    
                    <?php foreach ($Bulletins as $Bulletin) : ?>
                        <tr class="bulletinTable">
                                <td class="firstCol" width="35%"><a href="/user/<?= $Bulletin["by_user"] ?>" rel="nofollow"><?= displayname($Bulletin["by_user"]) ?></a>
                                <div class="xsmallText">
                                    <?php if (isset($_COOKIE['time_machine'])): ?>
                                    <?= date($LANGS['timenumberformat'], time_machine(strtotime((string) $Bulletin["submit_date"]))) ?></div></td>
                                <?php else: ?>
                                    <?= date($LANGS['timenumberformat'], strtotime((string) $Bulletin["submit_date"])) ?></div></td>
                                <?php endif ?>
                                <td align="left">
                                    <div><a href="/user/<?= $_PROFILE->Username ?>&page=bulletin&id=<?= $Bulletin["id"] ?>" rel="nofollow"><?= short_title($Bulletin["subject"], 20) ?></a></div>
                                </td>
                        </tr>
                    <?php endforeach ?>
                    <tr class="bulletinTable">
                        <td colspan="3" align="center" style="border-bottom:0!important;font-weight: bold;text-align: right;padding:4px 8px;">
                            <span><a style="font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif" href="/user/<?= $_PROFILE->Username ?>&page=bulletins"><?= $LANGS['seeall'] ?></a></span>
                        </td>
                    </tr>
                    <?php else : ?>
                    <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 29px"><?= $LANGS['nobulletins'] ?></div>
                    <?php endif ?>
                </tbody></table>
                </div>
                <div class="basicBoxesOpacity"></div>
            </div>
    <!--End Bulletin board Box-->
<?php endif ?>
    <!--Begin Comments Box-->
<!--End Comments Box-->
</div>
<!--End Left Column-->
    
<!--Begin Right Column-->
<div class="channelRightColumn">
    <?php if ($_PROFILE->Info["c_bigvideo_box"] != 0) : ?>
    <?php if ($LatVideo > 0) : ?>
    <?php foreach ($LatVideo as $Video) : ?>
        <div class="profileEmbedVideo">
            <center>
            <div <?php if (!isset($_COOKIE["html5_player"])) : ?>style="width: 640; height: 360px; text-align: center"<?php else: ?>style="width: 640; height: 385px; text-align: center"<?php endif ?>>
                <?php
                $_VIDEO = new Video($Video["url"],$DB);

                if ($_VIDEO->exists()) {
                $_VIDEO->get_info();
                } 
                
                ?>
		<?php if (!isset($_COOKIE["html5_player"])) : ?>
            <?php $_VIDEO->show_video(640,385,true,$LANGS); ?>
        <?php else : ?>
            <object width="640" height="385" class="fl flash-video"><param name="movie" value="/player.swf?video_id=<?= $Video["file_url"] ?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" 	width="640" height="385" class="fl"></object>
        <?php endif ?>
            </div>
        </center>
        <center>
        <div class="basicBoxes profileEmbedVideoInfo">
        <div class="BoxesInnerOpacity">
        <table cellspacing="2" cellpadding="5" border="0">
            <tbody>
                <tr>
                <td width="424" valign="top">
                    <div class="floatL">
                        <div class="vtitle"><b><a href="/watch?v=<?= $Video["url"] ?>"><?= $Video["title"] ?></a></b></div>
                        <div class="vfacets">
                            <?= $LANGS['from'] ?>: <a href="/user/<?= $Video["uploaded_by"] ?>"><?= displayname($Video["uploaded_by"]) ?></a>
                            <br>
                            <?= $LANGS['cstatviews'] ?>: <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?>
                            <br>
                                <?= $LANGS['statcomments'] ?>: <a href="/watch?v=<?= $Video["url"] ?>&c=all"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["comments"]) ?><?php else: ?><?= ($Video["comments"]) ?><?php endif ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody></table>
        </div>
        <div class="basicBoxesOpacity"></div>
        </div>
        </center>
        </div>
    <?php endforeach ?>
    <?php else : ?>
    <?php endif ?>
    <?php endif ?>

    <?php if ($_PROFILE->Info["c_custom_box"] != 0 AND $_PROFILE->Info["is_partner"]) : ?>
    <div class="headerBox">     
            <div class="BoxesInnerOpacity">
            <div class="headerTitle"><?= $_PROFILE->Info["custom_box_title"] ?></div>            
            </div>
        <div class="headerBoxOpacity"></div>
        </div>
        <div class="basicBoxes profileRightCol" style="margin-bottom:15px;">
            <div class="BoxesInnerOpacity">
            <div class="customContent" style="padding:5px">
            <?= make_links_clickable(nl2br((string) $_PROFILE->Info["custom_box"])) ?>
        </div>
            </div>
            <div class="basicBoxesOpacity"></div>
        </div>
    <?php endif ?>

    <?php if ($_PROFILE->Info["c_videos_box"] != 0) : ?>
    <!--Begin Videos Scroller Box-->
            <div class="headerBox">
            <div class="boxesInnerOpacity">         
            <div class="headerTitle">
                <span><?= $LANGS['videos'] ?> (<a href="/user/<?= $_PROFILE->Username ?>&page=videos" class="headersSmall"><?= $_PROFILE->Info["videos"] ?></a>)</span><div class="headerTitleRight">
        <?php if(!$_USER->is_subscribed($_PROFILE)) : ?>
                <a <?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username) : ?>href="/a/subscription_center?user=<?= $_PROFILE->Username ?>"<?php elseif (!$_USER->Logged_In) : ?>href="javascript:void(0)" onclick="alert('<?= $LANGS['logintosub'] ?>')"<?php else : ?>href="/my_account"<?php endif ?> class="action-button" title="subscribe to <?= $_PROFILE->Username ?>'s videos"><?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username) : ?><?= $LANGS['subvideos1'] ?><?= displayname($_PROFILE->Username) ?><?= $LANGS['subvideos2'] ?><?php elseif (!$_USER->Logged_In) : ?><?= $LANGS['subvideos1'] ?><?= displayname($_PROFILE->Username) ?><?= $LANGS['subvideos2'] ?><?php endif ?></a>
        <?php else : ?>
                <a href="/a/subscription_center?user=<?= $_PROFILE->Username ?>" class="action-button" onclick=""><?= $LANGS['unsubscribe'] ?></a>
        <?php endif ?>
        </div>
            </div>  
</div><div class="headerBoxOpacity"></div></div>
            <div class="basicBoxes scrollersBox profileRightCol">
                <div class="BoxesInnerOpacity">
                    <div id="profileVideos"><div style="padding:5px;">
    </div>
    <?php if ($_PROFILE->Info["videos"] > 0) : ?>
        <div class="alignC floatL" style="margin: 5px 0 5px 12px;font-size: 12px;">
                <span id="videosRecentSpan"><?= $LANGS['videos'] ?></span>
            | 
                <a id="videosViewedLink" href="/user/<?= $_PROFILE->Username ?>&page=videos&t=2"><?= $LANGS['mostviewed'] ?></a>
                | 
                    <a href="/user/<?= $_PROFILE->Username ?>&page=videos&t=3"><?= $LANGS['mostdiscussed'] ?></a>
        </div>
                <div style="float:right;margin: 4px 15px 15px 0">
                    <form action="/profile" method="GET" style="position:relative;bottom:1px">
                        <input type="hidden" name="user" value="<?= $_PROFILE->Username ?>">
                        <input type="hidden" name="page" value="videos">
                        <input type="text" maxlength="20" style="font-size:12px" name="query"<?php if (isset($_GET["query"])) : ?> value="<?= $_GET["query"] ?>"<?php endif ?>> <input style="font-size: 12px"type="submit" value="<?= $LANGS['search'] ?>">
                    </form>
                </div>
                        <table width="628" border="0" align="center">
        <tbody>
        <tr style="height:1px;">
        <td width="170"></td><td width="170"></td><td width="170"></td>
    </tr>
    <tr>
        </tr>
    <?php $Count = 0; ?>
        <tr>
        <?php foreach ($Videos as $Video) : ?>
        <?php $Count++ ?>
        <td width="170" valign="top" align="center">
            <div class="video-cell">
                



    <div class="video-entry">



            <div class="v120WideEntry"><div class="v120WrapperOuter"><div class="v120WrapperInner"><a href="<?= $Video["link"] ?>" rel="nofollow"><img title="<?= $Video["title"] ?>" src="<?= $Video["thumb"] ?>" class="vimg120" alt="<?= $Video["title"] ?>"></a><div class="video-time"><span id="video-run-time"><?= timestamp($Video["length"]) ?></span></div>
</div></div></div>

        <div class="video-main-content">


            <div class="video-title ">
                <div class="video-title">
                    <a href="<?= $Video["link"] ?>" title="<?= $Video["title"] ?>" rel="nofollow"><?= $Video["title"] ?></a>
                </div>
            </div>
            <div class="video-facets">

                    <span id="video-average-rating-SFfkDAqMPF8" class="video-rating-list video-rating-with-caps">
                                    

    <div>
    </div>


                    </span>

                        <span id="video-added-time" class="video-date-added"><?= get_time_ago($Video["uploaded_on"]) ?></span>

                    <span id="video-num-views" class="video-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>

                    <span class="video-username"><a id="video-from-username-SFfkDAqMPF8" class="hLink" href="<?= $Video["uploader_link"] ?>"><?= displayname($Video["uploaded_by"]) ?></a></span>

                    <span id="video-average-rating-SFfkDAqMPF8" class="video-rating-grid video-rating-with-caps">
                                    

    <div>

    
<div class="video-ratings"><?php show_ratings($Video,"12px","12px") ?></div>



    </div>


                    </span>


            </div>  

        </div>  
        <div class="video-clear-list-left"></div>



    </div>  

        </div>
    </td>
    <?php if ($Count == 3) : ?>
    </tr>
    <?php $Count = 0 ?>
     <?php endif ?>
    <?php endforeach ?>
    </tr>
    <tr>
        <td colspan="3" align="right">
            <b><a style="font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif" href="/user/<?= $_PROFILE->Username ?>&page=videos"><?= $LANGS['seeall'] ?></a></b>
        </td>
    </tr>
</tbody></table>
                <?php else : ?>
                    <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 29px"><?= $LANGS['novideoschannel'] ?></div>
                <?php endif ?>

                    </div>
                </div>
                <div class="basicBoxesOpacity"></div>
            </div>
                
                <?php endif ?>
    <!-- Begin Video Log Box-->
    <!--End Video Log Box-->
                    

    <!--Begin If No Favorites Empty Set Box-->
    <!--End If No Favorites Empty Set Box-->


    <?php if ($_PROFILE->Info["c_favorites_box"] != 0) : ?>  
    <!--Begin Favorites Box-->
            <div class="headerBox"><div class="boxesInnerOpacity">
            <div class="headerTitle">
                <div class="headerTitleRight">
            </div>
                <span><?= $LANGS['favorites'] ?> (<a href="/user/<?= $_PROFILE->Username ?>&page=favorites" class="headersSmall"><?= $_PROFILE->Info["favorites"] ?></a>)</span>
            </div>  
</div><div class="headerBoxOpacity"></div></div>
            <div class="basicBoxes scrollersBox profileRightCol">
                <div class="BoxesInnerOpacity">
                <?php if ($_PROFILE->Info["favorites"] > 0) : ?>
                    <table width="628" border="0" align="center">
        <tbody>
        <tr style="height:1px;">
        <td></td><td></td><td></td>
    </tr>
    <?php $Count = 0; ?>
        <tr>
        <?php foreach ($FavVideos as $Video) : ?>
        <?php $Count++ ?>
        <td width="170" valign="top" align="center">
        <div class="video-cell">
                



    <div class="video-entry">



            <div class="v120WideEntry"><div class="v120WrapperOuter"><div class="v120WrapperInner"><a href="/watch?v=<?= $Video["url"] ?>" rel="nofollow"><img title="<?= $Video["title"] ?>" src="/u/thmp/<?= $Video["url"] ?>.jpg" class="vimg120" alt="<?= $Video["title"] ?>"></a><div class="video-time"><span id="video-run-time"><?= timestamp($Video["length"]) ?></span></div>
</div></div></div>

        <div class="video-main-content">


            <div class="video-title ">
                <div class="video-title">
                    <a href="/watch?v=<?= $Video["url"] ?>" title="<?= $Video["title"] ?>" rel="nofollow"><?= $Video["title"] ?></a>
                </div>
            </div>
            <div class="video-facets">

                    <span id="video-average-rating" class="video-rating-list video-rating-with-caps">
                                    

    <div>
    </div>


                    </span>

                        <span id="video-added-time" class="video-date-added"><?= get_time_ago($Video["uploaded_on"]) ?></span>

                    <span id="video-num-views" class="video-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>

                    <span class="video-username"><a class="hLink" href="/user/<?= $Video["uploaded_by"] ?>"><?= displayname($Video["uploaded_by"]) ?></a></span>

                    <span id="video-average-rating-SFfkDAqMPF8" class="video-rating-grid video-rating-with-caps">
                                    

    <div>

    
<div class="video-ratings"><?php show_ratings($Video,"12px","12px") ?></div>



    </div>


                    </span>


            </div>  

        </div>  
        <div class="video-clear-list-left"></div>



    </div>  

        </div>
    </td>
    <?php if ($Count == 3) : ?>
    </tr>
    <?php $Count = 0 ?>
     <?php endif ?>
    <?php endforeach ?>
    </tr>
    <tr>
        <td colspan="3" align="right">
            <b><a style="font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif" href="/user/<?= $_PROFILE->Username ?>&page=favorites"><?= $LANGS['seeall'] ?></a></b>
        </td>
    </tr>
</tbody></table>
                <?php else : ?>
                    <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 29px"><?= $LANGS['nofavs'] ?></div>
                <?php endif ?>

                </div>
                <div class="basicBoxesOpacity"></div>

            </div>
    <!--End Favorites Box-->
<?php endif ?>


<?php if ($_PROFILE->Info["c_playlists_box"] != 0) : ?>  
    <!--Begin Favorites Box-->
            <div class="headerBox"><div class="boxesInnerOpacity">
            <div class="headerTitle">
                <div class="headerTitleRight">
            </div>
                <span><?= $LANGS['playlists'] ?></span>
            </div>  
</div><div class="headerBoxOpacity"></div></div>
            <div class="basicBoxes scrollersBox profileRightCol">
                <div class="BoxesInnerOpacity">
                <?php if ($Playlists) : ?>
                    <table width="628" border="0" class="playlists" align="center">
        <tbody>
    <?php $Count = 0; ?>
        <?php foreach ($Playlists as $Playlist) : ?>
        <?php $Count++ ?>
        <?php
                    $Videos = $DB->execute("SELECT url FROM playlists_videos WHERE playlist_id = :ID ORDER BY position ASC",false,array(":ID" => $Playlist["id"]));
                    if ($Videos) {
                        if (isset($Videos[0])) {
                            $Video1 = $Videos[0]["url"];
                        }
                    } else {
                        $Video1 = false;
                        $Video2 = false;
                        $Video3 = false;
                    }

                ?>
        <tr valign="top" class="vDetailEntry">
                    <td><div style="margin-right: 10px;"><div class="vCluster120WideEntry"><div class="vCluster120WrapperOuter"><div class="vCluster120WrapperInner"><a id="video-url" href="/view_playlist?id=<?= $Playlist["id"] ?>" rel="nofollow"><img title="LittleBigPlanet 101" src="/u/thmp/<?= $Video1 ?>.jpg" class="vimgCluster120" alt="LittleBigPlanet 101"></a><div class="video-corner-text"><span><?= $DB->execute("SELECT count(url) as amount FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["amount"] ?> <?= $LANGS['plvideoamount'] ?></span></div></div></div></div></div></td>
                <td width="100%">
                    <div class="pltitle">
                        <a href="/view_playlist?id=<?= $Playlist["id"] ?>"><?= $Playlist["title"] ?></a> <span dir="ltr" class="vlfacets" style="font-weight: bold;">
                        <?= $DB->execute("SELECT count(url) as amount FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["amount"] ?> <?= $LANGS['plvideos'] ?></span>
                    </div>
                    <div class="video-facets" style="margin-top: 4px;"><?php if (empty($Playlist["description"])) : ?><?php else : ?><?= $Playlist["description"] ?><?php endif ?></div>
                </td>
                <td valign="middle" nowrap="" align="right">
                    <div class="playlistLinks">
                        <a href="/watch?v=<?= $Video1 ?>&pl=<?= $Playlist["id"] ?>"><?= $LANGS['playall'] ?></a>
                    </div>
                </td>
                </tr>
    <?php if ($Count == 3) : ?>
    <?php $Count = 0 ?>
     <?php endif ?>
    <?php endforeach ?>
    </tr>
    <tr>
        <td colspan="3" align="right">
            <b><a style="font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif" href="/user/<?= $_PROFILE->Username ?>&page=playlists"><?= $LANGS['seeall'] ?></a></b>
        </td>
    </tr>
</tbody></table>
                <?php else : ?>
                    <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 29px"><?= $LANGS['noplchannel'] ?></div>
                <?php endif ?>

                </div>
                <div class="basicBoxesOpacity"></div>

            </div>
    <!--End Favorites Box-->
<?php endif ?>


    <?php $fc = explode(",", (string) $_PROFILE->Info["channels"]);
    if(!empty($fc[0])) {
    ?>
    <!--Begin Channels Box-->
    <div class="headerBox" bis_skin_checked="1"><div class="boxesInnerOpacity" bis_skin_checked="1">
    <div class="headerTitle" bis_skin_checked="1"><span><?php if (!$_PROFILE->Info["channels_title"]): ?><?= $LANGS['featuredchannels'] ?><?php else: ?><?= $_PROFILE->Info["channels_title"] ?><?php endif ?></span></div>                      
    </div><div class="headerBoxOpacity" bis_skin_checked="1"></div></div>
    <div id="channelsBox" class="basicBoxes profileRightCol" bis_skin_checked="1">
                <div class="BoxesInnerOpacity" bis_skin_checked="1">
                                <table style="padding: 0 5px; border-spacing: 0;" width="100%" border="0" align="center">
                <tbody>
    <tr class="commentsTableFull">
            <td valign="top" width="60" style="padding-bottom: 15px; <?php if (empty($fc[1])): ?>border-bottom: hidden!important<?php else : ?><?php endif ?>; ">
              <div class="user-thumb-medium"><div>
<a href="/user/<?= $fc[0]; ?>">
    <img id="" src="<?= avatar($fc[0]); ?>" style="margin-left: 0" alt="<?= displayname($fc[0]); ?>">
</a>
  </div></div>

        </td><td valign="top" style="padding-bottom: 15px; <?php if (empty($fc[1])): ?>border-bottom: hidden!important<?php else : ?><?php endif ?>; ">
        
            <div style="margin-bottom: 5px;">
                <a href="/user/<?= $fc[0]; ?>" style="font-size: 12px;"><b><?= title($fc[0]); ?></b></a>
            </div>
            <div>
                <?= short_title(about($fc[0]),80); ?>
            </div>
        </td><td valign="top" width="30%" style=" <?php if (empty($fc[1])): ?>border-bottom: hidden!important<?php else : ?><?php endif ?>; ">
            <div><span class="smallText" width="100%"><?= $LANGS['videos'] ?>:</span> <?= videos($fc[0]); ?></div>
            <div><span class="smallText" width="100%"><?= $LANGS['channelviews'] ?>:</span> <?= number_format(profile_views($fc[0])); ?></div>
            <div><span class="smallText" width="100%"><?= $LANGS['channelsubscribers'] ?>:</span> <?= subscribers($fc[0]); ?></div>
        </td></tr> <?php
    if(!empty($fc[1])) { 
    ?>
    <tr class="commentsTableFull">
            <td valign="top" width="60" style="padding-bottom: 15px; <?php if (empty($fc[2])): ?>border-bottom: hidden!important<?php else : ?><?php endif ?>; ">
              <div class="user-thumb-medium"><div>
<a href="/user/<?= $fc[1]; ?>">
    <img id="" src="<?= avatar($fc[1]); ?>" style="margin-left: 0" alt="<?= displayname($fc[1]); ?>">
</a>
  </div></div>

        </td><td valign="top" style="padding-bottom: 15px; <?php if (empty($fc[2])): ?>border-bottom: hidden!important<?php else : ?><?php endif ?>; ">
        
            <div style="margin-bottom: 5px;">
                <a href="/user/<?= $fc[1]; ?>" style="font-size: 12px;"><b><?= title($fc[1]); ?></b></a>
            </div>
            <div>
                <?= short_title(about($fc[1]),80); ?>
            </div>
        </td><td valign="top" width="30%" style=" <?php if (empty($fc[2])): ?>border-bottom: hidden!important<?php else : ?><?php endif ?>; ">
            <div><span class="smallText" width="100%"><?= $LANGS['videos'] ?>:</span> <?= videos($fc[1]); ?></div>
            <div><span class="smallText" width="100%"><?= $LANGS['channelviews'] ?>:</span> <?= number_format(profile_views($fc[1])); ?></div>
            <div><span class="smallText" width="100%"><?= $LANGS['channelsubscribers'] ?>:</span> <?= subscribers($fc[1]); ?></div>
        </td></tr> <?php
    }
    if(!empty($fc[2])) { 
    ?>
    <tr class="commentsTableFull">
            <td valign="top" width="60" style="padding-bottom: 15px; <?php if (empty($fc[3])): ?>border-bottom: hidden!important<?php else : ?><?php endif ?>; ">
              <div class="user-thumb-medium"><div>
<a href="/user/<?= $fc[2]; ?>">
    <img id="" src="<?= avatar($fc[2]); ?>" style="margin-left: 0" alt="<?= displayname($fc[2]); ?>">
</a>
  </div></div>

        </td><td valign="top" style="padding-bottom: 15px; <?php if (empty($fc[3])): ?>border-bottom: hidden!important<?php else : ?><?php endif ?>; ">
        
            <div style="margin-bottom: 5px;">
                <a href="/user/<?= $fc[2]; ?>" style="font-size: 12px;"><b><?= title($fc[2]); ?></b></a>
            </div>
            <div>
                <?= short_title(about($fc[2]),80); ?>
            </div>
        </td><td valign="top" width="30%" style=" <?php if (empty($fc[3])): ?>border-bottom: hidden!important<?php else : ?><?php endif ?>; ">
            <div><span class="smallText" width="100%"><?= $LANGS['videos'] ?>:</span> <?= videos($fc[2]); ?></div>
            <div><span class="smallText" width="100%"><?= $LANGS['channelviews'] ?>:</span> <?= number_format(profile_views($fc[2])); ?></div>
            <div><span class="smallText" width="100%"><?= $LANGS['channelsubscribers'] ?>:</span> <?= subscribers($fc[2]); ?></div>
        </td></tr> <?php
    }
    if(!empty($fc[3])) { 
    ?>
    <tr class="commentsTableFull">
            <td valign="top" width="60" style="padding-bottom: 15px; border-bottom: hidden!important; ">
              <div class="user-thumb-medium"><div>
<a href="/user/<?= $fc[3]; ?>">
    <img id="" src="<?= avatar($fc[3]); ?>" style="margin-left: 0" alt="<?= displayname($fc[3]); ?>">
</a>
  </div></div>

        </td><td valign="top" style="padding-bottom: 15px; border-bottom: hidden!important; ">
        
            <div style="margin-bottom: 5px;">
                <a href="/user/<?= $fc[3]; ?>" style="font-size: 12px;"><b><?= title($fc[3]); ?></b></a>
            </div>
            <div>
                <?= short_title(about($fc[3]),80); ?>
            </div>
        </td><td valign="top" width="30%" style=" border-bottom: hidden!important; ">
            <div><span class="smallText" width="100%"><?= $LANGS['videos'] ?>:</span> <?= videos($fc[3]); ?></div>
            <div><span class="smallText" width="100%"><?= $LANGS['channelviews'] ?>:</span> <?= number_format(profile_views($fc[3])); ?></div>
            <div><span class="smallText" width="100%"><?= $LANGS['channelsubscribers'] ?>:</span> <?= subscribers($fc[3]); ?></div>
        </td></tr> <?php
    }

    ?>
    <!--End Channels Box-->
    <tr>
                </tr>
            </tbody></table>
                        <div style="clear:both" bis_skin_checked="1"></div>
            </div>
            <div class="basicBoxesOpacity" bis_skin_checked="1"></div>
            </div>
    <?php } ?>
                    
    <!--Begin If No Subscribers Empty Set Box-->
    <!--End If No Subscribers Empty Set Box-->

    <!--Begin Subscribers Box-->
    <!--End Subscribers Box-->

    <!--Begin If No Friends Empty Set Box-->
    <!--End If No Friends Empty Set Box-->


    <!--Begin Friends Box-->
    <!--End Friends Box-->

<?php if ($_PROFILE->Info["c_comments_box"] != 0) : ?>  
<!--Begin Comments Box-->


    <div class="headerBox"><div class="boxesInnerOpacity">  <div class="headerTitle">
            <span><?= $LANGS['channelcomments'] ?> (<a href="/user/<?= $_PROFILE->Username ?>&page=comments" class="headersSmall" id="comment-amount"><?= $_PROFILE->Info["channel_comments"] ?></a>)</span>
    </div>
</div><div class="headerBoxOpacity"></div></div>
    <div id="commentsBoxRight" class="basicBoxes profileRightCol">
        <div class="BoxesInnerOpacity">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <?php if ($Comments) : ?>
                        <?php foreach ($Comments as $Comment) : ?>
        
        <tr class="commentsTableFull" id="cc_<?= $Comment["id"] ?>">
        <td width="60" valign="top" align="left" style="padding-bottom:15px">
            <div class="user-thumb-large" style="width:46px; height:46px;">
            <a href="/user/<?= $Comment["by_user"] ?>"><img src="<?= avatar($Comment["by_user"]) ?>"></a>
            </div>
        </td>
        <td valign="top" align="left" style="padding-bottom: 15px;">
            <div class="comment-top" style="padding-bottom: 5px;"><a href="/user/<?= $Comment["by_user"] ?>" style="font-weight: bold;"><?= displayname($Comment["by_user"]) ?></a>
<span class="labels">(<?= get_time_ago($Comment["submit_date"]) ?>)</span> <?php if ($_USER->Logged_In && ($_USER->Is_Admin || $_USER->Is_Moderator || $_USER->Username == $_PROFILE->Username || $_USER->Username == $Comment["by_user"])) : ?><span class="labels"> <a style="float:right" href="javascript:void(0)" onclick="delete_channel_comment(<?= $Comment["id"] ?>)"><?= $LANGS['delete'] ?></a></span><?php endif ?>
                <span>
                    </span>
            </div>

                <span><?= make_links_clickable(nl2br((string) $Comment["content"])) ?></span>
        </td>
        </tr>
                        <?php endforeach ?>
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
                    <?php endif ?>
                <tr>
                    <td colspan="3" align="center">
                        <div class="comments-bottom" style="padding: 6px; text-align: center; font-weight: bold;">
                            <?php if (!$_USER->Logged_In) : ?>
    <a href="/login" style="font-weight: normal;"><?= $LANGS['addcomment'] ?></a><br><br>
    <?php endif ?>
                            <span style="float:right">
                            <?php if ($Page_Amount > 1):?>
                            <?php foreach (range(1,$Page_Amount) as $Num):?>
                            <?php if ($Num != 1):?><a href="#" id="change-page-<?= $Num ?>" style="font-weight: bold;font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif;" onclick="change_comments_page('<?= $_PROFILE->Username ?>',<?= $Num ?>); return false;"><?= $Num ?></a>&nbsp;<?php else: ?><span id="current-page-<?= $Num ?>"><?= $Num ?></span>&nbsp;<?php endif ?>
                            <?php endforeach ?><?php if ($Page_Amount > 1):?><a href="#" id="change-page-next" style="font-weight: bold;font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif;" onclick="change_comments_page('<?= $_PROFILE->Username ?>',2);return false;"><?= $LANGS['next'] ?></a><?php endif ?>
                        <?php else: ?>
                            <span id="current-page-1">1</span>
                        <?php endif ?>
                        </span>
                            <?php if ($_USER->Logged_In) : ?>
                            <form action="/user/<?= $_PROFILE->Username ?>" method="POST">
<table cellpadding="4px" style="position:relative;">
    <tr>
        <td><div style="font-weight:bold;margin-bottom:4px;text-align:left;"><?= $LANGS['addacomment'] ?></div><textarea style="font-family: <?= $_PROFILE->Info["c_font"] ?>;min-width: 598px;max-width: 598px;width: 400px;" maxlength="500" name="comment" cols="66" rows="6"></textarea></td>
    </tr>
    <tr>
        <td style="text-align: left;"><input type="submit" class="yt-button yt-button-primary" name="post_comment" value="<?= $LANGS['postreplychannel'] ?>"></td>
    </tr>
</table>
</form> 
<?php endif ?>
                        </div>
                    </td>
                </tr>
            </tbody></table>
        </div>
        <div class="basicBoxesOpacity"></div>
        <div class="loading-div" id="loading-div"><table cellspacing="0" cellpadding="0" width="638" height="808" style="
"><tbody><tr><td align="center" valign="middle"><img src="/img/icn_loading_animated.gif"></td></tr></tbody></table></div>
    </div>
    <br>
<!--End Comments Box-->
<?php endif ?>
</div>
<div style="clear:both"></div>
<!--End Right Column-->
<!--End Page Container Table-->
</div>


        
              <?php if (!$Flagged) : ?><div class="flaggingText"><a href="/a/flag_user?user=<?= $_PROFILE->Username ?>&reason=1"><?= $LANGS['report'] ?></a> <?= $LANGS['bggraphic']?> / <a href="/a/flag_user?user=<?= $_PROFILE->Username ?>&reason=0"><?= $LANGS['report'] ?></a> <?= $LANGS['reportthisuser']?>.</div><?php endif ?>

        
    </div>
