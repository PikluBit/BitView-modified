<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/profile_style.php" ?>
<style>
#mainContent {
    margin-left: 150px;
}
</style>
<div id="baseDiv">
                <?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_profile.php" ?>
    
        <br>
        <!--Begin Page Container Table-->
<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_profile/main_links.php" ?>  
<div style="width: 875px; text-align: left;">
    <div id="mainContent"> 
<h2 style="margin:0 0 2px; color:#<?= $_PROFILE->Info["c_link_color"] ?>!important"><?= $LANGS['writeabulletin'] ?></h2>
<div style="margin-bottom:3px;font-family: <?= $_PROFILE->Info["c_font"] ?>, sans-serif; color:#<?= $_PROFILE->Info["c_link_color"] ?> !important"><?= $LANGS['bulletindesc'] ?></div>
<form action="/user/<?= $_USER->Username ?>&page=write_bulletin" method="POST">
<table cellpadding="4px" style="position:relative;right:4px">
    <tr>
        <td valign="middle" style="font-family: <?= $_PROFILE->Info["c_font"] ?>, sans-serif;color:#<?= $_PROFILE->Info["c_link_color"] ?>!important"><b><?= $LANGS['subject'] ?>:</b></td>
        <td><input type="text" name="subject" maxlength="128" style="width:260px;font-family: <?= $_PROFILE->Info["c_font"] ?>, sans-serif;"></td>
    </tr>
    <tr>
        <td valign="top" style="font-family:arial,helvetica,sans-serif;color:#<?= $_PROFILE->Info["c_link_color"] ?>; font-family: <?= $_PROFILE->Info["c_font"] ?>, sans-serif; !important"><b><?= $LANGS['body'] ?>:</b></td>
        <td><textarea maxlength="1000" name="bulletin" cols="48" rows="6" style="font-family: <?= $_PROFILE->Info["c_font"] ?>, sans-serif;"></textarea></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" name="post_bulletin" value="<?= $LANGS['postbulletin'] ?>"> <a href="/user/<?= $_USER->Username ?>"><button type="button"><?= $LANGS['cancel'] ?></button></a></td>
    </tr>
</table>
</form>
</div>
</div>
