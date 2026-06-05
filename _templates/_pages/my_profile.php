<style type="text/css">
.videoModifiers {
    padding: 5px 0px;
    border-bottom: 1px solid #ccc;
    text-align: center;
}
.videoModifiers div.first {
    border-left: 0px;
    padding: 0px 10px 0px 2px;
}
.videoModifiers div.subcategory {
    border-left: 1px solid #ccc;
    padding: 0px 10px;
    font-size: 11px;
    display: inline;
}
.videoModifiers .selected {
    font-weight: bold;
}
#nav-pane .header {
    height: 25px;
    padding: 10px 0;
    width: 960px;
    line-height: 19px;
}
</style>
<script src="/js/jscolor.js"></script>
<script>
// These options apply to all color pickers on the page
jscolor.presets.default = {
    borderColor:'#999999', borderRadius:0, padding:10, width:200, 
    height:100, mode:'HVS', controlBorderColor:'#CCCCCC', format:'hexa',
    sliderSize:20, shadow:false
};
function coloricebergblue() {
    document.getElementById("color_background").setAttribute('value','#2c405b');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#6b8ab8');
    document.getElementById("color_header_font").setAttribute('value','#6b8ab8');
    document.getElementById("color_highlight_header").setAttribute('value','#6b8ab8');
    document.getElementById("color_highlight_inner").setAttribute('value','#ebeff0');
    document.getElementById("color_normal_header").setAttribute('value','#6b8ab8');
    document.getElementById("color_normal_inner").setAttribute('value','#2c405b');
}
function colorclassic() {
    document.getElementById("color_background").setAttribute('value','#ffffff');
    document.getElementById("color_font").setAttribute('value','#000000');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#0033cc');
    document.getElementById("color_header_font").setAttribute('value','#666666');
    document.getElementById("color_highlight_header").setAttribute('value','#666666');
    document.getElementById("color_highlight_inner").setAttribute('value','#E6E6E6');
    document.getElementById("color_normal_header").setAttribute('value','#666666');
    document.getElementById("color_normal_inner").setAttribute('value','#ffffff');
}
function coloracidwash() {
    document.getElementById("color_background").setAttribute('value','#006599');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#56aad6');
    document.getElementById("color_header_font").setAttribute('value','#56aad6');
    document.getElementById("color_highlight_header").setAttribute('value','#56aad6');
    document.getElementById("color_highlight_inner").setAttribute('value','#006599');
    document.getElementById("color_normal_header").setAttribute('value','#56aad6');
    document.getElementById("color_normal_inner").setAttribute('value','#006599');
}
function colorstorm() {
    document.getElementById("color_background").setAttribute('value','#3a3a3a');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#898588');
    document.getElementById("color_header_font").setAttribute('value','#666666');
    document.getElementById("color_highlight_header").setAttribute('value','#999999');
    document.getElementById("color_highlight_inner").setAttribute('value','#EEEEEE');
    document.getElementById("color_normal_header").setAttribute('value','#999999');
    document.getElementById("color_normal_inner").setAttribute('value','#3a3a3a');
}
function colorforestgreen() {
    document.getElementById("color_background").setAttribute('value','#006600');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#4f9f00');
    document.getElementById("color_header_font").setAttribute('value','#4f9f00');
    document.getElementById("color_highlight_header").setAttribute('value','#4f9f00');
    document.getElementById("color_highlight_inner").setAttribute('value','#dcffba');
    document.getElementById("color_normal_header").setAttribute('value','#4f9f00');
    document.getElementById("color_normal_inner").setAttribute('value','#234701');
}
function colororangeapeel() {
    document.getElementById("color_background").setAttribute('value','#e25f0f');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#fdbe00');
    document.getElementById("color_header_font").setAttribute('value','#daa501');
    document.getElementById("color_highlight_header").setAttribute('value','#fdbe00');
    document.getElementById("color_highlight_inner").setAttribute('value','#f7f8e6');
    document.getElementById("color_normal_header").setAttribute('value','#fdbe00');
    document.getElementById("color_normal_inner").setAttribute('value','#e25f0f');
}
function colorprettyinpink() {
    document.getElementById("color_background").setAttribute('value','#cd2651');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#e9799f');
    document.getElementById("color_header_font").setAttribute('value','#e9799f');
    document.getElementById("color_highlight_header").setAttribute('value','#e9799f');
    document.getElementById("color_highlight_inner").setAttribute('value','#fae3eb');
    document.getElementById("color_normal_header").setAttribute('value','#e9799f');
    document.getElementById("color_normal_inner").setAttribute('value','#ffffff');
}
function colorpurplehaze() {
    document.getElementById("color_background").setAttribute('value','#3f1f60');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#9560ca');
    document.getElementById("color_header_font").setAttribute('value','#9560ca');
    document.getElementById("color_highlight_header").setAttribute('value','#9560ca');
    document.getElementById("color_highlight_inner").setAttribute('value','#eae1f4');
    document.getElementById("color_normal_header").setAttribute('value','#9560ca');
    document.getElementById("color_normal_inner").setAttribute('value','#3f1f60');
}
function colorrubyred() {
    document.getElementById("color_background").setAttribute('value','#5f1718');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#cd311b');
    document.getElementById("color_header_font").setAttribute('value','#cd311b');
    document.getElementById("color_highlight_header").setAttribute('value','#cd311b');
    document.getElementById("color_highlight_inner").setAttribute('value','#f8e0e0');
    document.getElementById("color_normal_header").setAttribute('value','#cd311b');
    document.getElementById("color_normal_inner").setAttribute('value','#5f1718');
}
</script>

