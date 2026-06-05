<style>
.yts-heading-menu {
    margin: 20px 0 0 195px;
    color: #333!important;
    width: 765px;
}
.yts-heading-menu h2 {
    margin-top: 0;
    border-bottom: 1px solid #ccc;
    padding-bottom: 5px;
}
.yts-main {
    color: #333333;
    margin: 15px 0 0 195px;
}
.yts-pretty-box {
    background: #fff url(http://s.ytimg.com/yt/img/static/background-drop-fade-vfl85178.gif) repeat-x top center;
}
.yt-primary-box {
    background-color: #fff;
    border: 1px solid #ccc;
    margin-bottom: 20px;
    padding: 10px;
    css-border-radius: 8px;
    -moz-border-radius: 8px;
    -webkit-border-radius: 8px 8px 8px 8px;
}
.yts-landing-intro {
    float: right;
    width: 300px;
}
.yts-landing-intro p {
    font-size: 14px;
    margin: 20px 0;
}
.heading {
    color: #333333;
    font-size: 18px;
    font-weight: bold;
}
.yt-button span {
    white-space: normal;
    line-height: 1.9166em;
    height: 1.9166em;
    *display: inline-block;
}
.yt-primary-box {
    background-color: #fff;
    border: 1px solid #ccc;
    margin-bottom: 20px;
}
.yt-box-title {
    background-color: #eee;
    border-bottom: 1px solid #ccc;
    padding: 4px 10px;
    margin-left: -10px;
    margin-top: -10px;
    margin-right: -10px;
    css-border-radius: 8px 8px 0 0;
    -moz-border-radius: 8px 8px 0 0;
    -webkit-border-radius: 8px 8px 0 0;
}
#yts-partners-panels-container {
    width: 696px;
    overflow: hidden;
    margin-left: 20px;
    margin-top: 14px;
}
#yts-partners-panels {
    display: block;
    width: 9744px;
    margin-left: 0;
}
#yts-partners-panels li {
    float: left;
    width: 116px;
    text-align: center;
}
#yts-partners-panels li .user-thumb-xlarge {
    margin: 10px;
}
#yts-partners-panels li a {
    display: block;
}
.yts-heading-menu ul {
    padding: 5px 0;
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
}
.user-thumb-xlarge img {
    height: 88px;
    width: 88px;
    margin-left: 0;
}
.yts-heading-menu ul li.first {
    border: none;
    padding-left: 0;
}
.yts-heading-menu ul li {
    display: inline;
    padding: 0 5px;
    border-left: 1px solid #ccc;
}
.yts-heading-menu ul li a.selected {
    color: #333;
    text-decoration: none;
}
#bv-static-sidebar-nav {
    width: 175px;
    float: left;
    margin-right: 20px;
    margin-top: 15px;
    height: 100%;
}
.bv-static-sidebar-subhead {
    padding: 6px 0;
    color: #333;
    margin-top: 1px;
    font-weight: bold;
}
ul.bv-static-sidebar-list {
    margin: 0;
    padding: 3px 0;
}
.bv-static-sidebar-item {
    list-style: none;
    margin: 0;
    padding: 3px 6px;
}
li.bv-static-sidebar-item a:link, li.bv-static-sidebar-item a:visited {
    text-decoration: none;
    color: #03c;
}
.bv-static-sidebar-item-highlight {
    list-style: none;
    margin: 0;
    padding: 3px 6px;
}
li.bv-static-sidebar-item-highlight a:link, li.bv-static-sidebar-item-highlight a:visited {
    text-decoration: none;
    color: #000;
}
</style>
<div id="baseDiv" class="date-20091209 ">
    <div id="bv-static-sidebar-nav">
    
<div class="bv-static-sidebar-subhead">
    BitView
</div>
<ul class="bv-static-sidebar-list">
    <li class="bv-static-sidebar-item"><a href="/blog"><?= $LANGS['bitviewblog'] ?></a></li>
</ul>

<div class="bv-static-sidebar-subhead">
    <?= $LANGS['discover'] ?>
</div>
<ul class="bv-static-sidebar-list">
    <li class="bv-static-sidebar-item"><a href="/bitviewonyoursite"><?= $LANGS['bvsite'] ?></a></li>
    <li class="bv-static-sidebar-item"><a href="/rss_feeds"><?= $LANGS['bvrss'] ?></a></li>
    <li class="bv-static-sidebar-item"><a href="/testview">TestView</a></li>
