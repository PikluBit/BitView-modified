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
    <h2 style="margin:0 0 2px; color:#<?= $_PROFILE->Info["c_link_color"] ?> !important"><?= $LANGS['writecomment'] ?><span style="font-size:12px;color:#<?= $_PROFILE->Info["c_link_color"] ?> !important"> (<?= $LANGS['for'] ?> <?= displayname($_PROFILE->Username) ?>)</span></h2>
<div style="margin-bottom:3px;font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif;color:#<?= $_PROFILE->Info["c_link_color"] ?> !important"><?= $LANGS['commentdesc'] ?></div>
<form action="/user/<?= $_PROFILE->Username ?>" method="POST">
<table cellpadding="4px" style="position:relative;right:4px">
    <tr>
        <td><textarea style="font-family: <?= $_PROFILE->Info["c_font"] ?>" maxlength="500" name="comment" cols="66" rows="6"></textarea></td>
    </tr>
    <tr>
        <td><input type="submit" class="yt-button yt-button-primary" name="post_comment" value="<?= $LANGS['postreplychannel'] ?>"> <a href="/user/<?= $_PROFILE->Username ?>"><button type="button"><?= $LANGS['cancel'] ?></button></a></td>
    </tr>
</table>
</form> 
        </div>
    </div>