<!-- left column - FOR ADS ONLY IF MY SUBS -->
<div id="nav-pane">
                <div class="header">
                    <?= $LANGS['myprofiledesc'] ?>
                </div>
                <div id="list-pane">
                    <div class="folder"><a class="name" href="/my_account#c_pic"><?= $LANGS['profileimages'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_account#c_info"><?= $LANGS['channelinformation'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_account#c_interests"><?= $LANGS['hobbies'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_account#c_email"><?= $LANGS['emailprefs'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_account#c_layout"><?= $LANGS['layoutprefs'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_account_modules"><?= $LANGS['customizehomepage'] ?></a></div>
                </div>
            </div>
<div id="view-pane" style="margin-bottom: 10px;">
                <div class="header yt2009-sub-header" style="padding: 20px;">
                    <div class="pager"></div>
                    <h2> </h2>
                </div>
                <div class="splitter">
                    <div class="view">
                        <div id="video_grid" class="browseGridView marT10">
                            <div style="width: 350px;background: #ffffe5;border: 1px solid #f5e082;padding: 6px;">
                            <b>Try out our NEW channels!</b><br><br>
                            Channel 2.0 is now available for BitView. Just click below to enable it.<br><br>
                            <a href="#" class="yt-button yt-button-primary" style="line-height: 23px;
    height: 23px;" onclick="if (confirm('Are you sure you wish to continue?')) { location.href='/a/switch_layout?layout=1'; }">Upgrade my channel!</a>
                        </div><br>
<div id="c_pic" style="font-size:14px;font-weight:bold;margin: 1px 0 10px"><?= $LANGS['profileimages'] ?></div>
<table border="0" cellpadding="5" cellspacing="0">
    <tr>
            <td align="right" width="110px"><span style="font-weight:bold"><?= $LANGS['avatar'] ?>:</span></td>
            <td><span class="user-thumb-large" style="margin-bottom: 5px;">
                    <a href="/user/<?= $_USER->Username ?>"><img src="<?= avatar($_USER->Username) ?>" <?php if ($_USER->Info["is_avatar_video"] == 1) : ?>class="avatarvideo"<?php endif ?> alt="<?= $_USER->Username ?>"></a>
                </span><?php if(!$_USER->Info["avatar"]) : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <input type="file" name="avatar_image"> <input type="submit" name="change_avatar_image" value="<?= $LANGS['submitimage'] ?>">
            </form>
            <?php else : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <input type="submit" class="yt-button yt-button-primary" name="delete_avatar_image" value="<?= $LANGS['deleteimage'] ?>">
            </form>
            <?php endif ?></td>
        </tr>
    <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['backgroundimage'] ?>:</span></td>
            <?php if(!$_USER->Info["c_background_image"]) : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <td><input type="file" name="background_image"> <input type="submit" name="change_background_image" value="<?= $LANGS['submitimage'] ?>"></td>
            </form>
            <?php else : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <td><input type="submit" name="delete_background_image" class="yt-button yt-button-primary" value="<?= $LANGS['deleteimage'] ?>"></td>
            </form>
            <td><img src="<?= cache_bust($_USER->Info["c_background_image"]) ?>" width="300"></td>
            <?php endif ?>
        </tr>
</table>
<form action="/my_account" method="post">
    <div id="c_info" style="font-size:14px;font-weight:bold;margin: 1px 0 10px"><?= $LANGS['channelinformation'] ?></div>
    <table border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['title'] ?>:</span></td>
            <td><input type="text" name="profile_name" value="<?= $_USER->Info["i_name"] ?>" maxlength="30" style="width:150px" /></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['website'] ?>:</span></td>
            <td><input type="text" name="profile_website" value="<?= $_USER->Info["i_website"] ?>" maxlength="64" style="width:200px" /></td>
        </tr>
        <tr>
               <?php $fc = explode(",", (string) $_USER->Info["channels"]);
                ?>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['featuredchannels'] ?>:</span></td>
            <td><input type="text" name="channel1" value="<?= $fc[0] ?>" maxlength="20" style="width:50px" />, <input type="text" name="channel2" value="<?= $fc[1] ?>" maxlength="20" style="width:50px" />, <input type="text" name="channel3" value="<?= $fc[2] ?>" maxlength="20" style="width:50px" />, <input type="text" name="channel4" value="<?= $fc[3] ?>" maxlength="20" style="width:50px" />, </td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['fctitle'] ?>:</span></td>
            <td><input type="text" name="fc_title" value="<?= $_USER->Info["channels_title"] ?>" maxlength="60" style="width:200px" /></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['gender'] ?>:</span></td>
            <td>
                <select name="profile_gender">
                    <option value="0"<?php if ($_USER->Info["i_gender"] == 0) : ?> selected<?php endif ?>><?= $LANGS['genderrelationprivate'] ?></option>
                    <option value="1"<?php if ($_USER->Info["i_gender"] == 1) : ?> selected<?php endif ?>><?= $LANGS['male'] ?></option>
                    <option value="2"<?php if ($_USER->Info["i_gender"] == 2) : ?> selected<?php endif ?>><?= $LANGS['female'] ?></option>
                </select>
            </td>
        </tr>
        <td align="right"><span style="font-weight:bold"><?= $LANGS['relationship'] ?>:</span></td>
        <td>
            <select name="profile_relationship">
                <option value="0"<?php if ($_USER->Info["i_relationship"] == 0) : ?> selected<?php endif ?>><?= $LANGS['genderrelationprivate'] ?></option>
                <option value="1"<?php if ($_USER->Info["i_relationship"] == 1) : ?> selected<?php endif ?>><?= $LANGS['single_m'] ?></option>
                <option value="2"<?php if ($_USER->Info["i_relationship"] == 2) : ?> selected<?php endif ?>><?= $LANGS['taken_m'] ?></option>
                <option value="3"<?php if ($_USER->Info["i_relationship"] == 3) : ?> selected<?php endif ?>><?= $LANGS['married_m'] ?></option>
            </select>
        </td>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['birthday'] ?>:</span></td>
            <td>
                <select name="month">
                    <?php foreach($Months as $item => $value) : ?>
                        <option value="<?= $value ?>"<?php if ($Birth_Month == $value) : ?> selected<?php endif ?>><?= $item ?></option>
                    <?php endforeach ?>
                </select>
                <select name="day">
                    <?php for ($x = 1; $x <= 31; $x++) : ?>
                        <option value="<?= $x ?>"<?php if ($Birth_Day == $x) : ?> selected<?php endif ?>><?= $x ?></option>
                    <?php endfor ?>
                </select>
                <select name="year">
                    <?php for($x = date("Y");$x >= 1910;$x--) : ?>
                        <option value="<?= $x ?>"<?php if ($Birth_Year == $x) : ?> selected<?php endif ?>><?= $x ?></option>
                    <?php endfor ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['showage'] ?>:</span></td>
            <td>
                <select name="show_birthday">
                    <option value="0"<?php if ($_USER->Info["s_age"] == 0) : ?> selected<?php endif ?>><?= $LANGS['no'] ?></option>
                    <option value="1"<?php if ($_USER->Info["s_age"] == 1) : ?> selected<?php endif ?>><?= $LANGS['yes'] ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight: bold"><?= $LANGS['country'] ?>:</span></td>
            <td>
                <select name="profile_country">
                        <option value=""<?php if (!$CheckCountry) : ?> selected<?php endif ?>>------</option>
                    <?php foreach($Countries as $value => $item) : ?>
                        <option value="<?= $value ?>"<?php if ($CheckCountry == $value) : ?> selected<?php endif ?>><?= $item ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight: bold"><?= $LANGS['type'] ?>:</span></td>
            <td>
                <select name="channel_type">
                    <?php foreach($Channel_Type as $value => $item) : ?>
                        <option value="<?= $value ?>"<?php if ($CheckChannelType == $value) : ?> selected<?php endif ?>><?= $item ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>
    </table>
    <div id="c_interests" style="font-size:14px;font-weight:bold;margin: 15px 0 10px"><?= $LANGS['hobbies'] ?></div>
    <table border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['aboutme'] ?>:</span></td>
            <td><textarea name="profile_about" maxlength="2048" style="width:350px;resize:vertical;height:275px;"><?= $_USER->Info["i_about"] ?></textarea></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['hobbies'] ?>:</span></td>
            <td><input type="text" name="profile_hobbies" value="<?= $_USER->Info["i_hobbies"] ?>" maxlength="128" style="width:200px" /></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['books'] ?>:</span></td>
            <td><input type="text" name="profile_books" value="<?= $_USER->Info["i_books"] ?>" maxlength="128" style="width:200px" /></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['movies'] ?>:</span></td>
            <td><input type="text" name="profile_movies" value="<?= $_USER->Info["i_movies"] ?>" maxlength="128" style="width:200px" /></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['music'] ?>:</span></td>
            <td><input type="text" name="profile_music" value="<?= $_USER->Info["i_music"] ?>" maxlength="128" style="width:200px" /></td>
        </tr>
    </table>

    <div id="c_email" style="font-size:14px;font-weight:bold;margin: 15px 0 10px"><?= $LANGS['emailprefs'] ?></div>
    <table border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td align="middle"><input type="checkbox" name="e_messages" id="e_messages"<?php if ($_USER->Info["e_messages"] == 1) : ?> checked<?php endif ?>></td>
            <td><label for="e_messages"><?= $LANGS['emailpm'] ?></label></td>
        </tr>
        <tr>
            <td align="middle"><input type="checkbox" name="e_comments" id="e_comments"<?php if ($_USER->Info["e_comments"] == 1) : ?> checked<?php endif ?>></td>
            <td><label for="e_comments"><?= $LANGS['emailcomm'] ?></label></td>
        </tr>
        <tr>
            <td align="middle"><input type="checkbox" name="e_highlights" id="e_highlights"<?php if ($_USER->Info["e_subscriptions"] == 1) : ?> checked<?php endif ?>></td>
            <td><label for="e_highlights"><?= $LANGS['emailsub'] ?></label></td>
        </tr>
    </table>

    <div id="c_layout" style="font-size:14px;font-weight:bold;margin: 15px 0 10px"><?= $LANGS['layoutprefs'] ?></div>
    <table border="0" cellpadding="5" cellspacing="0">
        <tr style="padding: 10px 0px;width: 0;display: block;">
            <td width="8.4%"><span style="cursor:pointer;display: block;width: 50px;height: 25px;background-color: #2c405b;border: 1px solid #2c405b;" onclick="coloricebergblue()"><span style="font-weight:bold;display: block;width: 25px;height: 25px;background: #6b8ab8; float: right;"></span></span>
            </td>
            <td width="8.4%"><span style="cursor:pointer;display: block;width: 50px;height: 25px;background-color: #666;border: 1px solid #666666;" onclick="colorclassic()"><span style="font-weight:bold;display: block;width: 25px;height: 25px;background: #eee;float: right;"></span></span>
            </td>
            <td width="8.4%"><span style="cursor:pointer;display: block;width: 50px;height: 25px;background-color: #006599;border: 1px solid #006599;" onclick="coloracidwash()"><span style="font-weight:bold;display: block;width: 25px;height: 25px;background: #56aad6;float: right;"></span></span>
            </td>
            <td width="8.4%"><span style="cursor:pointer;display: block;width: 50px;height: 25px;background-color: #3a3a3a;border: 1px solid #3a3a3a;" onclick="colorstorm()"><span style="font-weight:bold;display: block;width: 25px;height: 25px;background: #999999;float: right;"></span></span>
            </td>
            <td width="8.4%"><span style="cursor:pointer;display: block;width: 50px;height: 25px;background-color: #234701;border: 1px solid #234701;" onclick="colorforestgreen()"><span style="font-weight:bold;display: block;width: 25px;height: 25px;background: #4f9f00;float: right;"></span></span>
            </td>
            <td width="8.4%"><span style="cursor:pointer;display: block;width: 50px;height: 25px;background-color: #e25f0f;border: 1px solid #e25f0f;" onclick="colororangeapeel()"><span style="font-weight:bold;display: block;width: 25px;height: 25px;background: #fdbe00;float: right;"></span></span>
            </td>
            <td width="8.4%"><span style="cursor:pointer;display: block;width: 50px;height: 25px;background-color: #cd2651;border: 1px solid #cd2651;" onclick="colorprettyinpink()"><span style="font-weight:bold;display: block;width: 25px;height: 25px;background: #e9799f;float: right;"></span></span>
            </td>
            <td width="8.4%"><span style="cursor:pointer;display: block;width: 50px;height: 25px;background-color: #3f1f60;border: 1px solid #3f1f60;" onclick="colorpurplehaze()"><span style="font-weight:bold;display: block;width: 25px;height: 25px;background: #9560ca;float: right;"></span></span>
            </td>
            <td width="8.4%"><span style="cursor:pointer;display: block;width: 50px;height: 25px;background-color: #5f1718;border: 1px solid #5f1718;" onclick="colorrubyred()"><span style="font-weight:bold;display: block;width: 25px;height: 25px;background: #cd311b;float: right;"></span></span>
            </td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['bgcolor'] ?>:</span></td>
            <td><input type="color" name="color_background" id="color_background" value="#<?= $_USER->Info["c_background"] ?>"/> </td>
        </tr>

       <?php if($_USER->Info["c_background_image"]) : ?>
        <tr>
            <td align="right"><span style="font-weight: bold"><?= $LANGS['bgfixed'] ?>:</span></td>
            <td><input type="checkbox" name="c_background_image_fixed" id="c_background_image_fixed"<?php if ($CheckFixedBackground == 1) : ?> checked<?php endif ?>></td>
            </td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight: bold"><?= $LANGS['bgrepeat'] ?>:</span></td>
            <td>
                <select name="c_background_image_repeat">
                        <option value="0"<?php if ($CheckRepeatBackground == 0) : ?> selected<?php endif ?>><?= $LANGS['norepeat'] ?></option>
                        <option value="1"<?php if ($CheckRepeatBackground  == 1) : ?> selected<?php endif ?>><?= $LANGS['repeat'] ?></option>
                        <option value="2"<?php if ($CheckRepeatBackground  == 2) : ?> selected<?php endif ?>><?= $LANGS['repeatx'] ?></option>
                        <option value="3"<?php if ($CheckRepeatBackground  == 3) : ?> selected<?php endif ?>><?= $LANGS['repeaty'] ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight: bold"><?= $LANGS['bgposition'] ?>:</span></td>
            <td>
                <select name="c_background_image_position">
                        <option value="0"<?php if ($CheckPositionBackground == 0) : ?> selected<?php endif ?>><?= $LANGS['top'] ?></option>
                        <option value="1"<?php if ($CheckPositionBackground == 1) : ?> selected<?php endif ?>><?= $LANGS['middle'] ?></option>
                        <option value="2"<?php if ($CheckPositionBackground == 2) : ?> selected<?php endif ?>><?= $LANGS['bottom'] ?></option>
                </select>
            </td>
        </tr>
        <?php endif ?>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['fontcolor'] ?>:</span></td>
            <td><input type="color" name="color_font" id="color_font" value="#<?= $_USER->Info["c_normal_font"] ?>"/></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['titlefontcolor'] ?>:</span></td>
            <td><input type="color" name="color_title_font" id="color_title_font" value="#<?= $_USER->Info["c_title_font"] ?>"/></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['linkcolor'] ?>:</span></td>
            <td><input type="color" name="color_links" id="color_links" value="#<?= $_USER->Info["c_link_color"] ?>"/></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['hlfontcolor'] ?>:</span></td>
            <td><input type="color" name="color_header_font" id="color_header_font" value="#<?= $_USER->Info["c_header_font"] ?>"/></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['hlheadercolor'] ?>:</span></td>
            <td><input type="color" name="color_highlight_header" id="color_highlight_header" value="#<?= $_USER->Info["c_highlight_header"] ?>"/></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['hlinsidecolor'] ?>:</span></td>
            <td><input type="color" name="color_highlight_inner" id="color_highlight_inner" value="#<?= $_USER->Info["c_highlight_inner"] ?>"/></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['headercolor'] ?>:</span></td>
            <td><input type="color" name="color_normal_header" id="color_normal_header" value="#<?= $_USER->Info["c_normal_header"] ?>"/></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['insidecolor'] ?>:</span></td>
            <td><input type="color" name="color_normal_inner" id="color_normal_inner" value="#<?= $_USER->Info["c_normal_inner"] ?>"/></td>
        </tr>
        <tr>
        <td align="right" width="110px"><span style="font-weight:bold"><?= $LANGS['font'] ?>:</span></td>
        <td>
                <select name="c_font">
                        <option value="Arial" <?php if ($CheckChannelFont == "Arial") : ?> selected <?php endif ?>>Arial</option>
                        <option value="Verdana" <?php if ($CheckChannelFont == "Verdana") : ?> selected <?php endif ?> >Verdana</option>
                        <option value="Georgia" <?php if ($CheckChannelFont == "Georgia") : ?> selected <?php endif ?>>Georgia</option>
                        <option value="Times New Roman" <?php if ($CheckChannelFont == "Times New Roman") : ?> selected <?php endif ?> >Times New Roman</option>
                        <option value="Courier New" <?php if ($CheckChannelFont == "Courier New") : ?> selected <?php endif ?> >Courier New</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="middle"><input type="checkbox" name="big_box" id="big_box"<?php if ($CheckBoxBig == 1) : ?> checked<?php endif ?>></td>
            <td><label for="big_box"><?= $LANGS['featuredvideobox'] ?></label></td>
        </tr>
        <tr>
            <td align="middle"><input type="checkbox" name="subs_box" id="subs_box"<?php if ($CheckBoxSubs == 1) : ?> checked<?php endif ?>></td>
            <td><label for="subs_box"><?= $LANGS['subscriptionsbox'] ?></label></td>
        </tr>
            <td align="middle"><input type="checkbox" name="subscrib_box" id="subscrib_box"<?php if ($CheckBoxSubscrib == 1) : ?> checked<?php endif ?>></td>
            <td><label for="subscrib_box"><?= $LANGS['subscribersbox'] ?></label></td>
        </tr>
        <tr>
            <td align="middle" width="110px"><input type="checkbox" name="friends_box" id="friends_box"<?php if ($CheckBoxFriends == 1) : ?> checked<?php endif ?>></td>
            <td><label for="friends_box"><?= $LANGS['friendsbox'] ?></label></td>
        </tr>
        <tr>
            <td align="middle"><input type="checkbox" name="bull_box" id="bull_box"<?php if ($CheckBoxBull == 1) : ?> checked<?php endif ?>></td>
            <td><label for="bull_box"><?= $LANGS['bulletinsbox'] ?></label></td>
        </tr>
        <tr>
            <td align="middle"><input type="checkbox" name="videos_box" id="videos_box"<?php if ($CheckBoxVid == 1) : ?> checked<?php endif ?>></td>
            <td><label for="videos_box"><?= $LANGS['videosbox'] ?></label></td>
        </tr>
        
        <tr>
            <td align="middle"><input type="checkbox" name="fav_box" id="fav_box"<?php if ($CheckBoxFav == 1) : ?> checked<?php endif ?>></td>
            <td><label for="fav_box"><?= $LANGS['favoritesbox'] ?></label></td>
        </tr>
        <tr>
            <td align="middle"><input type="checkbox" name="pl_box" id="pl_box"<?php if ($CheckBoxPl == 1) : ?> checked<?php endif ?>></td>
            <td><label for="pl_box"><?= $LANGS['playlistsbox'] ?></label></td>
        </tr>
        <tr>
            <td align="middle"><input type="checkbox" name="comment_box" id="comment_box"<?php if ($CheckBoxCom == 1) : ?> checked<?php endif ?>></td>
            <td><label for="comment_box"><?= $LANGS['commentsbox'] ?></label></td>
        </tr>
        <tr>
            <td align="middle"><input type="checkbox" name="lastrat_box" id="lastrat_box"<?php if ($CheckBoxRatings == 1) : ?> checked<?php endif ?>></td>
            <td><label for="lastrat_box"><?= $LANGS['ratingsbox'] ?></label></td>
        </tr>

        <tr>
        </tr>
    </table>
    <?php if( $_USER->Info["is_partner"]) : ?>
    <div id="c_prt" style="font-size:14px;font-weight:bold;margin: 1px 0 10px"><?= $LANGS['partnersettings'] ?></div>
<table>
    <tr style="display: none;">
            <td align="right"><span style="font-weight:bold"><?= $LANGS['bannerimage'] ?>:<br><span class="smallText" style="color:#666; font-weight: normal;">(<?= $LANGS['recommendedsize'] ?>: 960x150)</span></td>
            <?php if(!$_USER->Info["c_banner_image"]) : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <td><input type="file" name="banner_img"> <input type="submit" name="change_banner_img" value="<?= $LANGS['submitimage'] ?>"></td>
            </form>
            <?php else : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <td><input type="submit" name="delete_banner_image" class="yt-button yt-button-primary" value="<?= $LANGS['deleteimage'] ?>"></td>
            </form>
            <td><img src="<?= cache_bust($_USER->Info["c_banner_image"]) ?>" width="300"></td>
            <?php endif ?>
        </tr>
    <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['bannerimage'] ?>:<br><span class="smallText" style="color:#666; font-weight: normal;">(<?= $LANGS['recommendedsize'] ?>: 960x150)</span></td>
            <?php if(!$_USER->Info["c_banner_image"]) : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <td><input type="file" name="banner_img"> <input type="submit" name="change_banner_img" value="<?= $LANGS['submitimage'] ?>"></td>
            </form>
            <?php else : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <td><input type="submit" name="delete_banner_image" class="yt-button yt-button-primary" value="<?= $LANGS['deleteimage'] ?>"></td>
            </form>
            <td><img src="<?= cache_bust($_USER->Info["c_banner_image"]) ?>" width="300"></td>
            <?php endif ?>
        </tr>
    <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['minibannerimage'] ?>:<br><span class="smallText" style="color:#666; font-weight: normal;">(<?= $LANGS['recommendedsize'] ?>: 300x45)</span></td>
            <?php if(!$_USER->Info["c_mbanner_image"]) : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <td><input type="file" name="mbanner_image"> <input type="submit" name="change_mbanner_image" value="<?= $LANGS['submitimage'] ?>"></td>
            </form>
            <?php else : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <td><input type="submit" name="delete_mbanner_image" class="yt-button yt-button-primary" value="<?= $LANGS['deleteimage'] ?>"></td>
            </form>
            <td><img src="<?= cache_bust($_USER->Info["c_mbanner_image"]) ?>" width="300"></td>
            <?php endif ?>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['sideimage'] ?>:<br><span class="smallText" style="color:#666; font-weight: normal;">(<?= $LANGS['recommendedsize'] ?>: 300x250)</span></td>
            <?php if(!$_USER->Info["c_sideimage"]) : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <td><input type="file" name="side_image"> <input type="submit" name="change_side_image" value="<?= $LANGS['submitimage'] ?>"></td>
            </form>
            <?php else : ?>
            <form action="/my_account" method="POST" enctype="multipart/form-data">
            <td><input type="submit" name="delete_side_image" class="yt-button yt-button-primary" value="<?= $LANGS['deleteimage'] ?>"></td>
            </form>
            <td><img src="<?= cache_bust($_USER->Info["c_sideimage"]) ?>" width="300"></td>
            <?php endif ?>
        </tr>
</table>
<table border="0" cellpadding="5" cellspacing="0">
    <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['bannerlink'] ?>:</span></td>
            <td><input type="text" name="banner_website" value="<?= $_USER->Info["banner_link"] ?>" maxlength="64" style="width:200px" /></td>
        </tr>
    <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['sideimagelink'] ?>:</span></td>
            <td><input type="text" name="side_website" value="<?= $_USER->Info["sideimage_link"] ?>" maxlength="64" style="width:200px" /></td>
        </tr>
        <tr>
            <td align="middle"><input type="checkbox" name="c_custom_box" id="c_custom_box"<?php if ($CheckCustomBox == 1) : ?> checked<?php endif ?>></td>
            <td><label for="c_custom_box"><?= $LANGS['custombox'] ?></label></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['customboxtitle'] ?>:</span></td>
            <td><input type="text" name="custom_box_title" value="<?= $_USER->Info["custom_box_title"] ?>" maxlength="60" style="width:200px" /></td>
        </tr>
        <tr>
            <td align="right"><span style="font-weight:bold"><?= $LANGS['customboxcontent'] ?>:</span></td>
            <td><textarea name="custom_box" maxlength="1024" style="width:350px;resize:vertical;height:275px;"><?= $_USER->Info["custom_box"] ?></textarea></td>
        </tr>
</table>
<?php endif ?>
<td><br><input type="submit" name="save_profile" value="<?= $LANGS['savechanges'] ?>"></td>
</form>
                    </div>
                </div>
            </div>
</div>
<!-- START AD COLUMN RIGHT -->
<div id="right-column">
    
    <div id="sideAd" z-index="10" style="width: auto; height: auto;">       
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- bitviewside -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:120px;height:240px;margin:10px 0"
                 data-ad-client="ca-pub-8433080377364721"
                 data-ad-slot="9813736805"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>



<div class="clear"></div>