</ul>

<div class="bv-static-sidebar-subhead">
    <?= $LANGS['programs'] ?>
</div>
<ul class="bv-static-sidebar-list">
        <li class="bv-static-sidebar-item-highlight"><a href="/partners"><?= $LANGS['partnerships'] ?></a></li>
    <li class="bv-static-sidebar-item"><a href="https://dev.bitview.net"><?= $LANGS['developers'] ?></a></li>
</ul>

<div class="bv-static-sidebar-subhead">
    <?= $LANGS['help'] ?>
</div>
<ul class="bv-static-sidebar-list">
    <li class="bv-static-sidebar-item"><a href="/help"><?= $LANGS['helpcenter'] ?></a></li>
</ul>

</div>
    <div class="yts-heading-menu">
        <h2><?= $LANGS['partnerhead'] ?></h2>
    </div>


    <div class="yts-main">
                <div class="yt-primary-box yts-pretty-box">
        <div class="yts-landing-intro">
            <h2><?= $LANGS['partnertitle'] ?></h2>
            
            <p><?= $LANGS['partnerdesc'] ?></p>
            
                <div>
                            <form name="yppApplyNowForm" method="post">
                                        <input type="hidden" name="page" value="start">

        <input type="hidden" name="partner_type" value="C">

        <input type="hidden" name="status" value="N">

        <input type="hidden" name="username" value="">


                                <span class="heading">
                                    <a class="yt-button yt-button-urgent" id="" style="padding: 0.3333em 0.666em;" href="/a/send_application"><span><?= $LANGS['applynow'] ?></span></a>
                                </span>
                            <input name="session_token" type="hidden" value="0KnlH0UfWqgPXO91E4AJdsnKYoN8MTI2MDQ3NjA3OA=="></form>
                </div>
        </div>
        
        <img src="/img/partners-videos-vfl85500.png" width="370" height="252">
        <div style="clear: right;"></div>
    </div>
    
    <div class="yt-primary-box" style="margin-top: 20px; width: 743px;">
        <h3 class="yt-box-title"><?= $LANGS['contentpartners'] ?></h3>
        
        <div id="yts-partners-panels-container">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
    <?php $Count = 0; ?>
        <tr valign="top">
        <?php if ($Users) : ?>
        <?php foreach ($Users as $User) : ?>
        <?php $Count++ ?>
        <td>
        <div class="memberContainer">
            <div class="memberBoxList">
                <div class="user-thumb-xlarge">
                    <a href="/user/<?= $User["username"] ?>" style="z-index: 50000;position: relative;"><img src="<?= avatar($User["username"]) ?>" <?php if ($User["is_avatar_video"] == 1) : ?>class="avatarvideo"<?php endif ?> alt="<?= $User["username"] ?>"></a>
                </div>
            </div>
            <div class="vldescbox">
                <div class="vltitle">
                                <a href="/user/<?= $User["username"] ?>"><?= short_title(displayname($User["username"]),10)  ?></a>

                </div>
            </div>
            <div class="vlclearalt"></div>
        </div> 

<?php unset($Avatar) ?>
 <?php if ($Count == 6) : ?>
 </td>
    </tr>
<tr valign="top">
    <?php $Count = 0 ?>
                    <?php endif ?>
                    <?php endforeach ?>
                    <?php else : ?>
        <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 16px">No channels were found...</div>
    <?php endif ?>
    </tr>
    </tbody></table>
        </div>
        <div class="clear"></div>
    </div>
    
    <table style="margin-top: 20px;"><tbody><tr><td style="width: 50%; padding-right: 5px;">
        <div class="yt-primary-box" style="height: 13em;">
            <h3 class="yt-box-title"><?= $LANGS['partnerbenefits'] ?></h3>
        
            <p style="margin-top: 1em;"><?= $LANGS['partnerbenefitsdesc'] ?><br><br></p>
        </div>
    </td><td style="padding-left: 5px;">
        <div class="yt-primary-box" style="height: 13em;">
            <h3 class="yt-box-title"><?= $LANGS['qualificationsfaq'] ?></h3>
            
            
            <p style="margin-top: 1em;"><?= $LANGS['qualificationsfaqdesc'] ?></p>
        </div>
    </td></tr></tbody></table>